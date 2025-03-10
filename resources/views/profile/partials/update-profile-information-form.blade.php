<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data" id="profileUpdateForm">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Phone Number -->
        <div>
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone ?? '')" autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <!-- Bio/About -->
        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="4">{{ old('bio', $user->bio ?? '') }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <!-- Profile Image -->
        <div>
            <x-input-label for="profile_image" :value="__('Profile Image')" />
            <div class="mt-2 flex items-center">
                <div class="mr-4">
                    @if($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="h-20 w-20 rounded-full object-cover">
                    @else
                        <div class="h-20 w-20 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                            <span class="text-gray-500 dark:text-gray-400 text-2xl">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
                <input id="profile_image" name="profile_image" type="file" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-md file:border-0
                    file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-indigo-700
                    dark:file:bg-indigo-900 dark:file:text-indigo-300
                    hover:file:bg-indigo-100 dark:hover:file:bg-indigo-800"
                    accept="image/*">
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ __('Upload a profile image (max 2MB). Allowed formats: JPG, PNG, GIF. Leave empty to keep current image.') }}
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button id="saveProfileBtn">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileForm = document.getElementById('profileUpdateForm');
            const saveBtn = document.getElementById('saveProfileBtn');
            const profileImageInput = document.getElementById('profile_image');
            
            // Max file size: 2MB
            const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB in bytes
            
            if (profileImageInput) {
                profileImageInput.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        const fileSize = this.files[0].size;
                        
                        // Check if file size exceeds the limit
                        if (fileSize > MAX_FILE_SIZE) {
                            // Reset the file input
                            this.value = '';
                            
                            // Show error alert
                            Swal.fire({
                                title: 'File Too Large',
                                text: 'The profile image must be less than 2MB. Your file size is ' + (fileSize / (1024 * 1024)).toFixed(2) + 'MB.',
                                icon: 'error',
                                confirmButtonColor: '#4F46E5'
                            });
                        }
                    }
                });
            }
            
            if (profileForm && saveBtn) {
                profileForm.addEventListener('submit', function(e) {
                    // Check file size again on submit
                    if (profileImageInput && profileImageInput.files.length > 0) {
                        const fileSize = profileImageInput.files[0].size;
                        
                        if (fileSize > MAX_FILE_SIZE) {
                            e.preventDefault();
                            Swal.fire({
                                title: 'File Too Large',
                                text: 'The profile image must be less than 2MB. Your file size is ' + (fileSize / (1024 * 1024)).toFixed(2) + 'MB.',
                                icon: 'error',
                                confirmButtonColor: '#4F46E5'
                            });
                            return false;
                        }
                    }
                    
                    e.preventDefault();
                    showLoading('Updating profile...');
                    this.submit();
                });
                
                @if (session('status') === 'profile-updated')
                    Swal.fire({
                        title: 'Success!',
                        text: 'Your profile has been updated successfully.',
                        icon: 'success',
                        confirmButtonColor: '#4F46E5'
                    });
                @endif
            }
        });
    </script>
</section>
