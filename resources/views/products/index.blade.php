@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Page Header -->
    <div class="bg-white border-b">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-4">Products</h1>
            
            <!-- Search & Filter Bar -->
            <div class="flex flex-col md:flex-row gap-4">
                <form action="{{ route('products.index') }}" method="GET" class="flex-1 flex gap-4">
                    <div class="flex-1">
                        <input type="search" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Search products..." 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900">
                    </div>
                    <button type="submit" class="px-6 py-3 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="grid lg:grid-cols-4 gap-8">
            <!-- Sidebar Filters -->
            <aside class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-4">
                    <h2 class="font-bold text-lg mb-4">Filters</h2>
                    
                    <!-- Categories -->
                    <div class="mb-6">
                        <h3 class="font-semibold mb-3">Categories</h3>
                        <div class="space-y-2">
                            <a href="{{ route('products.index') }}" 
                               class="block py-2 px-3 rounded-md {{ !request('category') ? 'bg-slate-900 text-white' : 'hover:bg-gray-100' }}">
                                All Products
                            </a>
                            @foreach($categories as $category)
                            <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                               class="block py-2 px-3 rounded-md {{ request('category') == $category->id ? 'bg-slate-900 text-white' : 'hover:bg-gray-100' }}">
                                {{ $category->name }}
                                <span class="text-xs opacity-75">({{ $category->products_count }})</span>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6">
                        <h3 class="font-semibold mb-3">Price Range</h3>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2">
                                <input type="checkbox" class="rounded">
                                <span class="text-sm">Under $500</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" class="rounded">
                                <span class="text-sm">$500 - $1000</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" class="rounded">
                                <span class="text-sm">$1000 - $2000</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" class="rounded">
                                <span class="text-sm">Over $2000</span>
                            </label>
                        </div>
                    </div>

                    <!-- Clear Filters -->
                    @if(request('category') || request('search'))
                    <a href="{{ route('products.index') }}" class="block w-full px-4 py-2 text-center border border-gray-300 rounded-lg hover:bg-gray-50">
                        Clear Filters
                    </a>
                    @endif
                </div>
            </aside>

            <!-- Products Grid -->
            <main class="lg:col-span-3">
                <!-- Sort & Results Count -->
                <div class="flex items-center justify-between mb-6">
                    <p class="text-gray-600">
                        Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
                    </p>
                    <form action="{{ route('products.index') }}" method="GET" class="flex items-center gap-2">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <label class="text-sm text-gray-600">Sort by:</label>
                        <select name="sort_by" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900">
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Newest</option>
                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </form>
                </div>

                @if($products->isEmpty())
                    <!-- No Products -->
                    <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                        <svg class="w-24 h-24 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <h2 class="text-2xl font-semibold mb-2">No products found</h2>
                        <p class="text-gray-600 mb-6">Try adjusting your filters or search terms</p>
                        <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-slate-900 text-white rounded-lg hover:bg-slate-800">
                            Clear Filters
                        </a>
                    </div>
                @else
                    <!-- Products Grid -->
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                        <div class="product-card bg-white rounded-lg border overflow-hidden">
                            <a href="{{ route('products.show', $product->id) }}">
                                <div class="relative aspect-square bg-slate-100 overflow-hidden">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @if($product->available_stock <= 0)
                                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                            <span class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded">Out of Stock</span>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-1">{{ $product->category->name }}</p>
                                <h3 class="font-semibold mb-2 line-clamp-2">
                                    <a href="{{ route('products.show', $product->id) }}" class="hover:text-slate-700">
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
                                    <span class="text-xs text-gray-500">(234)</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-xl font-bold">{{ $product->formatted_price }}</span>
                                    </div>
                                    @if($product->available_stock > 0)
                                        <form action="{{ route('cart.add') }}" method="POST" class="inline">
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
                                    @else
                                        <button disabled class="px-3 py-2 bg-gray-300 text-gray-600 rounded-md text-sm font-medium cursor-not-allowed">
                                            Out of Stock
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>
@endsection