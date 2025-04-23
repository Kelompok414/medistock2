<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'MediStock.com') }}</title>
    <!-- Tambahkan link Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tambahkan link CSS atau library lainnya -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <style>
        /* Terapkan font Poppins ke seluruh halaman */
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Definisi ukuran font */
        .font-small {
            font-size: 13px;
        }

        .font-medium {
            font-size: 16px;
        }

        .font-large {
            font-size: 20px;
        }

        .font-extra-large {
            font-size: 25px;
        }

        /* Contoh hierarki font */
        h1, .h1 {
            font-size: 25px;
            font-weight: 700;
        }

        h2, .h2 {
            font-size: 20px;
            font-weight: 600;
        }

        h3, .h3 {
            font-size: 16px;
            font-weight: 500;
        }

        p, .font-small {
            font-size: 13px;
            font-weight: 400;
        }

        .notif-tab {
        display: block;
        padding: 12px;
        text-decoration: none;
        text-align: center;
        font-weight: 400;
        transition: background-color 0.3s, border-radius 0.3s;
    }

    .notif-tab:hover {
        background-color: #3fb267;
    }

    .notif-th {
        padding: 0;
        border-bottom: 4px solid #ccc;
    }

    .notif-left {
        border-radius: 16px 0 0 16px;
    }

    .notif-right {
        border-radius: 0 16px 16px 0;
    }

    table {
        border-collapse: separate;
        border-spacing: 0;
    }

    thead tr {
        background-color: #279B48;
        color: white;
    }

    a.active {
        background-color: rgb(159, 198, 170);
        color: black;
    }
    
    </style>
</head>
<body>
    @if(session('status'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin: 20px;">
            {{ session('status') }}
        </div>
    @endif
    @yield('content')
    <!-- Tambahkan script JavaScript atau library lainnya -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>