<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class FixAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure the Admin Role exists
        $adminRole = Role::firstOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Admin',
                'description' => 'Full system access',
            ]
        );

        // 2. Create or Update the Admin User
        $user = User::updateOrCreate(
            ['email' => 'admin@driveboosted.com'],
            [
                'name' => 'Drive Boosted Admin',
                'password' => Hash::make('password'), // Ensure password is set to 'password'
                'email_verified_at' => now(),
            ]
        );

        // 3. Assign the Admin Role
        if (!$user->roles()->where('slug', 'admin')->exists()) {
            $user->roles()->attach($adminRole);
            $this->command->info('Admin role assigned to admin@driveboosted.com');
        } else {
            $this->command->info('User already has admin role.');
        }

        $this->command->info('Admin user fixed: admin@driveboosted.com / password');
    }
}
