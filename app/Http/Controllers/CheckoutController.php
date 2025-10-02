<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
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
            
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add items before checkout.');
        }
        
        $total = Cart::getCartTotal($userId, $sessionId);
        
        // Get user addresses if logged in
        $addresses = [];
        if (auth()->check()) {
            $addresses = Address::where('user_id', auth()->id())->get();
        }
        
        return view('checkout.index', compact('cartItems', 'total', 'addresses'));
    }
    
    public function process(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address_line_1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'payment_method' => 'required|in:credit_card,paypal',
            'shipping_method' => 'required|in:standard,express,overnight',
        ]);
        
        $userId = auth()->id();
        $sessionId = session()->get('cart_session_id');
        
        $cartItems = Cart::with('product')
            ->getCartByIdentifier($userId, $sessionId)->get();
            
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add items before checkout.');
        }
        
        $total = Cart::getCartTotal($userId, $sessionId);
        
        // Calculate shipping cost
        $shippingCost = 0;
        switch ($validated['shipping_method']) {
            case 'express':
                $shippingCost = 15;
                break;
            case 'overnight':
                $shippingCost = 25;
                break;
            default:
                $shippingCost = 5;
                break;
        }
        
        // Save address if user is logged in
        $shippingAddressId = null;
        if (auth()->check()) {
            $address = Address::create([
                'user_id' => auth()->id(),
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'address_line_1' => $validated['address_line_1'],
                'address_line_2' => $request->address_line_2,
                'city' => $validated['city'],
                'state' => $validated['state'],
                'postal_code' => $validated['postal_code'],
                'country' => $validated['country'],
                'phone' => $validated['phone'],
                'is_default_shipping' => false,
                'is_default_billing' => false,
            ]);
            
            $shippingAddressId = $address->id;
            $billingAddressId = $address->id;
        }
        
        // Create order
        $order = Order::create([
            'user_id' => $userId,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $validated['payment_method'],
            'total_price' => $total + $shippingCost,
            'shipping_address_id' => $shippingAddressId,
            'billing_address_id' => $shippingAddressId,
            'shipping_method' => $validated['shipping_method'],
            'shipping_cost' => $shippingCost,
            'notes' => $request->notes,
        ]);
        
        // Create order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'product_name' => $item->product->name,
                'product_options' => $item->options,
            ]);
        }
        
        // Clear cart
        Cart::clearCart($userId, $sessionId);
        
        // Store order info in session for confirmation page
        session()->put('order_completed', $order->id);
        
        return redirect()->route('checkout.complete');
    }
    
    public function complete()
    {
        $orderId = session('order_completed');
        
        if (!$orderId) {
            return redirect()->route('home');
        }
        
        $order = Order::with(['items', 'shippingAddress'])->findOrFail($orderId);
        
        // Clear the session variable
        session()->forget('order_completed');
        
        return view('checkout.complete', compact('order'));
    }
}