<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class RSAImportSeeder extends Seeder
{
    public function run()
    {
        $url = 'https://www.getrsa.com/products.json?limit=250';
        $this->command->info("Fetching data from $url...");

        try {
            $response = Http::get($url);
            
            if ($response->failed()) {
                $this->command->error("Failed to fetch data: " . $response->status());
                return;
            }

            $data = $response->json();
            $products = $data['products'] ?? [];
            
            $this->command->info("Found " . count($products) . " products. Starting import...");

            foreach ($products as $rsaProduct) {
                // 1. Handle Category
                $categoryName = $rsaProduct['product_type'] ?: 'Uncategorized';
                
                $category = Category::firstOrCreate(
                    ['slug' => Str::slug($categoryName)],
                    [
                        'name' => $categoryName,
                        // Use the first image of the first product in this category as the category image if available
                        'image' => $rsaProduct['images'][0]['src'] ?? null, 
                        'is_active' => true
                    ]
                );

                // 2. Handle Product
                // Skip if product already exists (by slug)
                if (Product::where('slug', $rsaProduct['handle'])->exists()) {
                    continue;
                }

                // Get price from first variant
                $price = 0;
                if (!empty($rsaProduct['variants'])) {
                    $price = $rsaProduct['variants'][0]['price'] ?? 0;
                }

                // Get image
                $image = null;
                if (!empty($rsaProduct['images'])) {
                    $image = $rsaProduct['images'][0]['src'];
                }

                Product::create([
                    'category_id' => $category->id,
                    'name' => $rsaProduct['title'],
                    'slug' => $rsaProduct['handle'],
                    'description' => strip_tags($rsaProduct['body_html']), // Strip HTML for clean description
                    'price' => $price,
                    'image' => $image, // Store remote URL directly
                    'is_active' => true,
                    'is_featured' => false,
                    'stock_quantity' => 100, // Default stock
                    'sku' => $rsaProduct['variants'][0]['sku'] ?? null,
                ]);
            }

            $this->command->info("Import completed successfully!");

        } catch (\Exception $e) {
            $this->command->error("Error extracting data: " . $e->getMessage());
        }
    }
}
