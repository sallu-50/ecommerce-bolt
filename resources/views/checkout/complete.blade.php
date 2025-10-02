@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-sm p-8 text-center max-w-3xl mx-auto">
            <div class="flex justify-center">
                <div class="rounded-full bg-success-100 p-3">
                    <svg class="h-12 w-12 text-success-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            
            <h1 class="mt-4 text-3xl font-bold text-gray-900">Order Confirmed!</h1>
            
            <p class="mt-2 text-lg text-gray-600">Thank you for your order. Your order has been placed and is being processed.</p>
            
            <div class="mt-8">
                <div class="bg-gray-50 rounded-lg p-6 text-left">
                    <h2 class="text-xl font-medium text-gray-900 mb-4">Order #{{ $order->id }}</h2>
                    
                    <div class="border-t border-gray-200 pt-4 pb-2">
                        <p class="text-sm text-gray-500">Order Date: {{ $order->created_at->format('F j, Y') }}</p>
                        <p class="text-sm text-gray-500">Payment Method: {{ ucfirst($order->payment_method) }}</p>
                        <p class="text-sm text-gray-500">Order Status: <span class="font-medium text-primary-600">{{ ucfirst($order->status) }}</span></p>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 mt-2">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Order Items</h3>
                        
                        <ul class="divide-y divide-gray-200">
                            @foreach($order->items as $item)
                                <li class="py-3 flex justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $item->product_name }}</p>
                                        <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900">${{ number_format($item->subtotal, 2) }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="flex justify-between">
                            <p class="text-sm text-gray-600">Subtotal</p>
                            <p class="text-sm font-medium text-gray-900">${{ number_format($order->total_price - $order->shipping_cost, 2) }}</p>
                        </div>
                        <div class="flex justify-between mt-2">
                            <p class="text-sm text-gray-600">Shipping ({{ ucfirst($order->shipping_method) }})</p>
                            <p class="text-sm font-medium text-gray-900">${{ number_format($order->shipping_cost, 2) }}</p>
                        </div>
                        <div class="border-t border-gray-200 pt-2 mt-2">
                            <div class="flex justify-between">
                                <p class="text-base font-medium text-gray-900">Total</p>
                                <p class="text-base font-medium text-gray-900">${{ number_format($order->total_price, 2) }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($order->shippingAddress)
                        <div class="border-t border-gray-200 pt-4 mt-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Shipping Address</h3>
                            <p class="text-sm text-gray-600">{{ $order->shippingAddress->full_name }}</p>
                            <p class="text-sm text-gray-600">{{ $order->shippingAddress->address_line_1 }}</p>
                            @if($order->shippingAddress->address_line_2)
                                <p class="text-sm text-gray-600">{{ $order->shippingAddress->address_line_2 }}</p>
                            @endif
                            <p class="text-sm text-gray-600">{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->postal_code }}</p>
                            <p class="text-sm text-gray-600">{{ $order->shippingAddress->country }}</p>
                            @if($order->shippingAddress->phone)
                                <p class="text-sm text-gray-600">{{ $order->shippingAddress->phone }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="mt-8">
                <p class="text-sm text-gray-500">We've sent a confirmation email to your email address.</p>
                <p class="text-sm text-gray-500">You can check the status of your order in the "Orders" section of your account.</p>
            </div>
            
            <div class="mt-8 flex justify-center">
                <a href="{{ route('home') }}" class="btn btn-primary">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
@endsection