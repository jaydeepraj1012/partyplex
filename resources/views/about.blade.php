@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-20 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-8">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                    About PartyPlex
                </h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-300">
                    PartyPlex is a comprehensive venue discovery and booking platform that helps users find the perfect space for their events. Whether you're planning a wedding, corporate event, birthday party, or any other celebration, we've got you covered.
                </p>
                <div class="mt-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Find the Perfect Venue</h3>
                            <p class="mt-2 text-base text-gray-500 dark:text-gray-300">
                                Browse through our extensive collection of venues including farmhouses, banquet halls, rooftops, gardens, and more. Filter by location, capacity, price, and amenities to find exactly what you're looking for.
                            </p>
                        </div>
                    </div>
                    <div class="mt-10 flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Book with Confidence</h3>
                            <p class="mt-2 text-base text-gray-500 dark:text-gray-300">
                                Our secure booking system allows you to reserve your chosen venue with just a few clicks. View real-time availability, make secure payments, and manage all your bookings in one place.
                            </p>
                        </div>
                    </div>
                    <div class="mt-10 flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">For Venue Owners</h3>
                            <p class="mt-2 text-base text-gray-500 dark:text-gray-300">
                                List your venue on PartyPlex and reach thousands of potential customers. Manage bookings, showcase your space with high-quality photos, and grow your business with our comprehensive venue management tools.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-12 lg:mt-0">
                <div class="pl-4 -mr-48 sm:pl-6 md:-mr-16 lg:px-0 lg:m-0 lg:relative lg:h-full">
                    <img class="w-full rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 lg:absolute lg:left-0 lg:h-full lg:w-auto lg:max-w-none" 
                         src="https://images.unsplash.com/photo-1478737270239-2f02b77fc618?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" 
                         alt="PartyPlex venue example">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Our Mission -->
    <div class="bg-indigo-700">
        <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                <span class="block">Our Mission</span>
            </h2>
            <p class="mt-4 text-lg leading-6 text-indigo-200">
                We're on a mission to simplify event planning by connecting people with the perfect venues for their special occasions. Our platform makes it easy to discover, compare, and book venues, saving time and reducing stress for event planners and host.
            </p>
        </div>
    </div>
    
    <!-- Team Section -->
    <div class="bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto py-12 px-4 text-center sm:px-6 lg:px-8 lg:py-24">
            <div class="space-y-12">
                <div class="space-y-5 sm:mx-auto sm:max-w-xl sm:space-y-4 lg:max-w-5xl">
                    <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl text-gray-900 dark:text-white">Meet Our Team</h2>
                    <p class="text-xl text-gray-500 dark:text-gray-300">
                        Our team of experienced professionals is dedicated to providing the best venue discovery and booking experience.
                    </p>
                </div>
                <ul class="mx-auto space-y-16 sm:grid sm:grid-cols-2 sm:gap-16 sm:space-y-0 lg:grid-cols-3 lg:max-w-5xl">
                    <li>
                        <div class="space-y-6">
                            <img class="mx-auto h-40 w-40 rounded-full xl:w-56 xl:h-56 object-cover" 
                                 src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" 
                                 alt="CEO">
                            <div class="space-y-2">
                                <div class="text-lg leading-6 font-medium space-y-1">
                                    <h3 class="text-gray-900 dark:text-white">John Smith</h3>
                                    <p class="text-indigo-600 dark:text-indigo-400">CEO & Founder</p>
                                </div>
                                <ul class="flex justify-center space-x-5">
                                    <li>
                                        <a href="#" class="text-gray-400 hover:text-gray-500">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-gray-400 hover:text-gray-500">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="space-y-6">
                            <img class="mx-auto h-40 w-40 rounded-full xl:w-56 xl:h-56 object-cover" 
                                 src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=688&q=80" 
                                 alt="CTO">
                            <div class="space-y-2">
                                <div class="text-lg leading-6 font-medium space-y-1">
                                    <h3 class="text-gray-900 dark:text-white">Sarah Johnson</h3>
                                    <p class="text-indigo-600 dark:text-indigo-400">CTO</p>
                                </div>
                                <ul class="flex justify-center space-x-5">
                                    <li>
                                        <a href="#" class="text-gray-400 hover:text-gray-500">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-gray-400 hover:text-gray-500">
                                            <i class="fab fa-github"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="space-y-6">
                            <img class="mx-auto h-40 w-40 rounded-full xl:w-56 xl:h-56 object-cover" 
                                 src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" 
                                 alt="Marketing Director">
                            <div class="space-y-2">
                                <div class="text-lg leading-6 font-medium space-y-1">
                                    <h3 class="text-gray-900 dark:text-white">Michael Brown</h3>
                                    <p class="text-indigo-600 dark:text-indigo-400">Marketing Director</p>
                                </div>
                                <ul class="flex justify-center space-x-5">
                                    <li>
                                        <a href="#" class="text-gray-400 hover:text-gray-500">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-gray-400 hover:text-gray-500">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Call to Action -->
    <div class="bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                <span class="block">Ready to experience PartyPlex?</span>
                <span class="block text-indigo-600 dark:text-indigo-400">Start searching for your perfect venue today.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="{{ route('venues.index') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Find Venues
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
                        Sign Up
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 