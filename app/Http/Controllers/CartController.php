<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $sessionId = session()->get('cart_session_id');
        
        if (!$sessionId) {
            $sessionId = Str::uuid()->toString();
            session()->put('cart_session_id', $sessionId);
        }
        
        $cartItems = Cart::with('product')
            ->getCartByIdentifier($userId, $sessionId)->get();
            
        $total = Cart::getCartTotal($userId, $sessionId);
        
        return view('cart.index', compact('cartItems', 'total'));
    }
    
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        if (!$product->isInStock()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is out of stock',
                ]);
            }
            
            return back()->with('error', 'Product is out of stock');
        }
        
        $userId = auth()->id();
        $sessionId = session()->get('cart_session_id');
        
        if (!$sessionId) {
            $sessionId = Str::uuid()->toString();
            session()->put('cart_session_id', $sessionId);
        }
        
        $quantity = $request->qty ?? 1;
        
        Cart::addItem($productId, $quantity, $userId, $sessionId);
        
        if ($request->wantsJson()) {
            $count = Cart::getCartCount($userId, $sessionId);
            
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart',
                'count' => $count,
            ]);
        }
        
        return back()->with('success', 'Item added to cart');
    }
    
    public function update(Request $request, $itemId)
    {
        $userId = auth()->id();
        $sessionId = session()->get('cart_session_id');
        
        $quantity = $request->quantity;
        
        if ($quantity <= 0) {
            Cart::removeItem($itemId, $userId, $sessionId);
        } else {
            Cart::updateQuantity($itemId, $quantity, $userId, $sessionId);
        }
        
        if ($request->wantsJson()) {
            $total = Cart::getCartTotal($userId, $sessionId);
            $count = Cart::getCartCount($userId, $sessionId);
            
            return response()->json([
                'success' => true,
                'message' => 'Cart updated',
                'total' => $total,
                'total_formatted' => '$' . number_format($total, 2),
                'count' => $count,
            ]);
        }
        
        return back()->with('success', 'Cart updated');
    }
    
    public function remove($itemId)
    {
        $userId = auth()->id();
        $sessionId = session()->get('cart_session_id');
        
        Cart::removeItem($itemId, $userId, $sessionId);
        
        return back()->with('success', 'Item removed from cart');
    }
    
    public function clear()
    {
        $userId = auth()->id();
        $sessionId = session()->get('cart_session_id');
        
        Cart::clearCart($userId, $sessionId);
        
        return back()->with('success', 'Cart cleared');
    }
}