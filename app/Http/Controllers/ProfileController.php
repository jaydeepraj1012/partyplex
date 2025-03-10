<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        try {
            // Fill validated data
            $user->fill($request->validated());
    
            // Handle email verification if email is changed
            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }
            
            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                // Verify the file size is within limits
                $fileSize = $request->file('profile_image')->getSize();
                if ($fileSize > 2 * 1024 * 1024) { // 2MB
                    return Redirect::route('profile.edit')
                        ->with('error', 'The profile image size exceeds the maximum allowed size of 2MB.');
                }
                
                // Delete old image if exists
                if ($user->profile_image) {
                    Storage::disk('public')->delete($user->profile_image);
                }
                
                // Store the new image
                $path = $request->file('profile_image')->store('profile-images', 'public');
                $user->profile_image = $path;
            }
            
            $user->save();
            
            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Profile update error: ' . $e->getMessage());
            
            return Redirect::route('profile.edit')
                ->with('error', 'There was an error updating your profile. Please try again.');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete profile image if exists
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
