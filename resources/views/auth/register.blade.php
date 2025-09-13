<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun - AutoSafe</title>
    <link href="https://fonts.googleapis.com/css?family=Inter:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <div class="autosafe-logo animate-logo-pop">
        <div class="logo-bg"></div>
        <img src="{{ asset('image/autologo.png') }}" alt="AutoSafe Logo" width="60" height="60">
    </div>
    <div class="autosafe-title animate-text-fade-in">AutoSafe</div>
    <div class="autosafe-subtitle animate-text-fade-in">Daftar Akun</div>
    <div class="autosafe-form-container animate-fade-in">
    <div class="register-title">Selamat Datang</div>
    <div class="register-desc">Masuk atau daftar untuk melanjutkan</div>
    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif
    <form class="register-form" method="POST" action="{{ route('prosesregister') }}">
        @csrf
        <label class="form-label" for="nama">Nama Lengkap</label>
        <input class="form-input" type="text" name="nama" id="nama" placeholder="Masukkan Nama Lengkap" required>
        <label class="form-label" for="email">Email</label>
        <input class="form-input" type="email" name="email" id="email" placeholder="Masukkan Email" required>
        <label class="form-label" for="password">Password</label>
        <input class="form-input" type="password" name="password" id="password" placeholder="Masukkan Password" required>
        <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
        <input class="form-input" type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" required>
        <button class="btn-autosafe" type="submit">Daftar dan Masuk</button>
    </form>
    <div class="login-link">
        Sudah memiliki Akun? <a href="{{ route('login') }}">Masuk</a>
    </div>
</div>
</body>
</html>