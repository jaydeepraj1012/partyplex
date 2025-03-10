<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Review;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|super-admin']);
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Get counts for dashboard
        $stats = [
            'users_count' => User::count(),
            'venues_count' => Venue::count(),
            'pending_venues_count' => Venue::where('is_approved', false)->count(),
            'bookings_count' => Booking::count(),
            'pending_bookings_count' => Booking::where('status', 'pending')->count(),
            'reviews_count' => Review::count(),
            'revenue' => Payment::where('status', 'completed')->sum('amount'),
        ];

        // Get recent activity
        $recentBookings = Booking::with(['user', 'venue'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        $recentVenues = Venue::with(['user', 'venueType'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        $recentUsers = User::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'recentVenues', 'recentUsers'));
    }

    /**
     * Show pending venues waiting for approval.
     *
     * @return \Illuminate\View\View
     */
    public function pendingVenues()
    {
        $venues = Venue::where('is_approved', false)
            ->with(['user', 'venueType'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.venues.pending', compact('venues'));
    }

    /**
     * Show user management page.
     *
     * @return \Illuminate\View\View
     */
    public function users()
    {
        $users = User::with('roles')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show edit user form.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function editUser(User $user)
    {
        $roles = Role::all();
        
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        // Update role
        $user->syncRoles($validated['role']);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Show reviews for moderation.
     *
     * @return \Illuminate\View\View
     */
    public function reviews()
    {
        $reviews = Review::with(['user', 'venue', 'booking'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Approve a review.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveReview(Review $review)
    {
        $review->is_approved = true;
        $review->save();

        return redirect()->back()
            ->with('success', 'Review approved successfully!');
    }

    /**
     * Delete a review.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteReview(Review $review)
    {
        $review->delete();

        return redirect()->back()
            ->with('success', 'Review deleted successfully!');
    }

    /**
     * Show booking reports.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function bookingReports(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        $bookingStats = Booking::selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(total_amount) as revenue')
            ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $bookingsByStatus = Booking::selectRaw('status, COUNT(*) as count')
            ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
            ->groupBy('status')
            ->get();

        return view('admin.reports.bookings', compact('bookingStats', 'bookingsByStatus', 'startDate', 'endDate'));
    }

    /**
     * Show revenue reports.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function revenueReports(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        $revenueStats = Payment::selectRaw('DATE(created_at) as date, SUM(amount) as revenue, COUNT(*) as transactions')
            ->where('status', 'completed')
            ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $revenueByPaymentMethod = Payment::selectRaw('payment_method, SUM(amount) as revenue')
            ->where('status', 'completed')
            ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
            ->groupBy('payment_method')
            ->get();

        return view('admin.reports.revenue', compact('revenueStats', 'revenueByPaymentMethod', 'startDate', 'endDate'));
    }

    /**
     * Show user reports.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function userReports(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        $userStats = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $usersByRole = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->selectRaw('roles.name, COUNT(*) as count')
            ->whereBetween(DB::raw('DATE(users.created_at)'), [$startDate, $endDate])
            ->groupBy('roles.name')
            ->get();

        return view('admin.reports.users', compact('userStats', 'usersByRole', 'startDate', 'endDate'));
    }

    /**
     * Show pending bookings that need approval.
     *
     * @return \Illuminate\View\View
     */
    public function pendingBookings()
    {
        $bookings = Booking::where('status', 'pending')
            ->with(['user', 'venue', 'venue.venueType'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.bookings.pending', compact('bookings'));
    }
}
