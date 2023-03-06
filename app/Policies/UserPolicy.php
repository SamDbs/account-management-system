<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine if user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if user can create the model.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->role === 'admin';
    }
}
