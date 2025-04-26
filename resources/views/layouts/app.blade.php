<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MediStock') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary: #279B48;
            --warning: #FFBD07;
            --danger: #ED1E28;
            --success: #0AC275;
            --black: #333333;
            --white: #FFFFFF;
            --light-gray: #F5F5F5;
            --dark-grey: #808080;
            --border-radius: 16px;
        }
        
        /* Body */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-gray);
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
        }

        /* Typography */
        .font-small { font-size: 13px; }
        .font-medium { font-size: 16px; }
        .font-large { font-size: 20px; }
        
        h1, .h1 { font-size: 25px; font-weight: 700; }
        h2, .h2 { font-size: 20px; font-weight: 600; }
        h3, .h3 { font-size: 16px; font-weight: 500; }
        p, .font-small { font-size: 13px; font-weight: 400; }

        /* Layout Structure */
        .app-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .content-container {
            display: flex;
            flex: 1;
            height: calc(100vh - 50px);
            overflow: hidden;
        }

        /* Header */
        .app-header {
            background-color: var(--primary);
            height: 50px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 20px;
            flex-shrink: 0;
        }
        
        .search-input::placeholder {
            color: white;
            opacity: 0.7;
        }
        
        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(39, 155, 72, 0.5);
            outline-color: var(--primary);
        }
        
        /* Sidebar Menu */
        .sidebar-container {
            height: 100%;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        
        .menu-box {
            background-color: var(--white);
            border-radius: var(--border-radius);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            width: 260px;
            height: 100%;
            overflow: hidden;
        }

        .menu-box-content {
            padding: 20px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .menu-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-weight: 600;
            font-size: 16px;
            color: var(--black);
        }

        .menu-toggle {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .sidebar-menu {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .menu-item {
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 15px;
            color: var(--black);
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 8px;
            color: var(--black);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        .menu-link:hover {
            background-color: rgba(39, 155, 72, 0.05);
            color: var(--primary);
        }

        .menu-link.active {
            background-color: var(--primary);
            color: var(--white);
        }

        .menu-icon {
            margin-right: 12px;
            width: 18px;
            height: 18px;
            transition: filter 0.3s ease;
        }
        
        /* Membuat icon menjadi hitam saat tidak aktif */
        .menu-link .menu-icon {
            filter: brightness(0);
        }
        
        /* Membuat icon menjadi putih saat menu aktif */
        .menu-link.active .menu-icon {
            filter: brightness(100);
        }

        .menu-box-footer {
            padding: 20px;
            margin-top: auto;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            background: none;
            border: none;
            color: var(--black);
            padding: 12px 15px;
            margin: 0 0 15px 0;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 500;
            width: 100%;
            text-align: left;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background-color: rgba(39, 155, 72, 0.05);
            color: var(--primary);
        }

        .logout-icon {
            width: 18px;
            height: 18px;
            margin-right: 12px;
        }

        .menu-divider {
            border-top: 1px solid var(--dark-grey);
            margin: 15px 0;
        }

        /* User Profile */
        .user-profile {
            display: flex;
            align-items: center;
            padding: 0 15px;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background-color: var(--dark-grey);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: 500;
            color: var(--white);
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 500;
            font-size: 15px;
            color: var(--black);
        }

        .user-role {
            font-size: 13px;
            color: var(--dark-grey);
        }
        
        /* Main Content Area */
        .main-content {
            flex: 1;
            padding: 1rem;
            overflow: auto;
            height: 100%;
        }
        
        /* Card Styling */
        .card {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .full-height-card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        /* Table Styling */
        .table-row-hover {
            transition: all 0.3s ease;
        }
        
        .table-row-hover:hover {
            background-color: rgba(0, 0, 0, 0.03);
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            cursor: pointer;
        }
        
        /* Scroll Styling */
        .scroll-container {
            overflow-y: auto;
            border-radius: 0 0 16px 16px;
            flex: 1;
        }
        
        .table-responsive::-webkit-scrollbar,
        .scroll-container::-webkit-scrollbar,
        .main-content::-webkit-scrollbar,
        .menu-box-content::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        
        .table-responsive::-webkit-scrollbar-track,
        .scroll-container::-webkit-scrollbar-track,
        .main-content::-webkit-scrollbar-track,
        .menu-box-content::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .table-responsive::-webkit-scrollbar-thumb,
        .scroll-container::-webkit-scrollbar-thumb,
        .main-content::-webkit-scrollbar-thumb,
        .menu-box-content::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        
        .table-responsive::-webkit-scrollbar-thumb:hover,
        .scroll-container::-webkit-scrollbar-thumb:hover,
        .main-content::-webkit-scrollbar-thumb:hover,
        .menu-box-content::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.2);
        }
        
        /* Table Header */
        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 2;
            background-color: var(--primary);
        }
        
        .sticky-header tr {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .borderless-table td,
        .borderless-table th {
            border: none;
        }
        
        .borderless-table td {
            vertical-align: middle;
        }
        
        .fixed-table {
            table-layout: fixed;
            width: 100%;
        }
        
        /* Notification */
        .status-notification {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin: 1rem;
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Header -->
        <header class="app-header">
            <div style="position: relative; width: 80%; max-width: 600px;">
                <input type="text" placeholder="Looking for something?" class="search-input" style="width: 100%; padding: 8px 15px 8px 45px; border-radius: 50px; border: none; outline: none; background-color: rgba(255, 255, 255, 0.2); color: white;">
                <img src="{{ asset('assets/images/search.png') }}" alt="Search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; opacity: 0.7;">
            </div>
            <div style="margin-left: 15px;">
                <button style="background-color: rgba(255, 255, 255, 0.2); border: none; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                    <img src="{{ asset('assets/images/bell.png') }}" alt="Notifications" style="width: 20px; height: 20px;">
                </button>
            </div>
        </header>

        <!-- Status Notification -->
        @if(session('status'))
            <div class="status-notification">
                {{ session('status') }}
            </div>
        @endif
        
        <div class="content-container">
            <!-- Sidebar Menu -->
            <div class="sidebar-container">
                <div class="menu-box">
                    <div class="menu-box-content">
                        <div class="menu-header" style="font-size: 20px; font-weight: medium;">
                            <span>Menu</span>
                            <button class="menu-toggle">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </button>
                        </div>
                        
                        <ul class="sidebar-menu">
                            <li class="menu-item">
                                <a href="{{ route('dashboard') }}" class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                    <img src="{{ asset('assets/images/dashboard.png') }}" alt="Dashboard" class="menu-icon">
                                    Dashboard
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <img src="{{ asset('assets/images/inventories.png') }}" alt="Inventaris" class="menu-icon">
                                    Inventaris
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('manajemen.kasir') }}" class="menu-link {{ request()->routeIs('manajemen.kasir') ? 'active' : '' }}">
                                    <img src="{{ asset('assets/images/cashier.png') }}" alt="Manajemen Kasir" class="menu-icon">
                                    Manajemen Kasir
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <img src="{{ asset('assets/images/report.png') }}" alt="Laporan" class="menu-icon">
                                    Laporan
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="menu-box-footer">
                        <!-- Logout button -->
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <img src="{{ asset('assets/images/logout.png') }}" alt="Logout" class="logout-icon">
                                Log Out
                            </button>
                        </form>

                        <div class="menu-divider"></div>
                        
                        <!-- User profile -->
                        <div class="user-profile">
                            <div class="user-avatar">
                                <span>A</span>
                            </div>
                            <div class="user-info">
                                <div class="user-name">{{ $name ?? 'Nama Admin' }}</div>
                                <div class="user-role">({{ $role ?? 'Admin' }})</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="main-content">
                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS and other scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>