@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

        @if($cart->items->isEmpty())
            <!-- Empty Cart -->
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <svg class="w-24 h-24 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h2 class="text-2xl font-semibold mb-2">Your cart is empty</h2>
                <p class="text-gray-600 mb-6">Add some products to get started</p>
                <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-slate-900 text-white rounded-md font-medium hover:bg-slate-800">
                    Continue Shopping
                </a>
            </div>
        @else
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cart->items as $item)
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex gap-6">
                            <!-- Product Image -->
                            <div class="flex-shrink-0">
                                <img src="{{ $item->product->image_url }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="w-32 h-32 object-cover rounded-lg">
                            </div>

                            <!-- Product Details -->
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold mb-1">
                                            <a href="{{ route('products.show', $item->product->id) }}" class="hover:text-slate-700">
                                                {{ $item->product->name }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-gray-500">{{ $item->product->category->name }}</p>
                                        
                                        @if($item->product->available_stock < $item->quantity)
                                            <p class="text-sm text-red-600 mt-2">
                                                Only {{ $item->product->available_stock }} left in stock
                                            </p>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xl font-bold">${{ number_format($item->price, 2) }}</p>
                                        <p class="text-sm text-gray-500">each</p>
                                    </div>
                                </div>

                                <!-- Quantity & Actions -->
                                <div class="flex items-center justify-between mt-4">
                                    <div class="flex items-center gap-4">
                                        <!-- Quantity Controls -->
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <button onclick="updateQuantity({{ $item->product_id }}, {{ $item->quantity - 1 }})" 
                                                    class="px-3 py-2 hover:bg-gray-100 {{ $item->quantity <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                    {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                            </button>
                                            <span class="px-4 py-2 border-x border-gray-300 min-w-[3rem] text-center font-medium">
                                                {{ $item->quantity }}
                                            </span>
                                            <button onclick="updateQuantity({{ $item->product_id }}, {{ $item->quantity + 1 }})" 
                                                    class="px-3 py-2 hover:bg-gray-100"
                                                    {{ $item->quantity >= $item->product->available_stock ? 'disabled' : '' }}>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Remove Button -->
                                        <form action="{{ route('cart.remove', $item->product_id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 text-sm hover:underline flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Remove
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Item Total -->
                                    <div class="text-right">
                                        <p class="text-lg font-bold">${{ number_format($item->total, 2) }}</p>
                                        <p class="text-xs text-gray-500">Subtotal</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Clear Cart Button -->
                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear your cart?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 text-sm hover:underline">
                            Clear entire cart
                        </button>
                    </form>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-4">
                        <h2 class="text-xl font-bold mb-4">Order Summary</h2>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal ({{ $cart->total_items }} items)</span>
                                <span class="font-medium">${{ number_format($cart->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-medium">
                                    @if($cart->subtotal >= 50)
                                        <span class="text-green-600">FREE</span>
                                    @else
                                        $25.00
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tax (8%)</span>
                                <span class="font-medium">${{ number_format($cart->subtotal * 0.08, 2) }}</span>
                            </div>
                            <div class="border-t pt-3 mt-3">
                                <div class="flex justify-between">
                                    <span class="font-bold text-lg">Total</span>
                                    <span class="font-bold text-xl">
                                        ${{ number_format($cart->subtotal + ($cart->subtotal >= 50 ? 0 : 25) + ($cart->subtotal * 0.08), 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if($cart->subtotal < 50)
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                                <p class="text-sm text-blue-800">
                                    Add <strong>${{ number_format(50 - $cart->subtotal, 2) }}</strong> more for FREE shipping!
                                </p>
                            </div>
                        @endif

                        @auth
                            <a href="{{ route('checkout.index') }}" class="block w-full px-6 py-3 bg-slate-900 text-white rounded-lg font-medium text-center hover:bg-slate-800 transition-colors mb-3">
                                Proceed to Checkout
                            </a>
                        @else
                            <button onclick="openSignInModal()" class="block w-full px-6 py-3 bg-slate-900 text-white rounded-lg font-medium text-center hover:bg-slate-800 transition-colors mb-3">
                                Sign in to Checkout
                            </button>
                        @endauth

                        <a href="{{ route('products.index') }}" class="block w-full px-6 py-3 bg-white border border-gray-300 rounded-lg font-medium text-center hover:bg-gray-50 transition-colors">
                            Continue Shopping
                        </a>

                        <!-- Trust Badges -->
                        <div class="mt-6 pt-6 border-t space-y-3">
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                Secure Checkout
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                Multiple Payment Options
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                                </svg>
                                Fast Delivery
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateQuantity(productId, newQuantity) {
    if (newQuantity < 1) return;
    
    fetch(`/cart/update/${productId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ quantity: newQuantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reload page to update totals
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update quantity');
    });
}
</script>
@endpush