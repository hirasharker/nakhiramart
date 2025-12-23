@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold">Order Details</h1>
            <a href="{{ route('orders.index') }}" class="text-slate-900 hover:underline flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Orders
            </a>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Order Items -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Status -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold mb-1">{{ $order->order_number }}</h2>
                            <p class="text-gray-600">Placed on {{ $order->order_date->format('F d, Y \a\t h:i A') }}</p>
                        </div>
                        <span class="px-4 py-2 rounded-full text-sm font-medium
                            @if($order->status->name == 'Pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status->name == 'Processing') bg-blue-100 text-blue-800
                            @elseif($order->status->name == 'Shipped') bg-purple-100 text-purple-800
                            @elseif($order->status->name == 'Delivered') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $order->status->name }}
                        </span>
                    </div>

                    <!-- Order Timeline -->
                    <div class="relative">
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                        <div class="space-y-6">
                            <div class="relative flex gap-4">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-500 flex items-center justify-center z-10">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium">Order Placed</p>
                                    <p class="text-sm text-gray-600">{{ $order->order_date->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>

                            @if($order->status->name != 'Cancelled')
                            <div class="relative flex gap-4">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full {{ in_array($order->status->name, ['Processing', 'Shipped', 'Delivered']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center z-10">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium">Processing</p>
                                    <p class="text-sm text-gray-600">Your order is being prepared</p>
                                </div>
                            </div>

                            <div class="relative flex gap-4">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full {{ in_array($order->status->name, ['Shipped', 'Delivered']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center z-10">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium">Shipped</p>
                                    <p class="text-sm text-gray-600">
                                        @if($order->shipped_date)
                                            {{ $order->shipped_date->format('M d, Y h:i A') }}
                                        @else
                                            Awaiting shipment
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="relative flex gap-4">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $order->status->name == 'Delivered' ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center z-10">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium">Delivered</p>
                                    <p class="text-sm text-gray-600">Your order will be delivered soon</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-bold mb-4">Order Items</h3>
                    <div class="space-y-4">
                        @foreach($order->lines as $line)
                        <div class="flex gap-4 pb-4 border-b last:border-0">
                            <img src="{{ $line->product->image_url }}" alt="{{ $line->product->name }}" class="w-24 h-24 object-cover rounded-lg">
                            <div class="flex-1">
                                <h4 class="font-semibold mb-1">
                                    <a href="{{ route('products.show', $line->product_id) }}" class="hover:text-slate-700">
                                        {{ $line->product->name }}
                                    </a>
                                </h4>
                                <p class="text-sm text-gray-600">{{ $line->product->category->name }}</p>
                                <p class="text-sm text-gray-600 mt-2">Quantity: {{ $line->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold">${{ number_format($line->line_total, 2) }}</p>
                                <p class="text-sm text-gray-500">${{ number_format($line->unit_price, 2) }} each</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Payment Info -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-bold mb-4">Payment Information</h3>
                    <dl class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <dt class="text-gray-600">Payment Method</dt>
                            <dd class="font-medium uppercase">{{ $order->payment_method }}</dd>
                        </div>
                        <div class="flex justify-between text-sm">
                            <dt class="text-gray-600">Payment Status</dt>
                            <dd>
                                @if($order->is_paid)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium">Paid</span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full font-medium">Pending</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Addresses -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-bold mb-4">Delivery Address</h3>
                    <p class="text-sm text-gray-700">{{ $order->shipping_address }}</p>
                </div>

                <!-- Order Total -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-bold mb-4">Order Summary</h3>
                    <dl class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <dt class="text-gray-600">Subtotal</dt>
                            <dd class="font-medium">${{ number_format($order->lines->sum('line_total'), 2) }}</dd>
                        </div>
                        <div class="flex justify-between text-sm">
                            <dt class="text-gray-600">Shipping</dt>
                            <dd class="font-medium">$25.00</dd>
                        </div>
                        <div class="flex justify-between text-sm">
                            <dt class="text-gray-600">Tax</dt>
                            <dd class="font-medium">${{ number_format($order->lines->sum('line_total') * 0.08, 2) }}</dd>
                        </div>
                        <div class="border-t pt-2 mt-2">
                            <div class="flex justify-between">
                                <dt class="font-bold text-lg">Total</dt>
                                <dd class="font-bold text-xl">{{ $order->formatted_total }}</dd>
                            </div>
                        </div>
                    </dl>
                </div>

                <!-- Actions -->
                <div class="space-y-3">
                    @if($order->status->canBeCancelled())
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                        @csrf
                        <button type="submit" class="w-full px-4 py-3 border-2 border-red-300 text-red-600 rounded-lg font-medium hover:bg-red-50">
                            Cancel Order
                        </button>
                    </form>
                    @endif

                    <a href="{{ route('orders.invoice', $order->id) }}" class="block w-full px-4 py-3 bg-slate-900 text-white rounded-lg font-medium text-center hover:bg-slate-800">
                        Download Invoice
                    </a>

                    @if($order->status->name == 'Delivered')
                    <form action="{{ route('orders.reorder', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-3 border border-gray-300 rounded-lg font-medium hover:bg-gray-50">
                            Order Again
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection