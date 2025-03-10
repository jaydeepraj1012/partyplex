@extends('layouts.app')

@section('title', $venue->name)

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
<style>
    .splide__arrow {
        background: rgba(255, 255, 255, 0.8);
    }
    .splide__pagination__page.is-active {
        background: #4f46e5;
    }
</style>
@endsection

@section('content')
<div class="bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-indigo-400">
                        <i class="fas fa-home mr-2"></i> Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-sm mx-1"></i>
                        <a href="{{ route('venues.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-indigo-400">Venues</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-sm mx-1"></i>
                        <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400 truncate max-w-xs">{{ $venue->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="lg:grid lg:grid-cols-2 lg:gap-8">
            <!-- Left Column: Venue Details -->
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight sm:text-4xl">
                    {{ $venue->name }}
                </h1>
                
                <div class="mt-3 flex items-center">
                    <p class="text-gray-600 dark:text-gray-300">
                        <i class="fas fa-map-marker-alt text-indigo-600 dark:text-indigo-400 mr-2"></i>
                        {{ $venue->address }}, {{ $venue->city }}, {{ $venue->state ?? '' }} {{ $venue->zip_code }}, {{ $venue->country }}
                    </p>
                </div>
                
                <div class="mt-4 flex items-center">
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $venue->getAverageRatingAttribute() >= $i ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"></i>
                        @endfor
                        <span class="ml-2 text-gray-600 dark:text-gray-300">
                            {{ number_format($venue->getAverageRatingAttribute(), 1) }} ({{ $venue->reviews->count() }} {{ Str::plural('review', $venue->reviews->count()) }})
                        </span>
                    </div>
                    <span class="mx-2 text-gray-400">|</span>
                    <span class="flex items-center">
                        <i class="fas fa-building text-indigo-600 dark:text-indigo-400 mr-2"></i>
                        {{ $venue->venueType->name }}
                    </span>
                </div>
                
                <!-- Image Gallery -->
                <div class="mt-6">
                    <div class="splide">
                        <div class="splide__track">
                            <ul class="splide__list">
                                @if($venue->featured_image)
                                    <li class="splide__slide">
                                        <img src="{{ asset('storage/' . $venue->featured_image) }}" 
                                             alt="{{ $venue->name }}" 
                                             class="w-full h-64 sm:h-96 object-cover rounded-lg shadow">
                                    </li>
                                @endif
                                
                                @if($venue->images)
                                    @foreach($venue->images as $image)
                                        <li class="splide__slide">
                                            <img src="{{ asset('storage/' . $image) }}" 
                                                alt="{{ $venue->name }}" 
                                                class="w-full h-64 sm:h-96 object-cover rounded-lg shadow">
                                        </li>
                                    @endforeach
                                @endif
                                
                                @if(!$venue->featured_image && (!$venue->images || count($venue->images) == 0))
                                    <li class="splide__slide">
                                        <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80" 
                                             alt="{{ $venue->name }}" 
                                             class="w-full h-64 sm:h-96 object-cover rounded-lg shadow">
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Description -->
                <div class="mt-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Description</h2>
                    <div class="mt-2 text-gray-600 dark:text-gray-300 space-y-4">
                        {{ $venue->description }}
                    </div>
                </div>
                
                <!-- Capacity & Pricing -->
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Capacity</h3>
                        <div class="mt-2 text-gray-600 dark:text-gray-300">
                            <div class="flex items-center">
                                <i class="fas fa-users text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                <span>{{ $venue->capacity }} guests maximum</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Pricing</h3>
                        <div class="mt-2 text-gray-600 dark:text-gray-300">
                            <div class="flex items-center">
                                <i class="fas fa-clock text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                <span>${{ number_format($venue->price_per_hour) }} per hour</span>
                            </div>
                            @if($venue->price_per_day)
                                <div class="flex items-center mt-1">
                                    <i class="fas fa-calendar-day text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                    <span>${{ number_format($venue->price_per_day) }} per day</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Amenities -->
                <div class="mt-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Amenities</h2>
                    <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @forelse($venue->amenities as $amenity)
                            <div class="flex items-center">
                                <i class="fas {{ $amenity->icon }} text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                <span class="text-gray-600 dark:text-gray-300">{{ $amenity->name }}</span>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400 col-span-3">No amenities listed.</p>
                        @endforelse
                    </div>
                </div>
                
                <!-- Venue Rules -->
                @if($venue->rules)
                    <div class="mt-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Venue Rules</h2>
                        <div class="mt-2 text-gray-600 dark:text-gray-300 space-y-2">
                            @if(is_array($venue->rules))
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach($venue->rules as $rule)
                                        <li>{{ $rule }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>{{ $venue->rules }}</p>
                            @endif
                        </div>
                    </div>
                @endif
                
                <!-- Location Map -->
                <div class="mt-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Location</h2>
                    <div class="mt-2 bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden shadow-sm">
                        <div id="map" class="h-64 w-full"></div>
                    </div>
                </div>
                
                <!-- Host Information -->
                <div class="mt-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Hosted by {{ $venue->user->name }}</h2>
                    <div class="mt-4 flex items-start">
                        <div class="flex-shrink-0">
                            <img class="h-12 w-12 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($venue->user->name) }}&background=4f46e5&color=fff" alt="{{ $venue->user->name }}">
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">Joined {{ $venue->user->created_at->diffForHumans() }}</div>
                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                <p>Contact host with any questions about the venue.</p>
                            </div>
                            @auth
                                <div class="mt-3">
                                    <a href="{{ route('messages.show', $venue->user->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <i class="fas fa-comment-alt mr-2"></i> Message Host
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Booking Form & Reviews -->
            <div class="mt-10 lg:mt-0">
                <!-- Booking Card -->
                <div class="bg-white dark:bg-gray-700 rounded-lg shadow-lg p-6 sticky top-8">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Book this venue</h2>
                    
                    <div class="mt-4">
                        <div class="flex justify-between">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">${{ number_format($venue->price_per_hour) }}</div>
                            <div class="text-gray-600 dark:text-gray-300">per hour</div>
                        </div>
                        
                        @if($venue->price_per_day)
                        <div class="flex justify-between mt-1">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">${{ number_format($venue->price_per_day) }}</div>
                            <div class="text-gray-600 dark:text-gray-300">per day</div>
                        </div>
                        @endif
                        
                        @auth
                            <form action="{{ route('bookings.create', $venue) }}" method="GET" class="mt-6">
                                <div class="space-y-4">
                                    <!-- Booking Type Selection -->
                                    <div>
                                        <label for="booking_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Booking Type</label>
                                        <select id="booking_type" name="booking_type" required
                                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="hourly">Hourly Booking</option>
                                            @if($venue->price_per_day)
                                                <option value="daily">Daily Booking</option>
                                            @endif
                                        </select>
                                    </div>
                                    
                                    <!-- Hourly Booking Options -->
                                    <div id="hourly-booking-options">
                                        <div>
                                            <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                                            <input type="date" name="date" id="date" required min="{{ date('Y-m-d') }}"
                                                  class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-4 mt-4">
                                            <div>
                                                <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Time</label>
                                                <select name="start_time" id="start_time" required
                                                       class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    <option value="">Select time</option>
                                                    @for($hour = 8; $hour <= 22; $hour++)
                                                        @foreach(['00', '30'] as $minute)
                                                            @php 
                                                                $formattedHour = $hour % 12 == 0 ? 12 : $hour % 12;
                                                                $ampm = $hour < 12 ? 'AM' : 'PM';
                                                                $timeDisplay = $formattedHour . ':' . $minute . ' ' . $ampm;
                                                                $timeValue = sprintf('%02d', $hour) . ':' . $minute;
                                                            @endphp
                                                            <option value="{{ $timeValue }}">{{ $timeDisplay }}</option>
                                                        @endforeach
                                                    @endfor
                                                </select>
                                            </div>
                                            <div>
                                                <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Time</label>
                                                <select name="end_time" id="end_time" required
                                                       class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    <option value="">Select time</option>
                                                    @for($hour = 8; $hour <= 23; $hour++)
                                                        @foreach(['00', '30'] as $minute)
                                                            @php 
                                                                $formattedHour = $hour % 12 == 0 ? 12 : $hour % 12;
                                                                $ampm = $hour < 12 ? 'AM' : 'PM';
                                                                $timeDisplay = $formattedHour . ':' . $minute . ' ' . $ampm;
                                                                $timeValue = sprintf('%02d', $hour) . ':' . $minute;
                                                            @endphp
                                                            <option value="{{ $timeValue }}">{{ $timeDisplay }}</option>
                                                        @endforeach
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Daily Booking Options -->
                                    <div id="daily-booking-options" class="hidden">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                                                <input type="date" name="start_date" id="start_date" min="{{ date('Y-m-d') }}"
                                                      class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            </div>
                                            
                                            <div>
                                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
                                                <input type="date" name="end_date" id="end_date" min="{{ date('Y-m-d') }}"
                                                      class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label for="guests" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Number of Guests</label>
                                        <input type="number" name="guests" id="guests" min="1" max="{{ $venue->capacity }}" required
                                               class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maximum capacity: {{ $venue->capacity }} guests</p>
                                    </div>
                                </div>
                                
                                <div class="mt-6">
                                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Continue to Book
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="mt-6 bg-gray-50 dark:bg-gray-600 p-4 rounded-lg">
                                <p class="text-gray-700 dark:text-gray-300 text-center">
                                    Please <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 font-semibold hover:text-indigo-800 dark:hover:text-indigo-300">login</a> 
                                    or <a href="{{ route('register') }}" class="text-indigo-600 dark:text-indigo-400 font-semibold hover:text-indigo-800 dark:hover:text-indigo-300">register</a> 
                                    to book this venue.
                                </p>
                            </div>
                        @endauth
                    </div>
                </div>
                
                <!-- Reviews Section -->
                <div class="mt-10">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Reviews ({{ $venue->reviews->count() }})
                    </h2>
                    
                    @if($venue->reviews->count() > 0)
                        <div class="mt-6 space-y-6">
                            @foreach($venue->reviews as $review)
                                <div class="bg-white dark:bg-gray-700 rounded-lg shadow-sm p-4">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&background=4f46e5&color=fff" alt="{{ $review->user->name }}">
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <div class="flex items-center justify-between">
                                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ $review->user->name }}</h3>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $review->created_at->format('M d, Y') }}</p>
                                            </div>
                                            <div class="mt-1 flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $review->rating >= $i ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }} text-sm"></i>
                                                @endfor
                                            </div>
                                            <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                                <p>{{ $review->comment }}</p>
                                            </div>
                                            
                                            @if($review->images && count($review->images) > 0)
                                                <div class="mt-3 flex space-x-2 overflow-x-auto pb-2">
                                                    @foreach($review->images as $image)
                                                        <img src="{{ asset('storage/' . $image) }}" alt="Review image" class="h-20 w-20 object-cover rounded">
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-4 text-gray-500 dark:text-gray-400">No reviews yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<script>
    // Initialize image gallery slider
    document.addEventListener('DOMContentLoaded', function() {
        new Splide('.splide', {
            type: 'loop',
            perPage: 1,
            autoplay: true,
            interval: 5000,
            pauseOnHover: true,
            pagination: true,
            arrows: true,
        }).mount();
    });
    
    // Initialize Google Map
    function initMap() {
        const venueLocation = { 
            lat: {{ $venue->latitude }}, 
            lng: {{ $venue->longitude }} 
        };
        
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 15,
            center: venueLocation,
        });
        
        const marker = new google.maps.Marker({
            position: venueLocation,
            map: map,
            title: "{{ $venue->name }}",
        });
    }
