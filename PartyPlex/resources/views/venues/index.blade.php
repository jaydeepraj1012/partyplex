@extends('layouts.app')

@section('title', 'Browse Venues')

@section('content')
    <div class="bg-white dark:bg-gray-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                    Find Your Perfect Venue
                </h1>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 dark:text-gray-300 sm:mt-4">
                    Browse through our collection of venues and find the one that fits your needs.
                </p>
            </div>

            <div class="mt-10 flex flex-col lg:flex-row">
                <!-- Filter Sidebar -->
                <div class="w-full lg:w-1/4 mb-6 lg:mb-0 lg:pr-6">
                    <form action="{{ route('venues.index') }}" method="GET" class="bg-white dark:bg-gray-700 shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Filters</h3>
                        
                        <!-- Location Search -->
                        <div class="mb-4">
                            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location</label>
                            <input type="text" name="location" id="location" value="{{ request('location') }}" placeholder="City, state or zip" 
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md">
                        </div>
                        
                        <!-- Venue Type -->
                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Venue Type</label>
                            <select name="type" id="type" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md">
                                <option value="">All Types</option>
                                @foreach($venueTypes as $type)
                                    <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Capacity -->
                        <div class="mb-4">
                            <label for="capacity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Minimum Capacity</label>
                            <select name="capacity" id="capacity" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md">
                                <option value="">Any Capacity</option>
                                <option value="50" {{ request('capacity') == 50 ? 'selected' : '' }}>50+ guests</option>
                                <option value="100" {{ request('capacity') == 100 ? 'selected' : '' }}>100+ guests</option>
                                <option value="200" {{ request('capacity') == 200 ? 'selected' : '' }}>200+ guests</option>
                                <option value="300" {{ request('capacity') == 300 ? 'selected' : '' }}>300+ guests</option>
                                <option value="500" {{ request('capacity') == 500 ? 'selected' : '' }}>500+ guests</option>
                                <option value="1000" {{ request('capacity') == 1000 ? 'selected' : '' }}>1000+ guests</option>
                            </select>
                        </div>
                        
                        <!-- Price Range -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price Per Hour</label>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="min_price" class="sr-only">Min Price</label>
                                    <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" placeholder="Min" 
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md">
                                </div>
                                <div>
                                    <label for="max_price" class="sr-only">Max Price</label>
                                    <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" placeholder="Max" 
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Amenities -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Amenities</label>
                            <div class="space-y-2 max-h-60 overflow-y-auto">
                                @foreach($amenities as $amenity)
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="amenity-{{ $amenity->id }}" name="amenities[]" value="{{ $amenity->id }}" type="checkbox" 
                                                   {{ in_array($amenity->id, (array) request('amenities')) ? 'checked' : '' }}
                                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="amenity-{{ $amenity->id }}" class="font-medium text-gray-700 dark:text-gray-300">
                                                <i class="fas {{ $amenity->icon }} mr-1 text-indigo-500"></i> {{ $amenity->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Sort By -->
                        <div class="mb-6">
                            <label for="sort_by" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sort By</label>
                            <select name="sort_by" id="sort_by" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Newest</option>
                                <option value="price_per_hour" {{ request('sort_by') == 'price_per_hour' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_per_hour_desc" {{ request('sort_by') == 'price_per_hour_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="capacity" {{ request('sort_by') == 'capacity' ? 'selected' : '' }}>Capacity: Low to High</option>
                                <option value="capacity_desc" {{ request('sort_by') == 'capacity_desc' ? 'selected' : '' }}>Capacity: High to Low</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Apply Filters
                        </button>
                    </form>
                </div>

                <!-- Venue Listings -->
                <div class="w-full lg:w-3/4">
                    <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{ $venues->total() }} {{ Str::plural('Venue', $venues->total()) }} Found</h2>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Showing {{ $venues->firstItem() ?? 0 }} - {{ $venues->lastItem() ?? 0 }} of {{ $venues->total() }}
                            </div>
                        </div>

                        @if($venues->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                                @foreach($venues as $venue)
                                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg hover:-translate-y-1 border border-gray-200 dark:border-gray-700">
                                        <div class="relative">
                                            <img src="{{ $venue->featured_image ? asset('storage/' . $venue->featured_image) : 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80' }}" 
                                                alt="{{ $venue->name }}" class="w-full h-48 object-cover">
                                            <div class="absolute top-0 right-0 mt-2 mr-2 bg-indigo-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                                {{ $venue->venueType->name }}
                                            </div>
                                            @if($venue->is_featured)
                                                <div class="absolute top-0 left-0 mt-2 ml-2 bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                                    Featured
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-5">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                <a href="{{ route('venues.show', $venue) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                                    {{ $venue->name }}
                                                </a>
                                            </h3>
                                            <p class="mt-1 text-gray-600 dark:text-gray-300 text-sm">
                                                <i class="fas fa-map-marker-alt text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                                {{ $venue->city }}, {{ $venue->state ?? $venue->country }}
                                            </p>
                                            <div class="mt-3 flex justify-between items-center">
                                                <div class="flex items-center">
                                                    <div class="flex items-center">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star {{ $venue->getAverageRatingAttribute() >= $i ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }} text-sm"></i>
                                                        @endfor
                                                    </div>
                                                    <span class="ml-1 text-xs text-gray-600 dark:text-gray-300">
                                                        ({{ $venue->reviews_count }})
                                                    </span>
                                                </div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    ${{ number_format($venue->price_per_hour) }}/hr
                                                </div>
                                            </div>
                                            <div class="mt-3 flex justify-between items-center text-xs text-gray-500 dark:text-gray-400">
                                                <div>
                                                    <i class="fas fa-users mr-1 text-indigo-600 dark:text-indigo-400"></i> {{ $venue->capacity }} guests
                                                </div>
                                                <div>
                                                    <i class="fas fa-ruler-combined mr-1 text-indigo-600 dark:text-indigo-400"></i> {{ rand(1000, 5000) }} sq ft
                                                </div>
                                            </div>
                                            <div class="mt-4 grid grid-cols-3 gap-2">
                                                @foreach($venue->amenities->take(3) as $amenity)
                                                    <span class="inline-flex items-center text-xs text-gray-600 dark:text-gray-300">
                                                        <i class="fas {{ $amenity->icon }} mr-1 text-indigo-600 dark:text-indigo-400"></i> {{ $amenity->name }}
                                                    </span>
                                                @endforeach
                                                @if($venue->amenities->count() > 3)
                                                    <span class="inline-flex items-center text-xs text-gray-600 dark:text-gray-300">
                                                        +{{ $venue->amenities->count() - 3 }} more
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="mt-4">
                                                <a href="{{ route('venues.show', $venue) }}" class="block w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-8">
                                {{ $venues->appends(request()->query())->links() }}
                            </div>
                        @else
                            <div class="text-center py-16">
                                <i class="fas fa-search text-4xl text-gray-300 dark:text-gray-600 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">No venues found</h3>
                                <p class="mt-2 text-gray-500 dark:text-gray-400">Try adjusting your search criteria</p>
                                <a href="{{ route('venues.index') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Clear All Filters
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 