<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Venue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the user's bookings.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Query builder for user bookings
        $userBookingsQuery = Booking::where('user_id', $user->id)
            ->with(['venue', 'venue.venueType']);
        
        // Query builder for venue bookings (for venue owners or admins)
        $venueBookingsQuery = null;
        if ($user->hasRole('venue-owner') || $user->hasRole(['admin', 'super-admin'])) {
            $venueBookingsQuery = Booking::with(['user', 'venue']);
            
            if ($user->hasRole('venue-owner') && !$user->hasRole(['admin', 'super-admin'])) {
                // Venue owners only see bookings for their venues
                $venueBookingsQuery->whereHas('venue', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            }
        }
        
        // Apply status filter if provided
        if ($request->has('filter')) {
            if ($request->filter === 'pending') {
                $userBookingsQuery->where('status', 'pending');
                if ($venueBookingsQuery) {
                    $venueBookingsQuery->where('status', 'pending');
                }
            } elseif ($request->filter === 'approved') {
                $userBookingsQuery->where('status', 'approved');
                if ($venueBookingsQuery) {
                    $venueBookingsQuery->where('status', 'approved');
                }
            } elseif ($request->filter === 'rejected') {
                $userBookingsQuery->where('status', 'rejected');
                if ($venueBookingsQuery) {
                    $venueBookingsQuery->where('status', 'rejected');
                }
            } elseif ($request->filter === 'cancelled') {
                $userBookingsQuery->where('status', 'cancelled');
                if ($venueBookingsQuery) {
                    $venueBookingsQuery->where('status', 'cancelled');
                }
            }
        }
        
        // Get the results
        $userBookings = $userBookingsQuery->orderBy('created_at', 'desc')->get();
        $venueBookings = $venueBookingsQuery ? $venueBookingsQuery->orderBy('created_at', 'desc')->get() : collect();
        
        return view('bookings.index', compact('userBookings', 'venueBookings'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create(Request $request, Venue $venue)
    {
        // Check if price_per_day is available for daily bookings
        if ($request->booking_type === 'daily' && !$venue->price_per_day) {
            return redirect()->back()->with('error', 'Daily booking is not available for this venue.');
        }
        
        // Validate based on booking type
        if ($request->booking_type === 'hourly') {
            $validated = $request->validate([
                'date' => 'required|date|after_or_equal:today',
                'start_time' => 'required',
                'end_time' => 'required',
                'guests' => 'required|integer|min:1|max:' . $venue->capacity,
                'booking_type' => 'required|in:hourly'
            ]);
            
            // Format date and times for display
            $date = Carbon::parse($validated['date']);
            $startTime = Carbon::parse($validated['date'] . ' ' . $validated['start_time']);
            $endTime = Carbon::parse($validated['date'] . ' ' . $validated['end_time']);
            
            // Validate end time is after start time
            if ($startTime >= $endTime) {
                return redirect()->back()->withErrors(['end_time' => 'End time must be after start time'])->withInput();
            }
            
            // Calculate duration in hours
            $durationHours = $startTime->diffInHours($endTime);
            if ($durationHours < 1) {
                $durationHours = 1; // Minimum 1 hour booking
            }
            
            // Calculate total cost
            $totalAmount = $durationHours * $venue->price_per_hour;
            
            // Prepare the booking details for the confirmation page
            $bookingDetails = [
                'booking_type' => 'hourly',
                'date' => $date->format('Y-m-d'),
                'start_time' => $startTime->format('H:i'),
                'end_time' => $endTime->format('H:i'),
                'guest_count' => $validated['guests'],
                'duration_hours' => $durationHours,
                'total_amount' => $totalAmount,
            ];
        } else { // daily booking
            $validated = $request->validate([
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after_or_equal:start_date',
                'guests' => 'required|integer|min:1|max:' . $venue->capacity,
                'booking_type' => 'required|in:daily'
            ]);
            
            // Format dates for display
            $startDate = Carbon::parse($validated['start_date']);
            $endDate = Carbon::parse($validated['end_date']);
            
            // Calculate duration in days (inclusive of start and end day)
            $durationDays = $startDate->diffInDays($endDate) + 1;
            
            // Calculate total cost
            $totalAmount = $durationDays * $venue->price_per_day;
            
            // Prepare the booking details for the confirmation page
            $bookingDetails = [
                'booking_type' => 'daily',
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'guest_count' => $validated['guests'],
                'duration_days' => $durationDays,
                'total_amount' => $totalAmount,
            ];
        }
        
        return view('bookings.create', compact('venue', 'bookingDetails'));
    }

    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request, Venue $venue)
    {
        // Validate based on booking type
        if ($request->booking_type === 'hourly') {
            $validated = $request->validate([
                'date' => 'required|date|after_or_equal:today',
                'start_time' => 'required',
                'end_time' => 'required',
                'guest_count' => 'required|integer|min:1|max:' . $venue->capacity,
                'special_requests' => 'nullable|string|max:500',
                'booking_type' => 'required|in:hourly'
            ]);
            
            // Format start and end times as datetimes
            $startTime = Carbon::parse($validated['date'] . ' ' . $validated['start_time']);
            $endTime = Carbon::parse($validated['date'] . ' ' . $validated['end_time']);
            
            // Validate end time is after start time
            if ($startTime >= $endTime) {
                return redirect()->back()->withErrors(['end_time' => 'End time must be after start time'])->withInput();
            }
            
            // Check if venue is available for this time slot
            $conflictingBookings = Booking::where('venue_id', $venue->id)
                ->where('status', '!=', 'cancelled')
                ->where('status', '!=', 'rejected')
                ->where(function($query) use ($startTime, $endTime) {
                    $query->where(function($q) use ($startTime, $endTime) {
                        // Check for overlapping hourly bookings
                        $q->where('booking_type', 'hourly')
                          ->where(function($innerQ) use ($startTime, $endTime) {
                              $innerQ->whereBetween('start_time', [$startTime, $endTime])
                                  ->orWhereBetween('end_time', [$startTime, $endTime])
                                  ->orWhere(function($deepQ) use ($startTime, $endTime) {
                                      $deepQ->where('start_time', '<=', $startTime)
                                          ->where('end_time', '>=', $endTime);
                                  });
                          });
                    })
                    ->orWhere(function($q) use ($startTime) {
                        // Check for daily bookings on the same day
                        $dateString = $startTime->format('Y-m-d');
                        $q->where('booking_type', 'daily')
                          ->whereRaw("DATE(?) BETWEEN start_time AND end_time", [$dateString]);
                    });
                })
                ->count();
                
            if ($conflictingBookings > 0) {
                return redirect()->back()->withErrors([
                    'time_conflict' => 'The venue is already booked during the selected time slot. Please choose a different time.'
                ])->withInput();
            }
            
            // Calculate total cost
            $durationHours = $startTime->diffInHours($endTime);
            if ($durationHours < 1) {
                $durationHours = 1; // Minimum 1 hour booking
            }
            $totalAmount = $durationHours * $venue->price_per_hour;
            
            // Create new booking
            $booking = new Booking();
            $booking->user_id = Auth::id();
            $booking->venue_id = $venue->id;
            $booking->booking_type = 'hourly';
            $booking->start_time = $startTime;
            $booking->end_time = $endTime;
            $booking->guest_count = $validated['guest_count'];
            $booking->total_amount = $totalAmount;
            $booking->status = 'pending';
            $booking->special_requests = $validated['special_requests'] ?? null;
            $booking->booking_code = Booking::generateBookingCode();
            $booking->save();
        } else { // daily booking
            $validated = $request->validate([
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after_or_equal:start_date',
                'guest_count' => 'required|integer|min:1|max:' . $venue->capacity,
                'special_requests' => 'nullable|string|max:500',
                'booking_type' => 'required|in:daily'
            ]);
            
            // Format dates (start at 00:00 of first day, end at 23:59 of last day)
            $startTime = Carbon::parse($validated['start_date'])->startOfDay();
            $endTime = Carbon::parse($validated['end_date'])->endOfDay();
            
            // Check if venue is available for these days
            $conflictingBookings = Booking::where('venue_id', $venue->id)
                ->where('status', '!=', 'cancelled')
                ->where('status', '!=', 'rejected')
                ->where(function($query) use ($startTime, $endTime) {
                    $query->where(function($q) use ($startTime, $endTime) {
                        // Check for hourly bookings within the date range
                        $q->where('booking_type', 'hourly')
                          ->where('start_time', '>=', $startTime)
                          ->where('start_time', '<=', $endTime);
                    })
                    ->orWhere(function($q) use ($startTime, $endTime) {
                        // Check for overlapping daily bookings
                        $q->where('booking_type', 'daily')
                          ->where(function($innerQ) use ($startTime, $endTime) {
                              // Start date falls within existing booking
                              $innerQ->where('start_time', '<=', $startTime)
                                  ->where('end_time', '>=', $startTime);
                          })
                          ->orWhere(function($innerQ) use ($startTime, $endTime) {
                              // End date falls within existing booking
                              $innerQ->where('start_time', '<=', $endTime)
                                  ->where('end_time', '>=', $endTime);
                          })
                          ->orWhere(function($innerQ) use ($startTime, $endTime) {
                              // New booking completely covers existing booking
                              $innerQ->where('start_time', '>=', $startTime)
                                  ->where('end_time', '<=', $endTime);
                          });
                    });
                })
                ->count();
                
            if ($conflictingBookings > 0) {
                return redirect()->back()->withErrors([
                    'date_conflict' => 'The venue is already booked during the selected dates. Please choose different dates.'
                ])->withInput();
            }
            
            // Calculate total cost
            $durationDays = $startTime->diffInDays($endTime->startOfDay()) + 1;
            $totalAmount = $durationDays * $venue->price_per_day;
            
            // Create new booking
            $booking = new Booking();
            $booking->user_id = Auth::id();
            $booking->venue_id = $venue->id;
            $booking->booking_type = 'daily';
            $booking->start_time = $startTime;
            $booking->end_time = $endTime;
            $booking->guest_count = $validated['guest_count'];
            $booking->total_amount = $totalAmount;
            $booking->status = 'pending';
            $booking->special_requests = $validated['special_requests'] ?? null;
            $booking->booking_code = Booking::generateBookingCode();
            $booking->save();
        }
        
        // Redirect to booking confirmation page
        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Your booking request has been submitted successfully! The venue owner will be notified, and we\'ll update you on the status of your booking.');
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        // Check if the current user is authorized to view this booking
        if (Auth::id() !== $booking->user_id && Auth::id() !== $booking->venue->user_id && !Auth::user()->hasRole(['admin', 'super-admin'])) {
            abort(403, 'You are not authorized to view this booking.');
        }
        
        $booking->load(['venue', 'venue.venueType', 'venue.user', 'user', 'payment']);
        
        return view('bookings.show', compact('booking'));
    }

    /**
     * Cancel a booking.
     */
    public function cancel(Request $request, Booking $booking)
    {
        // Check if the current user is authorized to cancel this booking
        if (Auth::id() !== $booking->user_id && !Auth::user()->hasRole(['admin', 'super-admin'])) {
            abort(403, 'You are not authorized to cancel this booking.');
        }
        
        // Check if booking can be cancelled
        if ($booking->status === 'cancelled') {
            return redirect()->back()->with('error', 'This booking is already cancelled.');
        }
        
        if ($booking->status === 'completed') {
            return redirect()->back()->with('error', 'Completed bookings cannot be cancelled.');
        }
        
        // Update booking status
        $booking->status = 'cancelled';
        $booking->save();
        
        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Your booking has been cancelled successfully.');
    }

    /**
     * Approve a booking (for venue owners).
     */
    public function approve(Request $request, Booking $booking)
    {
        // Check if the current user is authorized to approve this booking
        if (Auth::id() !== $booking->venue->user_id && !Auth::user()->hasRole(['admin', 'super-admin'])) {
            abort(403, 'You are not authorized to approve this booking.');
        }
        
        // Check if booking can be approved
        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending bookings can be approved.');
        }
        
        // Update booking status
        $oldStatus = $booking->status;
        $booking->status = 'approved';
        $result = $booking->save();
        
        \Log::info('Booking approval', [
            'booking_id' => $booking->id,
            'old_status' => $oldStatus,
            'new_status' => $booking->status,
            'save_result' => $result,
            'user_id' => Auth::id()
        ]);
        
        // TODO: Send notification to the user
        
        return redirect()->route('bookings.show', $booking)
            ->with('success', 'The booking has been approved successfully. Status updated from ' . $oldStatus . ' to ' . $booking->status);
    }

    /**
     * Reject a booking (for venue owners).
     */
    public function reject(Request $request, Booking $booking)
    {
        // Check if the current user is authorized to reject this booking
        if (Auth::id() !== $booking->venue->user_id && !Auth::user()->hasRole(['admin', 'super-admin'])) {
            abort(403, 'You are not authorized to reject this booking.');
        }
        
        // Validate rejection reason
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);
        
        // Check if booking can be rejected
        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending bookings can be rejected.');
        }
        
        // Update booking status
        $booking->status = 'rejected';
        $booking->rejection_reason = $validated['rejection_reason'];
        $booking->save();
        
        // TODO: Send notification to the user
        
        return redirect()->route('bookings.show', $booking)
            ->with('success', 'The booking has been rejected successfully.');
    }
}
