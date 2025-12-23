<!-- Header -->
<header class="bg-white border-b sticky top-0 z-40">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-slate-900 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <span class="text-xl font-bold">{{ config('app.name', 'TechStore') }}</span>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="nav-link text-sm font-medium {{ request()->routeIs('home') ? 'text-slate-900' : 'text-gray-600' }}">Home</a>
                <a href="{{ route('products.index') }}" class="nav-link text-sm font-medium {{ request()->routeIs('products.*') ? 'text-slate-900' : 'text-gray-600' }}">Products</a>
                <a href="#" class="nav-link text-sm font-medium text-gray-600">About</a>
                <a href="#" class="nav-link text-sm font-medium text-gray-600">Contact</a>
            </nav>

            <!-- Right Section -->
            <div class="flex items-center gap-4">
                <!-- Search -->
                <button class="hidden md:block p-2 hover:bg-slate-50 rounded-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- Cart -->
                <button onclick="openCartModal()" class="relative p-2 hover:bg-slate-50 rounded-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="cart-count absolute -top-1 -right-1 bg-slate-900 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                </button>

                <!-- User Menu -->
                @auth
                <div class="relative">
                    <button class="p-2 hover:bg-slate-50 rounded-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </button>
                </div>
                @else
                <button onclick="openSignInModal()" class="hidden md:block px-4 py-2 bg-slate-900 text-white rounded-md text-sm font-medium hover:bg-slate-800">
                    Sign In
                </button>
                @endauth

                <!-- Mobile Menu Button -->
                <button class="md:hidden p-2 hover:bg-slate-50 rounded-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>

@push('scripts')
<script>
// Update cart count on page load
fetch('{{ route("cart.count") }}')
    .then(response => response.json())
    .then(data => {
        const cartCount = document.querySelector('.cart-count');
        if (cartCount) {
            cartCount.textContent = data.count;
        }
    });
</script>
@endpush