@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">My Orders</h1>

        @if($orders->isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <svg class="w-24 h-24 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h2 class="text-2xl font-semibold mb-2">No orders yet</h2>
                <p class="text-gray-600 mb-6">Start shopping to create your first order</p>
                <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-slate-900 text-white rounded-md font-medium hover:bg-slate-800">
                    Browse Products
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <!-- Order Header -->
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex flex-wrap items-center gap-6">
                                <div>
                                    <p class="text-xs text-gray-500">Order Number</p>
                                    <p class="font-bold">{{ $order->order_number }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Order Date</p>
                                    <p class="font-medium">{{ $order->order_date->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Total</p>
                                    <p class="font-bold text-lg">{{ $order->formatted_total }}</p>
                                </div>
                                <div>
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        @if($order->status->name == 'Pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status->name == 'Processing') bg-blue-100 text-blue-800
                                        @elseif($order->status->name == 'Shipped') bg-purple-100 text-purple-800
                                        @elseif($order->status->name == 'Delivered') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ $order->status->name }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('orders.show', $order->id) }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium hover:bg-gray-50">
                                    View Details
                                </a>
                                @if($order->status->canBeCancelled())
                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 border border-red-300 text-red-600 rounded-md text-sm font-medium hover:bg-red-50">
                                        Cancel Order
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Order Items Preview -->
                    <div class="px-6 py-4">
                        <div class="flex flex-wrap gap-4">
                            @foreach($order->lines->take(3) as $line)
                            <div class="flex items-center gap-3">
                                <img src="{{ $line->product->image_url }}" alt="{{ $line->product->name }}" class="w-16 h-16 object-cover rounded">
                                <div>
                                    <p class="text-sm font-medium line-clamp-1">{{ $line->product->name }}</p>
                                    <p class="text-xs text-gray-500">Qty: {{ $line->quantity }}</p>
                                </div>
                            </div>
                            @endforeach
                            @if($order->lines->count() > 3)
                            <div class="flex items-center">
                                <span class="text-sm text-gray-500">+{{ $order->lines->count() - 3 }} more items</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Order Actions -->
                    <div class="px-6 py-4 bg-gray-50 border-t flex flex-wrap gap-3">
                        @if($order->status->name == 'Delivered')
                        <form action="{{ route('orders.reorder', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-md text-sm font-medium hover:bg-slate-800">
                                Order Again
                            </button>
                        </form>
                        @endif
                        
                        @if($order->status->name != 'Cancelled')
                        <a href="{{ route('orders.track', $order->id) }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium hover:bg-gray-50">
                            Track Order
                        </a>
                        @endif
                        
                        <a href="{{ route('orders.invoice', $order->id) }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium hover:bg-gray-50">
                            Download Invoice
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection