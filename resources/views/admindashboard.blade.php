<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin AutoSafe Dashboard</title>
  <link rel="icon" type="image/x-icon" href="/public/favicon.ico" />
  <link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}" />
</head>
<body>
  <aside class="sidebar" aria-label="Sidebar Navigation and User Info">
    <div class="sidebar-top">
      <div class="sidebar-header" role="banner">
        <div class="profile-icon" aria-hidden="true">
          <img src="{{ asset('image/autologo.png') }}" alt="Logo AutoSafe" style="width:48px;height:48px;object-fit:contain;">
        </div>
        <div>
          <div class="profile-name"><strong>Admin AutoSafe</strong></div>
        </div>
      </div>

      <nav class="nav-menu" role="navigation" aria-label="Primary sidebar navigation">
        <a href="#" class="active" aria-current="page" tabindex="0">
          <svg aria-hidden="true" focusable="false" viewBox="0 0 24 24" width="20" height="20">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
          </svg>
          Dashboard
        </a>

        <!-- Riwayat Transaksi (ganti icon -> clock/history) -->
        <a href="{{ route('riwayatadmin') }}" tabindex="0">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <circle cx="12" cy="12" r="9"/>
            <path d="M12 7v5l3 3" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Riwayat Transaksi
        </a>

        <!-- Kelola Lokasi (ganti icon -> modern map-pin) -->
        <a href="{{ route('kelolalokasi') }}" tabindex="0">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <path d="M12 21s-6-5.686-6-10a6 6 0 1112 0c0 4.314-6 10-6 10z" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="12" cy="11" r="2.5"/>
          </svg>
          Kelola Lokasi
        </a>
      </nav>
    </div>
        <button class="logout-btn" type="button" aria-label="Logout from Admin AutoSafe account">Logout</button>
  </aside>

  <main role="main" aria-label="Admin Dashboard Main Content">
    <header class="main-header">
      <h1>Dashboard Admin</h1>
      <p class="subtitle">Selamat datang kembali, Admin AutoSafe</p>
    </header>

    <section class="top-cards" aria-label="Key summary metrics">
      <article class="card" tabindex="0" aria-label="Pendapatan total {{ number_format($totalPendapatan,0,',','.') }} rupiah">
        <div class="card-info">
          <span class="top-label">Pendapatan Layanan</span>
          <span class="main-value">Rp {{ number_format($totalPendapatan,0,',','.') }}</span>
        </div>
        <div class="card-icon" aria-hidden="true" title="Money bag icon">💰</div>
      </article>
      <article class="card" tabindex="0" aria-label="Total transaksi {{ $totalTransaksi }} unit">
        <div class="card-info">
          <span class="top-label">Total Transaksi</span>
          <span class="main-value">{{ $totalTransaksi }}</span>
        </div>
        <div class="card-icon" aria-hidden="true" title="Chart icon">📊</div>
      </article>
      <article class="card" tabindex="0" aria-label="Total lokasi aktif {{ $totalLokasiAktif }} unit">
        <div class="card-info">
          <span class="top-label">Lokasi Aktif</span>
          <span class="main-value">{{ $totalLokasiAktif }}</span>
        </div>
        <div class="card-icon" aria-hidden="true" title="Chart icon">📍</div>
      </article>
    </section>

 
        <div class="main-flex">
            <!-- Transaksi Terbaru -->
            <div class="transaksi-card">
                <div class="transaksi-header">
                    <div>
                        <div class="transaksi-title">Transaksi terbaru</div>
                        <div class="transaksi-desc">Aktivitas transaksi real-time</div>
                    </div>
                    <a href="{{ route('riwayatadmin') }}" class="transaksi-link">Lihat Semua</a>
                </div>
                <div class="transaksi-list scrollable-transaksi-list">
                    @foreach($datapesanan ?? [] as $p)
                        <div class="transaksi-item">
                            <div>
                                <div class="transaksi-nama">{{ $p->nama_kontak ?? '-' }}</div>
                                <div class="transaksi-detail">{{ $p->merk ?? '-' }} - {{ $p->plat_nomor ?? '-' }}</div>
                                <div class="transaksi-detail">{{ $p->nama_lokasi ?? $p->pilihlokasi ?? '-' }}</div>
                            </div>
                            <div class="transaksi-right">
                                @php
                                    $status = strtolower($p->status_pesanan ?? '');
                                    $statusLabelMap = [
                                        'completed' => 'Selesai',
                                        'confirmed' => 'Menunggu Konfirmasi',
                                        'pending'   => 'Menunggu Pembayaran',
                                        'cancelled' => 'Dibatalkan',
                                    ];
                                    $label = $statusLabelMap[$status] ?? ( $status ? ucfirst($status) : '-' );
                                    $cls = in_array($status, ['completed','confirmed','pending','cancelled']) ? $status : 'pending';
                                @endphp

                                <span class="transaksi-status {{ $cls }}">{{ $label }}</span>

                                <div class="transaksi-nominal">Rp {{ number_format($p->biaya_layanan ?? 0,0,',','.') }}</div>
                                <div class="transaksi-waktu">{{ \Carbon\Carbon::parse($p->created_at)->diffForHumans() ?? '-' }}</div>
                            </div>
                        </div>
                    @endforeach
                    @if(empty($datapesanan) || count($datapesanan) == 0)
                        <p class="kosong-text">Tidak ada transaksi.</p>
                    @endif
                </div>
            </div>

            <!-- Overview Lokasi -->
            <div class="lokasi-card">
                <div class="lokasi-header">
                    <div class="lokasi-title">Overview Lokasi</div>
                    <a href="{{ route('kelolalokasi') }}" class="lokasi-link">Kelola lokasi</a>
                </div>
                <div class="lokasi-list scrollable-lokasi-list">
                    @foreach($lokasi ?? [] as $l)
                        <div class="lokasi-item">
                            <div class="lokasi-item-header">
                                <div class="lokasi-nama">{{ $l->nama_lokasi ?? '-' }}</div>
                                <span class="lokasi-status {{ $l->status=='aktif'?'aktif':'nonaktif' }}">{{ ucfirst($l->status) }}</span>
                            </div>
                            <div class="lokasi-bar-row">
                        Motor <span class="lokasi-bar-text">{{ $l->jumlah_motor }}/{{ $l->kapasitas_motor ?? 30 }}</span>
                        <span class="lokasi-bar">
                            <span class="lokasi-bar-fill motor"
                                style="width:{{ ($l->kapasitas_motor ?? 30) > 0 ? round(($l->jumlah_motor / ($l->kapasitas_motor ?? 30)) * 100) : 0 }}%">
                            </span>
                        </span>
                    </div>
                    <div class="lokasi-bar-row">
                        Mobil <span class="lokasi-bar-text">{{ $l->jumlah_mobil }}/{{ $l->kapasitas_mobil ?? 20 }}</span>
                        <span class="lokasi-bar">
                            <span class="lokasi-bar-fill mobil"
                                style="width:{{ ($l->kapasitas_mobil ?? 20) > 0 ? round(($l->jumlah_mobil / ($l->kapasitas_mobil ?? 20)) * 100) : 0 }}%">
                            </span>
                        </span>
                    </div>
                    <div class="lokasi-pendapatan">
                        Pendapatan Hari ini <span class="lokasi-pendapatan-nominal">Rp {{ number_format($l->pendapatan_hari_ini ?? 0,0,',','.') }}</span>
                    </div>
                        </div>
                    @endforeach
                    @if(empty($lokasi) || count($lokasi) == 0)
                        <p class="kosong-text">Tidak ada lokasi.</p>
                    @endif
                </div>
            </div>
        </div>
  </main>
<script>
  document.querySelector('.logout-btn').addEventListener('click', function() {
    if (confirm('Apakah Anda yakin ingin logout dari akun Admin AutoSafe?')) {
      window.location.href = "{{ route('landingpage') }}";
    }
  });
</script>
<script src="{{ asset('js/dashboardadmin.js') }}"></script>
</body>
</html>

