@extends('layouts.app')

@section('title', 'Pending Bookings')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Pending Bookings</h1>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 focus:outline-none">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
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
        
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                @if($bookings->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Booking Details</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Venue</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date & Time</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">#{{ $booking->booking_code }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->created_at->format('M d, Y \a\t g:i A') }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->guest_count }} guests</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $booking->user->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $booking->venue->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->venue->venueType->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->venue->city }}, {{ $booking->venue->country }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 dark:text-white">{{ $booking->start_time->format('M d, Y') }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $booking->start_time->format('g:i A') }} - {{ $booking->end_time->format('g:i A') }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $booking->start_time->diff($booking->end_time)->h }} hour(s)
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">${{ number_format($booking->total_amount, 2) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('bookings.show', $booking) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                <form action="{{ route('bookings.approve', $booking) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300" title="Approve">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                
                                                <button type="button" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 reject-booking" 
                                                        data-booking-id="{{ $booking->id }}" title="Reject">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6">
                        {{ $bookings->links() }}
                    </div>
                @else
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 text-center">
                        <div class="text-2xl text-gray-400 dark:text-gray-500 mb-4">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">No Pending Bookings</h3>
                        <p class="text-gray-500 dark:text-gray-400">There are no bookings waiting for approval at the moment.</p>
                    </div>
                @endif
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
                <form id="rejectForm" action="" method="POST">
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
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none">
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
        const modalClosers = document.querySelectorAll('.modal-close');
        const rejectButtons = document.querySelectorAll('.reject-booking');
        const rejectForm = document.getElementById('rejectForm');
        
        rejectButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const bookingId = button.getAttribute('data-booking-id');
                rejectForm.action = `/bookings/${bookingId}/reject`;
                modal.classList.remove('hidden');
            });
        });
        
        modalClosers.forEach(function(closer) {
            closer.addEventListener('click', function() {
                const parentModal = closer.closest('.fixed.z-10');
                if (parentModal) {
                    parentModal.classList.add('hidden');
                }
            });
        });
        
        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });
</script>
@endsection
@endsection 