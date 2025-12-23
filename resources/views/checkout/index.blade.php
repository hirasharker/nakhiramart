@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="bg-gray-50 py-8 min-h-screen">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">Checkout</h1>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Shipping Address -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-bold mb-4">Shipping Address</h2>
                        
                        @if($addresses->isNotEmpty())
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">Select saved address:</label>
                                <select name="shipping_address_id" id="shipping_address_id" onchange="toggleAddressForm('shipping')" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900">
                                    <option value="">Enter new address</option>
                                    @foreach($addresses->where('type', 'shipping') as $address)
                                    <option value="{{ $address->id }}" {{ $defaultAddress && $defaultAddress->id == $address->id ? 'selected' : '' }}>
                                        {{ $address->full_address }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div id="shipping_address_form" class="{{ $defaultAddress ? 'hidden' : '' }}">
                            <textarea name="shipping_address" 
                                      rows="3" 
                                      placeholder="Enter your shipping address"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 @error('shipping_address') border-red-500 @enderror">{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Billing Address -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-bold mb-4">Billing Address</h2>
                        
                        <label class="flex items-center gap-2 mb-4">
                            <input type="checkbox" id="same_as_shipping" checked onchange="toggleBillingAddress()" class="rounded">
                            <span class="text-sm">Same as shipping address</span>
                        </label>

                        <div id="billing_address_form" class="hidden">
                            @if($addresses->isNotEmpty())
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-2">Select saved address:</label>
                                    <select name="billing_address_id" id="billing_address_id" onchange="toggleAddressForm('billing')" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900">
                                        <option value="">Enter new address</option>
                                        @foreach($addresses->where('type', 'billing') as $address)
                                        <option value="{{ $address->id }}">{{ $address->full_address }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div id="billing_address_input">
                                <textarea name="billing_address" 
                                          rows="3" 
                                          placeholder="Enter your billing address"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 @error('billing_address') border-red-500 @enderror">{{ old('billing_address') }}</textarea>
                                @error('billing_address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-bold mb-4">Payment Method</h2>
                        
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-slate-900 has-[:checked]:border-slate-900 has-[:checked]:bg-slate-50">
                                <input type="radio" name="payment_method" value="cod" checked class="w-4 h-4">
                                <div class="flex-1">
                                    <p class="font-medium">Cash on Delivery (COD)</p>
                                    <p class="text-sm text-gray-600">Pay when you receive your order</p>
                                </div>
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </label>

                            <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-slate-900 has-[:checked]:border-slate-900 has-[:checked]:bg-slate-50">
                                <input type="radio" name="payment_method" value="card" class="w-4 h-4">
                                <div class="flex-1">
                                    <p class="font-medium">Credit/Debit Card</p>
                                    <p class="text-sm text-gray-600">Visa, Mastercard, Amex</p>
                                </div>
                                <div class="flex gap-2">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa" class="h-6">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard" class="h-6">
                                </div>
                            </label>

                            <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-slate-900 has-[:checked]:border-slate-900 has-[:checked]:bg-slate-50">
                                <input type="radio" name="payment_method" value="bkash" class="w-4 h-4">
                                <div class="flex-1">
                                    <p class="font-medium">bKash</p>
                                    <p class="text-sm text-gray-600">Mobile payment</p>
                                </div>
                                <span class="text-pink-600 font-bold">bKash</span>
                            </label>

                            <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-slate-900 has-[:checked]:border-slate-900 has-[:checked]:bg-slate-50">
                                <input type="radio" name="payment_method" value="nagad" class="w-4 h-4">
                                <div class="flex-1">
                                    <p class="font-medium">Nagad</p>
                                    <p class="text-sm text-gray-600">Mobile payment</p>
                                </div>
                                <span class="text-orange-600 font-bold">Nagad</span>
                            </label>
                        </div>
                        @error('payment_method')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Save Addresses -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="save_addresses" value="1" class="rounded">
                            <span class="text-sm">Save addresses for future orders</span>
                        </label>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-4">
                        <h2 class="text-xl font-bold mb-4">Order Summary</h2>

                        <!-- Cart Items -->
                        <div class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                            @foreach($cart->items as $item)
                            <div class="flex gap-3">
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium line-clamp-1">{{ $item->product->name }}</p>
                                    <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                                    <p class="text-sm font-bold">${{ number_format($item->total, 2) }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Totals -->
                        <div class="border-t pt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-medium">
                                    @if($shippingFee > 0)
                                        ${{ number_format($shippingFee, 2) }}
                                    @else
                                        <span class="text-green-600">FREE</span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tax</span>
                                <span class="font-medium">${{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="border-t pt-2 mt-2">
                                <div class="flex justify-between">
                                    <span class="font-bold text-lg">Total</span>
                                    <span class="font-bold text-xl">${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <button type="submit" class="w-full mt-6 px-6 py-4 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors">
                            Place Order
                        </button>

                        <p class="text-xs text-gray-500 text-center mt-4">
                            By placing your order, you agree to our Terms of Service and Privacy Policy
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleBillingAddress() {
    const checkbox = document.getElementById('same_as_shipping');
    const billingForm = document.getElementById('billing_address_form');
    
    if (checkbox.checked) {
        billingForm.classList.add('hidden');
    } else {
        billingForm.classList.remove('hidden');
    }
}

function toggleAddressForm(type) {
    const select = document.getElementById(`${type}_address_id`);
    const form = document.getElementById(`${type}_address_form`) || document.getElementById(`${type}_address_input`);
    
    if (select.value) {
        form.classList.add('hidden');
    } else {
        form.classList.remove('hidden');
    }
}
</script>
@endpush