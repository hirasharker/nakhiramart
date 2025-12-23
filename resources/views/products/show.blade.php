@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="text-sm mb-8">
            <ol class="flex items-center gap-2 text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-slate-900">Home</a></li>
                <li>/</li>
                <li><a href="{{ route('products.index') }}" class="hover:text-slate-900">Products</a></li>
                <li>/</li>
                <li><a href="{{ route('products.index', ['category' => $product->category_id]) }}" class="hover:text-slate-900">{{ $product->category->name }}</a></li>
                <li>/</li>
                <li class="text-slate-900 font-medium">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="grid lg:grid-cols-2 gap-12 bg-white rounded-lg shadow-sm p-8">
            <!-- Product Images -->
            <div>
                <div class="mb-4">
                    <img id="mainImage" 
                         src="{{ $product->image_url }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-[500px] object-contain bg-slate-50 rounded-lg">
                </div>
                
                @if($product->images->count() > 1)
                <div class="grid grid-cols-4 gap-4">
                    @foreach($product->images as $image)
                    <button onclick="changeImage(this, '{{ $image->url }}')" 
                            class="thumbnail border-2 rounded-lg overflow-hidden {{ $image->is_primary ? 'border-slate-900' : 'border-gray-200' }} hover:border-slate-900 transition-colors">
                        <img src="{{ $image->url }}" 
                             alt="{{ $image->alt_text }}" 
                             class="w-full h-24 object-contain bg-slate-50">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Details -->
            <div>
                <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
                
                <div class="flex items-center gap-4 mb-4">
                    <!-- Rating -->
                    <div class="flex items-center gap-1">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 {{ $i < 4 ? 'fill-yellow-400 text-yellow-400' : 'fill-gray-300 text-gray-300' }}" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                        <span class="text-sm text-gray-600 ml-2">(234 reviews)</span>
                    </div>
                    
                    <!-- Stock Status -->
                    @if($product->available_stock > 0)
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full font-medium">
                            In Stock ({{ $product->available_stock }} available)
                        </span>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full font-medium">
                            Out of Stock
                        </span>
                    @endif
                </div>

                <!-- Price -->
                <div class="mb-6">
                    <span class="text-4xl font-bold">{{ $product->formatted_price }}</span>
                </div>

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.add') }}" method="POST" class="mb-8">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="flex items-center gap-4 mb-6">
                        <label class="text-sm font-medium">Quantity:</label>
                        <div class="flex items-center border border-gray-300 rounded-lg">
                            <button type="button" onclick="decrementQty()" class="px-4 py-2 hover:bg-gray-100">-</button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->available_stock }}" 
                                   class="w-20 text-center border-x border-gray-300 py-2 focus:outline-none">
                            <button type="button" onclick="incrementQty()" class="px-4 py-2 hover:bg-gray-100">+</button>
                        </div>
                    </div>

                    @if($product->available_stock > 0)
                        <div class="flex gap-4">
                            <button type="submit" class="flex-1 px-8 py-4 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Add to Cart
                            </button>
                            <button type="button" class="px-6 py-4 border-2 border-slate-900 rounded-lg hover:bg-slate-50 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                        </div>
                    @else
                        <button type="button" disabled class="w-full px-8 py-4 bg-gray-300 text-gray-600 rounded-lg font-medium cursor-not-allowed">
                            Out of Stock
                        </button>
                    @endif
                </form>

                <!-- Features -->
                <div class="border-t pt-6 space-y-3 mb-6">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm">Free shipping on orders over $50</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm">2 Year Warranty</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm">30-Day Returns</span>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="border-t pt-6">
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-600">SKU:</dt>
                            <dd class="font-medium">{{ $product->sku }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Category:</dt>
                            <dd class="font-medium">{{ $product->category->name }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Product Details Tabs -->
        <div class="mt-12 bg-white rounded-lg shadow-sm p-8">
            <div class="border-b mb-6">
                <div class="flex gap-8">
                    <button class="tab-button pb-4 border-b-2 font-medium active" data-target="description">
                        Description
                    </button>
                    <button class="tab-button pb-4 border-b-2 font-medium text-gray-600 border-transparent" data-target="specifications">
                        Specifications
                    </button>
                    <button class="tab-button pb-4 border-b-2 font-medium text-gray-600 border-transparent" data-target="reviews">
                        Reviews (234)
                    </button>
                </div>
            </div>

            <div id="description" class="tab-content active">
                <div class="prose max-w-none">
                    <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                </div>
            </div>

            <div id="specifications" class="tab-content">
                <dl class="grid grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm text-gray-600 mb-1">Brand</dt>
                        <dd class="font-medium">{{ $product->category->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-600 mb-1">Model</dt>
                        <dd class="font-medium">{{ $product->sku }}</dd>
                    </div>
                </dl>
            </div>

            <div id="reviews" class="tab-content">
                <p class="text-gray-600">Reviews coming soon...</p>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Related Products</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                <div class="bg-white rounded-lg border overflow-hidden hover:shadow-lg transition-shadow">
                    <a href="{{ route('products.show', $related->id) }}">
                        <div class="aspect-square bg-slate-100 overflow-hidden">
                            <img src="{{ $related->image_url }}" alt="{{ $related->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="p-4">
                            <p class="text-xs text-gray-500 mb-1">{{ $related->category->name }}</p>
                            <h3 class="font-semibold mb-2 line-clamp-2">{{ $related->name }}</h3>
                            <p class="text-lg font-bold">{{ $related->formatted_price }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function incrementQty() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.max);
    const current = parseInt(input.value);
    if (current < max) {
        input.value = current + 1;
    }
}

function decrementQty() {
    const input = document.getElementById('quantity');
    const current = parseInt(input.value);
    if (current > 1) {
        input.value = current - 1;
    }
}

function changeImage(thumbnail, imageUrl) {
    document.getElementById('mainImage').src = imageUrl;
    document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('border-slate-900'));
    document.querySelectorAll('.thumbnail').forEach(t => t.classList.add('border-gray-200'));
    thumbnail.classList.remove('border-gray-200');
    thumbnail.classList.add('border-slate-900');
}
</script>
@endpush