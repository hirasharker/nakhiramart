@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8 text-sm">
        <a href="{{ route('home') }}" class="text-gray-600 hover:text-slate-900">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-slate-900">Products</a>
        @if($product->category)
        <span class="mx-2 text-gray-400">/</span>
        <a href="{{ route('products.index', ['category' => $product->category_id]) }}" class="text-gray-600 hover:text-slate-900">
            {{ $product->category->name }}
        </a>
        @endif
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-900">{{ $product->name }}</span>
    </nav>

    <!-- Product Details -->
    <div class="grid lg:grid-cols-2 gap-12 mb-16">
        <!-- Left: Image Gallery -->
        <div>
            <!-- Main Image -->
            <div class="bg-slate-100 rounded-2xl overflow-hidden mb-4 aspect-square">
                <img id="mainImage" 
                     src="{{ $product->image_url }}" 
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover">
            </div>

            <!-- Thumbnail Gallery -->
            @if($product->images && $product->images->count() > 1)
            <div class="grid grid-cols-4 gap-4">
                @foreach($product->images as $image)
                <button onclick="changeImage(this, '{{ asset('storage/' . $image->path) }}')" 
                        class="thumbnail {{ $loop->first ? 'active' : '' }} bg-slate-100 rounded-lg overflow-hidden aspect-square border-2 border-transparent hover:border-slate-900 transition-colors">
                    <img src="{{ asset('storage/' . $image->path) }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Right: Product Info -->
        <div>
            <!-- Category Badge -->
            @if($product->category)
            <span class="inline-block px-3 py-1 bg-slate-100 text-slate-900 rounded-full text-sm mb-4">
                {{ $product->category->name }}
            </span>
            @endif

            <!-- Product Name -->
            <h1 class="text-4xl font-bold mb-4">{{ $product->name }}</h1>

            <!-- Rating & Reviews -->
            <div class="flex items-center gap-3 mb-6">
                <div class="flex">
                    @for($i = 1; $i <= 5; $i++)
                    <svg class="w-5 h-5 {{ $i <= 4 ? 'fill-yellow-400 text-yellow-400' : 'fill-gray-300 text-gray-300' }}" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    @endfor
                </div>
                <span class="text-gray-600">(234 reviews)</span>
            </div>

            <!-- Price -->
            <div class="mb-6">
                <span class="text-4xl font-bold">${{ number_format($product->price, 2) }}</span>
            </div>

            <!-- Stock Status -->
            <div class="mb-6">
                @if($product->isInStock())
                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        In Stock ({{ $product->stock_quantity }} available)
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        Out of Stock
                    </span>
                @endif

                <!-- Already in Cart Badge -->
                @if($quantityInCart > 0)
                <div class="mt-3 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-center gap-2 text-blue-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="font-medium">Already in cart: {{ $quantityInCart }} {{ Str::plural('item', $quantityInCart) }}</span>
                    </div>
                    <p class="text-sm text-blue-600 mt-1">Adjust the quantity below to update your cart</p>
                </div>
                @endif
            </div>

            <!-- Description -->
            <div class="mb-8">
                <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
            </div>

            <!-- Quantity & Add to Cart -->
            @if($product->isInStock())
            <form id="addToCartForm" class="mb-6">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="replace" value="1">
                
                <div class="flex flex-wrap gap-4 mb-4">
                    <!-- Quantity Selector -->
                    <div class="flex items-center">
                        <label class="text-sm font-medium mr-3">Quantity:</label>
                        <div class="flex items-center border-2 border-gray-300 rounded-lg">
                            <button type="button" 
                                    onclick="decrementQuantity()"
                                    class="px-4 py-3 hover:bg-gray-100 text-lg font-bold">
                                −
                            </button>
                            <input type="number" 
                                   id="quantity" 
                                   name="quantity" 
                                   value="{{ $quantityInCart > 0 ? $quantityInCart : 1 }}"
                                   min="1" 
                                   max="{{ $product->stock_quantity }}"
                                   class="w-20 text-center border-x-2 border-gray-300 py-3 focus:outline-none text-lg font-semibold">
                            <button type="button" 
                                    onclick="incrementQuantity()"
                                    class="px-4 py-3 hover:bg-gray-100 text-lg font-bold">
                                +
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Add to Cart Button -->
                <div class="flex gap-4">
                    <button type="submit" 
                            id="addToCartBtn"
                            class="flex-1 px-8 py-4 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span id="btnText">{{ $quantityInCart > 0 ? 'Update Cart' : 'Add to Cart' }}</span>
                    </button>
                    
                    <button type="button" 
                            class="px-6 py-4 border-2 border-gray-300 rounded-lg hover:border-slate-900 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>
            @else
            <div class="p-4 bg-gray-100 rounded-lg text-center">
                <p class="text-gray-600 font-medium">Currently Out of Stock</p>
                <button class="mt-3 px-6 py-2 bg-slate-900 text-white rounded-md hover:bg-slate-800">
                    Notify When Available
                </button>
            </div>
            @endif

            <!-- Product Features -->
            <div class="border-t pt-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm">Free Shipping</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm">2 Year Warranty</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm">30-Day Returns</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm">Secure Payment</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Tabs -->
    <div class="mb-16">
        <div class="border-b mb-6">
            <div class="flex gap-8">
                <button class="tab-button active pb-4 px-2 font-medium border-b-2 border-transparent" 
                        data-target="description">
                    Description
                </button>
                <button class="tab-button pb-4 px-2 font-medium border-b-2 border-transparent" 
                        data-target="specifications">
                    Specifications
                </button>
                <button class="tab-button pb-4 px-2 font-medium border-b-2 border-transparent" 
                        data-target="reviews">
                    Reviews (234)
                </button>
            </div>
        </div>

        <!-- Tab Contents -->
        <div id="description" class="tab-content active">
            <div class="prose max-w-none">
                <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
            </div>
        </div>

        <div id="specifications" class="tab-content">
            <div class="grid md:grid-cols-2 gap-4">
                <div class="p-4 bg-slate-50 rounded-lg">
                    <span class="font-medium">SKU:</span>
                    <span class="text-gray-600 ml-2">{{ $product->sku }}</span>
                </div>
                @if($product->category)
                <div class="p-4 bg-slate-50 rounded-lg">
                    <span class="font-medium">Category:</span>
                    <span class="text-gray-600 ml-2">{{ $product->category->name }}</span>
                </div>
                @endif
            </div>
        </div>

        <div id="reviews" class="tab-content">
            <p class="text-gray-600">Reviews coming soon...</p>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts && $relatedProducts->count() > 0)
    <section class="mb-16">
        <h2 class="text-3xl font-bold mb-8">You May Also Like</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $relatedProduct)
            <a href="{{ route('products.show', $relatedProduct->id) }}" class="product-card bg-white rounded-lg border overflow-hidden">
                <div class="relative aspect-square bg-slate-100 overflow-hidden">
                    <img src="{{ $relatedProduct->image_url }}" 
                         alt="{{ $relatedProduct->name }}"
                         class="w-full h-full object-cover">
                </div>
                <div class="p-4">
                    <h3 class="font-semibold mb-2 line-clamp-2">{{ $relatedProduct->name }}</h3>
                    <p class="text-xl font-bold">${{ number_format($relatedProduct->price, 2) }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif
</div>

@push('scripts')
<script>
    const maxQuantity = {{ $product->stock_quantity }};
    const initialQuantityInCart = {{ $quantityInCart }};
    
    function incrementQuantity() {
        const input = document.getElementById('quantity');
        const currentValue = parseInt(input.value);
        if (currentValue < maxQuantity) {
            input.value = currentValue + 1;
            updateButtonText();
        }
    }
    
    function decrementQuantity() {
        const input = document.getElementById('quantity');
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
            updateButtonText();
        }
    }
    
    function updateButtonText() {
        const quantity = parseInt(document.getElementById('quantity').value);
        const btnText = document.getElementById('btnText');
        
        if (initialQuantityInCart > 0) {
            if (quantity === initialQuantityInCart) {
                btnText.textContent = 'Cart Updated';
            } else {
                btnText.textContent = 'Update Cart';
            }
        } else {
            btnText.textContent = 'Add to Cart';
        }
    }
    
    // Handle form submission
    document.getElementById('addToCartForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const btn = document.getElementById('addToCartBtn');
        const btnText = document.getElementById('btnText');
        const originalText = btnText.textContent;
        
        // Disable button and show loading
        btn.disabled = true;
        btnText.textContent = 'Adding...';
        
        try {
            const formData = new FormData(this);
            const response = await fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Update button text
                btnText.textContent = '✓ ' + data.message;
                
                // Update cart count badge
                document.querySelectorAll('.cart-count').forEach(el => {
                    el.textContent = data.cart_count || 0;
                });
                
                // Reset button after 2 seconds
                setTimeout(() => {
                    btnText.textContent = 'Update Cart';
                    btn.disabled = false;
                }, 2000);
            } else {
                throw new Error(data.message || 'Failed to add to cart');
            }
        } catch (error) {
            console.error('Error:', error);
            alert(error.message || 'Failed to add to cart. Please try again.');
            btnText.textContent = originalText;
            btn.disabled = false;
        }
    });
    
    // Watch for quantity changes
    document.getElementById('quantity').addEventListener('change', updateButtonText);
</script>
@endpush
@endsection