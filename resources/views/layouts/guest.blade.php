<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PartyPlex') }}</title>

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
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div>
                <a href="/">
                    <span class="text-xl font-semibold text-indigo-600 dark:text-indigo-400">
                        <i class="fas fa-building mr-2"></i>PartyPlex
                    </span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>

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
            
            // Auth specific status messages
            @if(session('status'))
                @if(session('status') == 'verification-link-sent')
                    Swal.fire({
                        title: 'Verification Email Sent',
                        text: 'A new verification link has been sent to your email address.',
                        icon: 'success',
                        confirmButtonColor: '#4F46E5'
                    });
                @elseif(session('status') == 'password-updated')
                    Swal.fire({
                        title: 'Password Updated',
                        text: 'Your password has been updated successfully.',
                        icon: 'success',
                        confirmButtonColor: '#4F46E5'
                    });
                @elseif(session('status') == 'profile-updated')
                    Swal.fire({
                        title: 'Profile Updated',
                        text: 'Your profile has been updated successfully.',
                        icon: 'success',
                        confirmButtonColor: '#4F46E5'
                    });
                @elseif(session('status') == 'auth-failed')
                    Swal.fire({
                        title: 'Authentication Failed',
                        text: 'Invalid login credentials. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#4F46E5'
                    });
                @else
                    Swal.fire({
                        title: 'Information',
                        text: "{{ session('status') }}",
                        icon: 'info',
                        confirmButtonColor: '#4F46E5'
                    });
                @endif
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
    </body>
</html>
