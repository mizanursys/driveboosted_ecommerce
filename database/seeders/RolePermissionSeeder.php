<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define Permissions
        $permissions = [
            ['name' => 'View Dashboard', 'slug' => 'view_dashboard'],
            ['name' => 'Manage Products', 'slug' => 'manage_products'],
            ['name' => 'Manage Categories', 'slug' => 'manage_categories'],
            ['name' => 'Manage Orders', 'slug' => 'manage_orders'],
            ['name' => 'Manage Users', 'slug' => 'manage_users'],
            ['name' => 'View Reports', 'slug' => 'view_reports'],
            ['name' => 'Access POS', 'slug' => 'access_pos'],
        ];

        foreach ($permissions as $p) {
            \App\Models\Permission::updateOrCreate(['slug' => $p['slug']], $p);
        }

        // Define Roles and Assign Permissions
        $roles = [
            'admin' => [
                'name' => 'Admin',
                'description' => 'Full system access',
                'permissions' => ['view_dashboard', 'manage_products', 'manage_categories', 'manage_orders', 'manage_users', 'view_reports', 'access_pos'],
            ],
            'manager' => [
                'name' => 'Manager',
                'description' => 'Manage shop operations',
                'permissions' => ['view_dashboard', 'manage_products', 'manage_categories', 'manage_orders', 'view_reports'],
            ],
            'cashier' => [
                'name' => 'Cashier',
                'description' => 'Process sales via POS',
                'permissions' => ['view_dashboard', 'access_pos'],
            ],
            'customer' => [
                'name' => 'Customer',
                'description' => 'Standard customer account',
                'permissions' => [],
            ],
        ];

        foreach ($roles as $slug => $data) {
            $role = \App\Models\Role::updateOrCreate(
                ['slug' => $slug],
                ['name' => $data['name'], 'description' => $data['description']]
            );

            $permissionIds = \App\Models\Permission::whereIn('slug', $data['permissions'])->pluck('id');
            $role->permissions()->sync($permissionIds);
        }

        // Assign Admin role to the first user
        $admin = \App\Models\User::where('email', 'admin@driveboosted.com')->first();
        if ($admin) {
            $admin->roles()->sync(\App\Models\Role::where('slug', 'admin')->pluck('id'));
        }
    }
}
