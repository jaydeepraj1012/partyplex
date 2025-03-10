@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-6">Admin Dashboard</h1>
        
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 mr-4">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Users</div>
                            <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['users_count'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 mr-4">
                            <i class="fas fa-building text-xl"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Venues</div>
                            <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['venues_count'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-400 mr-4">
                            <i class="fas fa-calendar-check text-xl"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Bookings</div>
                            <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['bookings_count'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400 mr-4">
                            <i class="fas fa-dollar-sign text-xl"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Revenue</div>
                            <div class="text-2xl font-semibold text-gray-900 dark:text-white">${{ number_format($stats['revenue'], 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Secondary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Pending Approvals</h3>
                </div>
                <div class="p-6">
                    <div class="flex flex-col">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-400">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Venues</div>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                {{ $stats['pending_venues_count'] }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-400">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Bookings</div>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                {{ $stats['pending_bookings_count'] }}
                            </span>
                        </div>
                    </div>
                    
                    @if($stats['pending_venues_count'] > 0)
                        <div class="mt-6">
                            <a href="{{ route('admin.venues.pending') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                Review pending venues <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg col-span-1 md:col-span-2">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Quick Links</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('admin.venues.pending') }}" class="text-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <i class="fas fa-check-circle text-2xl text-indigo-600 dark:text-indigo-400 mb-2"></i>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">Approve Venues</div>
                        </a>
                        
                        <a href="{{ route('admin.users.index') }}" class="text-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <i class="fas fa-users-cog text-2xl text-indigo-600 dark:text-indigo-400 mb-2"></i>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">Manage Users</div>
                        </a>
                        
                        <a href="{{ route('admin.reviews.index') }}" class="text-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <i class="fas fa-star text-2xl text-indigo-600 dark:text-indigo-400 mb-2"></i>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">Moderate Reviews</div>
                        </a>
                        
                        <a href="{{ route('admin.reports.bookings') }}" class="text-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <i class="fas fa-chart-line text-2xl text-indigo-600 dark:text-indigo-400 mb-2"></i>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">View Reports</div>
                        </a>
                        
                        <a href="{{ route('venues.create') }}" class="text-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <i class="fas fa-plus-circle text-2xl text-indigo-600 dark:text-indigo-400 mb-2"></i>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">Add New Venue</div>
                        </a>
                        
                        <a href="{{ url('/bookings?filter=pending') }}" class="text-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <i class="fas fa-calendar-alt text-2xl text-indigo-600 dark:text-indigo-400 mb-2"></i>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">Pending Bookings</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Venues -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Venues</h3>
                        <a href="{{ route('venues.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                            View all
                        </a>
                    </div>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($recentVenues as $venue)
                        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $venue->featured_image ? asset('storage/' . $venue->featured_image) : 'https://ui-avatars.com/api/?name=' . urlencode($venue->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $venue->name }}">
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $venue->name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        Added by {{ $venue->user->name }} · {{ $venue->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                <div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $venue->is_approved ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }}">
                                        {{ $venue->is_approved ? 'Approved' : 'Pending' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                            No venues found.
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Recent Bookings -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Bookings</h3>
                        <a href="#" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                            View all
                        </a>
                    </div>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($recentBookings as $booking)
                        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $booking->venue->featured_image ? asset('storage/' . $booking->venue->featured_image) : 'https://ui-avatars.com/api/?name=' . urlencode($booking->venue->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $booking->venue->name }}">
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $booking->user->name }} booked {{ $booking->venue->name }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $booking->start_time->format('M d, Y') }} · ${{ number_format($booking->total_amount, 2) }}
                                    </div>
                                </div>
                                <div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($booking->status == 'confirmed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                        @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                        @elseif($booking->status == 'cancelled') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                        @else bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                        @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                            No bookings found.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 