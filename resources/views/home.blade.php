@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="bg-primary-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-4xl font-extrabold text-white sm:text-5xl sm:tracking-tight lg:text-6xl animate-fade-in">
                    Welcome to Our Shop
                </h1>
                <p class="mt-6 text-xl text-primary-100 animate-slide-in">
                    Discover the best products at affordable prices. We offer a wide range of high-quality items for all
                    your needs.
                </p>
                <div class="mt-10 flex justify-center gap-4 animate-bounce-in">
                    <a href="{{ route('products.index') }}" class="btn btn-accent py-3 px-8 text-base rounded-lg">
                        Shop Now
                    </a>
                    <a href="#"
                        class="btn btn-outline bg-transparent border-white text-white hover:bg-white hover:text-primary-700 py-3 px-8 text-base rounded-lg">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Shop by Category
            </h2>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                Browse our wide selection of products
            </p>
        </div>

        <div class="mt-12 grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-3 xl:gap-x-8">
            @foreach ($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="group">
                    <div class="w-full aspect-w-1 aspect-h-1 rounded-lg overflow-hidden sm:aspect-w-2 sm:aspect-h-1">
                        <div
                            class="bg-gradient-to-br from-primary-500 to-secondary-600 h-full w-full flex items-center justify-center">
                            <h3 class="text-2xl font-bold text-white text-center px-4">
                                {{ $category->name }}
                            </h3>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-500">
                            {{ $category->products_count ?? 0 }} products
                        </p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('products.index') }}" class="btn btn-outline">
                View All Categories
            </a>
        </div>
    </div>

    <!-- Featured Products Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Featured Products
                </h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                    Our handpicked selection of the best products
                </p>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                @foreach ($featuredProducts as $product)
                    <div class="product-card">
                        <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg">
                            <img src="{{ $product->image ?? 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}"
                                class="h-64 w-full object-cover">
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</p>
                            <div class="mt-2 flex items-center">
                                @if ($product->sale_price && $product->sale_price < $product->price)
                                    <span
                                        class="text-lg font-medium text-gray-900">${{ number_format($product->sale_price, 2) }}</span>
                                    <span
                                        class="ml-2 text-sm text-gray-500 line-through">${{ number_format($product->price, 2) }}</span>
                                    <span
                                        class="ml-2 text-xs font-medium text-white bg-accent-500 rounded-full px-2 py-0.5">
                                        {{ $product->discount_percentage }}% OFF
                                    </span>
                                @else
                                    <span
                                        class="text-lg font-medium text-gray-900">${{ number_format($product->price, 2) }}</span>
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

            <div class="mt-12 text-center">
                <a href="{{ route('products.index') }}" class="btn btn-outline">
                    View All Products
                </a>
            </div>
        </div>
    </div>

    <!-- New Arrivals Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                New Arrivals
            </h2>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                Check out our latest products
            </p>
        </div>

        <div class="mt-12 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            @foreach ($newArrivals as $product)
                <div class="product-card">
                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg">
                        <img src="{{ $product->image ?? 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}"
                            class="h-64 w-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            <a href="{{ route('products.show', $product->slug) }}">
                                {{ $product->name }}
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        <div class="mt-2 flex items-center">
                            @if ($product->sale_price && $product->sale_price < $product->price)
                                <span
                                    class="text-lg font-medium text-gray-900">${{ number_format($product->sale_price, 2) }}</span>
                                <span
                                    class="ml-2 text-sm text-gray-500 line-through">${{ number_format($product->price, 2) }}</span>
                                <span class="ml-2 text-xs font-medium text-white bg-accent-500 rounded-full px-2 py-0.5">
                                    {{ $product->discount_percentage }}% OFF
                                </span>
                            @else
                                <span
                                    class="text-lg font-medium text-gray-900">${{ number_format($product->price, 2) }}</span>
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

        <div class="mt-12 text-center">
            <a href="{{ route('products.index') }}" class="btn btn-outline">
                View All Products
            </a>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    What Our Customers Say
                </h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                    Don't just take our word for it
                </p>
            </div>

            <div class="mt-12 grid gap-8 md:grid-cols-3">
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center">
                            <span class="text-primary-700 text-xl font-bold">JD</span>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">John Doe</h3>
                            <div class="flex text-yellow-400">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">
                        "I've been shopping here for years and have never been disappointed. Great selection, fast shipping,
                        and excellent customer service."
                    </p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center">
                            <span class="text-primary-700 text-xl font-bold">JS</span>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Jane Smith</h3>
                            <div class="flex text-yellow-400">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">
                        "The quality of the products exceeded my expectations. Shipping was fast and everything arrived in
                        perfect condition. I'll definitely be shopping here again!"
                    </p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center">
                            <span class="text-primary-700 text-xl font-bold">RJ</span>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Robert Johnson</h3>
                            <div class="flex text-yellow-400">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">
                        "Customer service is top-notch. I had an issue with my order and they resolved it immediately. The
                        products are high quality and reasonably priced."
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Newsletter Section -->
    <div class="bg-primary-700 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-xl mx-auto text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    Sign up for our newsletter
                </h2>
                <p class="mt-4 text-lg text-primary-100">
                    Stay up to date with the latest products, promotions, and exclusive offers.
                </p>
                <form class="mt-8 sm:flex justify-center">
                    <label for="email-address" class="sr-only">Email address</label>
                    <input id="email-address" name="email" type="email" autocomplete="email" required
                        class="w-full px-5 py-3 placeholder-gray-500 focus:ring-primary-500 focus:border-primary-500 sm:max-w-xs border-transparent rounded-md"
                        placeholder="Enter your email">
                    <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3 sm:flex-shrink-0">
                        <button type="submit"
                            class="w-full flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-accent-500 hover:bg-accent-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500">
                            Subscribe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
