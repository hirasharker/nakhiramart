<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'TechStore - Premium Electronics')</title>

  <!-- Tailwind (kept same as your original file) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
      background-color: #ffffff;
    }
    .product-card { transition: all 0.3s ease; }
    .product-card:hover { box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
    .product-card:hover img { transform: scale(1.05); }
    .product-card img { transition: transform 0.3s ease; }
    .category-btn { transition: all 0.2s ease; }
    .category-btn:hover { background-color: #f1f5f9; }
    .category-btn.active { background-color: #0f172a; color: white; }
    .nav-link { transition: color 0.2s ease; }
    .nav-link:hover { color: #0f172a; }
    .social-icon { transition: background-color 0.2s ease; }
    .social-icon:hover { background-color: #475569; }
    .modal-overlay { transition: opacity 0.3s ease; }
    .modal-content { transition: transform 0.3s ease, opacity 0.3s ease; }
    .container { max-width: 1200px; }
  </style>

  <style>
  .tab-content { display: none; }
  .tab-content.active { display: block; }
  .tab-button.active { color: #0f172a; border-color: #0f172a; font-weight: 700; }
</style>

  @stack('head')
</head>
<body class="bg-white">

  @include('partials.header')

  @yield('content')
 
  @include('partials.footer')

  <div id="signInModal" class="modal-overlay hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="modal-content bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold">Sign In</h2>
                    <button onclick="closeSignInModal()" class="p-1 hover:bg-gray-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Social Sign In -->
                <div class="space-y-3 mb-6">
                    <button class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg font-medium hover:border-slate-900 transition-colors flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Continue with Google
                    </button>
                    <button class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg font-medium hover:border-slate-900 transition-colors flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Continue with Facebook
                    </button>
                </div>

                <!-- Divider -->
                <div class="relative mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or continue with email</span>
                    </div>
                </div>

                <!-- Sign In Form -->
                <form class="space-y-4">
                    <div>
                        <label for="signInEmail" class="block text-sm font-medium mb-2">Email Address</label>
                        <input type="email" id="signInEmail" placeholder="you@example.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent">
                    </div>
                    <div>
                        <label for="signInPassword" class="block text-sm font-medium mb-2">Password</label>
                        <input type="password" id="signInPassword" placeholder="Enter your password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent">
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                            <span class="text-sm">Remember me</span>
                        </label>
                        <a href="#" class="text-sm text-slate-900 hover:underline">Forgot password?</a>
                    </div>
                    <button type="submit" class="w-full px-4 py-3 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors">
                        Sign In
                    </button>
                </form>

                <!-- Sign Up Link -->
                <p class="text-center text-sm text-gray-600 mt-6">
                    Don't have an account? 
                    <button onclick="switchToSignUp()" class="text-slate-900 font-medium hover:underline">Sign up</button>
                </p>
            </div>
        </div>
    </div>

    <!-- Sign Up Modal -->
    <div id="signUpModal" class="modal-overlay hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="modal-content bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold">Create Account</h2>
                    <button onclick="closeSignUpModal()" class="p-1 hover:bg-gray-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Social Sign Up -->
                <div class="space-y-3 mb-6">
                    <button class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg font-medium hover:border-slate-900 transition-colors flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Continue with Google
                    </button>
                    <button class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg font-medium hover:border-slate-900 transition-colors flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Continue with Facebook
                    </button>
                </div>

                <!-- Divider -->
                <div class="relative mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or sign up with email</span>
                    </div>
                </div>

                <!-- Sign Up Form -->
                <form class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="signUpFirstName" class="block text-sm font-medium mb-2">First Name</label>
                            <input type="text" id="signUpFirstName" placeholder="John" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent">
                        </div>
                        <div>
                            <label for="signUpLastName" class="block text-sm font-medium mb-2">Last Name</label>
                            <input type="text" id="signUpLastName" placeholder="Doe" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent">
                        </div>
                    </div>
                    <div>
                        <label for="signUpEmail" class="block text-sm font-medium mb-2">Email Address</label>
                        <input type="email" id="signUpEmail" placeholder="you@example.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent">
                    </div>
                    <div>
                        <label for="signUpPassword" class="block text-sm font-medium mb-2">Password</label>
                        <input type="password" id="signUpPassword" placeholder="Create a password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters</p>
                    </div>
                    <div>
                        <label for="signUpConfirmPassword" class="block text-sm font-medium mb-2">Confirm Password</label>
                        <input type="password" id="signUpConfirmPassword" placeholder="Confirm your password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent">
                    </div>
                    <div class="flex items-start gap-2">
                        <input type="checkbox" id="terms" class="w-4 h-4 mt-1 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                        <label for="terms" class="text-sm text-gray-600">
                            I agree to the <a href="#" class="text-slate-900 hover:underline">Terms of Service</a> and <a href="#" class="text-slate-900 hover:underline">Privacy Policy</a>
                        </label>
                    </div>
                    <button type="submit" class="w-full px-4 py-3 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors">
                        Create Account
                    </button>
                </form>

                <!-- Sign In Link -->
                <p class="text-center text-sm text-gray-600 mt-6">
                    Already have an account? 
                    <button onclick="switchToSignIn()" class="text-slate-900 font-medium hover:underline">Sign in</button>
                </p>
            </div>
        </div>
    </div>

    <!-- Cart Modal -->
    <div id="cartModal" class="modal-overlay hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-end">
        <div class="modal-content bg-white h-full w-full max-w-md shadow-2xl flex flex-col">
            <!-- Header -->
            <div class="p-6 border-b">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold">Shopping Cart</h2>
                    <button onclick="closeCartModal()" class="p-1 hover:bg-gray-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-sm text-gray-600 mt-1">3 items in cart</p>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4">
                <!-- Cart Item 1 -->
                <div class="flex gap-4 pb-4 border-b">
                    <div class="w-24 h-24 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0">
                        <img src="https://images.unsplash.com/photo-1511385348-a52b4a160dc2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxsYXB0b3AlMjBjb21wdXRlcnxlbnwxfHx8fDE3NjUwMTM1MTN8MA&ixlib=rb-4.1.0&q=80&w=1080" alt="MacBook Pro" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-sm mb-1">MacBook Pro 16-inch M3 Max</h3>
                        <p class="text-xs text-gray-500 mb-2">Space Gray, 256GB</p>
                        <div class="flex items-center gap-3">
                            <div class="flex items-center border border-gray-300 rounded">
                                <button class="px-2 py-1 hover:bg-gray-100">-</button>
                                <span class="px-3 py-1 text-sm border-x border-gray-300">1</span>
                                <button class="px-2 py-1 hover:bg-gray-100">+</button>
                            </div>
                            <button class="text-red-600 text-xs hover:underline">Remove</button>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold">$2499</p>
                    </div>
                </div>

                <!-- Cart Item 2 -->
                <div class="flex gap-4 pb-4 border-b">
                    <div class="w-24 h-24 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0">
                        <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHx3aXJlbGVzcyUyMGhlYWRwaG9uZXN8ZW58MXx8fHwxNzY0OTgwNDg0fDA&ixlib=rb-4.1.0&q=80&w=1080" alt="Headphones" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-sm mb-1">Sony WH-1000XM5 Wireless</h3>
                        <p class="text-xs text-gray-500 mb-2">Black</p>
                        <div class="flex items-center gap-3">
                            <div class="flex items-center border border-gray-300 rounded">
                                <button class="px-2 py-1 hover:bg-gray-100">-</button>
                                <span class="px-3 py-1 text-sm border-x border-gray-300">1</span>
                                <button class="px-2 py-1 hover:bg-gray-100">+</button>
                            </div>
                            <button class="text-red-600 text-xs hover:underline">Remove</button>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold">$349</p>
                    </div>
                </div>

                <!-- Cart Item 3 -->
                <div class="flex gap-4 pb-4 border-b">
                    <div class="w-24 h-24 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0">
                        <img src="https://images.unsplash.com/photo-1660844817855-3ecc7ef21f12?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxzbWFydHdhdGNofGVufDF8fHx8MTc2NTAzNzgxM3ww&ixlib=rb-4.1.0&q=80&w=1080" alt="Apple Watch" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-sm mb-1">Apple Watch Series 9 GPS</h3>
                        <p class="text-xs text-gray-500 mb-2">Midnight, 41mm</p>
                        <div class="flex items-center gap-3">
                            <div class="flex items-center border border-gray-300 rounded">
                                <button class="px-2 py-1 hover:bg-gray-100">-</button>
                                <span class="px-3 py-1 text-sm border-x border-gray-300">1</span>
                                <button class="px-2 py-1 hover:bg-gray-100">+</button>
                            </div>
                            <button class="text-red-600 text-xs hover:underline">Remove</button>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold">$399</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-6 border-t bg-slate-50">
                <!-- Coupon Code -->
                <div class="mb-4">
                    <div class="flex gap-2">
                        <input type="text" placeholder="Coupon code" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent">
                        <button class="px-4 py-2 border border-slate-900 text-slate-900 rounded-md font-medium hover:bg-slate-900 hover:text-white transition-colors">
                            Apply
                        </button>
                    </div>
                </div>

                <!-- Summary -->
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">$3,247</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-medium">$25</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Tax</span>
                        <span class="font-medium">$260</span>
                    </div>
                    <div class="border-t pt-2 mt-2">
                        <div class="flex justify-between">
                            <span class="font-bold">Total</span>
                            <span class="font-bold text-xl">$3,532</span>
                        </div>
                    </div>
                </div>

                <!-- Checkout Buttons -->
                <div class="space-y-2">
                    <button class="w-full px-6 py-3 bg-slate-900 text-white rounded-md font-medium hover:bg-slate-800 transition-colors">
                        Proceed to Checkout
                    </button>
                    <button onclick="closeCartModal()" class="w-full px-6 py-3 bg-white border border-gray-300 rounded-md font-medium hover:bg-gray-50 transition-colors">
                        Continue Shopping
                    </button>
                </div>
            </div>
        </div>
    </div>


  {{-- Compiled JavaScript from index_v3.html (modals, mobile nav, cart logic) --}}
  <script>
        // Modal Functions
        function openSignInModal() {
            document.getElementById('signInModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSignInModal() {
            document.getElementById('signInModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function openSignUpModal() {
            document.getElementById('signUpModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSignUpModal() {
            document.getElementById('signUpModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function openCartModal() {
            document.getElementById('cartModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeCartModal() {
            document.getElementById('cartModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function switchToSignUp() {
            closeSignInModal();
            setTimeout(() => openSignUpModal(), 100);
        }

        function switchToSignIn() {
            closeSignUpModal();
            setTimeout(() => openSignInModal(), 100);
        }

        // Close modal when clicking outside
        document.getElementById('signInModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeSignInModal();
            }
        });

        document.getElementById('signUpModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeSignUpModal();
            }
        });

        document.getElementById('cartModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCartModal();
            }
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSignInModal();
                closeSignUpModal();
                closeCartModal();
            }
        });

        // Image gallery functionality
        function changeImage(thumbnail, imageUrl) {
            document.getElementById('mainImage').src = imageUrl;
            document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
            thumbnail.classList.add('active');
        }

        // Tab switching functionality
        (function () {
  // Find existing tab buttons and normalize them to have data-target
  function normalizeTabButtons() {
    const btns = document.querySelectorAll('.tab-button');

    btns.forEach(btn => {
      // If data-target already set, nothing to do
      if (btn.hasAttribute('data-target')) return;

      // If an inline onclick contains switchTab('id') -> extract it and set data-target
      const onclick = btn.getAttribute('onclick') || '';
      const m = onclick.match(/switchTab\(['"]([^'"]+)['"]\)/);
      if (m) {
        btn.setAttribute('data-target', m[1]);
      }
    });
  }

  // Show a tab by id and mark the clicked button active
  function showTab(targetId, clickedButton) {
    const tabContents = document.querySelectorAll('.tab-content');
    const tabButtons = document.querySelectorAll('.tab-button');

    tabContents.forEach(c => c.classList.remove('active'));
    tabButtons.forEach(b => b.classList.remove('active'));

    const target = document.getElementById(targetId);
    if (target) target.classList.add('active');

    if (clickedButton) {
      clickedButton.classList.add('active');
    } else {
      // if clickedButton missing, try to find matching button by data-target
      const btn = document.querySelector(`.tab-button[data-target="${targetId}"]`);
      if (btn) btn.classList.add('active');
    }
  }

  // Called from old inline onclicks: switchTab('description')
  // We use document.activeElement to guess which button triggered the call.
  window.switchTab = function (targetId) {
    // prefer the element that currently has focus (usually the button that was clicked)
    const active = document.activeElement;
    if (active && active.classList && active.classList.contains('tab-button')) {
      showTab(targetId, active);
      return;
    }

    // fallback: find a .tab-button with matching data-target or with onclick referring to same id
    const byData = document.querySelector(`.tab-button[data-target="${targetId}"]`);
    if (byData) { showTab(targetId, byData); return; }

    // last resort: just show the tab without an active button
    showTab(targetId, null);
  };

  // Attach event listeners after DOM ready
  document.addEventListener('DOMContentLoaded', function () {
    normalizeTabButtons();

    const tabButtons = document.querySelectorAll('.tab-button');

    tabButtons.forEach(btn => {
      // If the button has an inline onclick that already calls switchTab, skip adding duplicate click handler.
      const onclick = btn.getAttribute('onclick') || '';
      const callsSwitchTab = /switchTab\(/.test(onclick);

      // Add a safe click handler (idempotent)
      if (!callsSwitchTab) {
        btn.addEventListener('click', function (e) {
          const targetId = btn.getAttribute('data-target') || btn.dataset.target;
          if (!targetId) return;
          showTab(targetId, btn);
        });
      } else {
        // For buttons that use inline switchTab(...) we still want to ensure they get 'active' class
        // when clicked (the global switchTab() uses document.activeElement)
        btn.addEventListener('click', function () {
          const targetId = btn.getAttribute('data-target') || (() => {
            const m = (btn.getAttribute('onclick') || '').match(/switchTab\(['"]([^'"]+)['"]\)/);
            return m ? m[1] : null;
          })();
          if (!targetId) return;
          // small timeout to let the global switchTab run first (if it exists)
          setTimeout(() => showTab(targetId, btn), 0);
        });
      }
    });

    // Hash support: open a tab if URL has #id
    if (location.hash) {
      const hashTarget = location.hash.replace('#', '');
      if (document.getElementById(hashTarget)) {
        showTab(hashTarget, document.querySelector(`.tab-button[data-target="${hashTarget}"]`));
      }
    }

    // Activate first tab if none active
    const anyActiveContent = document.querySelector('.tab-content.active');
    if (!anyActiveContent) {
      const firstContent = document.querySelector('.tab-content');
      if (firstContent) {
        const firstId = firstContent.id;
        const firstBtn = document.querySelector(`.tab-button[data-target="${firstId}"]`) || document.querySelector('.tab-button');
        showTab(firstId, firstBtn);
      }
    }
  });
})();
    </script>

  @stack('scripts')
</body>
</html>
