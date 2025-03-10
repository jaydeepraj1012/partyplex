@extends('layouts.app')

@section('title', 'Add New Venue')

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
                <h1 class="text-2xl font-semibold mb-6">Add New Venue</h1>
                
                <form action="{{ route('venues.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Basic Information -->
                    <div>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Basic Information</h2>
                        <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Venue Name</label>
                                <div class="mt-1">
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
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
                                            <option value="{{ $type->id }}" {{ old('venue_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
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
                                              class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
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
                                    <input type="text" name="address" id="address" value="{{ old('address') }}" required
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('address') border-red-500 @enderror">
                                    @error('address')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                                <div class="mt-1">
                                    <input type="text" name="city" id="city" value="{{ old('city') }}" required
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('city') border-red-500 @enderror">
                                    @error('city')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300">State/Province</label>
                                <div class="mt-1">
                                    <input type="text" name="state" id="state" value="{{ old('state') }}"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('state') border-red-500 @enderror">
                                    @error('state')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="zip_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">ZIP / Postal Code</label>
                                <div class="mt-1">
                                    <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code') }}" required
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('zip_code') border-red-500 @enderror">
                                    @error('zip_code')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country</label>
                                <div class="mt-1">
                                    <input type="text" name="country" id="country" value="{{ old('country') }}" required
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('country') border-red-500 @enderror">
                                    @error('country')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Map Location</label>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Click on the map to set the venue's location or use the search button below.</p>
                                <div class="mt-2">
                                    <div id="map" class="rounded-lg"></div>
                                </div>
                                <div class="mt-2 flex space-x-4">
                                    <button type="button" id="searchLocation" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                                        <i class="fas fa-search mr-2"></i> Search Address
                                    </button>
                                    <span class="text-sm text-gray-500 dark:text-gray-400 pt-2">or drag the marker to adjust the position</span>
                                </div>
                                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') ?? config('googlemaps.default_lat') }}">
                                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') ?? config('googlemaps.default_lng') }}">
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
                                    <input type="number" name="capacity" id="capacity" min="1" value="{{ old('capacity') }}" required
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('capacity') border-red-500 @enderror">
                                    @error('capacity')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="price_per_hour" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price Per Hour ($)</label>
                                <div class="mt-1">
                                    <input type="number" name="price_per_hour" id="price_per_hour" min="0" step="0.01" value="{{ old('price_per_hour') }}" required
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('price_per_hour') border-red-500 @enderror">
                                    @error('price_per_hour')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="price_per_day" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price Per Day ($)</label>
                                <div class="mt-1">
                                    <input type="number" name="price_per_day" id="price_per_day" min="0" step="0.01" value="{{ old('price_per_day') }}"
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
                            @foreach($amenities as $amenity)
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="amenity-{{ $amenity->id }}" name="amenities[]" type="checkbox" value="{{ $amenity->id }}"
                                               {{ in_array($amenity->id, old('amenities', [])) ? 'checked' : '' }}
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
                                      class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('rules') border-red-500 @enderror">{{ old('rules') }}</textarea>
                            @error('rules')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Enter any rules or restrictions for your venue. Each rule on a new line.</p>
                    </div>

                    <!-- Images -->
                    <div class="pt-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Venue Images</h2>
                        <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-6">
                                <label for="featured_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Featured Image</label>
                                <div class="mt-1 flex items-center">
                                    <input type="file" id="featured_image" name="featured_image" accept="image/*"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 @error('featured_image') border-red-500 @enderror">
                                </div>
                                @error('featured_image')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Upload a main image that best represents your venue (max 2MB)</p>
                            </div>

                            <div class="sm:col-span-6">
                                <label for="images" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Additional Images</label>
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
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Upload up to 10 additional images of your venue (max 2MB each)</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6">
                        <div class="flex justify-end">
                            <a href="{{ route('venues.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                                Cancel
                            </a>
                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Submit Venue
                            </button>
                        </div>
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
        const defaultLat = parseFloat(document.getElementById('latitude').value) || {{ config('googlemaps.default_lat') }};
        const defaultLng = parseFloat(document.getElementById('longitude').value) || {{ config('googlemaps.default_lng') }};
        
        const map = L.map('map').setView([defaultLat, defaultLng], {{ config('googlemaps.default_zoom') }});
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Add marker
        const marker = L.marker([defaultLat, defaultLng], {
            draggable: true
        }).addTo(map);
        
        // Update hidden fields when marker is moved
        marker.on('dragend', function(event) {
            const position = marker.getLatLng();
            document.getElementById('latitude').value = position.lat;
            document.getElementById('longitude').value = position.lng;
        });
        
        // Map click event
        map.on('click', function(event) {
            marker.setLatLng(event.latlng);
            document.getElementById('latitude').value = event.latlng.lat;
            document.getElementById('longitude').value = event.latlng.lng;
        });
        
        // Search location button
        document.getElementById('searchLocation').addEventListener('click', function() {
            const address = document.getElementById('address').value;
            const city = document.getElementById('city').value;
            const state = document.getElementById('state').value;
            const country = document.getElementById('country').value;
            
            if (!address || !city) {
                alert('Please enter at least address and city to search');
                return;
            }
            
            const searchAddress = `${address}, ${city}${state ? ', ' + state : ''}, ${country}`;
            
            // Use Nominatim for geocoding (OpenStreetMap)
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(searchAddress)}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lon = parseFloat(data[0].lon);
                        
                        marker.setLatLng([lat, lon]);
                        map.setView([lat, lon], 15);
                        
                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lon;
                    } else {
                        alert('Location not found. Please try a different address or place the marker manually.');
                    }
                })
                .catch(error => {
                    console.error('Error searching location:', error);
                    alert('Error searching location. Please try again or place the marker manually.');
                });
        });
    });
</script>
@endsection 