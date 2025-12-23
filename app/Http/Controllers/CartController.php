<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Display the shopping cart
     */
    public function index(Request $request)
    {
        $cart = $this->getCart();
        
        // Load cart items with product details and images
        $cart->load(['items.product']);
        
        // Sync prices with current product prices
        $cart->syncPrices();
        
        // Validate stock availability
        $stockValidation = $cart->validateStock();
        
        $subtotal = $cart->subtotal;
        $shippingFee = $this->calculateShipping($subtotal);
        $tax = $this->calculateTax($subtotal);
        $total = $subtotal + $shippingFee + $tax;
        
        // Return JSON for AJAX requests (cart modal)
        // Check multiple ways to detect AJAX request
        if ($request->ajax() || 
            $request->wantsJson() || 
            $request->expectsJson() ||
            $request->header('X-Requested-With') === 'XMLHttpRequest') {
            
            return response()->json([
                'success' => true,
                'total_items' => $cart->total_items,
                'items' => $cart->items->map(function($item) {
                    return [
                        'product_id' => $item->product_id,
                        'name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'price' => number_format($item->price, 2),
                        'total' => number_format($item->total, 2),
                        'image' => $item->product->image_url ?? asset('images/placeholder.png')
                    ];
                }),
                'subtotal' => number_format($subtotal, 2),
                'shipping' => number_format($shippingFee, 2),
                'tax' => number_format($tax, 2),
                'total' => number_format($total, 2),
                'stock_validation' => $stockValidation
            ]);
        }
        
        // Return view for regular page load
        return view('cart.index', compact(
            'cart',
            'stockValidation',
            'subtotal',
            'shippingFee',
            'tax',
            'total'
        ));
    }

    /**
     * Get cart data as JSON (dedicated AJAX endpoint)
     * This is more reliable than trying to detect AJAX in index()
     */
    public function getData()
    {
        $cart = $this->getCart();
        
        // Load cart items with product details
        $cart->load(['items.product']);
        
        // Sync prices with current product prices
        $cart->syncPrices();
        
        // Validate stock availability
        $stockValidation = $cart->validateStock();
        
        $subtotal = $cart->subtotal;
        $shippingFee = $this->calculateShipping($subtotal);
        $tax = $this->calculateTax($subtotal);
        $total = $subtotal + $shippingFee + $tax;
        
        return response()->json([
            'success' => true,
            'total_items' => $cart->total_items,
            'items' => $cart->items->map(function($item) {
                return [
                    'product_id' => $item->product_id,
                    'name' => $item->product->name ?? 'Unknown Product',
                    'quantity' => $item->quantity,
                    'price' => number_format($item->price, 2),
                    'total' => number_format($item->total, 2),
                    'image' => $item->product->image_url ?? asset('images/placeholder.png')
                ];
            }),
            'subtotal' => number_format($subtotal, 2),
            'shipping' => number_format($shippingFee, 2),
            'tax' => number_format($tax, 2),
            'total' => number_format($total, 2),
            'stock_validation' => $stockValidation
        ]);
    }

    /**
     * Add product to cart (AJAX)
     */
    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1|max:99',
            'replace' => 'nullable|boolean' // New: for product detail page
        ]);

        try {
            $cart = $this->getCart();
            
            // Check if replace mode (from product detail page)
            $replace = $validated['replace'] ?? false;
            
            if ($replace) {
                // Replace quantity instead of adding
                $cartItem = $cart->updateItem(
                    $validated['product_id'],
                    $validated['quantity'] ?? 1
                );
                $message = 'Cart updated';
            } else {
                // Add to existing quantity (default behavior)
                $cartItem = $cart->addItem(
                    $validated['product_id'],
                    $validated['quantity'] ?? 1
                );
                $message = 'Product added to cart';
            }

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'cart_count' => $cart->fresh()->total_items,
                    'cart_item' => $cartItem ? $cartItem->load('product') : null
                ]);
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Error adding to cart: ' . $e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update cart item quantity (AJAX)
     */
    public function update(Request $request, $productId)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0|max:99'
        ]);

        try {
            $cart = $this->getCart();
            $cartItem = $cart->updateItem($productId, $validated['quantity']);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated',
                    'cart_item' => $cartItem ? $cartItem->load('product') : null,
                    'cart_count' => $cart->fresh()->total_items,
                    'cart_subtotal' => number_format($cart->fresh()->subtotal, 2)
                ]);
            }

            return redirect()->route('cart.index')->with('success', 'Cart updated');

        } catch (\Exception $e) {
            Log::error('Error updating cart: ' . $e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove item from cart
     */
    public function remove($productId)
    {
        try {
            $cart = $this->getCart();
            $cart->removeItem($productId);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item removed from cart',
                    'cart_count' => $cart->fresh()->total_items,
                    'cart_subtotal' => number_format($cart->fresh()->subtotal, 2)
                ]);
            }

            return redirect()->route('cart.index')->with('success', 'Item removed from cart');

        } catch (\Exception $e) {
            Log::error('Error removing from cart: ' . $e->getMessage());

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        try {
            $cart = $this->getCart();
            $cart->clear();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cart cleared',
                    'cart_count' => 0
                ]);
            }

            return redirect()->route('cart.index')->with('success', 'Cart cleared');

        } catch (\Exception $e) {
            Log::error('Error clearing cart: ' . $e->getMessage());

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Get cart item count (AJAX)
     */
    public function count()
    {
        $cart = $this->getCart();
        
        return response()->json([
            'count' => $cart->total_items
        ]);
    }

    /**
     * Get or create cart for current user/session
     */
    public function getCart()
    {
        if (auth()->check()) {
            // Get or create user cart
            $cart = Cart::firstOrCreate(
                ['user_id' => auth()->id()],
                ['session_id' => session()->getId()]
            );

            // Check if there's a guest cart to merge
            $guestCart = Cart::where('session_id', session()->getId())
                ->where('user_id', null)
                ->first();

            if ($guestCart && $guestCart->id !== $cart->id) {
                $cart->mergeWith($guestCart);
            }

            return $cart;
        }

        // Get or create guest cart
        return Cart::firstOrCreate(
            ['session_id' => session()->getId()],
            ['user_id' => null]
        );
    }

    /**
     * Calculate shipping fee
     */
    protected function calculateShipping($subtotal)
    {
        // Free shipping over $50
        if ($subtotal >= 50) {
            return 0;
        }

        // Flat rate shipping
        return 25;
    }

    /**
     * Calculate tax
     */
    protected function calculateTax($subtotal)
    {
        // 8% tax rate
        return $subtotal * 0.08;
    }

    /**
     * Apply coupon code (AJAX)
     */
    public function applyCoupon(Request $request)
    {
        $validated = $request->validate([
            'coupon_code' => 'required|string|max:50'
        ]);

        // TODO: Implement coupon logic
        // For now, return error
        return response()->json([
            'success' => false,
            'message' => 'Invalid coupon code'
        ], 400);
    }
}