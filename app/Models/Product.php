<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'sku', 'description', 'price', 
        'cost_price', 'stock_quantity', 'low_stock_threshold', 'image', 
        'is_featured', 'is_active'
    ];

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    public function isLowStock(): bool
    {
        return $this->stock_quantity <= $this->low_stock_threshold;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
