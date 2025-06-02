<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Medistock - Your Pharmacy Outlet</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-white text-[#1b1b18] font-sans">

    <!-- Header -->
    <header class="w-full px-6 py-6 flex justify-between items-center max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold text-primary">Medistock</h1>
        @if (Route::has('login'))
        <nav class="flex gap-4 text-sm">
            @auth
            <a href="{{ url('/dashboard') }}" class="px-4 py-2 border border-primary text-primary hover:bg-primary hover:text-white transition rounded-sm">
                Dashboard
            </a>
            @else
            <a href="{{ route('login') }}"
                class="inline-block px-6 py-2.5 bg-white border border-primary text-primary font-semibold rounded-full shadow-sm hover:bg-primary hover:text-white transition-all duration-300 ease-in-out">
                Log in
            </a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="px-4 py-2 border border-gray-300 text-gray-800 hover:bg-gray-100 transition rounded-sm">
                Register
            </a>
            @endif
            @endauth
        </nav>
        @endif
    </header>

    <!-- Hero -->
    <section class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center h-[36rem]">
        <div>
            <h2 class="text-5xl font-extrabold text-gray-900 leading-tight mb-6">
                Empowering <span class="text-primary">Pharmacies</span><br>with Smart Inventory
            </h2>
            <p class="text-gray-600 mb-8 text-lg">
                Medistock is your all-in-one platform to manage stocks, monitor suppliers, and optimize orders.
            </p>
            <a href="{{ route('login') }}" class="inline-block border-2 border-transparent bg-primary hover:bg-white hover:border-primary hover:text-primary font-medium text-white px-6 py-3 rounded-full transition shadow-md">
                Get Started
            </a>
        </div>
        <div class="hidden md:flex items-end">
            <img src="{{ asset('assets/images/pharmacy.jpg') }}" alt="Medistock Illustration" class="w-full h-auto">
        </div>
    </section>

    <!-- Features -->
    <section class="bg-gray-50 py-20 px-6">
        <div class="max-w-7xl mx-auto text-center mb-16">
            <h3 class="text-3xl font-bold mb-4">Why Medistock?</h3>
            <p class="text-gray-600 max-w-xl mx-auto">
                Tools tailored to help your pharmacy stay efficient, compliant, and ahead of the curve.
            </p>
        </div>
        <div class="grid md:grid-cols-3 gap-12 max-w-6xl mx-auto text-center">
            <div>
                <div class="w-16 h-16 mx-auto bg-primary/10 text-primary rounded-full flex items-center justify-center mb-4 text-2xl">📦</div>
                <h4 class="font-semibold text-lg mb-2">Stock Monitoring</h4>
                <p class="text-gray-600">Keep track of medicine availability in real-time and avoid stockouts.</p>
            </div>
            <div>
                <div class="w-16 h-16 mx-auto bg-primary/10 text-primary rounded-full flex items-center justify-center mb-4 text-2xl">📊</div>
                <h4 class="font-semibold text-lg mb-2">Sales & Reports</h4>
                <p class="text-gray-600">Visualize sales trends and generate insightful reports with ease.</p>
            </div>
            <div>
                <div class="w-16 h-16 mx-auto bg-primary/10 text-primary rounded-full flex items-center justify-center mb-4 text-2xl">🤝</div>
                <h4 class="font-semibold text-lg mb-2">Supplier Management</h4>
                <p class="text-gray-600">Connect, evaluate, and communicate effectively with your suppliers.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary text-sm text-center py-6">
        &copy; {{ now()->year }} Medistock. All rights reserved.
    </footer>

</body>

</html>