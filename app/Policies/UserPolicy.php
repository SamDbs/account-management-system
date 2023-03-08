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
        return $user->role->name === 'admin';
    }

    /**
     * Determine if user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->role->name === 'admin' || $user->id === auth()->id();
    }

    /**
     * Determine if user can create the model.
     */
    public function create(): bool
    {
        return auth()->user()->role->name === 'admin';
    }

    /**
     * Determine if user can create the model.
     */
    public function store(): bool
    {
        return auth()->user()->role->name === 'admin';
    }

    /**
     * Determine if user can update the model.
     */
    public function edit(User $user,User $profileUser): bool
    {
        return $user->role->name === 'admin' || $user->id === $profileUser->id;
    }

    /**
     * Determine if user can update the model.
     */
    public function update(User $user, User $profileUser): bool
    {
        return $user->role->name === 'admin' || $user->id === $profileUser->id;
    }

    /**
     * Determine if user can delete the model.
     */
    public function destroy(User $user, User $profileUser): bool
    {
        return $user->role->name === 'admin' || $user->id === $profileUser->id;
    }
}
