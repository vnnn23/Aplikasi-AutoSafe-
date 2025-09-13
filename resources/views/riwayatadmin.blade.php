<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin AutoSafe Dashboard</title>
  <link rel="icon" type="image/x-icon" href="/public/favicon.ico" />
  <link rel="stylesheet" href="{{ asset('css/riwayatadmin.css') }}" />
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
        <a href="{{ route('admindashboard') }}" tabindex="0">
          <svg aria-hidden="true" focusable="false" viewBox="0 0 24 24">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
          </svg>
          Dashboard
        </a>

        <a href="#" class="active" aria-current="page" tabindex="0">
          <!-- Riwayat Transaksi: clock/history icon -->
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true" focusable="false">
            <circle cx="12" cy="12" r="9" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 7v5l3 3" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Riwayat Transaksi
        </a>

        <a href="{{ route('kelolalokasi') }}" tabindex="0">
          <!-- Kelola Lokasi: map-pin icon -->
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true" focusable="false">
            <path d="M12 21s-6-5.686-6-10a6 6 0 1112 0c0 4.314-6 10-6 10z" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="12" cy="11" r="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Kelola Lokasi
        </a>
      </nav>
    </div>
        <button class="logout-btn" type="button" aria-label="Logout from Admin AutoSafe account">Logout</button>
  </aside>
