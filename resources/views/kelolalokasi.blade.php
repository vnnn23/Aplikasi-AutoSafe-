<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin AutoSafe Dashboard</title>
  <link rel="icon" type="image/x-icon" href="/public/favicon.ico" />
  <link rel="stylesheet" href="{{ asset('css/kelolalokasi.css') }}" />
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
          <svg aria-hidden="true" focusable="false" viewBox="0 0 24 24" width="20" height="20">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
          </svg>
          Dashboard
        </a>

        <!-- Riwayat Transaksi: ganti ke icon jam/riwayat -->
        <a href="{{ route('riwayatadmin') }}" tabindex="0">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <circle cx="12" cy="12" r="9" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 8v4l3 3" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Riwayat Transaksi
        </a>

        <!-- Kelola Lokasi: ganti ke map-pin modern -->
        <a href="{{ route('kelolalokasi') }}"  class="active" aria-current="page" tabindex="0">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
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
    <header class="main-header" style="display: flex; justify-content: space-between; align-items: center;">
      <div>
        <h1>Manajemen Lokasi</h1>
        <p class="main-subtitle">Kelola semua lokasi</p>
      </div>
      <a href="#" class="btn-tambah-lokasi" id="btnTambahLokasi">+ Tambah Lokasi</a>
    </header>
    <div class="summary-cards">
      <div class="summary-card">
        <span class="summary-value">
          {{ $lokasi->where('status', 'aktif')->count() }}
        </span>
        <span class="summary-label">Total Lokasi Aktif</span>
      </div>
      <div class="summary-card">
        <span class="summary-value">
          {{ $lokasi->where('status', 'nonaktif')->count() }}
        </span>
        <span class="summary-label">Total Lokasi Tidak Aktif</span>
      </div>
    </div>
    <div class="lokasi-grid">
      @foreach($lokasi as $l)
        <div class="lokasi-card">
          <span class="lokasi-status {{ $l->status == 'aktif' ? '' : 'nonaktif' }}">{{ ucfirst($l->status) }}</span>
          <div class="lokasi-nama">{{ $l->nama_lokasi }}</div>
          <div class="lokasi-alamat">{{ $l->alamat_lokasi ?? '-' }}</div>
          <div class="lokasi-bar">
            <div class="lokasi-bar-label">Motor</div>
            <div class="lokasi-bar-track">
              <span class="lokasi-bar-fill motor" style="width:{{ round(($l->jumlah_motor/30)*100) }}%"></span>
            </div>
            <div class="lokasi-bar-info">{{ $l->jumlah_motor }}/30</div>
          </div>
          <div class="lokasi-bar">
            <div class="lokasi-bar-label">Mobil</div>
            <div class="lokasi-bar-track">
              <span class="lokasi-bar-fill mobil" style="width:{{ round(($l->jumlah_mobil/20)*100) }}%"></span>
            </div>
            <div class="lokasi-bar-info">{{ $l->jumlah_mobil }}/20</div>
          </div>
          <div class="lokasi-harga">
            <div class="lokasi-harga-col">
              <div class="lokasi-harga-title">Harga Penitipan Kendaraan</div>
              <div class="lokasi-harga-val">Motor: Rp 25.000/Hari<br>Mobil: Rp 45.000/Hari</div>
            </div>
            <div class="lokasi-harga-col">
              <div class="lokasi-harga-title">Biaya Penjemputan</div>
              <div class="lokasi-harga-val">Biaya: Rp {{ number_format($l->biaya_jemput,0,',','.') }}</div>
            </div>
          </div>
          <div class="lokasi-pendapatan">Rp {{ number_format($l->pendapatan_hari_ini ?? 0,0,',','.') }}</div>
          <div class="lokasi-manager">Manager<br>{{ $l->nama_manajer ?? '-' }}</div>
          <div class="lokasi-btn-row">
            @if($l->status == 'aktif')
              <form method="POST" action="{{ route('lokasi.nonaktif', ['id_lokasi' => $l->id_lokasi]) }}" style="display:inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="lokasi-btn nonaktif" onclick="return confirm('Nonaktifkan lokasi ini?')">Nonaktifkan</button>
              </form>
            @else
              <form method="POST" action="{{ route('lokasi.aktifkan', ['id_lokasi' => $l->id_lokasi]) }}" style="display:inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="lokasi-btn aktif" onclick="return confirm('Aktifkan lokasi ini?')">Aktifkan</button>
              </form>
            @endif
            <button
              class="lokasi-btn detail btn-edit-lokasi"
              data-id="{{ $l->id_lokasi }}"
              data-nama="{{ $l->nama_lokasi }}"
              data-biaya="{{ $l->biaya_jemput }}"
              data-alamat="{{ $l->alamat_lokasi }}"
              data-manajer="{{ $l->nama_manajer }}"
            >Edit</button>
          </div>
        </div>
      @endforeach
      @if(empty($lokasi) || count($lokasi) == 0)
        <p class="kosong-text">Tidak ada lokasi.</p>
      @endif
    </div>
  </div>

  <!-- Modal Pop Up Tambah Lokasi -->
  <div id="modalTambahLokasi" class="modal-tambah-lokasi" style="display:none;">
    <div class="modal-content">
      <span class="close-modal" id="closeModalTambahLokasi">&times;</span>
      <h2>Tambah Lokasi</h2>
      <form method="POST" action="{{ route('lokasi.store') }}">
        @csrf
        <div class="form-group">
          <label>Nama Lokasi</label>
          <input type="text" name="nama_lokasi" required>
        </div>
        <div class="form-group">
          <label>Biaya Jemput</label>
          <input type="text" name="biaya_jemput" required>
        </div>
        <div class="form-group">
          <label>Alamat Lokasi</label>
          <input type="text" name="alamat_lokasi" required>
        </div>
        <div class="form-group">
          <label>Nama Manajer</label>
          <input type="text" name="nama_manajer" required>
        </div>
        <div class="form-group">
          <label>Status</label>
          <select name="status" required>
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
          </select>
        </div>
        <button type="submit" class="btn-simpan">Simpan</button>
      </form>
    </div>
  </div>

  <!-- Modal Pop Up Edit Lokasi -->
  <div id="modalEditLokasi" class="modal-edit-lokasi" style="display:none;">
    <div class="modal-content">
      <span class="close-modal" id="closeModalEditLokasi">&times;</span>
      <h2>Edit Lokasi</h2>
      <form id="formEditLokasi" method="POST">
        @csrf
        @method('PATCH')
        <input type="hidden" name="id_lokasi" id="edit_id_lokasi">
        <div class="form-group">
          <label>Nama Lokasi</label>
          <input type="text" name="nama_lokasi" id="edit_nama_lokasi" required>
        </div>
        <div class="form-group">
          <label>Biaya Jemput</label>
          <input type="text" name="biaya_jemput" id="edit_biaya_jemput" required>
        </div>
        <div class="form-group">
          <label>Alamat Lokasi</label>
          <input type="text" name="alamat_lokasi" id="edit_alamat_lokasi" required>
        </div>
        <div class="form-group">
          <label>Nama Manajer</label>
          <input type="text" name="nama_manajer" id="edit_nama_manajer" required>
        </div>
        <button type="submit" class="btn-simpan">Simpan Perubahan</button>
      </form>
      <form id="formHapusLokasi" method="POST" style="margin-top:16px;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus lokasi ini?')">Hapus Lokasi</button>
      </form>
    </div>
  </div>
  <script>
window.routeLandingpage = "{{ route('landingpage') }}";
</script>
<script src="{{ asset('js/kelolalokasi.js') }}"></script>
</body>
</html>