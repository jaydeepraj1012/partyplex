@extends('layouts.app')

@section('title', 'Find Your Perfect Venue')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gray-900 overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80" 
                 alt="Event venue" class="w-full h-full object-cover opacity-50">
            <div class="absolute inset-0 bg-gradient-to-b from-gray-900/60 to-gray-900/90"></div>
        </div>
        <div class="relative px-4 py-24 sm:px-6 sm:py-32 lg:py-40 lg:px-8">
            <h1 class="text-center text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
                <span class="block text-white">Find Your Perfect</span>
                <span class="block text-indigo-400">Party Venue</span>
            </h1>
            <p class="mt-6 max-w-lg mx-auto text-center text-xl text-gray-300 sm:max-w-3xl">
                Discover and book the best venues for your events - farmhouses, banquet halls, party venues, and more.
            </p>
            <div class="mt-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <form action="{{ route('venues.search') }}" method="GET" class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
                            <div class="mt-1">
                                <input type="text" name="location" id="location" placeholder="Enter city, state or zip code" 
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-white rounded-md">
                            </div>
                        </div>
                        <div>
                            <label for="venue_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Venue Type</label>
                            <div class="mt-1">
                                <select id="venue_type" name="type" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-white rounded-md">
                                    <option value="">All Venue Types</option>
                                    @foreach($venueTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="capacity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Capacity</label>
                            <div class="mt-1">
                                <select id="capacity" name="capacity" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-white rounded-md">
                                    <option value="">Any Capacity</option>
                                    <option value="50">50+ guests</option>
                                    <option value="100">100+ guests</option>
                                    <option value="200">200+ guests</option>
                                    <option value="300">300+ guests</option>
                                    <option value="500">500+ guests</option>
                                    <option value="1000">1000+ guests</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-search mr-2"></i> Search Venues
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Featured Venues Section -->
    <div class="py-12 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base text-indigo-600 dark:text-indigo-400 font-semibold tracking-wide uppercase">Discover</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                    Featured Venues
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-300 mx-auto">
                    Browse through our handpicked selection of the best venues available for your next event.
                </p>
            </div>

            <div class="mt-10">
                @if($featuredVenues->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($featuredVenues as $venue)
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:shadow-xl hover:-translate-y-1">
                                <div class="relative">
                                    <img src="{{ $venue->featured_image ? asset('storage/' . $venue->featured_image) : 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80' }}" 
                                         alt="{{ $venue->name }}" class="w-full h-52 object-cover">
                                    <div class="absolute top-0 right-0 mt-2 mr-2 bg-indigo-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ $venue->venueType->name }}
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        <a href="{{ route('venues.show', $venue) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                            {{ $venue->name }}
                                        </a>
                                    </h3>
                                    <p class="mt-2 text-gray-600 dark:text-gray-300 text-sm">
                                        <i class="fas fa-map-marker-alt text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        {{ $venue->city }}, {{ $venue->state ?? $venue->country }}
                                    </p>
                                    <div class="mt-4 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-users text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        <span>Capacity: {{ $venue->capacity }} guests</span>
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-dollar-sign text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        <span>{{ number_format($venue->price_per_hour) }} per hour</span>
                                    </div>
                                    <div class="mt-4 flex items-center">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $venue->getAverageRatingAttribute() >= $i ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"></i>
                                            @endfor
                                        </div>
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">
                                            ({{ $venue->reviews_count }} reviews)
                                        </span>
                                    </div>
                                    <div class="mt-6">
                                        <a href="{{ route('venues.show', $venue) }}" class="block w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-12 text-center">
                        <a href="{{ route('venues.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            View All Venues <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-500 dark:text-gray-400">No featured venues available at the moment.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Venue Types Section -->
    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base text-indigo-600 dark:text-indigo-400 font-semibold tracking-wide uppercase">Categories</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                    Browse by Venue Type
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-300 mx-auto">
                    Find the perfect venue type to match your event requirements and preferences.
                </p>
            </div>

            <div class="mt-10">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($venueTypes as $type)
                        <a href="{{ route('venues.index', ['type' => $type->id]) }}" class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center transition-transform duration-300 hover:shadow-lg hover:-translate-y-1">
                            <div class="text-3xl text-indigo-600 dark:text-indigo-400 mb-4">
                                <i class="fas {{ $type->icon }}"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $type->name }}</h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">{{ Str::limit($type->description, 60) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="py-12 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base text-indigo-600 dark:text-indigo-400 font-semibold tracking-wide uppercase">Simple Process</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                    How PartyPlex Works
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-300 mx-auto">
                    Booking your perfect venue is just a few steps away.
                </p>
            </div>

            <div class="mt-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 dark:bg-indigo-900 mx-auto">
                            <i class="fas fa-search text-2xl text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Search</h3>
                        <p class="mt-2 text-base text-gray-500 dark:text-gray-300">
                            Find the perfect venue based on location, capacity, and amenities.
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 dark:bg-indigo-900 mx-auto">
                            <i class="fas fa-calendar-check text-2xl text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Book</h3>
                        <p class="mt-2 text-base text-gray-500 dark:text-gray-300">
                            Reserve your chosen venue for your event date with our secure booking system.
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 dark:bg-indigo-900 mx-auto">
                            <i class="fas fa-glass-cheers text-2xl text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Celebrate</h3>
                        <p class="mt-2 text-base text-gray-500 dark:text-gray-300">
                            Enjoy your event at your perfectly chosen venue with complete peace of mind.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-indigo-700">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Ready to find your perfect venue?</span>
                <span class="block text-indigo-200">Start your search today.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="{{ route('venues.index') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
                        Browse Venues
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Sign Up Now
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection 