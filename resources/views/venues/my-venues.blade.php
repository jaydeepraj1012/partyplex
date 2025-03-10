@extends('layouts.app')

@section('title', 'My Venues')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold">My Venues</h1>
                    <a href="{{ route('venues.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-plus mr-2"></i> Add New Venue
                    </a>
                </div>

                <!-- Venue Statistics -->
                <div class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-indigo-50 dark:bg-indigo-900 rounded-lg p-6 shadow-sm">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-indigo-600 dark:text-indigo-300 font-medium">Total Venues</p>
                                <p class="text-2xl font-semibold text-indigo-700 dark:text-indigo-200">{{ $statistics['total'] }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-800">
                                <i class="fas fa-building text-indigo-600 dark:text-indigo-400 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 dark:bg-green-900 rounded-lg p-6 shadow-sm">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-green-600 dark:text-green-300 font-medium">Active Venues</p>
                                <p class="text-2xl font-semibold text-green-700 dark:text-green-200">{{ $statistics['active'] }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-green-100 dark:bg-green-800">
                                <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-yellow-50 dark:bg-yellow-900 rounded-lg p-6 shadow-sm">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-yellow-600 dark:text-yellow-300 font-medium">Pending Approval</p>
                                <p class="text-2xl font-semibold text-yellow-700 dark:text-yellow-200">{{ $statistics['pending'] }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-800">
                                <i class="fas fa-clock text-yellow-600 dark:text-yellow-400 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-purple-50 dark:bg-purple-900 rounded-lg p-6 shadow-sm">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-purple-600 dark:text-purple-300 font-medium">Total Bookings</p>
                                <p class="text-2xl font-semibold text-purple-700 dark:text-purple-200">{{ $statistics['bookings'] }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-800">
                                <i class="fas fa-calendar-check text-purple-600 dark:text-purple-400 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter options -->
                <div class="mb-6">
                    <form action="{{ route('venues.my-venues') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                            <select id="status" name="status" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                <option value="">All Statuses</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div>
                            <label for="venue_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Venue Type</label>
                            <select id="venue_type" name="venue_type" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                <option value="">All Types</option>
                                @foreach($venueTypes as $type)
                                    <option value="{{ $type->id }}" {{ request('venue_type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sort By</label>
                            <select id="sort" name="sort" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <i class="fas fa-filter mr-2"></i> Filter
                            </button>
                            @if(request()->has('status') || request()->has('venue_type') || request()->has('sort'))
                                <a href="{{ route('venues.my-venues') }}" class="ml-2 inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    <i class="fas fa-times mr-2"></i> Clear
                                </a>
                            @endif
                        </div>
                    </form>
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
                                        Location
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Price
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Bookings
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
                                            <div class="text-sm text-gray-900 dark:text-white">{{ $venue->city }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $venue->state ?? $venue->country }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">${{ number_format($venue->price_per_hour, 2) }}/hr</div>
                                            @if($venue->price_per_day)
                                                <div class="text-xs text-gray-500 dark:text-gray-400">${{ number_format($venue->price_per_day, 2) }}/day</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col space-y-1">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $venue->is_approved ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }}">
                                                    {{ $venue->is_approved ? 'Approved' : 'Pending Approval' }}
                                                </span>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $venue->is_active ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                                    {{ $venue->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                                @if($venue->is_featured)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                                        Featured
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            <div class="text-sm text-gray-900 dark:text-white">{{ $venue->bookings_count ?? 0 }} total</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $venue->pending_bookings_count ?? 0 }} pending
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('venues.show', $venue) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('venues.edit', $venue) }}" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-900 dark:hover:text-yellow-300" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('venues.toggle-active', $venue) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="{{ $venue->is_active ? 'text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300' : 'text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300' }}" title="{{ $venue->is_active ? 'Deactivate' : 'Activate' }}">
                                                        <i class="fas {{ $venue->is_active ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('venues.destroy', $venue) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this venue? This action cannot be undone.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300" title="Delete">
                                                        <i class="fas fa-trash"></i>
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
                        {{ $venues->withQueryString()->links() }}
                    </div>
                @else
                    <div class="bg-white dark:bg-gray-700 rounded-lg p-6 text-center">
                        <i class="fas fa-building text-gray-400 dark:text-gray-500 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">No venues found</h3>
                        <p class="mt-2 text-gray-500 dark:text-gray-400">You haven't added any venues yet or none match your filter criteria.</p>
                        <a href="{{ route('venues.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fas fa-plus mr-2"></i> Add Your First Venue
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 