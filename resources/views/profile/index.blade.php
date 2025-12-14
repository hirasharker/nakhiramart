@extends('layouts.app')

@section('title', 'User Profile')

@section('content')

<main class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white border rounded-lg overflow-hidden">
                    <!-- Profile Header -->
                    <div class="p-6 bg-slate-50 border-b">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-slate-900 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                                JD
                            </div>
                            <div>
                                <h3 class="font-bold text-lg">John Doe</h3>
                                <p class="text-sm text-gray-600">john.doe@email.com</p>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="p-2">
                        <button onclick="switchTab('overview')" class="sidebar-link active w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="font-medium">Overview</span>
                        </button>
                        <button onclick="switchTab('orders')" class="sidebar-link w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <span class="font-medium">Orders</span>
                        </button>
                        <button onclick="switchTab('wishlist')" class="sidebar-link w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <span class="font-medium">Wishlist</span>
                        </button>
                        <button onclick="switchTab('addresses')" class="sidebar-link w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="font-medium">Addresses</span>
                        </button>
                        <button onclick="switchTab('payment')" class="sidebar-link w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            <span class="font-medium">Payment Methods</span>
                        </button>
                        <button onclick="switchTab('settings')" class="sidebar-link w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="font-medium">Settings</span>
                        </button>
                        <div class="border-t my-2"></div>
                        <button class="sidebar-link w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left text-red-600 hover:bg-red-50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="font-medium">Log Out</span>
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="lg:col-span-3">
                
                <!-- Overview Tab -->
                <div id="overview" class="tab-content active">
                    <h1 class="text-3xl font-bold mb-6">Account Overview</h1>
                    
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white border rounded-lg p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Total Orders</p>
                                    <p class="text-3xl font-bold">24</p>
                                </div>
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white border rounded-lg p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Wishlist Items</p>
                                    <p class="text-3xl font-bold">12</p>
                                </div>
                                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white border rounded-lg p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Total Spent</p>
                                    <p class="text-3xl font-bold">$12,458</p>
                                </div>
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="bg-white border rounded-lg p-6 mb-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold">Recent Orders</h2>
                            <button onclick="switchTab('orders')" class="text-sm text-slate-900 font-medium hover:underline">View All</button>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 pb-4 border-b">
                                <img src="https://images.unsplash.com/photo-1511385348-a52b4a160dc2?w=200" alt="MacBook Pro" class="w-20 h-20 object-cover rounded-lg bg-slate-100">
                                <div class="flex-1">
                                    <h3 class="font-semibold mb-1">MacBook Pro 16-inch M3 Max</h3>
                                    <p class="text-sm text-gray-600">Order #ORD-2024-1234</p>
                                    <p class="text-sm text-gray-600">Placed on Dec 1, 2024</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold mb-2">$2,499</p>
                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Delivered</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 pb-4 border-b">
                                <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=200" alt="Headphones" class="w-20 h-20 object-cover rounded-lg bg-slate-100">
                                <div class="flex-1">
                                    <h3 class="font-semibold mb-1">Sony WH-1000XM5</h3>
                                    <p class="text-sm text-gray-600">Order #ORD-2024-1235</p>
                                    <p class="text-sm text-gray-600">Placed on Dec 3, 2024</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold mb-2">$349</p>
                                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">In Transit</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <img src="https://images.unsplash.com/photo-1660844817855-3ecc7ef21f12?w=200" alt="Apple Watch" class="w-20 h-20 object-cover rounded-lg bg-slate-100">
                                <div class="flex-1">
                                    <h3 class="font-semibold mb-1">Apple Watch Series 9</h3>
                                    <p class="text-sm text-gray-600">Order #ORD-2024-1236</p>
                                    <p class="text-sm text-gray-600">Placed on Dec 5, 2024</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold mb-2">$399</p>
                                    <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Processing</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders Tab -->
                <div id="orders" class="tab-content">
                    <h1 class="text-3xl font-bold mb-6">Order History</h1>
                    
                    <div class="bg-white border rounded-lg overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-slate-50 border-b">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-sm font-semibold">Order</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold">Date</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold">Total</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="font-medium">#ORD-2024-1236</div>
                                            <div class="text-sm text-gray-600">3 items</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm">Dec 5, 2024</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Processing</span>
                                        </td>
                                        <td class="px-6 py-4 font-semibold">$3,247.00</td>
                                        <td class="px-6 py-4">
                                            <button class="text-sm text-slate-900 font-medium hover:underline">View Details</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="font-medium">#ORD-2024-1235</div>
                                            <div class="text-sm text-gray-600">1 item</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm">Dec 3, 2024</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">In Transit</span>
                                        </td>
                                        <td class="px-6 py-4 font-semibold">$349.00</td>
                                        <td class="px-6 py-4">
                                            <button class="text-sm text-slate-900 font-medium hover:underline">Track Order</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="font-medium">#ORD-2024-1234</div>
                                            <div class="text-sm text-gray-600">1 item</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm">Dec 1, 2024</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Delivered</span>
                                        </td>
                                        <td class="px-6 py-4 font-semibold">$2,499.00</td>
                                        <td class="px-6 py-4">
                                            <button class="text-sm text-slate-900 font-medium hover:underline">Buy Again</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="font-medium">#ORD-2024-1233</div>
                                            <div class="text-sm text-gray-600">2 items</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm">Nov 28, 2024</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Delivered</span>
                                        </td>
                                        <td class="px-6 py-4 font-semibold">$1,548.00</td>
                                        <td class="px-6 py-4">
                                            <button class="text-sm text-slate-900 font-medium hover:underline">Leave Review</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Wishlist Tab -->
                <div id="wishlist" class="tab-content">
                    <h1 class="text-3xl font-bold mb-6">My Wishlist</h1>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Wishlist Item 1 -->
                        <div class="bg-white rounded-lg border overflow-hidden hover:shadow-lg transition-shadow">
                            <div class="relative aspect-square bg-slate-100 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1760708369071-e8a50a8979cb?w=600" alt="iPad Pro" class="w-full h-full object-cover">
                                <button class="absolute top-3 right-3 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-red-50">
                                    <svg class="w-5 h-5 fill-red-600 text-red-600" viewBox="0 0 24 24">
                                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-1">Tablets</p>
                                <h3 class="font-semibold mb-2">iPad Pro 12.9-inch M2</h3>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xl font-bold">$1,099</span>
                                    <span class="text-sm text-green-600">In Stock</span>
                                </div>
                                <button class="w-full py-2 bg-slate-900 text-white rounded-lg text-sm font-medium hover:bg-slate-800 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </div>

                        <!-- Wishlist Item 2 -->
                        <div class="bg-white rounded-lg border overflow-hidden hover:shadow-lg transition-shadow">
                            <div class="relative aspect-square bg-slate-100 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1579535984712-92fffbbaa266?w=600" alt="Camera" class="w-full h-full object-cover">
                                <button class="absolute top-3 right-3 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-red-50">
                                    <svg class="w-5 h-5 fill-red-600 text-red-600" viewBox="0 0 24 24">
                                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-1">Cameras</p>
                                <h3 class="font-semibold mb-2">Canon EOS R6 Mark II</h3>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xl font-bold">$2,499</span>
                                    <span class="text-sm text-green-600">In Stock</span>
                                </div>
                                <button class="w-full py-2 bg-slate-900 text-white rounded-lg text-sm font-medium hover:bg-slate-800 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </div>

                        <!-- Wishlist Item 3 -->
                        <div class="bg-white rounded-lg border overflow-hidden hover:shadow-lg transition-shadow">
                            <div class="relative aspect-square bg-slate-100 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1674303324806-7018a739ed11?w=600" alt="Speaker" class="w-full h-full object-cover">
                                <button class="absolute top-3 right-3 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-red-50">
                                    <svg class="w-5 h-5 fill-red-600 text-red-600" viewBox="0 0 24 24">
                                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-1">Speakers</p>
                                <h3 class="font-semibold mb-2">Bose SoundLink Revolve+ II</h3>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xl font-bold">$329</span>
                                    <span class="text-sm text-red-600">Low Stock</span>
                                </div>
                                <button class="w-full py-2 bg-slate-900 text-white rounded-lg text-sm font-medium hover:bg-slate-800 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Addresses Tab -->
                <div id="addresses" class="tab-content">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-3xl font-bold">Saved Addresses</h1>
                        <button class="px-4 py-2 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors">
                            Add New Address
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Address 1 -->
                        <div class="bg-white border rounded-lg p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <span class="inline-block px-3 py-1 bg-slate-900 text-white rounded-full text-xs font-medium mb-3">Default</span>
                                    <h3 class="font-bold text-lg">Home</h3>
                                </div>
                                <button class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="text-gray-600 space-y-1">
                                <p class="font-medium text-slate-900">John Doe</p>
                                <p>123 Main Street, Apt 4B</p>
                                <p>New York, NY 10001</p>
                                <p>United States</p>
                                <p class="pt-2">Phone: (555) 123-4567</p>
                            </div>
                            <div class="flex gap-2 mt-4 pt-4 border-t">
                                <button class="flex-1 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">Edit</button>
                                <button class="flex-1 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">Remove</button>
                            </div>
                        </div>

                        <!-- Address 2 -->
                        <div class="bg-white border rounded-lg p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="font-bold text-lg mt-8">Office</h3>
                                </div>
                                <button class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="text-gray-600 space-y-1">
                                <p class="font-medium text-slate-900">John Doe</p>
                                <p>456 Corporate Blvd, Suite 200</p>
                                <p>San Francisco, CA 94105</p>
                                <p>United States</p>
                                <p class="pt-2">Phone: (555) 987-6543</p>
                            </div>
                            <div class="flex gap-2 mt-4 pt-4 border-t">
                                <button class="flex-1 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">Edit</button>
                                <button class="flex-1 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods Tab -->
                <div id="payment" class="tab-content">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-3xl font-bold">Payment Methods</h1>
                        <button class="px-4 py-2 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors">
                            Add Payment Method
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Card 1 -->
                        <div class="bg-white border rounded-lg p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-slate-900 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" viewBox="0 0 32 20" fill="currentColor">
                                            <rect width="32" height="20" rx="2" fill="currentColor"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <p class="font-semibold">•••• •••• •••• 4242</p>
                                            <span class="inline-block px-2 py-0.5 bg-slate-900 text-white rounded text-xs font-medium">Default</span>
                                        </div>
                                        <p class="text-sm text-gray-600">Expires 12/2026</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">Edit</button>
                                    <button class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">Remove</button>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="bg-white border rounded-lg p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" viewBox="0 0 32 20" fill="currentColor">
                                            <rect width="32" height="20" rx="2" fill="currentColor"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold mb-1">•••• •••• •••• 8765</p>
                                        <p class="text-sm text-gray-600">Expires 08/2025</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">Edit</button>
                                    <button class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Settings Tab -->
                <div id="settings" class="tab-content">
                    <h1 class="text-3xl font-bold mb-6">Account Settings</h1>
                    
                    <!-- Personal Information -->
                    <div class="bg-white border rounded-lg p-6 mb-6">
                        <h2 class="text-xl font-bold mb-6">Personal Information</h2>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2">First Name</label>
                                    <input type="text" value="John" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2">Last Name</label>
                                    <input type="text" value="Doe" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Email Address</label>
                                <input type="email" value="john.doe@email.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Phone Number</label>
                                <input type="tel" value="(555) 123-4567" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent">
                            </div>
                            <button class="px-6 py-2 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors">
                                Save Changes
                            </button>
                        </div>
                    </div>

                    <!-- Change Password -->
                    <div class="bg-white border rounded-lg p-6 mb-6">
                        <h2 class="text-xl font-bold mb-6">Change Password</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">Current Password</label>
                                <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">New Password</label>
                                <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Confirm New Password</label>
                                <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent">
                            </div>
                            <button class="px-6 py-2 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors">
                                Update Password
                            </button>
                        </div>
                    </div>

                    <!-- Email Preferences -->
                    <div class="bg-white border rounded-lg p-6">
                        <h2 class="text-xl font-bold mb-6">Email Preferences</h2>
                        <div class="space-y-4">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" checked class="w-5 h-5 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                <div>
                                    <p class="font-medium">Order Updates</p>
                                    <p class="text-sm text-gray-600">Receive updates about your orders</p>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" checked class="w-5 h-5 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                <div>
                                    <p class="font-medium">Promotional Emails</p>
                                    <p class="text-sm text-gray-600">Receive special offers and discounts</p>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="w-5 h-5 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                                <div>
                                    <p class="font-medium">Newsletter</p>
                                    <p class="text-sm text-gray-600">Weekly newsletter with new products</p>
                                </div>
                            </label>
                            <button class="px-6 py-2 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors">
                                Save Preferences
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>
@endsection