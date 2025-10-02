<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->active();
        
        // Handle category filter
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }
        
        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $query->search($request->search);
        }
        
        // Handle sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->latest();
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }
        
        $products = $query->paginate(12)->withQueryString();
        
        $categories = Category::active()->get();
        
        return view('products.index', compact('products', 'categories'));
    }
    
    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->active()->firstOrFail();
        
        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->inRandomOrder()
            ->take(4)
            ->get();
            
        return view('products.show', compact('product', 'relatedProducts'));
    }
}