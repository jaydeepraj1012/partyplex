@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-20 lg:px-8">
        <div class="max-w-xl mx-auto lg:max-w-none">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">Contact Us</h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-300">
                    Have questions or feedback? We'd love to hear from you! Fill out the form below or use one of our contact methods.
                </p>
            </div>
            <div class="mt-12">
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                    <!-- Contact Form -->
                    <div class="bg-white dark:bg-gray-700 py-8 px-6 shadow rounded-lg sm:px-10">
                        <form action="{{ route('contact.submit') }}" method="POST" class="mb-0 space-y-6">
                            @csrf
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                <div class="mt-1">
                                    <input id="name" name="name" type="text" 
                                           class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('name') border-red-500 @enderror" 
                                           value="{{ old('name') }}" required>
                                    
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <div class="mt-1">
                                    <input id="email" name="email" type="email" autocomplete="email" 
                                           class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') border-red-500 @enderror" 
                                           value="{{ old('email') }}" required>
                                    
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject</label>
                                <div class="mt-1">
                                    <input id="subject" name="subject" type="text" 
                                           class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('subject') border-red-500 @enderror" 
                                           value="{{ old('subject') }}" required>
                                    
                                    @error('subject')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                                <div class="mt-1">
                                    <textarea id="message" name="message" rows="4" 
                                              class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('message') border-red-500 @enderror" 
                                              required>{{ old('message') }}</textarea>
                                    
                                    @error('message')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-white dark:bg-gray-700 py-8 px-6 shadow rounded-lg sm:px-10">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Get In Touch</h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-md font-medium text-gray-900 dark:text-white">Email</h4>
                                    <p class="mt-1 text-gray-500 dark:text-gray-300">
                                        <a href="mailto:info@partyplex.com" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                            info@partyplex.com
                                        </a>
                                    </p>
                                    <p class="mt-1 text-gray-500 dark:text-gray-300">
                                        <a href="mailto:support@partyplex.com" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                            support@partyplex.com
                                        </a>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-md font-medium text-gray-900 dark:text-white">Phone</h4>
                                    <p class="mt-1 text-gray-500 dark:text-gray-300">
                                        <a href="tel:+12345678900" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                            +1 (234) 567-8900
                                        </a>
                                    </p>
                                    <p class="mt-1 text-gray-500 dark:text-gray-300">
                                        Monday-Friday, 9am to 6pm EST
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-md font-medium text-gray-900 dark:text-white">Office</h4>
                                    <p class="mt-1 text-gray-500 dark:text-gray-300">
                                        123 Main Street<br>
                                        Suite 456<br>
                                        New York, NY 10001<br>
                                        United States
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                        <i class="fas fa-comments"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-md font-medium text-gray-900 dark:text-white">Follow Us</h4>
                                    <div class="mt-2 flex space-x-4">
                                        <a href="#" class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">
                                            <i class="fab fa-facebook-f text-xl"></i>
                                        </a>
                                        <a href="#" class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">
                                            <i class="fab fa-twitter text-xl"></i>
                                        </a>
                                        <a href="#" class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">
                                            <i class="fab fa-instagram text-xl"></i>
                                        </a>
                                        <a href="#" class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">
                                            <i class="fab fa-linkedin-in text-xl"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Map -->
            <div class="mt-12">
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg overflow-hidden">
                    <div class="h-96 w-full">
                        <iframe 
                            class="w-full h-full"
                            style="border:0"
                            loading="lazy"
                            allowfullscreen
                            src="https://www.google.com/maps/embed/v1/place?key={{ config('googlemaps.api_key') }}&q=New+York,NY+10001+USA">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 