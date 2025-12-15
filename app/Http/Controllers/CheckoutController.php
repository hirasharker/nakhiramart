<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Address;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page
     */
    public function index()
    {
        $cart = $this->getCart();

        // Check if cart is empty
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }

        // Load cart items with product details
        $cart->load(['items.product.primaryImage']);

        // Get user's saved addresses
        $addresses = auth()->user()->addresses ?? collect();
        $defaultAddress = $addresses->where('is_default', true)->first();

        // Calculate totals
        $subtotal = $cart->subtotal;
        $shippingFee = $this->calculateShipping($subtotal);
        $tax = $this->calculateTax($subtotal);
        $total = $subtotal + $shippingFee + $tax;

        return view('checkout.index', compact(
            'cart',
            'addresses',
            'defaultAddress',
            'subtotal',
            'shippingFee',
            'tax',
            'total'
        ));
    }

    /**
     * Process the checkout and create order
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:cod,card,bkash,nagad',
            'billing_address_id' => 'nullable|exists:addresses,id',
            'shipping_address_id' => 'nullable|exists:addresses,id',
            'billing_address' => 'required_without:billing_address_id|string|max:500',
            'shipping_address' => 'required_without:shipping_address_id|string|max:500',
            'notes' => 'nullable|string|max:1000',
            'save_addresses' => 'nullable|boolean',
        ]);

        $cart = $this->getCart();

        // Validate cart not empty
        if ($cart->items->isEmpty()) {
            return back()->with('error', 'Your cart is empty');
        }

        // Validate stock availability
        $stockValidation = $this->validateStock($cart);
        if (!$stockValidation['valid']) {
            return back()->with('error', $stockValidation['message']);
        }

        DB::beginTransaction();

        try {
            // Get or format addresses
            $billingAddress = $this->getAddressString($validated, 'billing');
            $shippingAddress = $this->getAddressString($validated, 'shipping');

            // Calculate totals
            $subtotal = $cart->subtotal;
            $shippingFee = $this->calculateShipping($subtotal);
            $tax = $this->calculateTax($subtotal);
            $total = $subtotal + $shippingFee + $tax;

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_date' => now(),
                'billing_address' => $billingAddress,
                'shipping_address' => $shippingAddress,
                'total_amount' => $total,
                'order_status_id' => OrderStatus::getPendingId(),
                'payment_method' => $validated['payment_method'],
                'is_paid' => $validated['payment_method'] === 'card' ? false : false, // Will be updated after payment
            ]);

            // Create order lines and update stock
            foreach ($cart->items as $item) {
                $order->lines()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->price,
                    'line_total' => $item->total
                ]);

                // Decrease stock
                $product = Product::find($item->product_id);
                $product->decrement('stock_quantity', $item->quantity);
            }

            // Save addresses if requested
            if ($request->save_addresses && auth()->check()) {
                $this->saveUserAddresses($validated);
            }

            // Clear cart
            $cart->clear();

            DB::commit();

            // Process payment based on method
            return $this->handlePayment($order, $validated['payment_method']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());
            
            return back()
                ->with('error', 'An error occurred while processing your order. Please try again.')
                ->withInput();
        }
    }

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
     * Validate stock availability for all cart items
     */
    protected function validateStock(Cart $cart)
    {
        foreach ($cart->items as $item) {
            $product = Product::find($item->product_id);
            
            if (!$product || !$product->is_active) {
                return [
                    'valid' => false,
                    'message' => "Product '{$item->product->name}' is no longer available"
                ];
            }

            if ($product->stock_quantity < $item->quantity) {
                return [
                    'valid' => false,
                    'message' => "Insufficient stock for '{$product->name}'. Only {$product->stock_quantity} available."
                ];
            }
        }

        return ['valid' => true];
    }

    /**
     * Get address string from request
     */
    protected function getAddressString(array $validated, string $type)
    {
        $addressIdKey = $type . '_address_id';
        $addressKey = $type . '_address';

        if (!empty($validated[$addressIdKey])) {
            $address = Address::find($validated[$addressIdKey]);
            return $address ? $address->full_address : $validated[$addressKey];
        }

        return $validated[$addressKey];
    }

    /**
     * Save user addresses
     */
    protected function saveUserAddresses(array $validated)
    {
        // Save billing address
        if (!empty($validated['billing_address']) && empty($validated['billing_address_id'])) {
            Address::create([
                'user_id' => auth()->id(),
                'type' => 'billing',
                'address_line_1' => $validated['billing_address'],
                'city' => 'Dhaka', // You might want to add city field to form
                'country' => 'Bangladesh',
                'is_default' => false
            ]);
        }

        // Save shipping address
        if (!empty($validated['shipping_address']) && empty($validated['shipping_address_id'])) {
            Address::create([
                'user_id' => auth()->id(),
                'type' => 'shipping',
                'address_line_1' => $validated['shipping_address'],
                'city' => 'Dhaka',
                'country' => 'Bangladesh',
                'is_default' => true
            ]);
        }
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
     * Handle payment processing based on method
     */
    protected function handlePayment(Order $order, string $paymentMethod)
    {
        switch ($paymentMethod) {
            case 'cod':
                // Cash on Delivery - Order is placed, payment will be collected on delivery
                return redirect()->route('orders.show', $order->id)
                    ->with('success', 'Order placed successfully! You will pay on delivery.');

            case 'card':
                // Redirect to card payment gateway
                return redirect()->route('payment.card', $order->id)
                    ->with('info', 'Please complete your card payment');

            case 'bkash':
                // Redirect to bKash payment
                return redirect()->route('payment.bkash', $order->id)
                    ->with('info', 'Please complete your bKash payment');

            case 'nagad':
                // Redirect to Nagad payment
                return redirect()->route('payment.nagad', $order->id)
                    ->with('info', 'Please complete your Nagad payment');

            default:
                return redirect()->route('orders.show', $order->id)
                    ->with('success', 'Order placed successfully!');
        }
    }

    /**
     * Apply coupon code
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50'
        ]);

        // TODO: Implement coupon logic
        // For now, return error
        return back()->with('error', 'Invalid coupon code');
    }

    /**
     * Get shipping options (AJAX)
     */
    public function getShippingOptions(Request $request)
    {
        $request->validate([
            'postal_code' => 'required|string',
            'city' => 'required|string'
        ]);

        // TODO: Calculate shipping based on location
        $options = [
            [
                'name' => 'Standard Delivery',
                'cost' => 25,
                'duration' => '3-5 business days'
            ],
            [
                'name' => 'Express Delivery',
                'cost' => 50,
                'duration' => '1-2 business days'
            ],
            [
                'name' => 'Same Day Delivery',
                'cost' => 100,
                'duration' => 'Same day'
            ]
        ];

        return response()->json([
            'success' => true,
            'options' => $options
        ]);
    }

    /**
     * Calculate order total (AJAX)
     */
    public function calculateTotal(Request $request)
    {
        $cart = $this->getCart();
        
        $subtotal = $cart->subtotal;
        $shippingFee = $this->calculateShipping($subtotal);
        $tax = $this->calculateTax($subtotal);
        $total = $subtotal + $shippingFee + $tax;

        return response()->json([
            'success' => true,
            'subtotal' => number_format($subtotal, 2),
            'shipping' => number_format($shippingFee, 2),
            'tax' => number_format($tax, 2),
            'total' => number_format($total, 2)
        ]);
    }
}