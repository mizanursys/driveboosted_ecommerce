<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Define RSA Premium Categories
        $categories = [
            [
                'name' => 'Ceramic Coatings',
                'description' => 'Permanent nano-ceramic protection for paint and wheels.',
                'image' => 'https://cdn.shopify.com/s/files/1/0793/0216/4717/files/ceramic_coating_banner.jpg?v=1706600000'
            ],
            [
                'name' => 'Wash & Decontamination',
                'description' => 'pH-neutral shampoos and iron removers for maintenance.',
                'image' => 'https://cdn.shopify.com/s/files/1/0793/0216/4717/files/detailing_banner.jpg?v=1706600001'
            ],
            [
                'name' => 'Paint Correction',
                'description' => 'Compounds, polishes, and pads for defect removal.',
                'image' => 'https://cdn.shopify.com/s/files/1/0793/0216/4717/files/polishing_pad.jpg?v=1706600002'
            ],
            [
                'name' => 'Interior Lab',
                'description' => 'Leather, fabric, and plastic protection systems.',
                'image' => 'https://cdn.shopify.com/s/files/1/0793/0216/4717/files/interior_detail.jpg?v=1706600003'
            ],
            [
                'name' => 'Accessories & Tools',
                'description' => 'Premium microfiber, brushes, and application tools.',
                'image' => 'https://cdn.shopify.com/s/files/1/0793/0216/4717/files/brushes.jpg?v=1706600004'
            ]
        ];

        foreach ($categories as $catData) {
            $category = Category::updateOrCreate(
                ['slug' => Str::slug($catData['name'])],
                [
                    'name' => $catData['name'],
                    'description' => $catData['description'],
                    'image' => $catData['image']
                ]
            );
        }

        // Distribute existing products into these categories
        $allCategories = Category::all();
        $products = Product::all();

        foreach ($products as $index => $product) {
            // Round-robin assignment
            $category = $allCategories[$index % $allCategories->count()];
            $product->category_id = $category->id;
            $product->save();
        }
    }
}
