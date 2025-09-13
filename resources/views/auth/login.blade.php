<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AutoSafe Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
<div class="autosafe-center">
    <div class="autosafe-logo animate-logo-pop">
        <div class="logo-bg"></div>
        <img src="{{ asset('image/autologo.png') }}" alt="AutoSafe Logo" width="60" height="60">
    </div>
    <div class="autosafe-title animate-text-fade-in">AutoSafe</div>
    <div class="autosafe-subtitle animate-text-fade-in">Pilih jenis akun Anda</div>
    <div class="autosafe-card animate-fade-in">
        <div class="autosafe-tab-group">
            <button type="button" class="autosafe-btn-customer active" id="btn-customer">
                <span>&#128100;</span> Customer
            </button>
            <button type="button" class="autosafe-btn-admin" id="btn-admin">
                <span>&#128273;</span> Admin
            </button>
        </div>
        <div>
            <h2 id="login-title">Login Customer</h2>
            <p id="login-desc">Akses untuk menitipkan kendaraan dan akan dijemput</p>
            <div class="autosafe-form-container">
                <!-- Customer Login Form -->
                <form id="customer-form" class="autosafe-form active" method="POST" action="{{ route('proseslogin') }}">
                    @csrf
                    @if (session('customer_error'))
                        <div class="error">{{ session('customer_error') }}</div>
                    @endif
                    <input type="email" name="email" placeholder="Masukkan Email" required>
                    <input type="password" name="password" placeholder="Masukkan Password" required>
                    <button type="submit" class="btn-autosafe">Masuk sebagai Customer</button>
                    <div>
                        Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
                    </div>
                </form>
                <!-- Admin Login Form -->
                <form id="admin-form" class="autosafe-form" method="POST" action="{{ route('prosesloginadmin') }}">
                    @csrf
                    @if (session('admin_error'))
                        <div class="error" style="color:#e74c3c;">{{ session('admin_error') }}</div>
                    @endif
                    <input type="email" name="email" placeholder="Email Admin" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" class="btn-autosafe">Masuk sebagai Admin</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/login.js') }}"></script>
</body>
</html>