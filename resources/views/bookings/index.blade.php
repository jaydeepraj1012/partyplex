@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-6">My Bookings</h1>
        
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
        
        <!-- Booking Tabs -->
        <div class="mb-6">
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="-mb-px flex" aria-label="Tabs">
                    <button id="tab-my-bookings" class="tab-button text-indigo-600 dark:text-indigo-400 border-indigo-600 dark:border-indigo-400 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        My Bookings
                    </button>
                    
                    @if($venueBookings->count() > 0)
                        <button id="tab-venue-bookings" class="tab-button text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm ml-8">
                            Venue Bookings
                        </button>
                    @endif
                </nav>
            </div>
        </div>
        
        <!-- My Bookings Tab Content -->
        <div id="content-my-bookings" class="tab-content">
            @if($userBookings->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($userBookings as $booking)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                            <div class="h-40 overflow-hidden">
                                <img src="{{ asset('storage/' . $booking->venue->featured_image) }}" alt="{{ $booking->venue->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">{{ $booking->venue->name }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $booking->venue->venueType->name }}</p>
                                
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-calendar mr-1"></i> {{ $booking->start_time->format('M d, Y') }}
                                    </span>
                                    <span class="px-2 py-1 text-xs rounded-full 
                                    @if($booking->status == 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @elseif($booking->status == 'cancelled') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @elseif($booking->status == 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @elseif($booking->status == 'completed') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                    @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                                
                                <div class="flex justify-between items-center mb-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-clock mr-1"></i> {{ $booking->start_time->format('g:i A') }} - {{ $booking->end_time->format('g:i A') }}
                                    </span>
                                    <span class="text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-user-friends mr-1"></i> {{ $booking->guest_count }} guests
                                    </span>
                                </div>
                                
                                <div class="flex justify-between items-center border-t border-gray-200 dark:border-gray-700 pt-3">
                                    <span class="font-semibold text-gray-900 dark:text-white">${{ number_format($booking->total_amount, 2) }}</span>
                                    <a href="{{ route('bookings.show', $booking) }}" class="inline-flex items-center text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                                        View Details <i class="fas fa-chevron-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 text-center">
                    <div class="text-2xl text-gray-400 dark:text-gray-500 mb-4">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">No Bookings Found</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">You haven't made any bookings yet.</p>
                    <a href="{{ route('venues.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                        <i class="fas fa-search mr-2"></i> Find Venues
                    </a>
                </div>
            @endif
        </div>
        
        <!-- Venue Bookings Tab Content -->
        <div id="content-venue-bookings" class="tab-content hidden">
            @if($venueBookings->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Booking Info</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Venue</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($venueBookings as $booking)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white font-semibold">#{{ $booking->booking_code }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->start_time->format('M d, Y') }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->start_time->format('g:i A') }} - {{ $booking->end_time->format('g:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $booking->user->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $booking->venue->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                        @if($booking->status == 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @elseif($booking->status == 'cancelled') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @elseif($booking->status == 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @elseif($booking->status == 'completed') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        ${{ number_format($booking->total_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('bookings.show', $booking) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 text-center">
                    <div class="text-2xl text-gray-400 dark:text-gray-500 mb-4">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">No Venue Bookings Found</h3>
                    <p class="text-gray-500 dark:text-gray-400">There are no bookings for your venues yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab functionality
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                tabButtons.forEach(function(btn) {
                    btn.classList.remove('text-indigo-600', 'dark:text-indigo-400', 'border-indigo-600', 'dark:border-indigo-400');
                    btn.classList.add('text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'dark:hover:text-gray-300', 'border-transparent');
                });
                
                // Add active class to clicked button
                button.classList.remove('text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'dark:hover:text-gray-300', 'border-transparent');
                button.classList.add('text-indigo-600', 'dark:text-indigo-400', 'border-indigo-600', 'dark:border-indigo-400');
                
                // Hide all tab contents
                tabContents.forEach(function(content) {
                    content.classList.add('hidden');
                });
                
                // Show the corresponding tab content
                const targetId = button.id.replace('tab-', 'content-');
                document.getElementById(targetId).classList.remove('hidden');
            });
        });
    });
</script>
@endsection
@endsection 