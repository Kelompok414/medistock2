<?php
use Illuminate\Support\Facades\Auth;
use App\Models\Setting as Tampilan;


$currentLanguage = 'id'; 
if (Auth::check()) {
    $user = Auth::user();
    
    $userSetting = Tampilan::firstOrCreate(
        ['user_id' => $user->id],
        [
            'language' => 'id', 
            'text_size' => 'default',
            'font_family' => 'Default',
            'dark_mode' => false,
        ]
    );

    $currentLanguage = $userSetting->language;
}
?>
<!DOCTYPE html>
<html lang="{{ $currentLanguage }}" class="{{ (Auth::check() && $userSetting->dark_mode) ? 'dark-mode' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MediStock') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/feather-icons/dist/feather.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <style>
        :root {
            /* Light Mode (Default) Variables */
            --primary: #279B48;
            --warning: #FFBD07;
            --danger: #ED1E28;
            --success: #0AC275;
            --black: #333333;
            --white: #FFFFFF;
            --light-gray: #F5F5F5;
            --dark-grey: #808080;
            --border-radius: 16px;
            --header-height: 60px;

            /* Default variables for light mode, overridden in dark-mode block */
            --body-bg: var(--light-gray);
            --body-text: var(--black);
            --container-bg: var(--white);
            --sidebar-bg: var(--white);
            --main-bg: var(--light-gray);
            --card-bg: var(--white);
            --input-bg: var(--white);
            --input-border: #ced4da; /* Bootstrap default border */
            --button-text-default: var(--white); /* Default button text color (PUTIH) */
            --menu-hover-bg: rgba(39, 155, 72, 0.05); /* Light hover for menu items */
            --menu-active-bg: var(--primary); /* Primary color for active menu background */
            --menu-active-text: var(--white); /* White for active menu text */
            --link-color: var(--primary); /* Primary color for links */
            --profile-small-text: var(--dark-grey);
            --shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Standard light mode shadow */

            /* Notification Colors - Light Mode */
            --success-bg: #d4edda;
            --success-text: #155724;
            --success-border: #c3e6cb;
            --error-bg: #f8d7da;
            --error-text: #721c24;
            --error-border: #f5c6cb;

            /* Specific Button and Header Colors for Settings/Profile Page - Light Mode */
            --save-button-bg: var(--primary);
            --save-button-hover-bg: #228a3f;
            --profile-header-bg: linear-gradient(to right, var(--primary), var(--success));
            --profile-header-text: var(--white);
            --profile-card-bg: var(--card-bg);
            --profile-label-color: var(--black);
            --profile-input-border: var(--input-border);
            --profile-input-bg: var(--input-bg);
            --profile-button-bg: var(--save-button-bg);
            --profile-button-text: var(--button-text-default);
            --profile-button-hover-bg: var(--save-button-hover-bg);
            --profile-button-cancel-bg: var(--dark-grey);
            --profile-button-cancel-hover-bg: #6b6b6b;
            --profile-button-cancel-text: var(--white);
            --profile-card-shadow: var(--shadow);
            --profile-edit-button-bg: #0d6efd;
            --profile-edit-button-hover-bg: #0b5ed7;
            --profile-edit-button-text: var(--white);
            --profile-field-border: var(--light-gray);
            --profile-icon-color: var(--black);
            --svg-filter: none; /* No filter for light mode icons */
        }

        /* Body */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--body-bg); /* Menggunakan variabel */
            min-height: 100vh;
            margin: 0;
            padding: 0;
            color: var(--body-text); /* Menggunakan variabel */
            transition: background-color 0.3s, color 0.3s; /* Transisi untuk dark mode */
        }

        /* Typography */
        .welcome-message {
            color: var(--primary);
            font-size: 20px;
            font-weight: 500;
        }

        .section-title {
            font-size: 20px;
            font-weight: 500;
        }

        /* Layout */
        html,
        body,
        .app-container {
            height: 100%;
        }

        .app-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content-container {
            display: flex;
            flex: 1;
            position: relative;
            height: calc(100vh - var(--header-height));
        }

        /* Header */
        .app-header {
            background-color: var(--primary);
            height: var(--header-height);
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 20px;
            z-index: 1000;
            position: sticky;
            top: 0;
            transition: background-color 0.3s; /* Transisi untuk dark mode */
        }

        .search-input {
            width: 100%;
            padding: 8px 15px 8px 45px;
            border-radius: 50px;
            border: none;
            outline: none;
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            transition: background-color 0.3s, color 0.3s; /* Transisi untuk dark mode */
        }

        .search-input::placeholder {
            color: white;
            opacity: 0.7;
        }

        /* Sidebar Menu */
        .sidebar-container {
            width: 280px;
            height: 100%;
            padding: 1rem;
            position: sticky;
            top: var(--header-height);
            align-self: flex-start;
        }

        .menu-box {
            background-color: var(--sidebar-bg); /* Menggunakan sidebar-bg */
            border-radius: var(--border-radius);
            box-shadow: var(--shadow); /* Menggunakan shadow */
            display: flex;
            flex-direction: column;
            height: calc(100vh - var(--header-height) - 2rem);
            transition: background-color 0.3s, box-shadow 0.3s; /* Transisi untuk dark mode */
        }

        .menu-box-content {
            padding: 20px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .app-logo {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding: 10px 0;
        }

        .logo-image {
            width: 40px;
            height: 40px;
            object-fit: contain;
            margin-right: 10px;
        }

        .logo-text {
            font-size: 20px;
            font-weight: 600;
            color: var(--primary);
        }

        .menu-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 20px;
            font-weight: 500;
            color: var(--body-text); /* Menggunakan body-text untuk header menu */
        }

        .sidebar-menu {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .menu-item {
            margin-bottom: 15px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 8px;
            color: var(--body-text); /* Menggunakan body-text untuk default menu link color */
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 15px;
            font-weight: 500;
        }

        .menu-link:hover {
            background-color: var(--menu-hover-bg); /* Menggunakan variabel */
            color: var(--primary);
        }

        .menu-link.active {
            background-color: var(--menu-active-bg);
            color: var(--menu-active-text);
        }

        .menu-icon {
            margin-right: 12px;
            width: 18px;
            height: 18px;
            filter: var(--svg-filter); 
        }

        .menu-link:hover .menu-icon {
            filter: brightness(0) invert(41%) sepia(86%) saturate(459%) hue-rotate(93deg) brightness(94%) contrast(89%); /* Warna hijau primary */
        }
        
        body.dark-mode .menu-link:hover .menu-icon {
            filter: var(--svg-filter);
        }

        .menu-link.active .menu-icon {
            color: #fff !important;
            stroke: #fff !important;
            filter: none !important; 
        }

        .menu-box-footer {
            padding: 20px;
            border-top: 1px solid var(--light-gray);
            transition: border-color 0.3s; 
        }

        .logout-btn {
            display: flex;
            align-items: center;
            background: none;
            border: none;
            color: var(--body-text); 
            padding: 12px 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 500;
            width: 100%;
            text-align: left;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background-color: var(--menu-hover-bg); 
            color: var(--primary);
        }

        .logout-icon {
            width: 18px;
            height: 18px;
            margin-right: 12px;
            filter: var(--svg-filter); 
        }
        body.dark-mode .logout-btn:hover .logout-icon {
            filter: brightness(0) invert(41%) sepia(86%) saturate(459%) hue-rotate(93deg) brightness(94%) contrast(89%); /* Warna hijau primary */
        }

        .menu-divider {
            border-top: 1px solid var(--dark-grey);
            margin: 15px 0;
            transition: border-color 0.3s; /* Transisi untuk dark mode */
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
            color: var(--body-text); 
        }

        .user-role {
            font-size: 13px;
            color: var(--dark-grey); 
        }


        .main-content {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
            height: 100%;
            background-color: var(--main-bg); 
            transition: background-color 0.3s; 
        }


        .card {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--shadow); 
            height: 100%;
            background-color: var(--card-bg); 
            transition: background-color 0.3s, box-shadow 0.3s; 
        }

        .text-total-obat {
            color: var(--success);
        }

        .text-akan-kadaluarsa {
            color: var(--warning);
        }

        .text-kadaluarsa {
            color: var(--danger);
        }

        .text-stok-menipis {
            color: var(--black);
        }

        .table {
            border-collapse: separate;
            border-spacing: 0 0px;
        }

        .table tbody tr td {
            border: none;
            color: var(--body-text); 
        }

        .table-header {
            background-color: var(--primary);
            color: var(--white);
        }

        .table-header th {
            padding: 12px;
            font-weight: 500;
            font-size: 16px;
        }

        .table-header th:first-child {
            border-radius: 16px 0 0 0;
        }

        .table-header th:last-child {
            border-radius: 0 16px 0 0;
        }

        .page-item:first-child .page-link {
            border-top-left-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
        }

        .page-item:last-child .page-link {
            border-top-right-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
        }

        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .page-item.disabled .page-link {
            color: var(--dark-grey);
            pointer-events: none;
            background-color: var(--white);
            border-color: var(--light-gray);
        }

        .page-link {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: var(--primary);
            background-color: var(--white);
            border: 1px solid var(--light-gray);
            text-decoration: none;
            transition: background-color 0.3s, border-color 0.3s, color 0.3s; /* Transisi untuk dark mode */
        }

        .page-link:hover {
            z-index: 2;
            color: var(--primary);
            text-decoration: none;
            background-color: var(--white);
            border-color: var(--light-gray);
        }

        .page-link:focus {
            z-index: 3;
            outline: 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Notification Styling */
        .icon-danger {
            filter: brightness(0) saturate(100%) invert(23%) sepia(83%) saturate(7470%) hue-rotate(356deg) brightness(91%) contrast(121%);
        }

        .icon-warning {
            filter: brightness(0) saturate(100%) invert(72%) sepia(78%) saturate(936%) hue-rotate(359deg) brightness(101%) contrast(106%);
        }

        .icon-black {
            filter: brightness(0) saturate(100%);
        }

        .bg-danger-light {
            background-color: rgba(237, 30, 40, 0.1);
        }

        .bg-warning-light {
            background-color: rgba(255, 189, 7, 0.1);
        }

        .bg-light-gray {
            background-color: var(--light-gray);
        }

        .notification-list {
            margin-bottom: 0;
        }

        .notification-item {
            padding: 10px;
            border-radius: 8px;
            transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
        }

        .table tbody tr,
        .notification-item {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover,
        .notification-item:hover {
            background-color: rgba(0, 0, 0, 0.03);
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            cursor: pointer;
        }

        .notification-icon {
            height: 2rem;
            width: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notification-message {
            font-size: 16px;
            margin-bottom: 5px;
            color: var(--body-text); 
        }

        .notification-description {
            font-size: 14px;
            margin-bottom: 5px;
            color: var(--dark-grey);
        }

        .badge-tanggal {
            background-color: var(--dark-grey);
            font-size: 14px;
            color: var(--white);
            padding: 4px 10px;
            border-radius: 16px;
            display: inline-block;
            min-width: 120px;
            text-align: center;
        }

        .view-all-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 16px;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .view-all-link:hover {
            text-decoration: underline;
        }

        /* Status Notification */
        .status-notification {
            background-color: #d4edda;
            color: var(--primary);
            padding: 10px;
            border-radius: 5px;
            margin: 1rem;
            transition: background-color 0.3s, color 0.3s;
        }

        .status-container {
            width: 100%;
        }

        .btn-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f5f5f5;
            border: none;
            transition: background 0.2s;
        }

        .btn-light-warning {
            color: #ffc107;
        }

        .btn-light-warning:hover,
        .btn-light-warning:focus {
            background: #fff8e1;
            color: #ff9800;
        }

        .btn-light-danger {
            color: #dc3545;
        }

        .btn-light-danger:hover,
        .btn-light-danger:focus {
            background: #ffeaea;
            color: #b71c1c;
        }

        .btn-icon i {
            width: 18px;
            height: 18px;
        }


        /* Dark Mode */
        html.dark-mode { 
            --white: #e0e0e0; 
            --bg: #282c34; 
            --text: #c5c5c5; 
            --light-gray: #4a4f59;
            --dark-grey: #a0a8b3; 
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.4); 

            --body-bg: var(--bg);
            --body-text: var(--text);
            --container-bg: #323842; 
            --sidebar-bg: var(--container-bg); 
            --main-bg: var(--bg); 
            --card-bg: var(--container-bg); 
            --input-bg: #3e4451; 
            --input-border: #626a7a; 
            --button-text-default: var(--white); 
            --menu-hover-bg: #3e4451; 
            --menu-active-bg: #36a361; 
            --menu-active-text: var(--white); 
            --link-color: #8ab4f8; 
            --profile-small-text: #a0a8b3; 

            
            --success-bg: #2d6b41; 
            --success-text: var(--white); 
            --success-border: #4d9c6c; 
            --error-bg: #a63d40; 
            --error-text: var(--white); 
            --error-border: #e06c75; 
            --save-button-bg: #5a7d5a;
            --save-button-hover-bg: #4a6c4a;

            --profile-header-bg: linear-gradient(to right, #36a361, #4a6c4a); 
            --profile-header-text: var(--white);
            --profile-card-bg: var(--card-bg); 
            --profile-label-color: var(--text);
            --profile-input-border: var(--input-border);
            --profile-input-bg: var(--input-bg);
            --profile-button-bg: var(--save-button-bg); 
            --profile-button-text: var(--button-text-default);
            --profile-button-hover-bg: var(--save-button-hover-bg);
            --profile-button-cancel-bg: #5f6671;
            --profile-button-cancel-hover-bg: #4a515d;
            --profile-button-cancel-text: var(--white); 
            --profile-card-shadow: var(--shadow);
            --profile-edit-button-bg: #4c678a;
            --profile-edit-button-hover-bg: #3d5570;
            --profile-edit-button-text: var(--white);
            --profile-field-border: var(--light-gray);
            --profile-icon-color: var(--white); 
            --svg-filter: invert(1) hue-rotate(180deg) brightness(1.5); 

            .menu-link {
                color: var(--white); /
            }
            .menu-link:hover {
                color: var(--primary); 
            }
            .logout-btn {
                color: var(--white); 
            }
            .logout-btn:hover {
                color: var(--primary); 
            }
            .menu-header {
                color: var(--white);
            }
            .user-name {
                color: var(--white); 
            }
            .user-role {
                color: var(--profile-small-text); /* Warna teks peran user di sidebar, sedikit lebih gelap dari putih */
            }
            .menu-box-footer {
                border-top: 1px solid var(--light-gray); /* Sesuaikan border footer sidebar */
            }
            .menu-divider {
                border-top: 1px solid var(--light-gray); /* Sesuaikan divider di sidebar */
            }
            .table tbody tr td {
                color: var(--body-text); /* Pastikan teks di tabel menggunakan warna teks dark mode */
            }
            .notification-message {
                color: var(--body-text); /* Pastikan teks notifikasi menggunakan warna teks dark mode */
            }
            .badge-tanggal {
                background-color: var(--container-bg); /* Sesuaikan badge tanggal dengan warna card */
                color: var(--body-text); /* Sesuaikan warna teks badge tanggal */
            }
            .search-input {
                background-color: rgba(255, 255, 255, 0.1); /* Sedikit lebih transparan di dark mode */
                color: var(--white);
            }
            .search-input::placeholder {
                color: var(--light-gray);
            }
            .app-header {
                background-color: #1e7a3a; /* Darker primary for header in dark mode */
            }
            .page-item.disabled .page-link {
                color: var(--light-gray);
                background-color: var(--container-bg);
                border-color: var(--light-gray);
            }
            .page-link {
                color: var(--link-color);
                background-color: var(--container-bg);
                border: 1px solid var(--light-gray);
            }
            .page-link:hover {
                background-color: var(--input-bg);
                border-color: var(--input-border);
            }
            .page-item.active .page-link {
                background-color: var(--primary);
                border-color: var(--primary);
            }
            .status-notification {
                background-color: var(--success-bg);
                color: var(--success-text);
            }
            .bg-danger-light {
                background-color: rgba(166, 61, 64, 0.3); 
            }
            .bg-warning-light {
                background-color: rgba(255, 189, 7, 0.2); 
            }
            .bg-light-gray { 
                background-color: var(--container-bg); 
            }
            .btn-icon {
                background: var(--input-bg);
            }
            .btn-light-warning {
                color: var(--warning);
            }
            .btn-light-warning:hover,
            .btn-light-warning:focus {
                background: var(--input-bg);
                color: var(--warning);
            }
            .btn-light-danger {
                color: var(--danger);
            }
            .btn-light-danger:hover,
            .btn-light-danger:focus {
                background: var(--input-bg);
                color: var(--danger);
            }
            
            .menu-icon {
                filter: var(--svg-filter);
            }
        }

        @media (max-width: 768px) {
            .profile-card .row {
                flex-direction: column;
                align-items: flex-start;
            }

            .profile-card label {
                margin-bottom: 5px;
            }

            .profile-card input[type="text"],
            .profile-card input[type="email"],
            .profile-card input[type="password"],
            .profile-card input[type="date"],
            .profile-card select {
                width: calc(100% - 10px); 
                margin-right: 0;
                margin-bottom: 10px;
            }

            .profile-card button {
                width: 100%;
                margin-right: 0;
            }

            .profile-card input[type="password"] + button {
                margin-right: 0;
                margin-bottom: 10px; 
            }

            .setting-card .row {
                flex-direction: column;
                align-items: flex-start;
            }

            .setting-card label {
                margin-bottom: 5px;
            }

            .setting-card select {
                width: 100%;
            }

            .setting-card button.save {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    @php
    @endphp
    <div class="app-container">
        <header class="app-header">
            <div style="position: relative; width: 80%; max-width: 600px;">
                <input type="text" placeholder="Looking for something?" class="search-input">
                <img src="{{ asset('assets/images/search.png') }}" alt="Search"
                    style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; opacity: 0.7;">
            </div>
            <div style="margin-left: 15px;">
                <button
                    style="background-color: rgba(255, 255, 255, 0.2); border: none; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                    <img src="{{ asset('assets/images/bell.png') }}" alt="Notifications"
                        style="width: 20px; height: 20px;">
                </button>
            </div>
        </header>

        @if(session('status'))
        <div class="status-container">
            <div class="status-notification">
                {{ session('status') }}
            </div>
        </div>
        @endif

        <div class="content-container">
            <div class="sidebar-container">
                <div class="menu-box">
                    <div class="menu-box-content">
                        <div class="app-logo">
                            <img src="{{ asset('assets/images/MediStock_Icon.png') }}" alt="MediStock Logo"
                                class="logo-image">
                            <span class="logo-text">MediStock</span>
                        </div>

                        <div class="menu-header">
                            <span>Menu</span>
                            <button class="btn p-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </button>
                        </div>

                        <ul class="sidebar-menu">
                            @if(Auth::check() && Auth::user()->hasRole('admin')) 
                            <li class="menu-item">
                                <a href="{{ route('dashboard') }}"
                                    class="menu-link {{ Request::routeIs('dashboard') || Request::is('*expiring-medications*') ? 'active' : '' }}">
                                    <i data-feather="home" class="menu-icon"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('inventory.index') }}"
                                    class="menu-link {{ Request::routeIs('inventory.index') ? 'active' : '' }}">
                                    <i data-feather="package" class="menu-icon"></i>
                                    Inventaris
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('manajemen.kasir') }}"
                                    class="menu-link {{ Request::routeIs('manajemen.kasir') ? 'active' : '' }}">
                                    <i data-feather="users" class="menu-icon"></i>
                                    Manajemen Kasir
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('reports.monthly') }}"
                                    class="menu-link {{ Request::routeIs('reports.monthly') ? 'active' : '' }}">
                                    <i data-feather="file" class="menu-icon"></i>
                                    Laporan
                                </a>
                            </li>
                            @elseif(Auth::check() && Auth::user()->hasRole('kasir')) 
                            <li class="menu-item">
                                <a href="{{ route('kasir.dashboard') }}"
                                    class="menu-link {{ Request::routeIs('kasir.dashboard') ? 'active' : '' }}">
                                    <i data-feather="home" class="menu-icon"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('transactions.index') }}"
                                    class="menu-link {{ Request::routeIs('transactions.index') || Request::is('*expiring-medications*') ? 'active' : '' }}">
                                    <i data-feather="shopping-cart" class="menu-icon"></i>
                                    Penjualan
                                </a>
                            </li>
                            @endif

                            <li class="menu-item">
                                <a href="{{ route('user-setting.display') }}"
                                    class="menu-link {{ Request::routeIs('user-setting.display') ? 'active' : '' }}">
                                    <i data-feather="monitor" class="menu-icon"></i> 
                                    Tampilan
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="{{ route('user-setting.index') }}"
                                    class="menu-link {{ Request::routeIs('user-setting.index') ? 'active' : '' }}">
                                    <i data-feather="user" class="menu-icon"></i>
                                    Profil Saya
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="menu-box-footer">
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <img src="{{ asset('assets/images/logout.png') }}" alt="Logout" class="logout-icon">
                                Log Out
                            </button>
                        </form>

                        <div class="menu-divider"></div>

                        @if ($user)
                        <a href="{{ route('user-setting.index') }}" class="menu-link">
                            <div class="user-profile">
                                <div class="user-avatar">
                                    <span>{{ substr($user->name ?? 'U', 0, 1) }}</span>
                                </div>
                                <div class="user-info">
                                    <div class="user-name">{{ $user->name ?? 'Nama User' }}</div>
                                    <div class="user-role">({{ $user->getRoleNames()->first() ?? 'User' }})</div>
                                </div>
                            </div>
                        </a>
                        @endif

                    </div>
                </div>
            </div>

            <div class="main-content">
                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </div>
    </div>

    
    {{-- mengaktifkan/menonaktifkan dark mode --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const darkModeSelect = document.getElementById('dark_mode');
            const textSizeSelect = document.getElementById('text_size');
            const fontFamilySelect = document.getElementById('font_family');
            const body = document.body;

            const fontSizeMap = {
                'small': '12px',
                'default': '14px',
                'medium': '16px',
                'large': '18px',
                'extra_large': '20px'
            };

            function applyDisplaySettings() {
                
                if (darkModeSelect.value === '1') {
                    body.classList.add('dark-mode');
                } else {
                    body.classList.remove('dark-mode');
                }

            
                const selectedTextSize = textSizeSelect.value;
                body.style.fontSize = fontSizeMap[selectedTextSize] || '14px'; 

                const selectedFontOption = fontFamilySelect.options[fontFamilySelect.selectedIndex];
                const selectedFontName = selectedFontOption.value; 
                const googleFontName = selectedFontOption.dataset.googleFont; 

                if (googleFontName) {
                    
                    if (!document.head.querySelector(`link[href*="family=${encodeURIComponent(googleFontName)}"]`)) {
                        const link = document.createElement('link');
                        link.href = `https://fonts.googleapis.com/css2?family=${encodeURIComponent(googleFontName)}:wght@400;700&display=swap`;
                        link.rel = 'stylesheet';
                        document.head.appendChild(link);
                    }
                    body.style.fontFamily = `'${selectedFontName}', sans-serif`; 
                } else {
                    body.style.fontFamily = `'${selectedFontName}', sans-serif`; 
                }
            }

            
            applyDisplaySettings();

           
            darkModeSelect.addEventListener('change', applyDisplaySettings);
            textSizeSelect.addEventListener('change', applyDisplaySettings);
            fontFamilySelect.addEventListener('change', applyDisplaySettings);
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts') 

</body>

</html>