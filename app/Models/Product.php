<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'price',
        'stock_quantity',
        'category_id',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderLines()
    {
        return $this->hasMany(OrderLine::class);
    }

    public function stocks()
    {
        return $this->hasMany(ProductStock::class);
    }

    public function mainStock()
    {
        return $this->hasOne(ProductStock::class)
            ->where('warehouse_location', 'Main Warehouse')
            ->whereNull('seller_id');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        $primaryImage = $this->primaryImage;
        return $primaryImage ? asset($primaryImage->image_path) : asset('images/no-image.png');
        // return $primaryImage ? asset('storage/' . $primaryImage->image_path) : asset('images/no-image.png');
    }

    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Stock Management Methods
    public function isInStock($quantity = 1, $sellerId = null)
    {
        $mainStock = $this->mainStock;
        if (!$mainStock) {
            return $this->stock_quantity >= $quantity;
        }
        
        $availableStock = $mainStock->quantity - $mainStock->reserved_quantity;
        return $availableStock >= $quantity;
    }


    public function getTotalStockAttribute()
    {
        return $this->stocks()->sum('quantity');
    }

    public function reserveStock($quantity, $orderId, $sellerId = null)
    {
        $stock = $this->mainStock;
        
        if (!$stock) {
            throw new \Exception("No stock record found for this product");
        }

        return $stock->reserveStock($quantity, $orderId);
    }


    public function getAvailableStockAttribute()
    {
        $mainStock = $this->mainStock;
        if (!$mainStock) {
            return $this->stock_quantity; // Fallback to product stock_quantity
        }
        return $mainStock->quantity - $mainStock->reserved_quantity;
    }
}