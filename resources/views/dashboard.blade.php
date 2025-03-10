@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-semibold mb-6">Welcome, {{ Auth::user()->name }}!</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-indigo-100 dark:bg-indigo-900 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-200 dark:bg-indigo-800 text-indigo-600 dark:text-indigo-300 mr-4">
                                <i class="fas fa-calendar-check text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-indigo-600 dark:text-indigo-300 font-medium">Upcoming Bookings</p>
                                <p class="text-2xl font-semibold text-indigo-700 dark:text-indigo-200">{{ Auth::user()->bookings()->where('status', 'confirmed')->where('end_time', '>=', now())->count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if(Auth::user()->hasRole('venue-owner'))
                    <div class="bg-green-100 dark:bg-green-900 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-200 dark:bg-green-800 text-green-600 dark:text-green-300 mr-4">
                                <i class="fas fa-building text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-green-600 dark:text-green-300 font-medium">My Venues</p>
                                <p class="text-2xl font-semibold text-green-700 dark:text-green-200">{{ Auth::user()->venues()->count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-yellow-100 dark:bg-yellow-900 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-200 dark:bg-yellow-800 text-yellow-600 dark:text-yellow-300 mr-4">
                                <i class="fas fa-envelope text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-yellow-600 dark:text-yellow-300 font-medium">New Messages</p>
                                <p class="text-2xl font-semibold text-yellow-700 dark:text-yellow-200">{{ Auth::user()->receivedMessages()->where('is_read', false)->count() }}</p>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="bg-purple-100 dark:bg-purple-900 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-200 dark:bg-purple-800 text-purple-600 dark:text-purple-300 mr-4">
                                <i class="fas fa-history text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-purple-600 dark:text-purple-300 font-medium">Past Bookings</p>
                                <p class="text-2xl font-semibold text-purple-700 dark:text-purple-200">{{ Auth::user()->bookings()->where('end_time', '<', now())->count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-blue-100 dark:bg-blue-900 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-200 dark:bg-blue-800 text-blue-600 dark:text-blue-300 mr-4">
                                <i class="fas fa-star text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-blue-600 dark:text-blue-300 font-medium">My Reviews</p>
                                <p class="text-2xl font-semibold text-blue-700 dark:text-blue-200">{{ Auth::user()->reviews()->count() }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Quick Actions -->
                <div class="mb-8">
                    <h2 class="text-lg font-medium mb-4">Quick Actions</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('bookings.index') }}" class="flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <i class="fas fa-calendar text-indigo-600 dark:text-indigo-400 mr-3"></i>
                            <span>View My Bookings</span>
                        </a>
                        
                        @if(Auth::user()->hasRole('venue-owner'))
                        <a href="{{ route('venues.create') }}" class="flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <i class="fas fa-plus-circle text-indigo-600 dark:text-indigo-400 mr-3"></i>
                            <span>Add New Venue</span>
                        </a>
                        @else
                        <a href="{{ route('venues.index') }}" class="flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <i class="fas fa-search text-indigo-600 dark:text-indigo-400 mr-3"></i>
                            <span>Find Venues</span>
                        </a>
                        @endif
                        
                        <a href="{{ route('messages.index') }}" class="flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <i class="fas fa-envelope text-indigo-600 dark:text-indigo-400 mr-3"></i>
                            <span>Messages</span>
                        </a>
                        
                        <a href="{{ route('profile.edit') }}" class="flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <i class="fas fa-user-edit text-indigo-600 dark:text-indigo-400 mr-3"></i>
                            <span>Edit Profile</span>
                        </a>
                    </div>
                </div>
                
                <!-- Upcoming Bookings -->
                <div class="mb-8">
                    <h2 class="text-lg font-medium mb-4">Upcoming Bookings</h2>
                    @php
                        $upcomingBookings = Auth::user()->bookings()
                            ->where('status', 'confirmed')
                            ->where('start_time', '>=', now())
                            ->with(['venue', 'venue.venueType'])
                            ->orderBy('start_time')
                            ->take(5)
                            ->get();
                    @endphp
                    
                    @if($upcomingBookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white dark:bg-gray-700 rounded-lg overflow-hidden">
                                <thead class="bg-gray-100 dark:bg-gray-600">
                                    <tr>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Venue</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date & Time</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Guests</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach($upcomingBookings as $booking)
                                        <tr>
                                            <td class="py-4 px-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $booking->venue->featured_image ? asset('storage/' . $booking->venue->featured_image) : 'https://ui-avatars.com/api/?name=' . urlencode($booking->venue->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $booking->venue->name }}">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $booking->venue->name }}</div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->venue->venueType->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($booking->start_time)->format('M d, Y') }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} - 
                                                    {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}
                                                </div>
                                            </td>
                                            <td class="py-4 px-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                {{ $booking->guest_count }}
                                            </td>
                                            <td class="py-4 px-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('bookings.show', $booking) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4 text-right">
                            <a href="{{ route('bookings.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">View all bookings <i class="fas fa-chevron-right ml-1"></i></a>
                        </div>
                    @else
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 text-center">
                            <p class="text-gray-500 dark:text-gray-400">You don't have any upcoming bookings.</p>
                            <a href="{{ route('venues.index') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Find a Venue
                            </a>
                        </div>
                    @endif
                </div>
                
                <!-- My Venues (for venue owners) -->
                @if(Auth::user()->hasRole('venue-owner'))
                    <div>
                        <h2 class="text-lg font-medium mb-4">My Venues</h2>
                        @php
                            $venues = Auth::user()->venues()
                                ->orderBy('created_at', 'desc')
                                ->take(3)
                                ->get();
                        @endphp
                        
                        @if($venues->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($venues as $venue)
                                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-sm overflow-hidden">
                                        <div class="h-36 bg-gray-200 dark:bg-gray-600 relative">
                                            <img src="{{ $venue->featured_image ? asset('storage/' . $venue->featured_image) : 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80' }}" 
                                                 alt="{{ $venue->name }}" class="w-full h-full object-cover">
                                            
                                            <div class="absolute top-0 right-0 mt-2 mr-2">
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $venue->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $venue->is_approved ? 'Approved' : 'Pending Approval' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="p-4">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $venue->name }}</h3>
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                <i class="fas fa-map-marker-alt mr-1"></i> {{ $venue->city }}, {{ $venue->state ?? $venue->country }}
                                            </p>
                                            <div class="mt-4 flex justify-between items-center">
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    <i class="fas fa-users mr-1"></i> {{ $venue->capacity }} guests
                                                </div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    ${{ number_format($venue->price_per_hour) }}/hr
                                                </div>
                                            </div>
                                            <div class="mt-4 flex space-x-2">
                                                <a href="{{ route('venues.show', $venue) }}" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none">
                                                    View
                                                </a>
                                                <a href="{{ route('venues.edit', $venue) }}" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                                                    Edit
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-6 text-center">
                                <a href="{{ route('venues.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <i class="fas fa-plus mr-2"></i> Add New Venue
                                </a>
                            </div>
                        @else
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 text-center">
                                <p class="text-gray-500 dark:text-gray-400">You haven't added any venues yet.</p>
                                <a href="{{ route('venues.create') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <i class="fas fa-plus mr-2"></i> Add Your First Venue
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
