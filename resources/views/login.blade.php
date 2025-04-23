<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #28a745; /* Hijau penuh di seluruh layar */
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url("assets/images/MEDIASTOCK.jpg"); /* Gambar sebagai background */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .container img {
            width: 120px;
            height: 120px;
            margin: 20px auto;
            border-radius: 50%; /* Menjadikan gambar berbentuk lingkaran */
        }
        h1 {
            font-size: 24px;
            margin: 20px 0;
        }
        .role-selection {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .role {
            margin: 0 10px;
            padding: 10px 20px;
            background-color: #fff;
            color: #28a745;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
        }
        .role:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src= "assets/images/MEDIASTOCK.jpg" alt="Hospital Icon">
        <h1>Sign In</h1>
        <div class="role-selection">
            <a href="{{ route('login.admin') }}" class="role">Admin</a>
            <a href="{{ route('login.kasir') }}" class="role">Kasir</a>
        </div>
    </div>
</body>
</html>