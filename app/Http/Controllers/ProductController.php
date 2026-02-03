<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->where('is_featured', true)->latest()->take(12)->get();
        if ($products->isEmpty()) {
            $products = Product::with('category')->latest()->take(12)->get();
        }
        
        // Get services for homepage display
        $services = \App\Models\Service::where('is_active', true)->get();
        
        // Get categories for homepage display
        $categories = Category::withCount('products')->orderBy('name')->take(8)->get();

        // Get Hero Slides
        $hero_slides = \App\Models\HeroSlide::where('is_active', true)->orderBy('order')->get();
        
        return view('welcome', compact('products', 'services', 'categories', 'hero_slides'));
    }

    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
        
        // Get services for the detail page
        $services = \App\Models\Service::where('is_active', true)->take(3)->get();
        
        // Get featured/best-selling products
        $featuredProducts = Product::with('category')
            ->where('is_featured', true)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
        
        return view('product-detail', compact('product', 'relatedProducts', 'services', 'featuredProducts'));
    }

    public function catalog(Request $request)
    {
        $categories = Category::all();
        $query = Product::with('category');

        // Filter by category
        if ($request->has('category') && $request->category) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Filter by query
        if ($request->has('q') && $request->q) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Sort
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        return view('catalog', compact('products', 'categories'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $products = Product::with('category')
            ->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->paginate(12)
            ->withQueryString();
        
        $categories = Category::all();
        
        return view('catalog', compact('products', 'categories'));
    }

    public function quickView($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('partials.product-quick-view', compact('product'))->render();
    }
}
