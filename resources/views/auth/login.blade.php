@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md px-8 py-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-800">{{ __('Login') }}</h2>

        <form method="POST" action="{{ route('login') }}" class="mt-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:outline-none focus:ring" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="text-sm text-red-600" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                <input id="password" type="password" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:outline-none focus:ring" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="text-sm text-red-600" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mt-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="ml-2 block text-sm text-gray-900">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:bg-blue-700">
                    {{ __('Login') }}
                </button>
            </div>

            <div class="mt-6 text-center">
                <a class="text-sm text-blue-600 hover:underline" href="{{ route('register') }}">
                    {{ __("Don't have an account? Register") }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
