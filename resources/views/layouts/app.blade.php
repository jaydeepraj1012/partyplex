<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PartyPlex') }} - @yield('title', 'Find Your Perfect Venue')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        
        <!-- Toastr CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        
        <!-- SweetAlert2 CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Google Maps -->
        @if(config('googlemaps.api_key'))
            <script src="https://maps.googleapis.com/maps/api/js?key={{ config('googlemaps.api_key') }}&libraries=places" defer></script>
        @endif
        
        <!-- Custom Styles -->
        @yield('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative max-w-7xl mx-auto mt-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-7xl mx-auto mt-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-800 shadow mt-8 py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ config('app.name', 'PartyPlex') }}</h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                Find the perfect venue for your next event - farmhouses, banquet halls, party venues, and more.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h3>
                            <ul class="space-y-2">
                                <li><a href="{{ route('venues.index') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Browse Venues</a></li>
                                <li><a href="{{ route('about') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">About Us</a></li>
                                <li><a href="{{ route('contact') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Contact Us</a></li>
                                <li><a href="{{ route('faq') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">FAQ</a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Legal</h3>
                            <ul class="space-y-2">
                                <li><a href="{{ route('terms') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Terms & Conditions</a></li>
                                <li><a href="{{ route('privacy') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Privacy Policy</a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Connect With Us</h3>
                            <div class="flex space-x-4">
                                <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700 mt-8 pt-8 text-center text-gray-600 dark:text-gray-300">
                        <p>&copy; {{ date('Y') }} {{ config('app.name', 'PartyPlex') }}. All rights reserved. Developed by jaydeepraj1012</p>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Scripts -->
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <!-- Toastr JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        
        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <script>
            // Configure Toastr
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            
            // Flash messages using Toastr
            @if(session('success'))
                toastr.success("{{ session('success') }}");
                // Also show SweetAlert for important success messages
                Swal.fire({
                    title: 'Success',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonColor: '#4F46E5'
                });
            @endif
            
            @if(session('error'))
                toastr.error("{{ session('error') }}");
                // Also show SweetAlert for errors
                Swal.fire({
                    title: 'Error',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonColor: '#4F46E5'
                });
            @endif
            
            @if(session('info'))
                toastr.info("{{ session('info') }}");
            @endif
            
            @if(session('warning'))
                toastr.warning("{{ session('warning') }}");
            @endif
            
            // Auth-specific messages
            @if(session('status') == 'verification-link-sent')
                Swal.fire({
                    title: 'Verification Email Sent',
                    text: 'A new verification link has been sent to your email address.',
                    icon: 'success',
                    confirmButtonColor: '#4F46E5'
                });
            @endif
            
            @if(session('status') && in_array(session('status'), ['login-success', 'registration-success']))
                Swal.fire({
                    title: 'Success!',
                    text: session('status') == 'login-success' ? 'You have successfully logged in.' : 'Your account has been created successfully.',
                    icon: 'success',
                    confirmButtonColor: '#4F46E5'
                });
            @endif
            
            // Loading indicator function
            window.showLoading = function(message = 'Processing...') {
                Swal.fire({
                    title: message,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            };
            
            window.hideLoading = function() {
                Swal.close();
            };
        </script>
        @yield('scripts')
    </body>
</html>
