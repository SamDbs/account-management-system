<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class UserPolicy
{
    /**
     * @var Role
     */
    protected Role $adminRole;
    public function __construct( )
    {
        $this->adminRole = Role::where('name', 'admin')->first();
    }
    /**
     * Determine if user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role_id === $this->adminRole->id;
    }

    /**
     * Determine if user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->role_id === $this->adminRole->id || $user->id === auth()->id();
    }

    /**
     * Determine if user can create the model.
     */
    public function create(User $user): bool
    {
        return $user->role_id === $this->adminRole->id;
    }

    /**
     * Determine if user can update the model.
     */
    public function edit(User $user,User $profileUser): bool
    {
        return $user->role_id === $this->adminRole->id || $user->id === $profileUser->id;
    }

    /**
     * Determine if user can update the model.
     */
    public function update(User $user, User $profileUser): bool
    {
        return $user->role_id === $this->adminRole->id || $user->id === $profileUser->id;
    }

    /**
     * Determine if user can delete the model.
     */
    public function destroy(User $user, User $profileUser): bool
    {
        return $user->role_id === $this->adminRole->id || $user->id === $profileUser->id;
    }
}
