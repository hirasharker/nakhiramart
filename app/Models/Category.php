<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'image',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Boot method to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Relationships
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function activeProducts()
    {
        return $this->hasMany(Product::class)
            ->where('is_active', true)
            ->where('stock_quantity', '>', 0);
    }

    public function inStockProducts()
    {
        return $this->hasMany(Product::class)
            ->where('stock_quantity', '>', 0);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWithProductCount($query)
    {
        return $query->withCount(['products' => function ($q) {
            $q->where('is_active', true);
        }]);
    }

    public function scopePopular($query, $limit = 10)
    {
        return $query->withCount('products')
            ->orderBy('products_count', 'desc')
            ->limit($limit);
    }

    public function scopeHasProducts($query)
    {
        return $query->has('products');
    }

    /**
     * Accessors
     */
    public function getProductCountAttribute()
    {
        return $this->products()->count();
    }

    public function getActiveProductCountAttribute()
    {
        return $this->activeProducts()->count();
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/categories/default.png');
    }

    public function getUrlAttribute()
    {
        return route('products.index', ['category' => $this->id]);
    }

    /**
     * Get category icon based on name (for UI)
     */
    public function getIconAttribute()
    {
        $icons = [
            'Laptops' => 'laptop',
            'Audio' => 'headphones',
            'Phones' => 'smartphone',
            'Wearables' => 'watch',
            'Tablets' => 'tablet',
            'Cameras' => 'camera',
            'Gaming' => 'gamepad',
            'Speakers' => 'speaker',
            'Accessories' => 'box',
            'Smart Home' => 'home',
            'TV & Video' => 'tv',
            'Computer Parts' => 'cpu',
        ];

        return $icons[$this->name] ?? 'folder';
    }

    /**
     * Get featured products for this category
     */
    public function featuredProducts($limit = 4)
    {
        return $this->activeProducts()
            ->with('primaryImage')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get price range for products in this category
     */
    public function getPriceRangeAttribute()
    {
        $prices = $this->activeProducts()->pluck('price');
        
        if ($prices->isEmpty()) {
            return ['min' => 0, 'max' => 0];
        }

        return [
            'min' => $prices->min(),
            'max' => $prices->max()
        ];
    }

    /**
     * Get average product price
     */
    public function getAveragePriceAttribute()
    {
        return $this->activeProducts()->avg('price') ?? 0;
    }

    /**
     * Check if category has any products
     */
    public function hasProducts()
    {
        return $this->products()->exists();
    }

    /**
     * Check if category has active products
     */
    public function hasActiveProducts()
    {
        return $this->activeProducts()->exists();
    }

    /**
     * Get total stock quantity for category
     */
    public function getTotalStockAttribute()
    {
        return $this->products()->sum('stock_quantity');
    }

    /**
     * Search products within category
     */
    public function searchProducts($query)
    {
        return $this->products()
            ->where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%')
                  ->orWhere('sku', 'like', '%' . $query . '%');
            });
    }

    /**
     * Get products sorted by price
     */
    public function productsByPrice($order = 'asc')
    {
        return $this->activeProducts()
            ->orderBy('price', $order)
            ->get();
    }

    /**
     * Get newest products in category
     */
    public function newestProducts($limit = 10)
    {
        return $this->activeProducts()
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get best selling products (requires order data)
     */
    public function bestSellingProducts($limit = 10)
    {
        return $this->products()
            ->withCount(['orderLines' => function ($query) {
                $query->whereHas('order', function ($q) {
                    $q->where('order_status_id', '!=', OrderStatus::getCancelledId());
                });
            }])
            ->orderBy('order_lines_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get low stock products in category
     */
    public function lowStockProducts($threshold = 10)
    {
        return $this->products()
            ->where('is_active', true)
            ->where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', $threshold)
            ->get();
    }

    /**
     * Get out of stock products
     */
    public function outOfStockProducts()
    {
        return $this->products()
            ->where('stock_quantity', 0)
            ->get();
    }

    /**
     * Custom route key for clean URLs
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}