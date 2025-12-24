<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request)
    {
        $query = Product::with(['category'])->where('is_active', true);
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }
        
        // Category filter
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        $categories = Category::get();
        
        // Sort
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $products = $query->paginate(12);
        
        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product
     */
    public function show($id)
    {
        $product = Product::with(['category', 'images'])->findOrFail($id);
        
        // Get cart to check if product is already in it
        $cart = $this->getCart();
        $cartItem = $cart->items()->where('product_id', $id)->first();
        
        // Get quantity in cart (0 if not in cart)
        $quantityInCart = $cartItem ? $cartItem->quantity : 0;
        
        // Get related products (same category)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->inStock()
            ->limit(4)
            ->get();
        
        return view('products.show', compact('product', 'relatedProducts', 'quantityInCart'));
    }

    /**
     * Show the form for creating a new product (Admin)
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created product (Admin)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|unique:products',
            'name' => 'required|max:200',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean'
        ]);

        $product = Product::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index
                ]);
            }
        }

        return redirect()->route('products.show', $product)
            ->with('success', 'Product created successfully');
    }

    /**
     * Show the form for editing the specified product (Admin)
     */
    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product (Admin)
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'sku' => 'required|unique:products,sku,' . $product->id,
            'name' => 'required|max:200',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean'
        ]);

        $product->update($validated);

        return redirect()->route('products.show', $product)
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified product (Admin)
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }


    /**
     * Get or create cart for current user/session
     */
    protected function getCart()
    {
        if (auth()->check()) {
            return Cart::firstOrCreate(
                ['user_id' => auth()->id()],
                ['session_id' => session()->getId()]
            );
        }

        return Cart::firstOrCreate(
            ['session_id' => session()->getId()],
            ['user_id' => null]
        );
    }

    
}