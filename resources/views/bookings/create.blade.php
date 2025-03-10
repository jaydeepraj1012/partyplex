@extends('layouts.app')

@section('title', 'Confirm Booking')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 focus:outline-none">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>
        
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-semibold mb-6">Confirm Your Booking</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Venue Details -->
                    <div class="md:col-span-1">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h2 class="text-lg font-medium mb-4">Venue Information</h2>
                            
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $venue->featured_image) }}" alt="{{ $venue->name }}" class="w-full h-48 object-cover rounded-lg">
                            </div>
                            
                            <h3 class="text-xl font-semibold mb-2">{{ $venue->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ $venue->venueType->name }}</p>
                            
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                <p><i class="fas fa-map-marker-alt mr-2"></i> {{ $venue->address }}, {{ $venue->city }}</p>
                                <p><i class="fas fa-user-friends mr-2"></i> Max Capacity: {{ $venue->capacity }}</p>
                                <p><i class="fas fa-dollar-sign mr-2"></i> ${{ number_format($venue->price_per_hour, 2) }} / hour</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Booking Form -->
                    <div class="md:col-span-2">
                        <form action="{{ route('bookings.store', $venue) }}" method="POST">
                            @csrf
                            
                            <!-- Error message -->
                            @if ($errors->any())
                                <div class="mb-4 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 p-4 rounded-lg">
                                    <ul class="list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            <!-- Booking Summary -->
                            <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="text-lg font-medium mb-3">Booking Summary</h3>
                                
                                @if($bookingDetails['booking_type'] === 'hourly')
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Date</p>
                                        <p class="text-base">{{ \Carbon\Carbon::parse($bookingDetails['date'])->format('M d, Y') }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Time</p>
                                        <p class="text-base">{{ \Carbon\Carbon::parse($bookingDetails['start_time'])->format('g:i A') }} - {{ \Carbon\Carbon::parse($bookingDetails['end_time'])->format('g:i A') }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Duration</p>
                                        <p class="text-base">{{ $bookingDetails['duration_hours'] }} hour(s)</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Guests</p>
                                        <p class="text-base">{{ $bookingDetails['guest_count'] }} person(s)</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Rate</p>
                                        <p class="text-base">${{ number_format($venue->price_per_hour, 2) }} per hour</p>
                                    </div>
                                </div>
                                @else
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Start Date</p>
                                        <p class="text-base">{{ \Carbon\Carbon::parse($bookingDetails['start_date'])->format('M d, Y') }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">End Date</p>
                                        <p class="text-base">{{ \Carbon\Carbon::parse($bookingDetails['end_date'])->format('M d, Y') }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Duration</p>
                                        <p class="text-base">{{ $bookingDetails['duration_days'] }} day(s)</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Guests</p>
                                        <p class="text-base">{{ $bookingDetails['guest_count'] }} person(s)</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Rate</p>
                                        <p class="text-base">${{ number_format($venue->price_per_day, 2) }} per day</p>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="border-t border-gray-200 dark:border-gray-600 pt-4 mt-4">
                                    <div class="flex justify-between items-center text-lg font-semibold">
                                        <span>Total Amount</span>
                                        <span>${{ number_format($bookingDetails['total_amount'], 2) }}</span>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Payment will be processed after the venue owner approves your booking.</p>
                                </div>
                            </div>
                            
                            <!-- Hidden fields to carry over data -->
                            <input type="hidden" name="booking_type" value="{{ $bookingDetails['booking_type'] }}">
                            @if($bookingDetails['booking_type'] === 'hourly')
                                <input type="hidden" name="date" value="{{ $bookingDetails['date'] }}">
                                <input type="hidden" name="start_time" value="{{ $bookingDetails['start_time'] }}">
                                <input type="hidden" name="end_time" value="{{ $bookingDetails['end_time'] }}">
                            @else
                                <input type="hidden" name="start_date" value="{{ $bookingDetails['start_date'] }}">
                                <input type="hidden" name="end_date" value="{{ $bookingDetails['end_date'] }}">
                            @endif
                            <input type="hidden" name="guest_count" value="{{ $bookingDetails['guest_count'] }}">
                            
                            <!-- Special Requests -->
                            <div class="mb-6">
                                <label for="special_requests" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Special Requests</label>
                                <textarea id="special_requests" name="special_requests" rows="3"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">{{ old('special_requests') }}</textarea>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Optional: Let the venue owner know about any special requirements or requests.</p>
                            </div>
                            
                            <!-- Terms and Conditions -->
                            <div class="mb-6">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="terms" name="terms" type="checkbox" required
                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="terms" class="font-medium text-gray-700 dark:text-gray-300">I agree to the <a href="{{ route('terms') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500" target="_blank">Terms and Conditions</a></label>
                                        <p class="text-gray-500 dark:text-gray-400">By booking this venue, you agree to abide by venue rules and PartyPlex policies.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Submit Buttons -->
                            <div class="flex justify-end space-x-3">
                                <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none">
                                    Cancel
                                </a>
                                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <i class="fas fa-calendar-check mr-2"></i> Confirm Booking
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 