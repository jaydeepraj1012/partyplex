<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Venue;
use App\Models\VenueType;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class VenueController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'search']);
    }

    /**
     * Display a listing of venues.
     */
    public function index(Request $request)
    {
        
        $query = Venue::where('is_approved', true)
            ->where('is_active', true)
            ->with(['venueType', 'amenities'])
            ->withCount('reviews');

        // Filter by venue type
        if ($request->has('type') && $request->type) {
            $query->where('venue_type_id', $request->type);
        }

        // Filter by capacity
        if ($request->has('capacity') && $request->capacity) {
            $query->where('capacity', '>=', $request->capacity);
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price_per_hour', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price_per_hour', '<=', $request->max_price);
        }

        // Filter by amenities
        if ($request->has('amenities') && is_array($request->amenities)) {
            $query->whereHas('amenities', function ($q) use ($request) {
                $q->whereIn('amenities.id', $request->amenities);
            }, '=', count($request->amenities));
        }

        // Search by location
        if ($request->has('location') && $request->location) {
            $query->where(function ($q) use ($request) {
                $q->where('address', 'like', '%' . $request->location . '%')
                    ->orWhere('city', 'like', '%' . $request->location . '%')
                    ->orWhere('state', 'like', '%' . $request->location . '%')
                    ->orWhere('country', 'like', '%' . $request->location . '%')
                    ->orWhere('zip_code', 'like', '%' . $request->location . '%');
            });
        }

        // Sort results
        $sortBy = $request->sort_by ?? 'created_at';
        $sortOrder = $request->sort_order ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);

        $venues = $query->paginate(12);
        $venueTypes = VenueType::all();
        $amenities = Amenity::all();

        return view('venues.index', compact('venues', 'venueTypes', 'amenities'));
    }

    /**
     * Search for venues by location and other criteria
     */
    public function search(Request $request)
    {
        return $this->index($request);
    }

    /**
     * Show the form for creating a new venue.
     */
    public function create()
    {
       
        $this->authorize('create', Venue::class);

        $venueTypes = VenueType::all();
        $amenities = Amenity::all();

        return view('venues.create', compact('venueTypes', 'amenities'));
    }

    /**
     * Store a newly created venue in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Venue::class);

        $validated = $request->validate([
            'venue_type_id' => 'required|exists:venue_types,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'capacity' => 'required|integer|min:1',
            'price_per_hour' => 'required|numeric|min:0',
            'price_per_day' => 'nullable|numeric|min:0',
            'rules' => 'nullable|string',
            'amenities' => 'array',
            'amenities.*' => 'exists:amenities,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Set up ImageManager
        $manager = new ImageManager(new Driver());

        // Handle images upload
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('venues/images', 'public');
                
                // Create a thumbnail
                $img = $manager->read(storage_path('app/public/' . $path));
                $img->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->save();
                
                $imagePaths[] = $path;
            }
        }

        // Handle featured image upload
        $featuredImagePath = null;
        if ($request->hasFile('featured_image')) {
            $featuredImagePath = $request->file('featured_image')->store('venues/featured', 'public');
            
            // Create a thumbnail
            $img = $manager->read(storage_path('app/public/' . $featuredImagePath));
            $img->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->save();
        }

        // Create venue
        $venue = new Venue();
        $venue->user_id = Auth::id();
        $venue->venue_type_id = $validated['venue_type_id'];
        $venue->name = $validated['name'];
        $venue->description = $validated['description'];
        $venue->address = $validated['address'];
        $venue->city = $validated['city'];
        $venue->state = $validated['state'] ?? null;
        $venue->country = $validated['country'];
        $venue->zip_code = $validated['zip_code'];
        $venue->latitude = $validated['latitude'];
        $venue->longitude = $validated['longitude'];
        $venue->capacity = $validated['capacity'];
        $venue->price_per_hour = $validated['price_per_hour'];
        $venue->price_per_day = $validated['price_per_day'] ?? null;
        $venue->rules = $validated['rules'] ?? null;
        $venue->images = !empty($imagePaths) ? $imagePaths : null;
        $venue->featured_image = $featuredImagePath;
        $venue->is_approved = Auth::user()->hasRole(['admin', 'super-admin']);
        $venue->save();

        // Attach amenities
        if (isset($validated['amenities'])) {
            $venue->amenities()->attach($validated['amenities']);
        }

        return redirect()->route('venues.show', $venue)
            ->with('success', 'Venue created successfully!' . (!$venue->is_approved ? ' It will be visible after approval.' : ''));
    }

    /**
     * Display the specified venue.
     */
    public function show(Venue $venue)
    {
        // If venue is not approved or active, only allow owner or admin to view it
        if (!$venue->is_approved || !$venue->is_active) {
            $this->authorize('view', $venue);
        }

        $venue->load(['venueType', 'amenities', 'user', 'reviews.user']);

        return view('venues.show', compact('venue'));
    }

    /**
     * Show the form for editing the specified venue.
     */
    public function edit(Venue $venue)
    {
        $this->authorize('update', $venue);

        $venueTypes = VenueType::all();
        $amenities = Amenity::all();

        return view('venues.edit', compact('venue', 'venueTypes', 'amenities'));
    }

    /**
     * Update the specified venue in storage.
     */
    public function update(Request $request, Venue $venue)
    {
        $this->authorize('update', $venue);

        $validated = $request->validate([
            'venue_type_id' => 'required|exists:venue_types,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'capacity' => 'required|integer|min:1',
            'price_per_hour' => 'required|numeric|min:0',
            'price_per_day' => 'nullable|numeric|min:0',
            'rules' => 'nullable|string',
            'amenities' => 'array',
            'amenities.*' => 'exists:amenities,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Set up ImageManager
        $manager = new ImageManager(new Driver());

        // Handle images upload
        $imagePaths = $venue->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('venues/images', 'public');
                
                // Create a thumbnail
                $img = $manager->read(storage_path('app/public/' . $path));
                $img->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->save();
                
                $imagePaths[] = $path;
            }
        }

        // Handle featured image upload
        $featuredImagePath = $venue->featured_image;
        if ($request->hasFile('featured_image')) {
            // Delete old featured image if exists
            if ($featuredImagePath && Storage::disk('public')->exists($featuredImagePath)) {
                Storage::disk('public')->delete($featuredImagePath);
            }
            
            $featuredImagePath = $request->file('featured_image')->store('venues/featured', 'public');
            
            // Create a thumbnail
            $img = $manager->read(storage_path('app/public/' . $featuredImagePath));
            $img->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->save();
        }

        // Update venue
        $venue->venue_type_id = $validated['venue_type_id'];
        $venue->name = $validated['name'];
        $venue->description = $validated['description'];
        $venue->address = $validated['address'];
        $venue->city = $validated['city'];
        $venue->state = $validated['state'] ?? null;
        $venue->country = $validated['country'];
        $venue->zip_code = $validated['zip_code'];
        $venue->latitude = $validated['latitude'];
        $venue->longitude = $validated['longitude'];
        $venue->capacity = $validated['capacity'];
        $venue->price_per_hour = $validated['price_per_hour'];
        $venue->price_per_day = $validated['price_per_day'] ?? null;
        $venue->rules = $validated['rules'] ?? null;
        $venue->images = !empty($imagePaths) ? $imagePaths : null;
        $venue->featured_image = $featuredImagePath;
        $venue->save();

        // Update amenities
        if (isset($validated['amenities'])) {
            $venue->amenities()->sync($validated['amenities']);
        } else {
            $venue->amenities()->detach();
        }

        return redirect()->route('venues.show', $venue)
            ->with('success', 'Venue updated successfully!');
    }

    /**
     * Remove the specified venue from storage.
     */
    public function destroy(Venue $venue)
    {
        $this->authorize('delete', $venue);

        // Delete images
        if ($venue->images) {
            foreach ($venue->images as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        // Delete featured image
        if ($venue->featured_image && Storage::disk('public')->exists($venue->featured_image)) {
            Storage::disk('public')->delete($venue->featured_image);
        }

        $venue->delete();

        return redirect()->route('venues.index')
            ->with('success', 'Venue deleted successfully!');
    }

    /**
     * Approve a venue.
     */
    public function approve(Venue $venue)
    {
        $this->authorize('approve venues');

        $venue->is_approved = true;
        $venue->save();

        return redirect()->back()->with('success', 'Venue approved successfully!');
    }

    /**
     * Feature or unfeature a venue.
     */
    public function toggleFeatured(Venue $venue)
    {
        $this->authorize('feature venues');

        $venue->is_featured = !$venue->is_featured;
        $venue->save();

        $message = $venue->is_featured ? 'Venue featured successfully!' : 'Venue unfeatured successfully!';

        return redirect()->back()->with('success', $message);
    }

    /**
     * Toggle active status of a venue.
     */
    public function toggleActive(Venue $venue)
    {
        $this->authorize('update', $venue);

        $venue->is_active = !$venue->is_active;
        $venue->save();

        $message = $venue->is_active ? 'Venue activated successfully!' : 'Venue deactivated successfully!';

        return redirect()->back()->with('success', $message);
    }

    /**
     * Display a list of the venue owner's venues.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function myVenues(Request $request)
    {
        $this->middleware('auth');
        
        // Only venue owners, admins, and super-admins can access this
        if (!auth()->user()->hasAnyRole(['venue-owner', 'admin', 'super-admin'])) {
            abort(403, 'Unauthorized action.');
        }
        
        $query = Venue::where('user_id', auth()->id())
            ->withCount(['bookings', 'bookings as pending_bookings_count' => function ($query) {
                $query->where('status', 'pending');
            }]);
        
        // Apply filters
        if ($request->has('status')) {
            if ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            } elseif ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }
        
        if ($request->has('venue_type') && $request->venue_type) {
            $query->where('venue_type_id', $request->venue_type);
        }
        
        // Apply sorting
        if ($request->has('sort')) {
            if ($request->sort === 'oldest') {
                $query->orderBy('created_at', 'asc');
            } elseif ($request->sort === 'price_asc') {
                $query->orderBy('price_per_hour', 'asc');
            } elseif ($request->sort === 'price_desc') {
                $query->orderBy('price_per_hour', 'desc');
            } elseif ($request->sort === 'name_asc') {
                $query->orderBy('name', 'asc');
            } elseif ($request->sort === 'name_desc') {
                $query->orderBy('name', 'desc');
            } else {
                $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        $venues = $query->with('venueType')->paginate(10);
        
        // Get statistics for the venue owner
        $statistics = [
            'total' => Venue::where('user_id', auth()->id())->count(),
            'active' => Venue::where('user_id', auth()->id())->where('is_active', true)->count(),
            'pending' => Venue::where('user_id', auth()->id())->where('is_approved', false)->count(),
            'bookings' => Booking::whereHas('venue', function ($query) {
                $query->where('user_id', auth()->id());
            })->count(),
        ];
        
        $venueTypes = VenueType::all();
        
        return view('venues.my-venues', compact('venues', 'statistics', 'venueTypes'));
    }
}