</script>
@if(config('googlemaps.api_key'))
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('googlemaps.api_key') }}&callback=initMap" async defer></script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const bookingTypeSelect = document.getElementById('booking_type');
        const hourlyOptions = document.getElementById('hourly-booking-options');
        const dailyOptions = document.getElementById('daily-booking-options');
        const dateInput = document.getElementById('date');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const startTimeSelect = document.getElementById('start_time');
        const endTimeSelect = document.getElementById('end_time');
        
        // Initialize form based on initial selection
        const initialBookingType = bookingTypeSelect.value;
        if (initialBookingType === 'hourly') {
            hourlyOptions.classList.remove('hidden');
            dailyOptions.classList.add('hidden');
        } else if (initialBookingType === 'daily') {
            hourlyOptions.classList.add('hidden');
            dailyOptions.classList.remove('hidden');
        }
        
        // Handle booking type change
        bookingTypeSelect.addEventListener('change', function() {
            if (this.value === 'hourly') {
                hourlyOptions.classList.remove('hidden');
                dailyOptions.classList.add('hidden');
                
                // Make hourly fields required and daily fields not required
                dateInput.required = true;
                startTimeSelect.required = true;
                endTimeSelect.required = true;
                
                if (startDateInput) startDateInput.required = false;
                if (endDateInput) endDateInput.required = false;
            } else if (this.value === 'daily') {
                hourlyOptions.classList.add('hidden');
                dailyOptions.classList.remove('hidden');
                
                // Make daily fields required and hourly fields not required
                if (startDateInput) startDateInput.required = true;
                if (endDateInput) endDateInput.required = true;
                
                dateInput.required = false;
                startTimeSelect.required = false;
                endTimeSelect.required = false;
            }
        });
        
        // Validate end time is after start time
        if (startTimeSelect && endTimeSelect) {
            startTimeSelect.addEventListener('change', function() {
                validateTimeRange();
            });
            
            endTimeSelect.addEventListener('change', function() {
                validateTimeRange();
            });
            
            function validateTimeRange() {
                const startTime = startTimeSelect.value;
                const endTime = endTimeSelect.value;
                
                if (startTime && endTime && startTime >= endTime) {
                    alert('End time must be after start time');
                    endTimeSelect.value = '';
                }
            }
        }
        
        // Validate end date is after start date
        if (startDateInput && endDateInput) {
            startDateInput.addEventListener('change', function() {
                validateDateRange();
                endDateInput.min = startDateInput.value;
            });
            
            endDateInput.addEventListener('change', function() {
                validateDateRange();
            });
            
            function validateDateRange() {
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;
                
                if (startDate && endDate && startDate > endDate) {
                    alert('End date must be after or the same as start date');
                    endDateInput.value = startDate;
                }
            }
        }
    });
</script>
@endsection 