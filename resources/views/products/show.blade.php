@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600">
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('products.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 md:ml-2">Products</a>
                    </div>
                </li>
                @if($product->category)
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 md:ml-2">{{ $product->category->name }}</a>
                    </div>
                </li>
                @endif
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6">
                <!-- Product Images -->
                <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg">
                    <img src="{{ $product->image ?? 'https://via.placeholder.com/600' }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                </div>
                
                <!-- Product Info -->
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                    
                    @if($product->category)
                        <p class="mt-2 text-sm text-gray-500">Category: <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-primary-600 hover:text-primary-700">{{ $product->category->name }}</a></p>
                    @endif
                    
                    <div class="mt-4 flex items-center">
                        <div class="flex text-yellow-400">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                        <p class="ml-2 text-sm text-gray-500">4.9 (128 reviews)</p>
                    </div>
                    
                    <div class="mt-6">
                        <div class="flex items-center">
                            @if($product->sale_price && $product->sale_price < $product->price)
                                <span class="text-3xl font-bold text-gray-900">${{ number_format($product->sale_price, 2) }}</span>
                                <span class="ml-4 text-xl text-gray-500 line-through">${{ number_format($product->price, 2) }}</span>
                                <span class="ml-4 px-2.5 py-0.5 bg-accent-500 text-white text-sm font-semibold rounded-full">
                                    {{ $product->discount_percentage }}% OFF
                                </span>
                            @else
                                <span class="text-3xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                        
                        <p class="mt-2 text-sm text-gray-500">
                            @if($product->quantity > 0)
                                <span class="text-success-600 font-medium">In Stock</span> - {{ $product->quantity }} units available
                            @else
                                <span class="text-danger-600 font-medium">Out of Stock</span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="mt-8 border-t border-gray-200 pt-8">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <div class="mb-6">
                                <label for="qty-{{ $product->id }}" class="block text-sm font-medium text-gray-700">Quantity</label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="number" min="1" value="1" id="qty-{{ $product->id }}" name="qty" class="input w-24">
                                </div>
                            </div>
                            
                            <div class="flex space-x-4">
                                <button type="submit" class="btn btn-primary flex-1 py-3">
                                    Add to Cart
                                </button>
                                <button type="button" class="btn btn-outline flex items-center justify-center">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="mt-8">
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900">Description</h3>
                            <div class="mt-4 prose prose-sm text-gray-700">
                                {!! $product->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Products</h2>
                
                <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="product-card">
                            <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg">
                                <img src="{{ $relatedProduct->image ?? 'https://via.placeholder.com/300' }}" alt="{{ $relatedProduct->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-medium text-gray-900">
                                    <a href="{{ route('products.show', $relatedProduct->slug) }}">
                                        {{ $relatedProduct->name }}
                                    </a>
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">{{ $relatedProduct->category->name ?? 'Uncategorized' }}</p>
                                <div class="mt-2 flex items-center">
                                    @if($relatedProduct->sale_price && $relatedProduct->sale_price < $relatedProduct->price)
                                        <span class="text-lg font-medium text-gray-900">${{ number_format($relatedProduct->sale_price, 2) }}</span>
                                        <span class="ml-2 text-sm text-gray-500 line-through">${{ number_format($relatedProduct->price, 2) }}</span>
                                        <span class="ml-2 text-xs font-medium text-white bg-accent-500 rounded-full px-2 py-0.5">
                                            {{ $relatedProduct->discount_percentage }}% OFF
                                        </span>
                                    @else
                                        <span class="text-lg font-medium text-gray-900">${{ number_format($relatedProduct->price, 2) }}</span>
                                    @endif
                                </div>
                                <div class="mt-4">
                                    <button class="btn btn-primary w-full add-to-cart" data-product-id="{{ $relatedProduct->id }}">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection