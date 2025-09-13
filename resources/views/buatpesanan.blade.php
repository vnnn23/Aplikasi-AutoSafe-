<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Buat Pesanan</title>
    <link rel="stylesheet" href="{{ asset('css/buatpesanan1.css') }}" />
  <style>

  </style>
</head>
<body>
  <header>
    <button aria-label="Kembali ke halaman sebelumnya" id="backBtn"
      onclick="window.location.href='{{ url('/layanan') }}'">
      &lt; Buat Pesanan
    </button>
  </header>

  <main>
    <section class="banner-section">
      <svg xmlns="http://www.w3.org/2000/svg" class="banner-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2a10 10 0 1010 10A10 10 0 0012 2zm-1 14l-3-3 1.414-1.414L11 13.172l4.586-4.586L17 10z" />
      </svg>
      <div>
        <h1 class="banner-title">Kendaraan Anda Aman Bersama Kami</h1>
        <p class="banner-subtitle">Petugas profesional</p>
      </div>
    </section>

    <h2 class="section-title">Detail Kendaraan</h2>

  @php
    $layanan = request('layanan', 'motor-harian');
    $data = [
      'motor-harian' => [
        'img' => asset('image/motor-harian.jpg'),
        'type' => 'Penitipan Motor - Harian',
        'price' => 'Rp. 25.000/hari'
      ],
      'mobil-harian' => [
        'img' => asset('image/mobil-harian.jpg'),
        'type' => 'Penitipan Mobil - Harian',
        'price' => 'Rp. 45.000/hari'
      ]
    ];
    $selected = isset($data[$layanan]) ? $data[$layanan] : $data['motor-harian'];
  @endphp

  <article class="vehicle-card">
    <div class="vehicle-img-box">
      <img 
        src="{{ $selected['img'] }}" 
        alt="Gambar {{ $selected['type'] }}" 
        width="60" height="60" 
        onerror="this.style.display='none'" 
        loading="lazy" />
    </div>
    <div class="vehicle-info">
      <p class="vehicle-type">{{ $selected['type'] }}</p>
      <p class="vehicle-price">{{ $selected['price'] }}</p>
    </div>
    <div class="vehicle-selected">
      <span class="selected-badge">Terpilih</span>
    </div>
  </article>

    <form id="orderForm" class="form-container space-y-6" method="POST" action="{{ route('buatpesanan.store') }}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="layanan" value="{{ $layanan }}">
      <input type="hidden" name="biaya_layanan" id="biaya_layanan" value="25000">

      <div class="form-group">
        <label for="hargaPreview" class="form-label">Total Biaya Layanan</label>
        <input type="text" id="hargaPreview" class="form-input" value="Rp -" readonly style="background:#f3f4f6;">
      </div>

      <fieldset aria-labelledby="kendaraanInfoLegend">
        <legend id="kendaraanInfoLegend">Informasi Kendaraan</legend>
        <div class="grid-container">
         <div>
            <label for="merk" class="form-label">Merk</label>
            <input 
              type="text" 
              id="merk" 
              name="merk" 
              placeholder="Masukkan Merk Kendaraan"
              class="form-input" 
              value="{{ old('merk', $form['merk'] ?? '') }}" />
          </div>
          <div>
            <label for="surat" class="form-label">Surat-surat Kendaraan (Foto STNK) Maksimal 64KB</label>
            <label for="surat" 
                   tabindex="0" 
                   class="file-upload-label">
              <span id="suratLabel" class="file-upload-text">Upload foto disini</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="file-upload-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v16h16" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 20l9-9 9 9" />
              </svg>
            </label>
            <input 
              type="file" 
              id="surat" 
              name="surat" 
              accept="image/*,application/pdf" 
              class="file-input-hidden" />

            <!-- Preview & Hapus -->
            <div id="previewBox" class="preview-container hidden">
              <img id="filePreview" src="/placeholder.svg" alt="Preview Surat" class="preview-image" />
              <button type="button" id="clearFileBtn" class="clear-file-btn">
                Hapus
              </button>
            </div>
          </div>
          <div>
            <label for="warna" class="form-label">Warna</label>
            <input 
              type="text" 
              id="warna" 
              name="warna" 
              placeholder="Masukkan Warna Kendaraan"
              class="form-input" 
              value="{{ old('warna', $form['warna'] ?? '') }}" />
          </div>
          <div>
            <label for="plat" class="form-label">Plat Nomor</label>
            <input 
              type="text" 
              id="plat" 
              name="plat" 
              placeholder="Masukkan Nomor Polisi"
              class="form-input" />
          </div>
          <div class="grid-full-width">
            <label for="catatan" class="form-label">Catatan</label>
            <select name="catatan" id="catatan" class="form-input">
              <option value="" disabled {{ old('catatan', $form['catatan'] ?? '') == '' ? 'selected' : '' }}>Pilih Catatan</option>
              <option value="Kendaraan Baik" {{ old('catatan', $form['catatan'] ?? '') == 'Kendaraan Baik' ? 'selected' : '' }}>Kendaraan Baik</option>
              <option value="Kendaraan ada lecet" {{ old('catatan', $form['catatan'] ?? '') == 'Kendaraan ada lecet' ? 'selected' : '' }}>Kendaraan ada lecet</option>
              <option value="Ban serep di bagasi" {{ old('catatan', $form['catatan'] ?? '') == 'Ban serep di bagasi' ? 'selected' : '' }}>Ban serep di bagasi</option>
              <option value="Tidak ada catatan khusus" {{ old('catatan', $form['catatan'] ?? '') == 'Tidak ada catatan khusus' ? 'selected' : '' }}>Tidak ada catatan khusus</option>
            </select>
          </div>
        </div>
      </fieldset>

      <fieldset aria-labelledby="waktuPenitipanLegend">
        <legend id="waktuPenitipanLegend">Waktu Penitipan</legend>
        <div class="grid-container">
          <div>
            <label for="tanggalMulai" class="form-label">Tanggal Mulai</label>
            <input 
              type="date" 
              id="tanggalMulai" 
              name="tanggalMulai" 
              placeholder="dd/mm/yyyy"
              class="form-input" />
          </div>
          <div>
            <label for="tanggalSelesai" class="form-label">Tanggal Selesai</label>
            <input 
              type="date" 
              id="tanggalSelesai" 
              name="tanggalSelesai" 
              placeholder="dd/mm/yyyy"
              class="form-input" />
          </div>
        </div>
      </fieldset>

      <h2 class="section-heading mt-8">Alamat & Waktu Jemput</h2>

      <fieldset aria-labelledby="alamatPenjemputanLegend">
        <legend id="alamatPenjemputanLegend" class="legend-with-icon">
          <span aria-hidden="true" role="img" class="legend-icon">📍</span> Alamat Penjemputan
        </legend>
        <div class="space-y-4">
          <div>
            <label for="alamatLengkap" class="form-label">Alamat Lengkap</label>
            <input 
              type="text" 
              id="alamatLengkap" 
              name="alamatLengkap" 
              placeholder="Contoh: Jl. Sudirman No. 123, RT 001/002, Kelurahan Senayan, Jakarta Selatan"
              class="form-input" />
          </div>
          <div>
            <label for="patokan" class="form-label">Patokan/Landmark</label>
            <input 
              type="text" 
              id="patokan" 
              name="patokan" 
              placeholder="Contoh: Dekat Starbucks, Sebelah Indomaret, Samping Mall"
              class="form-input" />
          </div>
          <div>
            <label for="instruksi" class="form-label">Instruksi Khusus untuk Petugas</label>
            <input 
              type="text" 
              id="instruksi" 
              name="instruksi" 
              placeholder="Contoh: Kendaraan parkir di basement lantai 2, hubungi security untuk akses"
              class="form-input" />
          </div>
        </div>
      </fieldset>

      <fieldset aria-labelledby="waktuPenjemputanLegend">
        <legend id="waktuPenjemputanLegend" class="legend-with-icon">
          <span aria-hidden="true" role="img" class="legend-icon">⏰</span> Waktu Penjemputan
        </legend>
        <div class="grid-container">
          <div>
            <label for="tanggalJemput" class="form-label">Tanggal Jemput</label>
            <input 
              type="date" 
              id="tanggalJemput" 
              name="tanggalJemput" 
              placeholder="dd/mm/yyyy"
              class="form-input"
              readonly/>
          </div>
          <div>
            <label for="waktuJemput" class="form-label">Waktu Jemput</label>
            <select 
              id="waktuJemput" 
              name="waktuJemput"
              class="form-select">
              <option value="" disabled selected>Pilih Waktu</option>
              <option value="08:00">08:00</option>
              <option value="09:00">09:00</option>
              <option value="10:00">10:00</option>
              <option value="11:00">11:00</option>
              <option value="12:00">12:00</option>
              <option value="13:00">13:00</option>
              <option value="14:00">14:00</option>
              <option value="15:00">15:00</option>
              <option value="16:00">16:00</option>
              <option value="17:00">17:00</option>
            </select>
          </div>
        </div>

        <div class="info-box" role="region" aria-label="Info Penjemputan">
          <svg xmlns="http://www.w3.org/2000/svg" class="info-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <div class="info-content">
            <p class="info-title">Info Penjemputan</p>
            <ul class="info-list">
              <li>Petugas akan tiba 15 menit sebelum waktu yang dipilih</li>
              <li>Anda akan mendapat notifikasi ketika petugas dalam perjalanan</li>
              <li>Proses penjemputan maksimal 10 menit</li>
            </ul>
          </div>
        </div>

        <div class="space-y-4 mt-8">
          <div>
            <label for="namaKontak" class="form-label">Nama Kontak</label>
            <input 
              type="text" 
              id="namaKontak" 
              name="namaKontak" 
              placeholder="Nama lengkap yang bisa dihubungi"
              class="form-input" />
          </div>
          <div>
            <label for="nohp" class="form-label">Nomor HP Kontak</label>
            <input 
              type="tel" 
              id="nohp" 
              name="nohp" 
              pattern="[0-9+ ]*"
              placeholder="Contoh: 081234567890"
              class="form-input" />
          </div>
          <div>
            <label for="nohpcadangan" class="form-label">Nomor HP Cadangan <span class="optional-label">(Opsional)</span></label>
            <input 
              type="tel" 
              id="nohpcadangan" 
              name="nohpcadangan" 
              pattern="[0-9+ ]*"
              placeholder="Nomor cadangan (opsional)"
              class="form-input" />
          </div>
        </div>
      </fieldset>

      <div class="button-container">
        <button type="submit" id="btnContinue" class="btn btn-primary">
          Lanjutkan
        </button>
      </div>
    </form>

@if ($errors->any())
  <div style="background:#fee2e2;color:#b91c1c;padding:10px;border-radius:8px;margin-bottom:16px;">
    <ul style="margin:0;padding-left:18px;">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
    <script src="{{ asset('js/buatpesanan.js') }}"></script>
  </main>
</body>
</html>
