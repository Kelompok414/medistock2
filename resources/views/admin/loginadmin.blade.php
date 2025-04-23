<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-box {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            max-width: 900px;
            width: 100%;
        }
        .login-form {
            padding: 30px;
            width: 50%;
        }
        .login-form img {
            width: 100px;
            margin-bottom: 20px;
        }
        .login-image {
            width: 50%;
            position: relative;
        }
        .login-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .login-image .text-overlay {
            position: absolute;
            bottom: 20px;
            left: 20px;
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }
        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="login-box">
        <!-- Form Section -->
        <div class="login-form">
            <img src="{{ asset('assets/images/MEDIASTOCK.jpg') }}" alt="MediStock Logo">
            <h3 class="mb-4">MEDISTOCK</h3>
            <form action="/login" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="email" class="form-control" placeholder="ex: example@gmail.com" name="email" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Sign In</button>
            </form>
        </div>

        <!-- Image Section -->
        <div class="login-image">
            <img src="{{ asset('assets/images/LOGIN.jpg') }}" alt="Login Image">
            <div class="text-overlay">
                Together<br>Let's Be Healthy
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>