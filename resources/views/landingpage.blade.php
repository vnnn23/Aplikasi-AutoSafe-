<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>AutoSafe - Layanan Jemput Kendaraan</title>
  <link rel="stylesheet" href="{{ asset('css/dashboarduser.css') }}" />
  <link rel="icon" type="image/x-icon" href="/public/favicon.ico" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=currency_exchange" />
</head>
<body class="body">

  <!-- HEADER / HERO -->
  <header class="header-hero">
    <div class="header-container">
      <div class="logo-wrapper">
  <img src="{{ asset('image/profil.png') }}" alt="Profil" class="logo-icon" style="width:48px;height:48px;object-fit:cover;border-radius:50%;" />
      </div>
      <div class="title-wrapper">
        <h1 class="title">Hai, <span class="highlight">AutoSafe!</span><span aria-label="waving hand" role="img">👋</span></h1>
        <p class="subtitle">Butuh jemput kendaraan hari ini?</p>
      </div>
      <div class="auth-btn-wrapper">
        <a href="{{ url('/login') }}" class="auth-btn">Masuk / Daftar</a>
      </div>
    </div>

    <div class="hero-text">
      <h2 class="hero-heading">Penitipan Kendaraan Terpercaya</h2>
      <a href="{{ url('/login') }}" aria-label="Pesan Jemput Kendaraan Sekarang" id="orderBtn" class="order-button">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="order-icon">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m-9-3a9 9 0 1118 0 9 9 0 01-18 0z" />
        </svg>
        Pesan Jemput Kendaraan Sekarang
      </a>
      <div class="stats">
        <div>
          <div class="stat-number">15.000+</div>
          <div class="stat-label">Kendaraan Dijemput</div>
        </div>
        <div>
          <div class="stat-number">98%</div>
          <div class="stat-label">Kepuasan Customer</div>
        </div>
        <div>
          <div class="stat-number">30 Menit</div>
          <div class="stat-label">Rata-rata Waktu Jemput</div>
        </div>
      </div>
    </div>
  </header>

  <!-- MAIN CONTENT -->
  <main class="main-content">
    <!-- How It Works Section -->
    <section aria-label="Cara Kerja AutoSafe" class="section-how">
      <h3 class="section-title">Cara Kerja AutoSafe</h3>
      <div class="how-grid">
        <div class="how-item">
          <div class="how-icon">📱</div>
          <h4 class="how-step">1. Pesan Online</h4>
          <p class="how-text">Pilih layanan, isi detail kendaraan dan alamat penjemputan Anda</p>
        </div>
        <div class="how-item">
          <div class="how-icon">🚚</div>
          <h4 class="how-step">2. Petugas Jemput</h4>
          <p class="how-text">Tim profesional kami datang ke lokasi Anda dalam 30-60 menit</p>
        </div>
        <div class="how-item">
          <div class="how-icon">🔒</div>
          <h4 class="how-step">3. Aman Tersimpan</h4>
          <p class="how-text">Kendaraan disimpan di fasilitas aman dengan monitoring 24/7</p>
        </div>
      </div>
    </section>

    <!-- Service List Section -->
    <section aria-label="Layanan Kami" class="section-service">
      <div class="service-header">
        <h3 class="section-title">Layanan kami</h3>
        <a href="login" class="service-link">Lainnya ></a>
      </div>
      <ul class="service-list">
        <!-- Motor service -->
        <li>
          <a href="{{ url('/login') }}" class="service-item" tabindex="0" role="button" aria-label="Penitipan Motor - Harian, Mulai dari Rp 25.000">
            <img src="{{ asset('image/motor-harian.jpg') }}" class="service-image" loading="lazy"/>
            <div class="service-info">
              <div class="service-title">
                <span>Penitipan Motor - Harian</span>
                <span class="badge">Populer</span>
              </div>
              <p class="service-desc">Petugas kami akan menjemput motor Anda</p>
              <div class="service-price">Mulai dari Rp 25.000</div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="service-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
          </a>
        </li>
        <!-- Mobil service -->
        <li>
          <a href="{{ url('/login') }}" class="service-item" tabindex="0" role="button" aria-label="Penitipan Mobil - Harian, Mulai dari Rp 45.000">
            <img src="{{ asset('image/mobil-harian.jpg') }}" class="service-image" loading="lazy"/>
            <div class="service-info">
              <div class="service-title">Penitipan Mobil - Harian</div>
              <p class="service-desc">Petugas kami akan menjemput mobil Anda</p>
              <div class="service-price">Mulai dari Rp 45.000</div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="service-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
          </a>
        </li>
      </ul>
    </section>

        <!-- Informasi Lokasi AutoSafe -->
    <section aria-label="Lokasi AutoSafe" class="section-location">
      <h3 class="section-title">Lokasi AutoSafe</h3>

      @if(isset($lokasiAktif) && $lokasiAktif->count())
        <div class="location-grid">
          @foreach($lokasiAktif as $lok)
            <div class="location-card">
              <div class="location-icon" aria-hidden="true">📍</div>
              <div class="location-info">
                <div class="location-name">{{ $lok->nama_lokasi ?? '-' }}</div>
                <div class="location-address">{{ $lok->alamat_lokasi ?? $lok->alamat ?? '-' }}</div>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="location-grid">
          <div class="location-card">
            <div class="location-icon" aria-hidden="true">📍</div>
            <div class="location-info">
              <div class="location-name">Belum ada lokasi</div>
              <div class="location-address">-</div>
              <div class="location-contact">-</div>
            </div>
          </div>
        </div>
      @endif
    </section>

