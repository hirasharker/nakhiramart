<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Get or create cart for current user/session
     */
    protected function getCart()
    {
        if (auth()->check()) {
            return Cart::firstOrCreate(
                ['user_id' => auth()->id()],
                ['session_id' => session()->getId()]
            );
        }

        return Cart::firstOrCreate(
            ['session_id' => session()->getId()],
            ['user_id' => null]
        );
    }

    /**
     * Display the cart
     */
    public function index()
    {
        $cart = $this->getCart();
        $cart->load(['items.product.primaryImage']);

        return view('cart.index', compact('cart'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock_quantity < $request->quantity) {
            return back()->with('error', 'Insufficient stock available');
        }

        $cart = $this->getCart();
        $cart->addItem($request->product_id, $request->quantity ?? 1);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart',
                'cart_count' => $cart->total_items
            ]);
        }

        return back()->with('success', 'Product added to cart');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $cart = $this->getCart();
        $cart->updateItemQuantity($productId, $request->quantity);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'subtotal' => $cart->subtotal,
                'total_items' => $cart->total_items
            ]);
        }

        return back()->with('success', 'Cart updated');
    }

    /**
     * Remove item from cart
     */
    public function remove($productId)
    {
        $cart = $this->getCart();
        $cart->removeItem($productId);

        return back()->with('success', 'Item removed from cart');
    }

    /**
     * Clear the cart
     */
    public function clear()
    {
        $cart = $this->getCart();
        $cart->clear();

        return back()->with('success', 'Cart cleared');
    }

    /**
     * Get cart count (AJAX)
     */
    public function count()
    {
        $cart = $this->getCart();
        return response()->json(['count' => $cart->total_items]);
    }
}