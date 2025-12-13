@extends('layouts.app')


@section('title', 'Product list')

@section('content')
<main class="container mx-auto px-4 py-8">
        
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Filters Sidebar -->
            <aside class="lg:w-64 flex-shrink-0">
                <div class="sticky top-24">
                    
                    <!-- Mobile Filter Toggle -->
                    <button class="lg:hidden w-full mb-4 px-4 py-3 border-2 border-gray-300 rounded-lg font-medium hover:border-slate-900 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filters
                    </button>

                    <div class="space-y-6">
                        
                        <!-- Categories Filter -->
                        <div class="bg-white border rounded-lg p-4">
                            <h3 class="font-bold mb-4">Categories</h3>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <span class="text-sm">Laptops</span>
                                    <span class="text-xs text-gray-500 ml-auto">(24)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <span class="text-sm">Smartphones</span>
                                    <span class="text-xs text-gray-500 ml-auto">(18)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <span class="text-sm">Tablets</span>
                                    <span class="text-xs text-gray-500 ml-auto">(12)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <span class="text-sm">Headphones</span>
                                    <span class="text-xs text-gray-500 ml-auto">(32)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <span class="text-sm">Smartwatches</span>
                                    <span class="text-xs text-gray-500 ml-auto">(15)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <span class="text-sm">Cameras</span>
                                    <span class="text-xs text-gray-500 ml-auto">(9)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <span class="text-sm">Accessories</span>
                                    <span class="text-xs text-gray-500 ml-auto">(45)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Brand Filter -->
                        <div class="bg-white border rounded-lg p-4">
                            <h3 class="font-bold mb-4">Brands</h3>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <span class="text-sm">Apple</span>
                                    <span class="text-xs text-gray-500 ml-auto">(38)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <span class="text-sm">Samsung</span>
                                    <span class="text-xs text-gray-500 ml-auto">(29)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <span class="text-sm">Sony</span>
                                    <span class="text-xs text-gray-500 ml-auto">(21)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <span class="text-sm">Dell</span>
                                    <span class="text-xs text-gray-500 ml-auto">(15)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <span class="text-sm">HP</span>
                                    <span class="text-xs text-gray-500 ml-auto">(12)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <span class="text-sm">Bose</span>
                                    <span class="text-xs text-gray-500 ml-auto">(8)</span>
                                </label>
                                <button class="text-sm text-slate-900 font-medium hover:underline mt-2">
                                    Show More
                                </button>
                            </div>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="bg-white border rounded-lg p-4">
                            <h3 class="font-bold mb-4">Price Range</h3>
                            <div class="space-y-4">
                                <div>
                                    <input type="range" min="0" max="5000" value="2500" class="w-full">
                                    <div class="flex justify-between mt-2 text-sm">
                                        <span class="text-gray-600">$0</span>
                                        <span class="font-medium">$2,500</span>
                                        <span class="text-gray-600">$5,000</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="text-xs text-gray-600 mb-1 block">Min</label>
                                        <input type="number" placeholder="$0" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-slate-900">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600 mb-1 block">Max</label>
                                        <input type="number" placeholder="$5000" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-slate-900">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rating Filter -->
                        <div class="bg-white border rounded-lg p-4">
                            <h3 class="font-bold mb-4">Customer Rating</h3>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <div class="flex items-center gap-1">
                                        <span class="text-yellow-400">★★★★★</span>
                                        <span class="text-xs text-gray-500 ml-1">(42)</span>
                                    </div>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <div class="flex items-center gap-1">
                                        <span class="text-yellow-400">★★★★</span>
                                        <span class="text-gray-300">★</span>
                                        <span class="text-xs text-gray-500 ml-1">& Up (78)</span>
                                    </div>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <div class="flex items-center gap-1">
                                        <span class="text-yellow-400">★★★</span>
                                        <span class="text-gray-300">★★</span>
                                        <span class="text-xs text-gray-500 ml-1">& Up (112)</span>
                                    </div>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <div class="flex items-center gap-1">
                                        <span class="text-yellow-400">★★</span>
                                        <span class="text-gray-300">★★★</span>
                                        <span class="text-xs text-gray-500 ml-1">& Up (138)</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Availability Filter -->
                        <div class="bg-white border rounded-lg p-4">
                            <h3 class="font-bold mb-4">Availability</h3>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <span class="text-sm">In Stock</span>
                                    <span class="text-xs text-gray-500 ml-auto">(142)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <span class="text-sm">Pre-Order</span>
                                    <span class="text-xs text-gray-500 ml-auto">(8)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <span class="text-sm">Coming Soon</span>
                                    <span class="text-xs text-gray-500 ml-auto">(5)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Features Filter -->
                        <div class="bg-white border rounded-lg p-4">
                            <h3 class="font-bold mb-4">Features</h3>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <span class="text-sm">Free Shipping</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <span class="text-sm">On Sale</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <span class="text-sm">Extended Warranty</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                    <span class="text-sm">Certified Refurbished</span>
                                </label>
                            </div>
                        </div>

                        <!-- Clear Filters Button -->
                        <button class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg font-medium hover:border-slate-900 transition-colors">
                            Clear All Filters
                        </button>

                    </div>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="flex-1">
                
                <!-- Header with Results Count and Sort -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl font-bold mb-1">All Products</h1>
                        <p class="text-sm text-gray-600">Showing 1-12 of 155 results</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-600">Sort by:</span>
                        <select class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-900">
                            <option>Featured</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Newest</option>
                            <option>Best Selling</option>
                            <option>Top Rated</option>
                        </select>
                        <div class="flex border border-gray-300 rounded-lg">
                            <button class="p-2 hover:bg-gray-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                            </button>
                            <button class="p-2 border-l border-gray-300 hover:bg-gray-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Active Filters -->
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-slate-900 text-white rounded-full text-sm">
                        Laptops
                        <button class="hover:text-gray-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </span>
                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-slate-900 text-white rounded-full text-sm">
                        Apple
                        <button class="hover:text-gray-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </span>
                    <button class="text-sm text-gray-600 hover:text-slate-900 underline">Clear all</button>
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    
                    <!-- Product 1 -->
                    <div class="product-card bg-white border rounded-lg overflow-hidden">
                        <a href="product-detail.html" class="block">
                            <div class="relative aspect-square bg-slate-100">
                                <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600" alt="MacBook Pro" class="w-full h-full object-cover">
                                <button class="absolute top-3 right-3 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                                <span class="absolute top-3 left-3 px-2 py-1 bg-red-500 text-white text-xs rounded-full font-medium">Sale</span>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-1">Apple</p>
                                <h3 class="font-semibold mb-2 line-clamp-2">MacBook Pro 16-inch M3 Max</h3>
                                <div class="flex items-center gap-1 mb-2">
                                    <div class="flex text-yellow-400 text-sm">
                                        <span>★★★★★</span>
                                    </div>
                                    <span class="text-xs text-gray-600">(234)</span>
                                </div>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-xl font-bold">$2,499.00</span>
                                    <span class="text-sm text-gray-500 line-through">$2,799.00</span>
                                </div>
                                <button class="w-full px-4 py-2 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </a>
                    </div>

                    <!-- Product 2 -->
                    <div class="product-card bg-white border rounded-lg overflow-hidden">
                        <a href="product-detail.html" class="block">
                            <div class="relative aspect-square bg-slate-100">
                                <img src="https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?w=600" alt="MacBook Air" class="w-full h-full object-cover">
                                <button class="absolute top-3 right-3 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-1">Apple</p>
                                <h3 class="font-semibold mb-2 line-clamp-2">MacBook Air 15-inch M2</h3>
                                <div class="flex items-center gap-1 mb-2">
                                    <div class="flex text-yellow-400 text-sm">
                                        <span>★★★★★</span>
                                    </div>
                                    <span class="text-xs text-gray-600">(189)</span>
                                </div>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-xl font-bold">$1,299.00</span>
                                </div>
                                <button class="w-full px-4 py-2 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </a>
                    </div>

                    <!-- Product 3 -->
                    <div class="product-card bg-white border rounded-lg overflow-hidden">
                        <a href="product-detail.html" class="block">
                            <div class="relative aspect-square bg-slate-100">
                                <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=600" alt="MacBook" class="w-full h-full object-cover">
                                <button class="absolute top-3 right-3 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                                <span class="absolute top-3 left-3 px-2 py-1 bg-blue-500 text-white text-xs rounded-full font-medium">New</span>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-1">Apple</p>
                                <h3 class="font-semibold mb-2 line-clamp-2">MacBook Pro 14-inch M3 Pro</h3>
                                <div class="flex items-center gap-1 mb-2">
                                    <div class="flex text-yellow-400 text-sm">
                                        <span>★★★★★</span>
                                    </div>
                                    <span class="text-xs text-gray-600">(156)</span>
                                </div>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-xl font-bold">$1,999.00</span>
                                </div>
                                <button class="w-full px-4 py-2 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </a>
                    </div>

                    <!-- Product 4 -->
                    <div class="product-card bg-white border rounded-lg overflow-hidden">
                        <a href="product-detail.html" class="block">
                            <div class="relative aspect-square bg-slate-100">
                                <img src="https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=600" alt="Laptop" class="w-full h-full object-cover">
                                <button class="absolute top-3 right-3 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-1">Dell</p>
                                <h3 class="font-semibold mb-2 line-clamp-2">Dell XPS 15 9520 Intel i7</h3>
                                <div class="flex items-center gap-1 mb-2">
                                    <div class="flex text-yellow-400 text-sm">
                                        <span>★★★★</span><span class="text-gray-300">★</span>
                                    </div>
                                    <span class="text-xs text-gray-600">(98)</span>
                                </div>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-xl font-bold">$1,499.00</span>
                                </div>
                                <button class="w-full px-4 py-2 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </a>
                    </div>

                    <!-- Product 5 -->
                    <div class="product-card bg-white border rounded-lg overflow-hidden">
                        <a href="product-detail.html" class="block">
                            <div class="relative aspect-square bg-slate-100">
                                <img src="https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=600" alt="Laptop" class="w-full h-full object-cover">
                                <button class="absolute top-3 right-3 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-1">HP</p>
                                <h3 class="font-semibold mb-2 line-clamp-2">HP Spectre x360 14 2-in-1</h3>
                                <div class="flex items-center gap-1 mb-2">
                                    <div class="flex text-yellow-400 text-sm">
                                        <span>★★★★</span><span class="text-gray-300">★</span>
                                    </div>
                                    <span class="text-xs text-gray-600">(76)</span>
                                </div>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-xl font-bold">$1,399.00</span>
                                </div>
                                <button class="w-full px-4 py-2 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </a>
                    </div>

                    <!-- Product 6 -->
                    <div class="product-card bg-white border rounded-lg overflow-hidden">
                        <a href="product-detail.html" class="block">
                            <div class="relative aspect-square bg-slate-100">
                                <img src="https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=600" alt="Laptop" class="w-full h-full object-cover">
                                <button class="absolute top-3 right-3 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                                <span class="absolute top-3 left-3 px-2 py-1 bg-red-500 text-white text-xs rounded-full font-medium">-15%</span>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-1">Apple</p>
                                <h3 class="font-semibold mb-2 line-clamp-2">MacBook Air 13-inch M1</h3>
                                <div class="flex items-center gap-1 mb-2">
                                    <div class="flex text-yellow-400 text-sm">
                                        <span>★★★★★</span>
                                    </div>
                                    <span class="text-xs text-gray-600">(412)</span>
                                </div>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-xl font-bold">$849.00</span>
                                    <span class="text-sm text-gray-500 line-through">$999.00</span>
                                </div>
                                <button class="w-full px-4 py-2 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </a>
                    </div>

                    <!-- Product 7 -->
                    <div class="product-card bg-white border rounded-lg overflow-hidden">
                        <a href="product-detail.html" class="block">
                            <div class="relative aspect-square bg-slate-100">
                                <img src="https://images.unsplash.com/photo-1484788984921-03950022c9ef?w=600" alt="Laptop" class="w-full h-full object-cover">
                                <button class="absolute top-3 right-3 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-1">Dell</p>
                                <h3 class="font-semibold mb-2 line-clamp-2">Dell Inspiron 15 3000 Series</h3>
                                <div class="flex items-center gap-1 mb-2">
                                    <div class="flex text-yellow-400 text-sm">
                                        <span>★★★★</span><span class="text-gray-300">★</span>
                                    </div>
                                    <span class="text-xs text-gray-600">(54)</span>
                                </div>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-xl font-bold">$649.00</span>
                                </div>
                                <button class="w-full px-4 py-2 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </a>
                    </div>

                    <!-- Product 8 -->
                    <div class="product-card bg-white border rounded-lg overflow-hidden">
                        <a href="product-detail.html" class="block">
                            <div class="relative aspect-square bg-slate-100">
                                <img src="https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600" alt="Laptop" class="w-full h-full object-cover">
                                <button class="absolute top-3 right-3 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-1">HP</p>
                                <h3 class="font-semibold mb-2 line-clamp-2">HP Pavilion 15 Gaming Laptop</h3>
                                <div class="flex items-center gap-1 mb-2">
                                    <div class="flex text-yellow-400 text-sm">
                                        <span>★★★★</span><span class="text-gray-300">★</span>
                                    </div>
                                    <span class="text-xs text-gray-600">(89)</span>
                                </div>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-xl font-bold">$899.00</span>
                                </div>
                                <button class="w-full px-4 py-2 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </a>
                    </div>

                    <!-- Product 9 -->
                    <div class="product-card bg-white border rounded-lg overflow-hidden">
                        <a href="product-detail.html" class="block">
                            <div class="relative aspect-square bg-slate-100">
                                <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600" alt="Laptop" class="w-full h-full object-cover">
                                <button class="absolute top-3 right-3 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                                <span class="absolute top-3 left-3 px-2 py-1 bg-blue-500 text-white text-xs rounded-full font-medium">New</span>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-1">Dell</p>
                                <h3 class="font-semibold mb-2 line-clamp-2">Dell Latitude 5430 Business Laptop</h3>
                                <div class="flex items-center gap-1 mb-2">
                                    <div class="flex text-yellow-400 text-sm">
                                        <span>★★★★</span><span class="text-gray-300">★</span>
                                    </div>
                                    <span class="text-xs text-gray-600">(45)</span>
                                </div>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-xl font-bold">$1,199.00</span>
                                </div>
                                <button class="w-full px-4 py-2 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </a>
                    </div>

                    <!-- Product 10 -->
                    <div class="product-card bg-white border rounded-lg overflow-hidden">
                        <a href="product-detail.html" class="block">
                            <div class="relative aspect-square bg-slate-100">
                                <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=600" alt="Laptop" class="w-full h-full object-cover">
                                <button class="absolute top-3 right-3 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-1">Apple</p>
                                <h3 class="font-semibold mb-2 line-clamp-2">iMac 24-inch M3 All-in-One</h3>
                                <div class="flex items-center gap-1 mb-2">
                                    <div class="flex text-yellow-400 text-sm">
                                        <span>★★★★★</span>
                                    </div>
                                    <span class="text-xs text-gray-600">(167)</span>
                                </div>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-xl font-bold">$1,599.00</span>
                                </div>
                                <button class="w-full px-4 py-2 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </a>
                    </div>

                    <!-- Product 11 -->
                    <div class="product-card bg-white border rounded-lg overflow-hidden">
                        <a href="product-detail.html" class="block">
                            <div class="relative aspect-square bg-slate-100">
                                <img src="https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=600" alt="Laptop" class="w-full h-full object-cover">
                                <button class="absolute top-3 right-3 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                                <span class="absolute top-3 left-3 px-2 py-1 bg-red-500 text-white text-xs rounded-full font-medium">-20%</span>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-1">HP</p>
                                <h3 class="font-semibold mb-2 line-clamp-2">HP Envy 13 Ultrabook</h3>
                                <div class="flex items-center gap-1 mb-2">
                                    <div class="flex text-yellow-400 text-sm">
                                        <span>★★★★</span><span class="text-gray-300">★</span>
                                    </div>
                                    <span class="text-xs text-gray-600">(92)</span>
                                </div>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-xl font-bold">$799.00</span>
                                    <span class="text-sm text-gray-500 line-through">$999.00</span>
                                </div>
                                <button class="w-full px-4 py-2 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </a>
                    </div>

                    <!-- Product 12 -->
                    <div class="product-card bg-white border rounded-lg overflow-hidden">
                        <a href="product-detail.html" class="block">
                            <div class="relative aspect-square bg-slate-100">
                                <img src="https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=600" alt="Laptop" class="w-full h-full object-cover">
                                <button class="absolute top-3 right-3 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-1">Dell</p>
                                <h3 class="font-semibold mb-2 line-clamp-2">Dell Precision 5570 Workstation</h3>
                                <div class="flex items-center gap-1 mb-2">
                                    <div class="flex text-yellow-400 text-sm">
                                        <span>★★★★★</span>
                                    </div>
                                    <span class="text-xs text-gray-600">(67)</span>
                                </div>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-xl font-bold">$2,299.00</span>
                                </div>
                                <button class="w-full px-4 py-2 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </a>
                    </div>

                </div>

                <!-- Pagination -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-8 border-t">
                    <p class="text-sm text-gray-600">Showing 1-12 of 155 products</p>
                    <div class="flex items-center gap-2">
                        <button class="px-3 py-2 border border-gray-300 rounded-lg hover:border-slate-900 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button class="px-4 py-2 bg-slate-900 text-white rounded-lg font-medium">1</button>
                        <button class="px-4 py-2 border border-gray-300 rounded-lg hover:border-slate-900 transition-colors">2</button>
                        <button class="px-4 py-2 border border-gray-300 rounded-lg hover:border-slate-900 transition-colors">3</button>
                        <span class="px-2 text-gray-600">...</span>
                        <button class="px-4 py-2 border border-gray-300 rounded-lg hover:border-slate-900 transition-colors">13</button>
                        <button class="px-3 py-2 border border-gray-300 rounded-lg hover:border-slate-900 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </main>
@endsection