@extends('layouts.app')

@section('title', 'Edit Venue')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<style>
    #map { height: 300px; }
</style>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold">Edit Venue: {{ $venue->name }}</h1>
                    <a href="{{ route('venues.show', $venue) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 focus:outline-none">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Venue
                    </a>
                </div>
                
                <form action="{{ route('venues.update', $venue) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Information -->
                    <div>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Basic Information</h2>
                        <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Venue Name</label>
                                <div class="mt-1">
                                    <input type="text" name="name" id="name" value="{{ old('name', $venue->name) }}" required
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('name') border-red-500 @enderror">
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="venue_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Venue Type</label>
                                <div class="mt-1">
                                    <select id="venue_type_id" name="venue_type_id" required
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('venue_type_id') border-red-500 @enderror">
                                        <option value="">Select Type</option>
                                        @foreach($venueTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('venue_type_id', $venue->venue_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('venue_type_id')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-6">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <div class="mt-1">
                                    <textarea id="description" name="description" rows="4" required
                                              class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('description') border-red-500 @enderror">{{ old('description', $venue->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Write a detailed description of your venue.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Location Information -->
                    <div class="pt-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Location</h2>
                        <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-6">
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                                <div class="mt-1">
                                    <input type="text" name="address" id="address" value="{{ old('address', $venue->address) }}" required
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('address') border-red-500 @enderror">
                                    @error('address')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                                <div class="mt-1">
                                    <input type="text" name="city" id="city" value="{{ old('city', $venue->city) }}" required
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('city') border-red-500 @enderror">
                                    @error('city')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300">State/Province</label>
                                <div class="mt-1">
                                    <input type="text" name="state" id="state" value="{{ old('state', $venue->state) }}"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('state') border-red-500 @enderror">
                                    @error('state')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="zip_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">ZIP / Postal Code</label>
                                <div class="mt-1">
                                    <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code', $venue->zip_code) }}" required
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('zip_code') border-red-500 @enderror">
                                    @error('zip_code')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country</label>
                                <div class="mt-1">
                                    <input type="text" name="country" id="country" value="{{ old('country', $venue->country) }}" required
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('country') border-red-500 @enderror">
                                    @error('country')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Map Location</label>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Click on the map to adjust the venue's location or use the search button below.</p>
                                <div class="mt-2">
                                    <div id="map" class="rounded-lg"></div>
                                </div>
                                <div class="mt-2 flex space-x-4">
                                    <button type="button" id="searchLocation" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                                        <i class="fas fa-search mr-2"></i> Search Address
                                    </button>
                                    <span class="text-sm text-gray-500 dark:text-gray-400 pt-2">or drag the marker to adjust the position</span>
                                </div>
                                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $venue->latitude) }}">
                                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $venue->longitude) }}">
                                @error('latitude')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Capacity & Pricing -->
                    <div class="pt-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Capacity & Pricing</h2>
                        <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label for="capacity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Capacity (Guests)</label>
                                <div class="mt-1">
                                    <input type="number" name="capacity" id="capacity" min="1" value="{{ old('capacity', $venue->capacity) }}" required
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('capacity') border-red-500 @enderror">
                                    @error('capacity')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="price_per_hour" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price Per Hour ($)</label>
                                <div class="mt-1">
                                    <input type="number" name="price_per_hour" id="price_per_hour" min="0" step="0.01" value="{{ old('price_per_hour', $venue->price_per_hour) }}" required
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('price_per_hour') border-red-500 @enderror">
                                    @error('price_per_hour')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="price_per_day" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price Per Day ($)</label>
                                <div class="mt-1">
                                    <input type="number" name="price_per_day" id="price_per_day" min="0" step="0.01" value="{{ old('price_per_day', $venue->price_per_day) }}"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('price_per_day') border-red-500 @enderror">
                                    @error('price_per_day')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Optional - for full day bookings</p>
                            </div>
                        </div>
                    </div>

                    <!-- Amenities -->
                    <div class="pt-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Amenities</h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Select all amenities available at your venue.</p>
                        <div class="mt-4 grid grid-cols-1 gap-y-4 sm:grid-cols-2 lg:grid-cols-3">
                            @php 
                                $venueAmenities = $venue->amenities->pluck('id')->toArray();
                            @endphp
                            @foreach($amenities as $amenity)
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="amenity-{{ $amenity->id }}" name="amenities[]" type="checkbox" value="{{ $amenity->id }}"
                                               {{ in_array($amenity->id, old('amenities', $venueAmenities)) ? 'checked' : '' }}
                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="amenity-{{ $amenity->id }}" class="font-medium text-gray-700 dark:text-gray-300">
                                            <i class="fas {{ $amenity->icon }} mr-1 text-indigo-500"></i> {{ $amenity->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('amenities')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Venue Rules -->
                    <div class="pt-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Venue Rules</h2>
                        <div class="mt-4">
                            <textarea id="rules" name="rules" rows="4"
                                      class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('rules') border-red-500 @enderror">{{ old('rules', $venue->rules) }}</textarea>
                            @error('rules')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Enter any rules or restrictions for your venue. Each rule on a new line.</p>
                    </div>

                    <!-- Images -->
                    <div class="pt-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Venue Images</h2>
                        
                        <!-- Current Featured Image -->
                        <div class="mt-4">
                            <h3 class="text-md font-medium text-gray-700 dark:text-gray-300">Current Featured Image</h3>
                            @if($venue->featured_image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $venue->featured_image) }}" alt="{{ $venue->name }}" class="h-40 w-auto object-cover rounded-md">
                                </div>
                            @else
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No featured image available</p>
                            @endif
                        </div>
                        
                        <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-6">
                                <label for="featured_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Update Featured Image</label>
                                <div class="mt-1 flex items-center">
                                    <input type="file" id="featured_image" name="featured_image" accept="image/*"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 @error('featured_image') border-red-500 @enderror">
                                </div>
                                @error('featured_image')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Upload a new main image that best represents your venue (max 2MB)</p>
                            </div>

                            <!-- Current Additional Images -->
                            <div class="sm:col-span-6">
                                <h3 class="text-md font-medium text-gray-700 dark:text-gray-300">Current Additional Images</h3>
                                @if($venue->images && count($venue->images) > 0)
                                    <div class="mt-2 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                        @foreach($venue->images as $imagePath)
                                            <div class="relative">
                                                <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $venue->name }}" class="h-32 w-full object-cover rounded-md">
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No additional images available</p>
                                @endif
                            </div>

                            <div class="sm:col-span-6">
                                <label for="images" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Add New Images</label>
                                <div class="mt-1 flex items-center">
                                    <input type="file" id="images" name="images[]" accept="image/*" multiple
                                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 @error('images') border-red-500 @enderror @error('images.*') border-red-500 @enderror">
                                </div>
                                @error('images')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @error('images.*')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Upload additional images of your venue (max 2MB each)</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 flex justify-between">
                        <button type="button" onclick="history.back()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                            <i class="fas fa-times mr-2"></i> Cancel
                        </button>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-save mr-2"></i> Update Venue
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the map
        const map = L.map('map').setView([
            parseFloat(document.getElementById('latitude').value) || 40.7128,
            parseFloat(document.getElementById('longitude').value) || -74.0060
        ], 13);

        // Add the OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add a marker at the initial position
        const marker = L.marker([
            parseFloat(document.getElementById('latitude').value) || 40.7128,
            parseFloat(document.getElementById('longitude').value) || -74.0060
        ], {
            draggable: true
        }).addTo(map);

        // Update coordinates when the marker is dragged
        marker.on('dragend', function(e) {
            const latlng = marker.getLatLng();
            document.getElementById('latitude').value = latlng.lat;
            document.getElementById('longitude').value = latlng.lng;
        });

        // Update the marker position when clicking on the map
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        });

        // Search for an address
        document.getElementById('searchLocation').addEventListener('click', function() {
            const address = document.getElementById('address').value;
            const city = document.getElementById('city').value;
            const state = document.getElementById('state').value;
            const country = document.getElementById('country').value;
            const searchQuery = [address, city, state, country].filter(Boolean).join(', ');
            
            if (searchQuery) {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(searchQuery)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            const lat = parseFloat(data[0].lat);
                            const lon = parseFloat(data[0].lon);
                            
                            document.getElementById('latitude').value = lat;
                            document.getElementById('longitude').value = lon;
                            
                            marker.setLatLng([lat, lon]);
                            map.setView([lat, lon], 15);
                        } else {
                            alert('Location not found. Please try a different address.');
                        }
                    })
                    .catch(error => {
                        console.error('Error searching for location:', error);
                        alert('Error searching for location. Please try again.');
                    });
            } else {
                alert('Please enter an address to search.');
            }
        });
    });
</script>
@endsection 