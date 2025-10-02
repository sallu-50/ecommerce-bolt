@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Sidebar with filters -->
            <div class="w-full md:w-64 flex-shrink-0">
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Categories</h3>
                    <div class="space-y-2">
                        <a href="{{ route('products.index') }}" class="block text-gray-700 hover:text-primary-600 {{ !request('category') ? 'font-medium text-primary-600' : '' }}">
                            All Products
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="block text-gray-700 hover:text-primary-600 {{ request('category') == $category->slug ? 'font-medium text-primary-600' : '' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Price Range</h3>
                    <div class="space-y-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            <span class="ml-2 text-gray-700">Under $50</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            <span class="ml-2 text-gray-700">$50 - $100</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            <span class="ml-2 text-gray-700">$100 - $200</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            <span class="ml-2 text-gray-700">Over $200</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Product grid -->
            <div class="flex-1">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">
                        @if(request('category'))
                            {{ $categories->where('slug', request('category'))->first()->name ?? 'Products' }}
                        @elseif(request('search'))
                            Search results for "{{ request('search') }}"
                        @else
                            All Products
                        @endif
                    </h1>
                    
                    <div class="flex items-center">
                        <label for="sort" class="text-sm text-gray-600 mr-2">Sort By:</label>
                        <select id="sort" name="sort" class="rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-primary-500 focus:outline-none focus:ring-primary-500 sm:text-sm"
                            onchange="window.location.href='{{ route('products.index') }}?{{ http_build_query(array_merge(request()->except('sort'), ['sort' => ''])) }}'+this.value">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                        </select>
                    </div>
                </div>
                
                @if($products->isEmpty())
                    <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-xl font-medium text-gray-900">No products found</h3>
                        <p class="mt-1 text-gray-500">Try adjusting your search or filter to find what you're looking for.</p>
                        <div class="mt-6">
                            <a href="{{ route('products.index') }}" class="btn btn-primary">View All Products</a>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach($products as $product)
                            <div class="product-card">
                                <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg">
                                    <img src="{{ $product->image ?? 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}" class="h-64 w-full object-cover">
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        <a href="{{ route('products.show', $product->slug) }}">
                                            {{ $product->name }}
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                    <div class="mt-2 flex items-center">
                                        @if($product->sale_price && $product->sale_price < $product->price)
                                            <span class="text-lg font-medium text-gray-900">${{ number_format($product->sale_price, 2) }}</span>
                                            <span class="ml-2 text-sm text-gray-500 line-through">${{ number_format($product->price, 2) }}</span>
                                            <span class="ml-2 text-xs font-medium text-white bg-accent-500 rounded-full px-2 py-0.5">
                                                {{ $product->discount_percentage }}% OFF
                                            </span>
                                        @else
                                            <span class="text-lg font-medium text-gray-900">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </div>
                                    <div class="mt-4">
                                        <button class="btn btn-primary w-full add-to-cart" data-product-id="{{ $product->id }}">
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection