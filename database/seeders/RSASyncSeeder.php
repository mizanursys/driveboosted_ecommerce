<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RSASyncSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks to truncate tables
        Schema::disableForeignKeyConstraints();
        
        DB::table('order_items')->truncate();
        DB::table('stock_movements')->truncate();
        DB::table('products')->truncate();
        DB::table('categories')->truncate();
        
        Schema::enableForeignKeyConstraints();

        $collectionsUrl = 'https://www.getrsa.com/collections.json';
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Accept' => 'application/json',
        ])->retry(3, 2000)->get($collectionsUrl);

        if (!$response->successful()) {
            $this->command->error('Failed to fetch collections');
            return;
        }

        $collections = $response->json()['collections'];

        foreach ($collections as $collection) {
            if ($collection['handle'] === 'all' || $collection['products_count'] == 0) {
                continue;
            }

            $category = Category::create([
                'name' => $collection['title'],
                'slug' => $collection['handle'],
                'image' => null, // Will update with first product image if needed
                'is_active' => true,
            ]);

            $this->command->info("Created Category: {$category->name}");

            sleep(2); // Deliberate delay to avoid bot detection

            $productsUrl = "https://www.getrsa.com/collections/{$collection['handle']}/products.json?limit=250";
            $prodResponse = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'Accept' => 'application/json',
            ])->retry(3, 2000)->get($productsUrl);

            if ($prodResponse->successful()) {
                $products = $prodResponse->json()['products'];
                
                foreach ($products as $index => $prod) {
                    $variant = $prod['variants'][0] ?? null;
                    $image = $prod['images'][0]['src'] ?? null;

                    // Update category image with the first product image if category image is null
                    if ($index === 0 && $image) {
                        $category->update(['image' => $image]);
                    }

                    Product::create([
                        'category_id' => $category->id,
                        'name' => $prod['title'],
                        'slug' => $prod['handle'],
                        'sku' => $variant['sku'] ?? 'RSA-' . strtoupper(Str::random(8)),
                        'description' => $prod['body_html'] ?? '',
                        'price' => $variant['price'] ?? 0,
                        'cost_price' => 0,
                        'stock_quantity' => rand(50, 200),
                        'low_stock_threshold' => 10,
                        'image' => $image,
                        'is_featured' => true,
                        'is_active' => true,
                    ]);
                }
                $this->command->info("  Imported " . count($products) . " products for {$category->name}");
            } else {
                $this->command->error("  Failed to fetch products for {$category->name}");
            }
        }
    }
}
