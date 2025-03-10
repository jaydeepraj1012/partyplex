<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Venue;
use Illuminate\Auth\Access\Response;

class VenuePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Everyone can view the list of venues
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Venue $venue): bool
    {
        // User can view the venue if they own it or have admin permissions
        return $user->id === $venue->user_id 
            || $user->hasPermissionTo('view venues');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create venues');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Venue $venue): bool
    {
        // User can update the venue if they own it or have admin permissions
        return $user->id === $venue->user_id 
            || $user->hasPermissionTo('edit venues');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Venue $venue): bool
    {
        // User can delete the venue if they own it or have admin permissions
        return $user->id === $venue->user_id 
            || $user->hasPermissionTo('delete venues');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Venue $venue): bool
    {
        // User can restore the venue if they have admin permissions
        return $user->hasPermissionTo('edit venues');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Venue $venue): bool
    {
        // User can force delete the venue if they have admin permissions
        return $user->hasPermissionTo('delete venues');
    }
}
