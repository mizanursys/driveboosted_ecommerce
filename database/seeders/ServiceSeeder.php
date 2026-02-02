<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'General Detail Service',
                'category' => 'General Service',
                'description' => 'Comprehensive exterior wash, vacuum, and interior wipe down with glass cleaning.',
                'price' => 2500,
                'duration' => '3 HOURS',
                'is_active' => true,
            ],
            [
                'name' => 'Deep Interior Detailing',
                'category' => 'Interior Detailing',
                'description' => 'Steam cleaning of seats and carpets, leather conditioning, and deep sanitation of all surfaces.',
                'price' => 5500,
                'duration' => '5 HOURS',
                'is_active' => true,
            ],
            [
                'name' => 'Ceramic Coating (Standard)',
                'category' => 'Ceramic Coating',
                'description' => '9H hardness ceramic coating with 2 years of protection and extreme gloss enhancement.',
                'price' => 12000,
                'duration' => '24 HOURS',
                'is_active' => true,
            ],
            [
                'name' => 'Ceramic Coating (Pro)',
                'category' => 'Ceramic Coating',
                'description' => '10H advanced ceramic coating with 5 years of protection and superior chemical resistance.',
                'price' => 25000,
                'duration' => '48 HOURS',
                'is_active' => true,
            ],
            [
                'name' => 'Exterior Detail & Polish',
                'category' => 'Exterior Detailing',
                'description' => 'Single-stage paint correction to remove light swirls and restore deep gloss.',
                'price' => 4500,
                'duration' => '6 HOURS',
                'is_active' => true,
            ],
            [
                'name' => 'Full RSA Laboratory Package',
                'category' => 'Complete Detailing',
                'description' => 'Complete detailing service including Ceramic Coating, Interior Spa, and Engine Bay cleaning.',
                'price' => 35000,
                'duration' => '72 HOURS',
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['name' => $service['name']],
                array_merge($service, ['slug' => Str::slug($service['name'])])
            );
        }
    }
}
