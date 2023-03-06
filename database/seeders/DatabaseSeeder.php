<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create user role
        Role::factory()->create();

        // Create user with admin role
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.fr',
            'password' => Hash::make(env('ADMIN_PASSWORD')),
            'role_id' => Role::factory()->admin()->create()
        ]);


    }
}
