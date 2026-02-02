<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class DriveBoostedDataSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Product::truncate();
        Category::truncate();
        Service::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Categories
        $categories = [
            ['name' => 'Complete Detailing', 'description' => 'Full vehicle restoration inside and out.'],
            ['name' => 'Exterior Detailing', 'description' => 'Professional paint correction and surface decontamination.'],
            ['name' => 'Ceramic Coating', 'description' => 'Nano-technology surface protection for long-term shield.'],
            ['name' => 'Interior Detailing', 'description' => 'Deep cleaning and sanitation of the vehicle cabin.'],
            ['name' => 'General Service', 'description' => 'Routine maintenance and specialized care protocols.'],
            ['name' => 'PPF & Wrap', 'description' => 'Paint Protection Film and aesthetic vinyl conversions.'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'description' => $cat['description'],
                'image' => 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?q=80&w=2070&auto=format&fit=crop'
            ]);
        }

        $cats = Category::all()->pluck('id', 'slug');

        // 2. Services (Based on Tonyin Bangladesh)
        $services = [
            [
                'name' => 'Nano Ceramic Coating',
                'category' => 'Ceramic Coating',
                'description' => 'Premium 9H hardness coating providing unmatched protection and permanent gloss bond.',
                'price' => 25000,
                'duration' => '2-3 Days',
                'image' => 'https://images.unsplash.com/photo-1616763355548-1b606f439f86?q=80&w=2070&auto=format&fit=crop'
            ],
            [
                'name' => 'Exterior Restoration (Stage 2)',
                'category' => 'Exterior Detailing',
                'description' => 'Multi-stage machine polishing to remove swirl marks and restore factory-new clarity.',
                'price' => 15000,
                'duration' => '1 Day',
                'image' => 'https://images.unsplash.com/photo-1613214150384-09874a7b738b?q=80&w=2071&auto=format&fit=crop'
            ],
            [
                'name' => 'Interior Deep Sanitization',
                'category' => 'Interior Detailing',
                'description' => 'Deep extraction cleaning, steam treatment, and premium leather conditioning.',
                'price' => 8000,
                'duration' => '6 Hours',
                'image' => 'https://images.unsplash.com/photo-1593466144596-9abe3ed2f5df?q=80&w=2070&auto=format&fit=crop'
            ],
            [
                'name' => 'Complete Detailing Package',
                'category' => 'Complete Detailing',
                'description' => 'The ultimate protocol involving both interior deep clean and exterior paint correction.',
                'price' => 20000,
                'duration' => '2 Days',
                'image' => 'https://images.unsplash.com/photo-1601362840469-51e4d8d59085?q=80&w=2070&auto=format&fit=crop'
            ],
            [
                'name' => 'Glass & Wheel Coating',
                'category' => 'Exterior Detailing',
                'description' => 'Specialized hydrophobic coating for better visibility and brake dust resistance.',
                'price' => 6000,
                'duration' => '4 Hours',
                'image' => 'https://images.unsplash.com/photo-1621359953476-b04967344f6e?q=80&w=2070&auto=format&fit=crop'
            ],
            [
                'name' => 'Engine Bay Detailing',
                'category' => 'General Service',
                'description' => 'Clinical cleaning and protection of the engine compartment surfaces.',
                'price' => 3500,
                'duration' => '2 Hours',
                'image' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=2070&auto=format&fit=crop'
            ],
        ];

        foreach ($services as $svc) {
            Service::create([
                'name' => $svc['name'],
                'slug' => Str::slug($svc['name']),
                'category' => $svc['category'],
                'description' => $svc['description'],
                'price' => $svc['price'],
                'duration' => $svc['duration'],
                'image' => $svc['image'],
                'is_active' => true
            ]);
        }

        // 3. Products
        $products = [
            [
                'category_id' => $cats['ceramic-coating'],
                'name' => 'Graphene Ceramic Coating 50ml',
                'price' => 4500,
                'description' => 'Next generation graphene coating for ultimate slickness and water beading.',
                'image' => 'https://images.unsplash.com/photo-1607860108855-64acf2078ed9?q=80&w=2071&auto=format&fit=crop',
                'is_featured' => true
            ],
            [
                'category_id' => $cats['exterior-detailing'],
                'name' => 'Hyper Compound V2',
                'price' => 2200,
                'description' => 'Fast cutting compound that finishes like a polish.',
                'image' => 'https://images.unsplash.com/photo-1597328290308-498b72528159?q=80&w=2070&auto=format&fit=crop',
                'is_featured' => true
            ],
            [
                'category_id' => $cats['exterior-detailing'],
                'name' => 'Mirror Finish Polish',
                'price' => 1950,
                'description' => 'Ultra-fine polish for the ultimate mirror-like clarity.',
                'image' => 'https://images.unsplash.com/photo-1616763355548-1b606f439f86?q=80&w=2070&auto=format&fit=crop',
                'is_featured' => true
            ],
            [
                'category_id' => $cats['interior-detailing'],
                'name' => 'Leather Serum Pro',
                'price' => 1800,
                'description' => 'Satin finish leather protectant with UV blockers.',
                'image' => 'https://images.unsplash.com/photo-1584622781564-1d9876a1df72?q=80&w=2070&auto=format&fit=crop',
                'is_featured' => true
            ],
            [
                'category_id' => $cats['ppf-wrap'],
                'name' => 'PPF Maintenance Spray',
                'price' => 2400,
                'description' => 'Specialized spray for maintaining self-healing PPF.',
                'image' => 'https://images.unsplash.com/photo-1601362840469-51e4d8d59085?q=80&w=2070&auto=format&fit=crop',
                'is_featured' => true
            ],
        ];

        foreach ($products as $prod) {
            Product::create([
                'category_id' => $prod['category_id'],
                'name' => $prod['name'],
                'slug' => Str::slug($prod['name']),
                'description' => $prod['description'],
                'price' => $prod['price'],
                'image' => $prod['image'],
                'is_featured' => $prod['is_featured'],
                'sku' => strtoupper(Str::random(8)),
                'stock_quantity' => rand(10, 50)
            ]);
        }
    }
}
