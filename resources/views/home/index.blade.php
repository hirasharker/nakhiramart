@extends('layouts.app')

@section('title', 'TechStore - Premium Electronics')

@section('content')
  <!-- Hero Section -->
    <section class="bg-gradient-to-br from-slate-50 to-slate-100 py-20">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left: Content -->
                <div>
                    <div class="inline-block px-3 py-1 bg-slate-900 bg-opacity-10 text-slate-900 rounded-full text-sm mb-6 font-medium">
                        New Arrivals
                    </div>
                    <h1 class="text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                        Premium Electronics<br>For Modern Living
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 max-w-2xl">
                        Discover the latest in technology. From cutting-edge laptops to immersive audio, find everything you need to stay connected.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('products.index') }}" class="px-6 py-3 bg-slate-900 text-white rounded-md font-medium hover:bg-slate-800 flex items-center gap-2">
                            Shop Now
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        <a href="{{ route('products.index') }}" class="px-6 py-3 bg-white border border-gray-300 rounded-md font-medium hover:bg-gray-50">
                            View Catalog
                        </a>
                    </div>
                </div>

                <!-- Right: Product Showcase -->
                <div class="hidden lg:grid grid-cols-2 gap-4">
                    @php
                        $heroProducts = $featuredProducts->take(3);
                    @endphp
                    
                    @if($heroProducts->count() > 0)
                        <!-- Large featured product -->
                        <div class="col-span-2 bg-white rounded-2xl shadow-lg overflow-hidden group hover:shadow-xl transition-shadow duration-300">
                            <div class="relative h-64 overflow-hidden">
                                <img src="{{ $heroProducts->first()->image_url }}" alt="{{ $heroProducts->first()->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 bg-slate-900 text-white text-xs rounded-full font-medium">Best Seller</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <p class="text-sm text-gray-500">{{ $heroProducts->first()->category->name ?? 'Featured' }}</p>
                                <h3 class="font-bold">{{ $heroProducts->first()->name }}</h3>
                            </div>
                        </div>

                        <!-- Secondary products -->
                        @foreach($heroProducts->skip(1)->take(2) as $product)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden group hover:shadow-xl transition-shadow duration-300">
                            <div class="relative h-48 overflow-hidden">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute top-3 left-3">
                                    <span class="px-2 py-1 bg-slate-900 text-white text-xs rounded-full font-medium">New</span>
                                </div>
                            </div>
                            <div class="p-3">
                                <p class="text-xs text-gray-500">{{ $product->category->name ?? 'Product' }}</p>
                                <h3 class="text-sm font-bold">{{ Str::limit($product->name, 25) }}</h3>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Category Filter -->
    <div class="border-b bg-white">
        <div class="container mx-auto px-4">
            <div class="flex gap-2 overflow-x-auto py-4">
                <a href="{{ route('products.index') }}" class="category-btn active flex-shrink-0 px-4 py-2 rounded-md text-sm font-medium">All</a>
                @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->id]) }}" class="category-btn flex-shrink-0 px-4 py-2 rounded-md text-sm font-medium">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <main class="container mx-auto px-4 py-12">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold mb-2">Featured Products</h2>
                <p class="text-gray-600">Discover our complete collection</p>
            </div>
            <div class="text-sm text-gray-600">{{ $featuredProducts->count() }} products</div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
            <!-- Product Card -->
            <div class="product-card bg-white rounded-lg border overflow-hidden">
                <a href="{{ route('products.show', $product->id) }}">
                    <div class="relative aspect-square bg-slate-100 overflow-hidden">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        <div class="absolute top-3 left-3 flex flex-col gap-2">
                            <span class="px-2 py-1 bg-slate-900 text-white text-xs rounded font-medium">New</span>
                        </div>
                    </div>
                </a>
                <div class="p-4">
                    <p class="text-xs text-gray-500 mb-1">{{ $product->category->name ?? 'Uncategorized' }}</p>
                    <h3 class="font-semibold mb-2 line-clamp-2">
                        <a href="{{ route('products.show', $product->id) }}" class="hover:text-slate-900">
                            {{ $product->name }}
                        </a>
                    </h3>
                    <div class="flex items-center gap-1 mb-3">
                        <div class="flex">
                            @for($i = 0; $i < 5; $i++)
                            <svg class="w-3 h-3 {{ $i < 4 ? 'fill-yellow-400 text-yellow-400' : 'fill-gray-300 text-gray-300' }}" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500">({{ rand(50, 500) }})</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xl font-bold">{{ $product->formatted_price }}</span>
                        </div>
                        <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="px-3 py-2 bg-slate-900 text-white rounded-md text-sm font-medium hover:bg-slate-800 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Add
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <!-- Features Section -->
    <section class="py-12 border-y bg-slate-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="flex gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-slate-900 bg-opacity-10 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-1">Free Shipping</h3>
                        <p class="text-sm text-gray-600">On orders over $50</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-slate-900 bg-opacity-10 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-1">2 Year Warranty</h3>
                        <p class="text-sm text-gray-600">On all products</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-slate-900 bg-opacity-10 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M3 18v-6a9 9 0 0118 0v6"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 19a2 2 0 01-2 2h-1a2 2 0 01-2-2v-3a2 2 0 012-2h3zM3 19a2 2 0 002 2h1a2 2 0 002-2v-3a2 2 0 00-2-2H3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-1">24/7 Support</h3>
                        <p class="text-sm text-gray-600">Dedicated support team</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-slate-900 bg-opacity-10 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-1">Secure Payment</h3>
                        <p class="text-sm text-gray-600">100% protected</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
// Add to cart AJAX
document.querySelectorAll('.add-to-cart-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                alert(data.message);
                
                // Update cart count in header if exists
                const cartCount = document.querySelector('.cart-count');
                if (cartCount) {
                    cartCount.textContent = data.cart_count;
                }
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
</script>
@endpush