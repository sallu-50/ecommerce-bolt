<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $featuredProducts = Product::featured()->latest()->take(4)->get();
        $newArrivals = Product::latest()->take(4)->get();

        return view('home', compact('categories', 'featuredProducts', 'newArrivals'));
    }
}