<div class="main-content">
  <header class="main-header">
    <h1>Manajemen Transaksi</h1>
    <p class="main-subtitle">Kelola semua transaksi dan booking</p>
  </header>

  <div class="filter-card">
    <input type="text" class="filter-search" placeholder="Cari...." />
    <button class="filter-reset">Reset</button>
  </div>

  <div class="summary-cards">
    <div class="summary-card">
      <span class="summary-value">{{ $transaksiAktif ?? 0 }}</span>
      <span class="summary-label">Transaksi</span>
    </div>
    <div class="summary-card">
      <span class="summary-value">
        Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
      </span>
      <span class="summary-label">Pendapatan Layanan</span>
    </div>
  </div>

  <div class="transaksi-list-card">
    <div class="transaksi-list-header">
      <span class="transaksi-list-title">Daftar Transaksi</span>
      <span class="transaksi-list-sub" id="transaksi-count">
    Menampilkan {{ count($datapesanan) }} dari {{ count($datapesanan) }} transaksi
  </span>
      <a href="{{ route('admin.export.pdf') }}" class="btn-export-pdf">Export PDF</a>
    </div>
    @foreach($datapesanan as $p)
      <div class="transaksi-detail-card">
        <div class="transaksi-detail-top">
          <div class="transaksi-detail-img">
            <img 
              src="{{ asset('image/' . ($p->jenis_layanan ?? 'motor') . '.jpg') }}" 
              alt="Kendaraan" 
              style="width:54px;height:54px;">
          </div>
          <div class="transaksi-detail-main">
            <div class="transaksi-detail-nama">{{ $p->nama_kontak ?? '' }}
              @if($p->status_pesanan == 'completed')
                <span class="transaksi-status selesai">Selesai</span>
              @elseif($p->status_pesanan == 'confirmed')
                <span class="transaksi-status aktif">Menunggu Konfirmasi</span>
              @elseif($p->status_pesanan == 'cancelled')
                <span class="transaksi-status batal">Dibatalkan</span>
              @else
                <span class="transaksi-status lain">{{ ucfirst($p->status_pesanan) }}</span>
              @endif
            </div>
            <div class="transaksi-detail-id">IDX000{{ $p->id_pesanan ?? '-' }}</div>
            <div class="transaksi-detail-lokasi">{{ $p->nama_lokasi ?? $p->pilihlokasi ?? '-' }}</div>
          </div>
          <div class="transaksi-detail-nominal">
            <span class="transaksi-nominal">Rp {{ number_format($p->biaya_layanan ?? 0,0,',','.') }}</span>
            <div class="transaksi-metode">{{ $p->metode_pembayaran ?? '-' }}</div>
          </div>
        </div>
        <div class="transaksi-detail-body">
          <div class="transaksi-detail-kiri">
            <div><strong>Kendaraan</strong></div>
            <div>{{ $p->merk ?? '-' }}</div>
            <div>{{ $p->plat_nomor ?? '-' }}</div>
            <div>{{ $p->warna ?? '-' }}</div>

            <!-- Alamat Jemput dipindah ke bawah Kendaraan -->
            <div style="margin-top:10px;"><strong>Alamat Jemput</strong></div>
            <div>{{ $p->alamat_jemput ?? $p->alamat_penjemputan ?? '-' }}</div>
          </div>

          <div class="transaksi-detail-tengah">
            <div><strong>Waktu</strong></div>
            <div>Check-in: <b>{{ $p->tanggal_mulai ?? '-' }}</b></div>
            <div>Check-out: <b>{{ $p->tanggal_selesai ?? '-' }}</b></div>
            <div>Durasi: 
              @php
                  $mulai = $p->tanggal_mulai ? \Carbon\Carbon::parse($p->tanggal_mulai) : null;
                  $selesai = $p->tanggal_selesai ? \Carbon\Carbon::parse($p->tanggal_selesai) : null;
              @endphp
              @if($mulai && $selesai)
                  @php
                      $diff = $mulai->diff($selesai);
                      $jam = $diff->h + ($diff->days * 24);
                      $menit = $diff->i;
                  @endphp
                  {{ $jam > 0 ? $jam . ' jam ' : '' }}{{ $menit > 0 ? $menit . ' menit' : '' }}
              @else
                  -
              @endif
            </div>
            <div>Waktu Jemput: <b>{{ $p->waktu_jemput ?? '-' }}</b></div>

            <!-- Patokan dipindah ke bawah Waktu -->
            <div style="margin-top:8px;"><strong>Patokan</strong></div>
            <div>{{ $p->patokan ?? '-' }}</div>
          </div>

          <div class="transaksi-detail-kanan">
            <div><strong>Kontak Customer</strong></div>
            <div>{{ $p->no_hp_kontak ?? '-' }}</div>
            <div>{{ $p->no_hp_kontak_cadangan ?? '-' }}</div>

            <!-- Instruksi tetap di bawah Kontak Customer -->
            <div style="margin-top:8px;"><strong>Instruksi Penjemputan</strong></div>
            <div>{{ $p->instruksi ?? $p->instruksi_penjemputan ?? ($p->note ?? '-') }}</div>

            @if(!empty($p->note))
              <div class="transaksi-note">Note: <a href="#" style="color:#3b82f6;">{{ $p->note }}</a></div>
            @endif

            @if(!empty($p->surat))
              <div class="transaksi-surat">
                <strong>Surat Kendaraan:</strong><br>
                <img src="{{ asset($p->surat) }}" alt="Surat Kendaraan" style="max-width:120px;max-height:120px;border-radius:8px;border:1px solid #eaffc7;margin-top:6px;">
              </div>
            @else
              <div class="transaksi-surat">
                <strong>Surat Kendaraan:</strong> <span style="color:#aaa;">Tidak ada surat</span>
              </div>
            @endif
          </div>
        </div>
        <div class="transaksi-detail-footer">
          Dibuat: {{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}
        </div>

        @if($p->status_pesanan == 'confirmed')
          <div class="transaksi-action-btns" style="margin-top:10px;">
            <form method="POST" action="{{ route('admin.pesanan.complete', $p->id_pesanan) }}" style="display:inline;">
              @csrf
              <button type="submit" class="btn-confirm" onclick="return confirm('Konfirmasi pesanan selesai?')">Konfirmasi</button>
            </form>
          </div>
        @endif
      </div>
    @endforeach
    @if(empty($datapesanan) || count($datapesanan) == 0)
      <p class="kosong-text">Tidak ada transaksi.</p>
    @endif
  </div>
</div>
<div id="modalSurat" class="modal-surat">
  <span id="closeModalSurat" class="modal-surat-close">&times;</span>
  <img id="modalSuratImg" src="" alt="Surat Kendaraan" class="modal-surat-img">
</div>

<script src="{{ asset('js/riwayatadmin.js') }}"></script>
</body>
</html>