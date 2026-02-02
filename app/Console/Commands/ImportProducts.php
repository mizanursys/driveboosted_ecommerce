<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ImportProducts extends Command
{
    protected $signature = 'app:import-products';
    protected $description = 'Import products from getrsa.com';

    public function handle()
    {
        $this->info('Starting a clean product import...');

        // Optional: Clear existing products if you want a perfect mirror
        if ($this->confirm('Do you want to clear existing products and categories first?', false)) {
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Product::truncate();
            Category::truncate();
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $this->info('Cleared existing data.');
        }

        $url = 'https://www.getrsa.com/products.json?limit=250';
        $response = Http::get($url);

        if (!$response->successful()) {
            $this->error('Failed to fetch products from ' . $url);
            return;
        }

        $data = $response->json();
        $products = $data['products'] ?? [];

        $this->info('Found ' . count($products) . ' products.');

        foreach ($products as $item) {
            $this->info('Processing: ' . $item['title']);

            // Improved Category Mapping
            $pType = strtolower($item['product_type'] ?: '');
            $tags = strtolower($item['tags'] ?: '');
            
            $catSlug = 'general';
            $catName = 'General';

            if (str_contains($pType, 'cleaner') || str_contains($tags, 'cleaner')) { $catSlug = 'cleaners'; $catName = 'Cleaners'; }
            elseif (str_contains($pType, 'polish') || str_contains($tags, 'polish') || str_contains($pType, 'compound')) { $catSlug = 'polish-compound'; $catName = 'Polish Compound'; }
            elseif (str_contains($pType, 'coating') || str_contains($tags, 'coating') || str_contains($pType, 'ceramic')) { $catSlug = 'ceramic-coating'; $catName = 'Ceramic Coating'; }
            elseif (str_contains($pType, 'wax') || str_contains($tags, 'wax') || str_contains($pType, 'clay')) { $catSlug = 'wax-clay-bar'; $catName = 'Wax & Clay Bar'; }
            elseif (str_contains($pType, 'oil') || str_contains($tags, 'additives')) { $catSlug = 'oil-additives'; $catName = 'Oil Additives'; }
            elseif (str_contains($pType, 'accessory') || str_contains($tags, 'tool') || str_contains($tags, 'accessory')) { $catSlug = 'accessories'; $catName = 'Accessories'; }
            elseif (str_contains($tags, 'ppf') || str_contains($tags, 'tint') || str_contains($pType, 'window')) { $catSlug = 'ppf-window-tint'; $catName = 'PPF & Window Tint'; }

            $category = Category::firstOrCreate(
                ['slug' => $catSlug],
                ['name' => $catName]
            );

            // Shopify variant price
            $price = $item['variants'][0]['price'] ?? 0;

            // Handle image - prioritizing high res
            $imagePath = null;
            if (!empty($item['images'])) {
                $imageUrl = $item['images'][0]['src'];
                try {
                    $imageContents = Http::get($imageUrl)->body();
                    $imageName = basename(parse_url($imageUrl, PHP_URL_PATH));
                    $imagePath = 'products/' . $imageName;
                    Storage::disk('public')->put($imagePath, $imageContents);
                } catch (\Exception $e) {
                    $this->error('Failed to download image: ' . $imageUrl);
                    // Use external link if download fails
                    $imagePath = $imageUrl;
                }
            }

            Product::updateOrCreate(
                ['slug' => $item['handle']],
                [
                    'category_id' => $category->id,
                    'name' => $item['title'],
                    'description' => $item['body_html'] ?: '',
                    'price' => $price,
                    'image' => $imagePath,
                    'is_featured' => true,
                    'sku' => $item['variants'][0]['sku'] ?? null,
                    'stock_quantity' => 100,
                    'cost_price' => $item['variants'][0]['compare_at_price'] ?? ($price * 0.7),
                ]
            );
        }

        $this->info('Product import completed successfully!');
    }
}
