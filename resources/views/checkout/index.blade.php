@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-6">Shipping Information</h2>
                    
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required class="input mt-1">
                                @error('first_name')
                                    <p class="text-danger-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required class="input mt-1">
                                @error('last_name')
                                    <p class="text-danger-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email') ?? auth()->user()->email ?? '' }}" required class="input mt-1">
                                @error('email')
                                    <p class="text-danger-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="input mt-1">
                                @error('phone')
                                    <p class="text-danger-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <div>
                                <label for="address_line_1" class="block text-sm font-medium text-gray-700">Address Line 1</label>
                                <input type="text" id="address_line_1" name="address_line_1" value="{{ old('address_line_1') }}" required class="input mt-1">
                                @error('address_line_1')
                                    <p class="text-danger-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="address_line_2" class="block text-sm font-medium text-gray-700">Address Line 2 (Optional)</label>
                                <input type="text" id="address_line_2" name="address_line_2" value="{{ old('address_line_2') }}" class="input mt-1">
                                @error('address_line_2')
                                    <p class="text-danger-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                    <input type="text" id="city" name="city" value="{{ old('city') }}" required class="input mt-1">
                                    @error('city')
                                        <p class="text-danger-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="state" class="block text-sm font-medium text-gray-700">State / Province</label>
                                    <input type="text" id="state" name="state" value="{{ old('state') }}" required class="input mt-1">
                                    @error('state')
                                        <p class="text-danger-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code / ZIP</label>
                                    <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" required class="input mt-1">
                                    @error('postal_code')
                                        <p class="text-danger-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                <select id="country" name="country" required class="input mt-1">
                                    <option value="United States">United States</option>
                                    <option value="Canada">Canada</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Germany">Germany</option>
                                    <option value="France">France</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Spain">Spain</option>
                                    <option value="Japan">Japan</option>
                                    <option value="China">China</option>
                                </select>
                                @error('country')
                                    <p class="text-danger-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-8 border-t border-gray-200 pt-8">
                            <h2 class="text-lg font-medium text-gray-900 mb-6">Shipping Method</h2>
                            
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input id="shipping_standard" name="shipping_method" type="radio" value="standard" checked class="h-4 w-4 text-primary-600 border-gray-300 focus:ring-primary-500">
                                    <label for="shipping_standard" class="ml-3">
                                        <span class="block text-sm font-medium text-gray-700">Standard Shipping</span>
                                        <span class="block text-sm text-gray-500">5-7 business days - $5.00</span>
                                    </label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input id="shipping_express" name="shipping_method" type="radio" value="express" class="h-4 w-4 text-primary-600 border-gray-300 focus:ring-primary-500">
                                    <label for="shipping_express" class="ml-3">
                                        <span class="block text-sm font-medium text-gray-700">Express Shipping</span>
                                        <span class="block text-sm text-gray-500">2-3 business days - $15.00</span>
                                    </label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input id="shipping_overnight" name="shipping_method" type="radio" value="overnight" class="h-4 w-4 text-primary-600 border-gray-300 focus:ring-primary-500">
                                    <label for="shipping_overnight" class="ml-3">
                                        <span class="block text-sm font-medium text-gray-700">Overnight Shipping</span>
                                        <span class="block text-sm text-gray-500">Next business day - $25.00</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 border-t border-gray-200 pt-8">
                            <h2 class="text-lg font-medium text-gray-900 mb-6">Payment Method</h2>
                            
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input id="payment_credit_card" name="payment_method" type="radio" value="credit_card" checked class="h-4 w-4 text-primary-600 border-gray-300 focus:ring-primary-500">
                                    <label for="payment_credit_card" class="ml-3">
                                        <span class="block text-sm font-medium text-gray-700">Credit Card</span>
                                    </label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input id="payment_paypal" name="payment_method" type="radio" value="paypal" class="h-4 w-4 text-primary-600 border-gray-300 focus:ring-primary-500">
                                    <label for="payment_paypal" class="ml-3">
                                        <span class="block text-sm font-medium text-gray-700">PayPal</span>
                                    </label>
                                </div>
                            </div>
                            
                            <div id="credit_card_fields" class="mt-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="card_number" class="block text-sm font-medium text-gray-700">Card Number</label>
                                        <input type="text" id="card_number" name="card_number" placeholder="XXXX XXXX XXXX XXXX" class="input mt-1">
                                    </div>
                                    
                                    <div>
                                        <label for="card_name" class="block text-sm font-medium text-gray-700">Name on Card</label>
                                        <input type="text" id="card_name" name="card_name" class="input mt-1">
                                    </div>
                                    
                                    <div>
                                        <label for="card_expiry" class="block text-sm font-medium text-gray-700">Expiration Date</label>
                                        <input type="text" id="card_expiry" name="card_expiry" placeholder="MM/YY" class="input mt-1">
                                    </div>
                                    
                                    <div>
                                        <label for="card_cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                                        <input type="text" id="card_cvv" name="card_cvv" placeholder="XXX" class="input mt-1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 border-t border-gray-200 pt-8">
                            <h2 class="text-lg font-medium text-gray-900 mb-6">Additional Information</h2>
                            
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700">Order Notes (Optional)</label>
                                <textarea id="notes" name="notes" rows="3" class="input mt-1">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                        
                        <div class="mt-8">
                            <button type="submit" class="btn btn-primary w-full py-3">
                                Place Order
                            </button>
                        </div>
                </div>
            </div>
            
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                    
                    <div class="mt-6 border-t border-gray-200 pt-4">
                        <h3 class="text-base font-medium text-gray-900 mb-3">Items ({{ $cartItems->sum('quantity') }})</h3>
                        
                        <ul class="divide-y divide-gray-200">
                            @foreach($cartItems as $item)
                                <li class="py-3 flex justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $item->product->name }}</p>
                                        <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900">${{ number_format($item->subtotal, 2) }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="flex justify-between">
                            <p class="text-sm text-gray-600">Subtotal</p>
                            <p class="text-sm font-medium text-gray-900">${{ number_format($total, 2) }}</p>
                        </div>
                        <div class="flex justify-between mt-2">
                            <p class="text-sm text-gray-600">Shipping</p>
                            <p class="text-sm font-medium text-gray-900">$5.00</p>
                        </div>
                        <div class="flex justify-between mt-2">
                            <p class="text-sm text-gray-600">Tax</p>
                            <p class="text-sm font-medium text-gray-900">${{ number_format($total * 0.1, 2) }}</p>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="flex justify-between">
                            <p class="text-base font-medium text-gray-900">Total</p>
                            <p class="text-base font-medium text-gray-900">${{ number_format($total + 5 + ($total * 0.1), 2) }}</p>
                        </div>
                    </div>
                    
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentCreditCard = document.getElementById('payment_credit_card');
            const paymentPaypal = document.getElementById('payment_paypal');
            const creditCardFields = document.getElementById('credit_card_fields');
            
            paymentCreditCard.addEventListener('change', function() {
                creditCardFields.style.display = 'block';
            });
            
            paymentPaypal.addEventListener('change', function() {
                creditCardFields.style.display = 'none';
            });
        });
    </script>
@endsection