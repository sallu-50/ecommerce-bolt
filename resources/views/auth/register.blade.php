@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md px-8 py-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-800">{{ __('Register') }}</h2>

        <form method="POST" action="{{ route('register') }}" class="mt-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                <input id="name" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:outline-none focus:ring" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                    <span class="text-sm text-red-600" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mt-4">
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:outline-none focus:ring" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                    <span class="text-sm text-red-600" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                <input id="password" type="password" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:outline-none focus:ring" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="text-sm text-red-600" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mt-4">
                <label for="password-confirm" class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:outline-none focus:ring" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:bg-blue-700">
                    {{ __('Register') }}
                </button>
            </div>

            <div class="mt-6 text-center">
                <a class="text-sm text-blue-600 hover:underline" href="{{ route('login') }}">
                    {{ __('Already have an account? Login') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
