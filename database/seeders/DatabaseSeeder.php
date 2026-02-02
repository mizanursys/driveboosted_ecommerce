<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Clear existing data
        Schema::disableForeignKeyConstraints();
        User::truncate();
        \App\Models\Product::truncate();
        \App\Models\Category::truncate();
        \App\Models\Service::truncate();
        Schema::enableForeignKeyConstraints();

        // Create Admin User
        User::create([
            'name' => 'Drive Boosted Admin',
            'email' => 'admin@driveboosted.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Run Role Permission Seeder
        $this->call(RolePermissionSeeder::class);

        // Run Drive Boosted Data Seeder
        $this->call(DriveBoostedDataSeeder::class);
    }
}