<!-- Support & Social Section -->
<section aria-label="Butuh Bantuan?" class="section-support">
  <a href="https://wa.me/6285165205580" target="_blank" rel="noopener noreferrer" class="support-box" style="text-decoration:none;">
    <span class="support-icon" aria-hidden="true">
      <img src="{{ asset('image/whatsapp.png') }}" alt="WhatsApp" class="icon" style="width:28px;height:28px;object-fit:cover;" />
    </span>
    <div class="support-text">
      <div class="support-title">Butuh Bantuan?</div>
      <div class="support-contact">Hubungi customer service: +62 851-6520-5580</div>
    </div>
  </a>
  <a href="https://www.instagram.com/official_autosafe?igsh=bzU0Y2VzbjZwdzMz" target="_blank" rel="noopener noreferrer" class="social-box">
    <span class="social-icon" aria-hidden="true">
      <img src="{{ asset('image/instagram.png') }}" alt="Instagram" class="icon" style="width:28px;height:28px;object-fit:cover;" />
    </span>
    <div class="support-text">
      <div class="support-title">Instagram</div>
      <div class="support-contact">@AutoSafe</div>
    </div>
  </a>
</section>
    
  </main>

  <!-- Bottom Navigation -->
<nav class="bottom-nav">
  <a href="#" class="nav-item active">
    <!-- Ikon Home baru -->
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="nav-icon">
      <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.75 12 4l9 6.75M4.5 10.75V19a2 2 0 0 0 2 2h3.5v-4.25a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1V21H17.5a2 2 0 0 0 2-2v-8.25"/>
    </svg>
    <span>Beranda</span>
  </a>
  <a href="/login" class="nav-item">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="nav-icon">
      <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
      <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2.5 2.5"/>
    </svg>
    <span>Riwayat</span>
  </a>
  <a href="/login" class="nav-item">
    <!-- Ikon Akun baru (user outline, modern) -->
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="nav-icon">
      <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2" fill="none"/>
      <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M4 20c0-2.5 3.5-4.5 8-4.5s8 2 8 4.5"/>
    </svg>
    <span>Akun</span>
  </a>
</nav>

<div id="loginModal" class="login-modal">
  <div class="login-modal-content">
    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" class="login-modal-icon">
      <circle cx="12" cy="12" r="12" fill="#42DB42"/>
      <path stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01"/>
    </svg>
    <h3 class="login-modal-title">Login Diperlukan</h3>
    <p class="login-modal-desc">Silakan login terlebih dahulu untuk mengakses fitur ini.</p>
    <div class="login-modal-actions">
      <button id="modalCancel" class="login-modal-btn cancel">Batal</button>
      <button id="modalLogin" class="login-modal-btn login">Login</button>
    </div>
  </div>
</div>

  <script src="{{ asset('js/landingpage.js') }}"></script>
</body>
</html>
