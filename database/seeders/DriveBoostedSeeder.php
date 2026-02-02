<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class DriveBoostedSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing to avoid confusion with RSA
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        Category::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = [
            'Accessories' => 'Premium microfiber, applicators, and detailing tools.',
            'Ceramic Coating' => 'Ultimate surface protection and gloss.',
            'Cleaners' => 'pH balanced solutions for all surfaces.',
            'Compound' => 'Professional paint correction formulas.',
        ];

        foreach ($categories as $name => $desc) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $desc,
                'image' => 'images/accessories.png' // Using the generic detailing image for categories
            ]);
        }

        $acc = Category::where('name', 'Accessories')->first();
        $cer = Category::where('name', 'Ceramic Coating')->first();

        Product::create([
            'category_id' => $acc->id,
            'name' => 'Ceramax Gray Towels (High & Low Pile)',
            'slug' => 'ceramax-gray-towels',
            'sku' => 'DB-T001',
            'description' => 'Premium dual-pile microfiber towels for versatile detailing tasks.',
            'price' => 380,
            'cost_price' => 200,
            'stock_quantity' => 100,
            'image' => 'images/products/ceramax-towels.png',
            'is_featured' => true
        ]);

        Product::create([
            'category_id' => $acc->id,
            'name' => 'Hurricane Car Dryer - TT24',
            'slug' => 'hurricane-car-dryer',
            'sku' => 'DB-H001',
            'description' => 'Professional high-velocity air dryer for touchless car drying.',
            'price' => 14800,
            'cost_price' => 10000,
            'stock_quantity' => 10,
            'image' => 'images/products/hurricane-dryer.png',
            'is_featured' => true
        ]);

        Product::create([
            'category_id' => $cer->id,
            'name' => 'Ceramax Graphene Coating - DB01',
            'slug' => 'ceramax-graphene-coating',
            'sku' => 'DB-G001',
            'description' => 'Elite level graphene ceramic coating for 5+ years of protection.',
            'price' => 4500,
            'cost_price' => 2500,
            'stock_quantity' => 50,
            'image' => 'images/products/graphene-coating.png',
            'is_featured' => true
        ]);

        Product::create([
            'category_id' => $acc->id,
            'name' => 'Ceramax Gold XL XL Microfiber',
            'slug' => 'ceramax-gold-xl',
            'sku' => 'DB-T002',
            'description' => 'Ultra-plush drying towel for absorbing maximum water without scratches.',
            'price' => 850,
            'cost_price' => 400,
            'stock_quantity' => 75,
            'image' => 'images/products/gold-xl-towel.png',
            'is_featured' => true
        ]);
    }
}
