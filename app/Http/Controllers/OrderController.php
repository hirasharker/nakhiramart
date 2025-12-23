<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display user's orders
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['status', 'lines.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display specific order
     */
    public function show($id)
    {
        $order = Order::with(['status', 'lines.product.primaryImage'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    /**
     * Cancel an order
     */
    public function cancel(Order $order)
    {
        // Verify user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Check if order can be cancelled
        if (!$order->status->canBeCancelled()) {
            return back()->with('error', 'This order cannot be cancelled anymore');
        }

        DB::beginTransaction();

        try {
            // Release reserved stock back to available
            foreach ($order->lines as $line) {
                $product = $line->product;
                $stock = $product->mainStock();

                if ($stock) {
                    // If stock was only reserved (not paid), release it
                    if (!$order->is_paid) {
                        $stock->releaseStock(
                            $line->quantity,
                            $order->id
                        );
                        Log::info("Reserved stock released for product {$product->id}: {$line->quantity} units");
                    }
                    // If stock was already deducted (paid order), add it back
                    else {
                        $stock->addStock(
                            $line->quantity,
                            'return',
                            auth()->id(),
                            "Order #{$order->order_number} Cancelled"
                        );
                        Log::info("Stock returned for product {$product->id}: {$line->quantity} units");
                    }
                }
            }

            // Update order status
            $order->update([
                'order_status_id' => OrderStatus::getCancelledId()
            ]);

            DB::commit();

            // Send cancellation email
            // Mail::to($order->user->email)->send(new OrderCancelled($order));

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order cancelled successfully. Stock has been restored.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Order cancellation failed for order {$order->id}: " . $e->getMessage());

            return back()->with('error', 'Failed to cancel order: ' . $e->getMessage());
        }
    }

    /**
     * Request return for delivered order
     */
    public function requestReturn(Request $request, Order $order)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:500',
            'items' => 'required|array',
            'items.*' => 'exists:order_lines,id'
        ]);

        // Verify user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Check if order is delivered
        if ($order->status->name !== 'Delivered') {
            return back()->with('error', 'Only delivered orders can be returned');
        }

        DB::beginTransaction();

        try {
            // Create return request for each item
            foreach ($validated['items'] as $lineId) {
                $line = $order->lines()->findOrFail($lineId);
                
                // Create return request (you'll need to create this model)
                // ReturnRequest::create([...]);
            }

            DB::commit();

            return back()->with('success', 'Return request submitted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Return request failed for order {$order->id}: " . $e->getMessage());

            return back()->with('error', 'Failed to submit return request');
        }
    }

    /**
     * Process return and restore stock (Admin only)
     */
    public function processReturn(Request $request, Order $order, $lineId)
    {
        // This should be protected by admin middleware
        
        $line = $order->lines()->findOrFail($lineId);
        $product = $line->product;
        $stock = $product->mainStock();

        DB::beginTransaction();

        try {
            // Add stock back
            $stock->addStock(
                $line->quantity,
                'return',
                auth()->id(),
                "Customer return - Order #{$order->order_number}"
            );

            // Update return request status
            // $returnRequest->update(['status' => 'completed']);

            DB::commit();

            return back()->with('success', 'Return processed. Stock restored.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Return processing failed: " . $e->getMessage());

            return back()->with('error', 'Failed to process return');
        }
    }

    /**
     * Reorder items from previous order
     */
    public function reorder(Order $order)
    {
        // Verify user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $cart = app(CartController::class)->getCart();

        foreach ($order->lines as $line) {
            $product = $line->product;
            
            // Check if product is still available and in stock
            if ($product->is_active && $product->isInStock($line->quantity)) {
                $cart->addItem($product->id, $line->quantity);
            }
        }

        return redirect()->route('cart.index')
            ->with('success', 'Items added to cart');
    }

    /**
     * Track order shipment
     */
    public function track(Order $order)
    {
        // Verify user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $order->load(['shipments.courier', 'status']);

        return view('orders.track', compact('order'));
    }

    /**
     * Download invoice
     */
    public function invoice(Order $order)
    {
        // Verify user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $order->load(['lines.product', 'user']);

        // Generate PDF invoice
        // $pdf = PDF::loadView('orders.invoice-pdf', compact('order'));
        // return $pdf->download("invoice-{$order->order_number}.pdf");

        return view('orders.invoice', compact('order'));
    }
}