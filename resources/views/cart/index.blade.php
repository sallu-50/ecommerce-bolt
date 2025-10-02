@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>
        
        @if($cartItems->isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <h3 class="mt-2 text-xl font-medium text-gray-900">Your cart is empty</h3>
                <p class="mt-1 text-gray-500">Looks like you haven't added any products to your cart yet.</p>
                <div class="mt-6">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping</a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach($cartItems as $item)
                                <li class="flex py-6 px-6">
                                    <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                        <img src="{{ $item->product->image ?? 'https://via.placeholder.com/300' }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover object-center">
                                    </div>

                                    <div class="ml-4 flex flex-1 flex-col">
                                        <div>
                                            <div class="flex justify-between text-base font-medium text-gray-900">
                                                <h3>
                                                    <a href="{{ route('products.show', $item->product->slug) }}">{{ $item->product->name }}</a>
                                                </h3>
                                                <p class="ml-4">${{ number_format($item->price, 2) }}</p>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-500">{{ $item->product->category->name ?? 'Uncategorized' }}</p>
                                        </div>
                                        <div class="flex flex-1 items-end justify-between text-sm">
                                            <div class="flex items-center">
                                                <p class="text-gray-500 mr-3">Qty</p>
                                                <input type="number" min="1" value="{{ $item->quantity }}" id="qty-{{ $item->id }}" data-item-id="{{ $item->id }}" class="input w-16 h-8 py-0 text-center quantity-input">
                                            </div>

                                            <div class="flex">
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-danger-600 hover:text-danger-500">Remove</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="mt-6 flex justify-between">
                        <a href="{{ route('products.index') }}" class="btn btn-outline">
                            Continue Shopping
                        </a>
                        
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline text-danger-600 border-danger-600 hover:bg-danger-50">
                                Clear Cart
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                        
                        <div class="border-t border-gray-200 py-4">
                            <div class="flex justify-between">
                                <p class="text-sm text-gray-600">Subtotal</p>
                                <p class="text-sm font-medium text-gray-900">${{ number_format($total, 2) }}</p>
                            </div>
                            <div class="flex justify-between mt-2">
                                <p class="text-sm text-gray-600">Shipping</p>
                                <p class="text-sm font-medium text-gray-900">Calculated at checkout</p>
                            </div>
                            <div class="flex justify-between mt-2">
                                <p class="text-sm text-gray-600">Tax</p>
                                <p class="text-sm font-medium text-gray-900">Calculated at checkout</p>
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-4 mt-4">
                            <div class="flex justify-between">
                                <p class="text-base font-medium text-gray-900">Total</p>
                                <p class="text-base font-medium text-gray-900">${{ number_format($total, 2) }}</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Shipping and taxes calculated at checkout</p>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary w-full py-3">
                                Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInputs = document.querySelectorAll('.quantity-input');
            
            quantityInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const itemId = this.dataset.itemId;
                    const quantity = this.value;
                    
                    if (quantity <= 0) {
                        if (confirm('Are you sure you want to remove this item from your cart?')) {
                            updateCartItem(itemId, quantity);
                        } else {
                            this.value = 1;
                        }
                    } else {
                        updateCartItem(itemId, quantity);
                    }
                });
            });
            
            function updateCartItem(itemId, quantity) {
                fetch(`/cart/update/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ quantity: quantity })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    </script>
@endsection