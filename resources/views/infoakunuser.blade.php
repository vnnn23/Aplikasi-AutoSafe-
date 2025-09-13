<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Profil - AutoSafe</title>
  <link rel="stylesheet" href="{{ asset('css/infoakunuser.css') }}" />
</head>
<body>
  <!-- Complete replacement with user profile layout -->
  <div class="profile-container">
    <!-- Profile Card -->
    <div class="profile-card">
      <!-- Profile Avatar and Info -->
      <div class="profile-header">
        <div class="profile-avatar">
          <img src="{{ asset('image/profil.png') }}" alt="Profile Avatar" />
        </div>
        <div class="profile-contact">
          <p class="nama">
            {{ Auth::check() ? (Auth::user()->nama ?? '-') : '-' }}
          </p>
          <p class="email">
            {{ Auth::check() ? (Auth::user()->email ?? '-') : '-' }}
          </p>
        </div>
      </div>

      <!-- Statistics Section -->
      <div class="profile-stats">
        <div class="stat-item">
          <h3>Aktifitas Saya</h3>
          <p class="stat-number">{{ $totalAktifitas ?? 0 }}</p>
        </div>
        <div class="stat-item">
          <h3>Total Pengeluaran</h3>
          <p class="stat-number">Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</p>
        </div>
      </div>

      <!-- Edit Profile Button -->
  <button class="edit-profile-btn" onclick="openEditModal()">Edit Profil</button>
<!-- Modal Edit Profil User -->
<div id="editProfileModal" class="custom-modal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:9999;align-items:center;justify-content:center;">
  <div class="custom-modal-content" style="max-width:400px;background:#fff;border-radius:18px;box-shadow:0 4px 24px rgba(0,0,0,0.12);padding:32px 24px 24px 24px;position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);">
    <div class="custom-modal-title" style="margin-bottom:16px;">Edit Profil</div>
    <form id="editProfileForm" method="POST" action="{{ route('updateprofil') }}">
      @csrf
      <input type="hidden" id="modal_nama" name="nama" value="{{ Auth::check() ? (Auth::user()->nama ?? '') : '' }}">
      <div class="modal-row">
        <label for="modal_email">Email</label>
        <input type="email" id="modal_email" name="email" value="{{ Auth::check() ? (Auth::user()->email ?? '') : '' }}" required class="input-login-style" style="width:100%;margin-bottom:12px;">
      </div>
      <div class="modal-row">
        <label for="modal_password">Password Baru</label>
        <input type="password" id="modal_password" name="password" placeholder="Kosongkan jika tidak ingin mengubah" class="input-login-style" style="width:100%;margin-bottom:12px;">
      </div>
      <div class="modal-btn-row">
        <button type="button" class="btn-cancel" onclick="closeEditModal()">Batal</button>
        <button type="submit" class="btn-ok">Simpan</button>
      </div>
    </form>
  </div>
</div>
    </div>

    <!-- Logout Button -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
      @csrf
    </form>
    <button class="logout-btn" id="logoutBtn">
      Keluar dari Akun
    </button>

  <!-- Bottom Navigation -->
<nav class="bottom-nav">
  <a href="/dashboard" class="nav-item">
    <!-- Ikon Home baru -->
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="nav-icon">
      <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.75 12 4l9 6.75M4.5 10.75V19a2 2 0 0 0 2 2h3.5v-4.25a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1V21H17.5a2 2 0 0 0 2-2v-8.25"/>
    </svg>
    <span>Beranda</span>
  </a>
  <a href="/riwayatuser" class="nav-item">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="nav-icon">
      <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
      <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2.5 2.5"/>
    </svg>
    <span>Riwayat</span>
  </a>
  <a href="#" class="nav-item active">
    <!-- Ikon Akun baru (user outline, modern) -->
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="nav-icon">
      <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2" fill="none"/>
      <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M4 20c0-2.5 3.5-4.5 8-4.5s8 2 8 4.5"/>
    </svg>
    <span>Akun</span>
  </a>
</nav>
  </div>

  <!-- Pop Up Konfirmasi Logout -->
<div id="logoutModal" class="custom-modal" style="display:none;">
  <div class="custom-modal-content">
    <div class="custom-modal-icon">
      <span>!</span>
    </div>
    <div class="custom-modal-title">Konfirmasi Logout</div>
    <div class="custom-modal-text">Apakah Anda yakin ingin keluar dari akun?</div>
    <div class="custom-modal-actions">
      <button type="button" id="logoutCancel" class="btn-cancel">Batal</button>
      <button type="button" id="logoutOk" class="btn-ok">Oke</button>
    </div>
  </div>
</div>
<script src="{{ asset('js/infoakunuser.js') }}"></script>
</body>
</html>
