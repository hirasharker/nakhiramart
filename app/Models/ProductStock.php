<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    // ... existing code ...

    public function stocks()
    {
        return $this->hasMany(ProductStock::class);
    }

    public function mainStock()
    {
        return $this->hasOne(ProductStock::class)
            ->where('warehouse_location', 'Main Warehouse');
    }

    /**
     * Get total available stock across all warehouses
     */
    public function getTotalStockAttribute()
    {
        return $this->stocks()->sum('quantity');
    }

    public function getAvailableStockAttribute()
    {
        return $this->stocks()
            ->get()
            ->sum(fn($stock) => $stock->available_quantity);
    }

    /**
     * Check if product is in stock
     */
    public function isInStock($quantity = 1, $sellerId = null)
    {
        $query = $this->stocks();
        
        if ($sellerId) {
            $query->where('seller_id', $sellerId);
        }

        $availableStock = $query->get()
            ->sum(fn($stock) => $stock->available_quantity);

        return $availableStock >= $quantity;
    }

    /**
     * Reserve stock for order
     */
    public function reserveStock($quantity, $orderId, $sellerId = null)
    {
        $stock = $this->stocks()
            ->when($sellerId, fn($q) => $q->where('seller_id', $sellerId))
            ->where('warehouse_location', 'Main Warehouse')
            ->first();

        if (!$stock) {
            throw new \Exception("No stock record found for this product");
        }

        return $stock->reserveStock($quantity, $orderId);
    }
}