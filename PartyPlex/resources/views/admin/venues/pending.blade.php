@extends('layouts.app')

@section('title', 'Pending Venues')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold">Pending Venue Approvals</h1>
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
                    </a>
                </div>

                @if($venues->count() > 0)
                    <div class="overflow-x-auto rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Venue
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Owner
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Location
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Details
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Submitted
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($venues as $venue)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $venue->featured_image ? asset('storage/' . $venue->featured_image) : 'https://ui-avatars.com/api/?name=' . urlencode($venue->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $venue->name }}">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $venue->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $venue->venueType->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $venue->user->name }}
                                                </div>
                                                <a href="mailto:{{ $venue->user->email }}" class="ml-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                                    <i class="fas fa-envelope"></i>
                                                </a>
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                Joined {{ $venue->user->created_at->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">{{ $venue->city }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $venue->state ?? $venue->country }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">
                                                <i class="fas fa-users text-indigo-600 dark:text-indigo-400 mr-1"></i> {{ $venue->capacity }} guests
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                <i class="fas fa-dollar-sign text-indigo-600 dark:text-indigo-400 mr-1"></i> {{ number_format($venue->price_per_hour, 2) }}/hr
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $venue->created_at->diffForHumans() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('venues.show', $venue) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('admin.venues.approve', $venue) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300" title="Approve">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('venues.destroy', $venue) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to reject this venue? This action cannot be undone.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300" title="Reject">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $venues->links() }}
                    </div>
                @else
                    <div class="bg-white dark:bg-gray-700 rounded-lg p-6 text-center">
                        <i class="fas fa-check-circle text-green-500 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">No pending venues</h3>
                        <p class="mt-2 text-gray-500 dark:text-gray-400">All venue submissions have been reviewed. Check back later for new submissions.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 