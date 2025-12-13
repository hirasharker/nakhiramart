<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Here later load products, banners, categories etc.
        return view('products.index');
    }
}
