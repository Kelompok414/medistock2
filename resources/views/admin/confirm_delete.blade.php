<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Hapus Pengguna</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to bottom, #3b82f6, #1d4ed8);
            margin: 0;
        }
        .confirmation-box {
            background: white;
            border-radius: 10px;
            padding: 20px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .confirmation-box img {
            width: 80px;
            margin-bottom: 20px;
        }
        .confirmation-box h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .confirmation-box p {
            font-size: 14px;
            margin-bottom: 20px;
        }
        .confirmation-box .btn {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .confirmation-box .btn-yes {
            background: #3b82f6;
            color: white;
        }
        .confirmation-box .btn-no {
            background: #ef4444;
            color: white;
        }
    </style>
</head>
<body>
    <div class="confirmation-box">
        <img src="{{ asset('images/trash-icon.png') }}" alt="Trash Icon">
        <h2>Hapus Pengguna?</h2>
        <p>Anda yakin menghapus pengguna ini?</p>
        <form action="{{ route('manajemen.kasir.destroy', $id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-yes">Iya</button>
        </form>
        <a href="{{ route('manajemen.kasir.edit', $id) }}">
            <button class="btn btn-no">Tidak</button>
        </a>
    </div>
</body>
</html>