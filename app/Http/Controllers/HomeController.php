<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured/new products
        $featuredProducts = Product::with(['category', 'primaryImage'])
            ->active()
            ->inStock()
            ->latest()
            ->limit(8)
            ->get();

        // Get categories with product count
        $categories = Category::withCount('activeProducts')
            ->having('active_products_count', '>', 0)
            ->get();

        return view('home.index', compact('featuredProducts', 'categories'));
    }
}