<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'user_id',
        'session_id',
    ];

    /**
     * Get the user that owns the cart
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get all items in the cart
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'id');
    }

    /**
     * Add item to cart or update quantity if exists
     */
    public function addItem(int $productId, int $quantity = 1)
    {
        $product = Product::findOrFail($productId);

        // Check if product is active
        if (!$product->is_active) {
            throw new \Exception('This product is no longer available');
        }

        // Check stock availability
        if (!$product->isInStock($quantity)) {
            throw new \Exception('Insufficient stock available');
        }

        // Check if item already exists in cart
        $cartItem = $this->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $quantity;
            
            // Verify stock for new quantity
            if (!$product->isInStock($newQuantity)) {
                throw new \Exception('Cannot add more items. Only ' . $product->stock_quantity . ' available in stock');
            }
            
            $cartItem->update([
                'quantity' => $newQuantity,
                'price' => $product->price, // Update price in case it changed
            ]);
        } else {
            // Create new cart item
            $cartItem = $this->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }

        return $cartItem;
    }

    /**
     * Update item quantity
     */
    public function updateItem(int $productId, int $quantity)
    {
        $cartItem = $this->items()->where('product_id', $productId)->firstOrFail();
        $product = $cartItem->product;

        // Check stock availability
        if (!$product->isInStock($quantity)) {
            throw new \Exception('Only ' . $product->stock_quantity . ' items available in stock');
        }

        if ($quantity <= 0) {
            $cartItem->delete();
            return null;
        }

        $cartItem->update([
            'quantity' => $quantity,
            'price' => $product->price, // Update price in case it changed
        ]);

        return $cartItem;
    }

    /**
     * Remove item from cart
     */
    public function removeItem(int $productId)
    {
        return $this->items()->where('product_id', $productId)->delete();
    }

    /**
     * Clear all items from cart
     */
    public function clear()
    {
        return $this->items()->delete();
    }

    /**
     * Get cart subtotal
     */
    public function getSubtotalAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->total;
        });
    }

    /**
     * Get total items count
     */
    public function getTotalItemsAttribute()
    {
        return $this->items->sum('quantity');
    }

    /**
     * Check if cart is empty
     */
    public function isEmpty()
    {
        return $this->items->isEmpty();
    }

    /**
     * Merge guest cart into user cart after login
     */
    public function mergeWith(Cart $guestCart)
    {
        foreach ($guestCart->items as $guestItem) {
            try {
                $this->addItem($guestItem->product_id, $guestItem->quantity);
            } catch (\Exception $e) {
                // Log error but continue merging other items
                \Log::warning("Failed to merge cart item: " . $e->getMessage());
            }
        }

        // Delete guest cart
        $guestCart->delete();
    }

    /**
     * Validate all cart items stock availability
     */
    public function validateStock()
    {
        $errors = [];

        foreach ($this->items as $item) {
            $product = $item->product;
            
            if (!$product || !$product->is_active) {
                $errors[] = "Product '{$item->product->name}' is no longer available";
                continue;
            }

            if (!$product->isInStock($item->quantity)) {
                $errors[] = "Only {$product->stock_quantity} units available for '{$product->name}'";
            }
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * Sync cart item prices with current product prices
     */
    public function syncPrices()
    {
        foreach ($this->items as $item) {
            $product = $item->product;
            if ($product && $item->price != $product->price) {
                $item->update(['price' => $product->price]);
            }
        }
    }
}