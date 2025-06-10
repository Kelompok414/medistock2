@extends('layouts.guest')

@section('content')
<!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<div class="min-h-screen grid grid-cols-1 md:grid-cols-3">
    <!-- Form Section -->
    <div class="w-full md:col-span-1 flex items-center justify-center bg-white shadow-lg z-10">
        <div class="max-w-md w-full">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <h1 class="text-4xl font-extrabold text-green-600 mb-10">MEDISTOCK</h1>
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700" />
                    <x-text-input id="email" class="mt-1 p-3 border border-gray-300 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-green-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700" />
                    <x-text-input id="password" class="mt-1 p-3 border border-gray-300 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-green-500"
                        type="password"
                        name="password"
                        required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <!-- @if (Route::has('password.request')) -->
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                    <!-- @endif -->

                    <!-- <x-primary-button class="ms-3">
                        {{ __('Log in') }}
                    </x-primary-button> -->

                    <button type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded-md transition duration-200">
                        Sign In
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Image Section -->
    <div class="hidden md:block md:col-span-2 relative h-full bg-green-600">
        <!-- <div class="flex items-center justify-center h-full">
                <img src="{{ asset('img/login.png') }}" alt="Health Illustration" class="">
            </div> -->
        <div class="absolute inset-0 bg-green-800 bg-opacity-30 flex items-center justify-center">
            <div class="text-white text-center px-8">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Together</h2>
                <p class="text-lg md:text-xl font-light">Let's Be Healthy</p>
            </div>
        </div>
    </div>
</div>
@endsection