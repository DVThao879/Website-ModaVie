<?php

namespace App\Policies;

use App\Models\Size;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SizePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [1, 2]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Size $size): bool
    {
        return in_array($user->role, [1, 2]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 2;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Size $size): bool
    {
        return $user->role === 2;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Size $size): bool
    {
        return $user->role === 2;
    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(User $user, Size $size): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(User $user, Size $size): bool
    // {
    //     //
    // }
}
