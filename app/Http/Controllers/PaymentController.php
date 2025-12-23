<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Process payment confirmation
     * This is called after payment gateway confirms successful payment
     */
    public function confirmPayment(Order $order)
    {
        DB::beginTransaction();

        try {
            // Verify order is still pending payment
            if ($order->is_paid) {
                return redirect()->route('orders.show', $order->id)
                    ->with('info', 'Payment already confirmed for this order');
            }

            // Process each order line and convert reserved stock to actual sale
            foreach ($order->lines as $line) {
                $product = $line->product;
                $stock = $product->mainStock();

                if (!$stock) {
                    throw new \Exception("Stock record not found for product: {$product->name}");
                }

                // Release reserved stock
                $stock->releaseStock($line->quantity, $order->id);

                // Remove stock (actual sale)
                $stock->removeStock(
                    $line->quantity,
                    'sale',
                    $order->user_id,
                    "Order #{$order->order_number} - Payment Confirmed"
                );

                Log::info("Stock deducted for product {$product->id}: {$line->quantity} units for order {$order->id}");
            }

            // Update order status
            $order->update([
                'is_paid' => true,
                'order_status_id' => OrderStatus::getProcessingId(),
            ]);

            DB::commit();

            // Send confirmation email
            // Mail::to($order->user->email)->send(new OrderConfirmation($order));

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Payment confirmed! Your order is being processed.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Payment confirmation failed for order {$order->id}: " . $e->getMessage());

            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Payment confirmation failed: ' . $e->getMessage());
        }
    }

    /**
     * Cancel payment and release reserved stock
     */
    public function cancelPayment(Order $order)
    {
        DB::beginTransaction();

        try {
            // Release all reserved stock
            foreach ($order->lines as $line) {
                $product = $line->product;
                $stock = $product->mainStock();

                if ($stock) {
                    // Release reserved stock back to available
                    $stock->releaseStock($line->quantity, $order->id);
                    
                    Log::info("Stock released for product {$product->id}: {$line->quantity} units from order {$order->id}");
                }
            }

            // Update order status to cancelled
            $order->update([
                'order_status_id' => OrderStatus::getCancelledId(),
            ]);

            DB::commit();

            return redirect()->route('home')
                ->with('info', 'Order cancelled. Reserved stock has been released.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Payment cancellation failed for order {$order->id}: " . $e->getMessage());

            return back()->with('error', 'Failed to cancel payment: ' . $e->getMessage());
        }
    }

    /**
     * COD Payment - Confirm on delivery
     */
    public function codPayment(Order $order)
    {
        // For COD, stock is reserved but not deducted yet
        // It will be deducted when delivery is confirmed
        
        return view('payment.cod', compact('order'));
    }

    /**
     * Card Payment Page
     */
    public function cardPayment(Order $order)
    {
        // Show card payment form
        // Integrate with Stripe, PayPal, or local payment gateway
        
        return view('payment.card', compact('order'));
    }

    /**
     * bKash Payment Page
     */
    public function bkashPayment(Order $order)
    {
        // Integrate with bKash API
        // https://developer.bka.sh/
        
        return view('payment.bkash', compact('order'));
    }

    /**
     * Nagad Payment Page
     */
    public function nagadPayment(Order $order)
    {
        // Integrate with Nagad API
        
        return view('payment.nagad', compact('order'));
    }

    /**
     * Payment Webhook (for payment gateway callbacks)
     */
    public function webhook(Request $request)
    {
        // Validate webhook signature
        // This depends on your payment gateway
        
        $orderId = $request->input('order_id');
        $status = $request->input('status');
        
        $order = Order::find($orderId);
        
        if (!$order) {
            Log::error("Webhook received for non-existent order: {$orderId}");
            return response()->json(['error' => 'Order not found'], 404);
        }

        if ($status === 'success') {
            $this->confirmPayment($order);
        } else {
            $this->cancelPayment($order);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Handle delivery confirmation for COD orders
     */
    public function confirmDelivery(Order $order)
    {
        // This is called when delivery is confirmed for COD orders
        
        if ($order->payment_method !== 'cod') {
            return back()->with('error', 'This order is not a COD order');
        }

        DB::beginTransaction();

        try {
            // For COD, now deduct the stock since payment is received
            foreach ($order->lines as $line) {
                $product = $line->product;
                $stock = $product->mainStock();

                if ($stock) {
                    // Release reserved stock
                    $stock->releaseStock($line->quantity, $order->id);
                    
                    // Remove stock (actual sale)
                    $stock->removeStock(
                        $line->quantity,
                        'sale',
                        auth()->id(),
                        "COD Order #{$order->order_number} - Delivered & Paid"
                    );
                }
            }

            // Update order
            $order->update([
                'is_paid' => true,
                'order_status_id' => OrderStatus::getDeliveredId(),
            ]);

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Delivery confirmed! Payment received.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Delivery confirmation failed for order {$order->id}: " . $e->getMessage());

            return back()->with('error', 'Failed to confirm delivery: ' . $e->getMessage());
        }
    }
}