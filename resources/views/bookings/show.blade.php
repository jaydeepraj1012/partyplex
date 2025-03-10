@extends('layouts.app')

@section('title', 'Booking Details')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('bookings.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 focus:outline-none">
                <i class="fas fa-arrow-left mr-2"></i> Back to Bookings
            </a>
        </div>
        
        @if(session('success'))
            <div class="mb-4 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 p-4 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 p-4 rounded-lg">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Booking #{{ $booking->booking_code }}</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Created on {{ $booking->created_at->format('M d, Y \a\t g:i A') }}</p>
                    </div>
                    
                    <div class="mt-4 md:mt-0">
                        <span class="px-3 py-1 text-sm rounded-full 
                        @if($booking->status == 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                        @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                        @elseif($booking->status == 'cancelled') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                        @elseif($booking->status == 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                        @elseif($booking->status == 'completed') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                        @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Venue Details -->
                    <div class="md:col-span-1">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h2 class="text-lg font-medium mb-4">Venue Information</h2>
                            
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $booking->venue->featured_image) }}" alt="{{ $booking->venue->name }}" class="w-full h-48 object-cover rounded-lg">
                            </div>
                            
                            <h3 class="text-xl font-semibold mb-2">{{ $booking->venue->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ $booking->venue->venueType->name }}</p>
                            
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                <p><i class="fas fa-map-marker-alt mr-2"></i> {{ $booking->venue->address }}, {{ $booking->venue->city }}</p>
                                <p><i class="fas fa-user-friends mr-2"></i> Max Capacity: {{ $booking->venue->capacity }}</p>
                                <p><i class="fas fa-dollar-sign mr-2"></i> ${{ number_format($booking->venue->price_per_hour, 2) }} / hour</p>
                            </div>
                            
                            <a href="{{ route('venues.show', $booking->venue) }}" class="inline-flex items-center text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-200">
                                <i class="fas fa-external-link-alt mr-1"></i> View Venue Details
                            </a>
                        </div>
                    </div>
                    
                    <!-- Booking Details -->
                    <div class="md:col-span-2">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                            <h2 class="text-lg font-medium mb-4">Booking Details</h2>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Date</p>
                                    <p class="text-base">{{ $booking->start_time->format('M d, Y') }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Time</p>
                                    <p class="text-base">{{ $booking->start_time->format('g:i A') }} - {{ $booking->end_time->format('g:i A') }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Duration</p>
                                    <p class="text-base">{{ $booking->start_time->diff($booking->end_time)->h }} hour(s)</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Guests</p>
                                    <p class="text-base">{{ $booking->guest_count }} person(s)</p>
                                </div>
                            </div>
                            
                            @if($booking->special_requests)
                                <div class="mt-4">
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Special Requests</p>
                                    <p class="text-base">{{ $booking->special_requests }}</p>
                                </div>
                            @endif
                            
                            @if($booking->status === 'rejected' && $booking->rejection_reason)
                                <div class="mt-4 p-3 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 rounded-md">
                                    <p class="text-sm font-medium">Rejection Reason:</p>
                                    <p class="text-sm">{{ $booking->rejection_reason }}</p>
                                </div>
                            @endif
                            
                            <div class="border-t border-gray-200 dark:border-gray-600 pt-4 mt-4">
                                <div class="flex justify-between items-center text-lg font-semibold">
                                    <span>Total Amount</span>
                                    <span>${{ number_format($booking->total_amount, 2) }}</span>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    @if($booking->status === 'approved' && !$booking->payment)
                                        Payment required to confirm this booking.
                                    @elseif($booking->payment)
                                        Payment Status: <span class="font-medium {{ $booking->payment->status === 'completed' ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400' }}">{{ ucfirst($booking->payment->status) }}</span>
                                    @else
                                        Payment will be processed after approval.
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-3">
                            <!-- Show approve/reject buttons for pending bookings to venue owners and admins -->
                            @if(Auth::id() === $booking->venue->user_id || Auth::user()->hasRole(['admin', 'super-admin']))
                                @if($booking->status === 'pending')
                                    <form action="{{ route('bookings.approve', $booking) }}" method="POST" class="inline" id="approveBookingForm">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" id="approveBookingBtn"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white"
                                        style="background-color: #16a34a; border: none;">
                                        <i class="fas fa-check mr-2"></i> Approve
                                    </button>
                                    </form>
                                    
                                    <button type="button" id="rejectBookingBtn"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white"
                                    style="background-color: #dc2626; border: none;">
                                    <i class="fas fa-times mr-2"></i> Reject
                                </button>
                                @endif
                            @endif
                            
                            <!-- User can cancel a pending booking -->
                            @if($booking->status === 'pending' && Auth::id() === $booking->user_id)
                                <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Are you sure you want to cancel this booking?')" 
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none">
                                        <i class="fas fa-times mr-2"></i> Cancel Booking
                                    </button>
                                </form>
                            @endif
                            
                            @if($booking->status === 'approved' && !$booking->payment && Auth::id() === $booking->user_id)
                                <a href="{{ route('payments.process', $booking) }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                                    <i class="fas fa-credit-card mr-2"></i> Make Payment
                                </a>
                            @endif
                            
                            <!-- Contact options -->
                            @if($booking->status !== 'rejected' && $booking->status !== 'cancelled')
                                @if(Auth::id() === $booking->user_id)
                                    <a href="{{ route('messages.show', $booking->venue->user_id) }}?booking_id={{ $booking->id }}" 
                                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none">
                                        <i class="fas fa-comment mr-2"></i> Contact Venue Owner
                                    </a>
                                @endif
                                
                                @if(Auth::id() === $booking->venue->user_id)
                                    <a href="{{ route('messages.show', $booking->user_id) }}?booking_id={{ $booking->id }}" 
                                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none">
                                        <i class="fas fa-comment mr-2"></i> Contact Customer
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div class="fixed z-10 inset-0 overflow-y-auto hidden" id="rejectModal">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Reject Booking</h3>
                <form action="{{ route('bookings.reject', $booking) }}" method="POST" id="rejectBookingForm">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reason for Rejection</label>
                        <textarea id="rejection_reason" name="rejection_reason" rows="3" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md"></textarea>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Please provide a reason for rejecting this booking.</p>
                    </div>
                    <div class="mt-5 sm:mt-6 flex justify-end space-x-3">
                        <button type="button" class="modal-close inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none">
                            Cancel
                        </button>
                        <button type="button" id="submitRejectBtn" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none">
                            Reject Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal functionality
        const modal = document.getElementById('rejectModal');
        const rejectBtn = document.getElementById('rejectBookingBtn');
        const closeModalBtns = document.querySelectorAll('.modal-close');
        
        if (rejectBtn) {
            rejectBtn.addEventListener('click', function() {
                modal.classList.remove('hidden');
            });
        }
        
        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
        });
        
        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });
        
        // Approve booking with SweetAlert confirmation
        const approveBtn = document.getElementById('approveBookingBtn');
        const approveForm = document.getElementById('approveBookingForm');
        
        if (approveBtn && approveForm) {
            approveBtn.addEventListener('click', function() {
                Swal.fire({
                    title: 'Approve Booking?',
                    text: 'Are you sure you want to approve this booking?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10B981',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Yes, approve it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoading('Approving booking...');
                        approveForm.submit();
                    }
                });
            });
        }
        
        // Reject booking with SweetAlert
        const submitRejectBtn = document.getElementById('submitRejectBtn');
        const rejectForm = document.getElementById('rejectBookingForm');
        const rejectionReasonInput = document.getElementById('rejection_reason');
        
        if (submitRejectBtn && rejectForm) {
            submitRejectBtn.addEventListener('click', function() {
                if (!rejectionReasonInput.value.trim()) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please provide a reason for rejection',
                        icon: 'error',
                        confirmButtonColor: '#4F46E5'
                    });
                    return;
                }
                
                Swal.fire({
                    title: 'Reject Booking?',
                    text: 'Are you sure you want to reject this booking? This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Yes, reject it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        modal.classList.add('hidden');
                        showLoading('Rejecting booking...');
                        rejectForm.submit();
                    }
                });
            });
        }
    });
</script>
@endsection
@endsection 