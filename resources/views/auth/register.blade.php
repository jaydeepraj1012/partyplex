<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" id="name-error"/>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" id="email-error"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" id="password-error"/>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" id="password-confirmation-error"/>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4" id="registerButton">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const registerForm = document.getElementById('registerForm');
            const registerButton = document.getElementById('registerButton');
            
            // Check for errors and display SweetAlert
            @if($errors->any())
                let errorMessage = '';
                
                @foreach($errors->all() as $error)
                    errorMessage += "{{ $error }}<br>";
                @endforeach
                
                Swal.fire({
                    title: 'Registration Failed',
                    html: errorMessage,
                    icon: 'error',
                    confirmButtonColor: '#4F46E5',
                    confirmButtonText: 'Try Again'
                });
            @endif
            
            registerForm.addEventListener('submit', function(e) {
                // Prevent default form submission
                e.preventDefault();
                
                // Basic validation
                const password = document.getElementById('password').value;
                const passwordConfirmation = document.getElementById('password_confirmation').value;
                
                if (password !== passwordConfirmation) {
                    Swal.fire({
                        title: 'Password Mismatch',
                        text: 'Password and confirmation do not match',
                        icon: 'error',
                        confirmButtonColor: '#4F46E5'
                    });
                    return;
                }
                
                // Show loading animation
                showLoading('Creating your account...');
                
                // Submit the form
                this.submit();
            });
        });
    </script>
</x-guest-layout>
