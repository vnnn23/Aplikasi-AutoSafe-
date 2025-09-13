<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Pilih Lokasi Penitipan</title>
  <link rel="stylesheet" href="{{ asset('css/pilihlokasi.css') }}" />
</head>
<body>
      <header>
    <form id="formCancel" method="POST" action="{{ route('pesanan.hapusSementara') }}" style="display:inline;">
      @csrf
      <button type="button" aria-label="Kembali ke halaman sebelumnya" id="backBtn">
        &lt; Pilih Lokasi
      </button>
    </form>
  </header>
    <div class="page" role="main" aria-label="Pilih Lokasi Penitipan">


@php
  $form = session('form_pesanan', []);
@endphp

<section class="pickup-address-container" aria-label="Alamat Penjemputan Anda">
  <div class="pickup-label" tabindex="0">Alamat Penjemputan Anda</div>
  <p class="pickup-address" tabindex="0">
    {{ $form['alamatLengkap'] ?? 'Alamat belum diisi' }}
  </p>
  <p class="pickup-desc" tabindex="0">
    Patokan {{ $form['patokan'] ?? '-' }}
  </p>
  <div class="pickup-schedule" aria-label="Jadwal Jemput">
    <div class="pickup-schedule-label">Jadwal Jemput</div>
    <div class="pickup-schedule-time" tabindex="0">
      {{ 
        (!empty($form['tanggalJemput']) && !empty($form['waktuJemput']))
          ? \Carbon\Carbon::parse($form['tanggalJemput'])->translatedFormat('l, j F Y') . ' • ' . $form['waktuJemput']
          : 'Belum dipilih'
      }}
    </div>
  </div>
</section>

    <h2 class="select-location-title" tabindex="0">Pilih Lokasi Penitipan</h2>
    <form id="locationForm" method="POST" action="{{ route('pilihlokasi.simpan') }}">
      @csrf
      <input type="hidden" name="biaya_jemput" id="biaya_jemput" value="10000">
      <div id="selectDesc" class="visually-hidden">Pilih salah satu lokasi penitipan dengan menggunakan tombol radio di bawah.</div>
      <div class="locations-list" role="radiogroup" aria-label="Daftar lokasi penitipan">
        @php
          $lokasiAktif = $lokasi->where('status', 'aktif');
        @endphp

        @if($lokasiAktif->isEmpty())
          <div class="no-location-msg" style="padding:32px 0;text-align:center;color:#888;font-size:1.1rem;">
            Mohon maaf lokasi belum tersedia
          </div>
        @else
          @foreach($lokasiAktif as $i => $l)
            <label class="location-card{{ $i === 0 ? ' selected' : '' }}" tabindex="{{ $i === 0 ? '0' : '-1' }}" for="loc{{ $l->id_lokasi }}" aria-checked="{{ $i === 0 ? 'true' : 'false' }}" role="radio">
              <div class="location-left">
                <input type="radio" name="location" id="loc{{ $l->id_lokasi }}" value="{{ $l->nama_lokasi }}" data-biaya="{{ $l->biaya_jemput }}" {{ $i === 0 ? 'checked' : '' }}>
                <div class="location-info">
                  <div class="location-name">{{ $l->nama_lokasi }}</div>
                  <div class="location-estimate">Estimasi Penjemputan <strong>0-1 jam</strong></div>

                  <!-- Tambahan: tampilkan alamat_lokasi di bawah estimasi -->
                  <div class="location-address" aria-label="Alamat lokasi" tabindex="0">
                    {{ $l->alamat_lokasi ?? $l->alamat ?? '-' }}
                  </div>
                </div>
              </div>
              <div class="location-right">
                <div class="pickup-cost" aria-label="Biaya Penjemputan">+ Rp {{ number_format($l->biaya_jemput,0,',','.') }}</div>
                <div class="status-badge status-optimal" aria-label="Status Optimal">AKTIF</div>
              </div>
            </label>
          @endforeach
        @endif
      </div>

      <div class="btns-container">
        <button type="submit" class="btn-next" id="btnNext" tabindex="0" aria-label="Lanjutkan ke proses berikutnya">Lanjutkan</button>
      </div>
    </form>
  </div>

  <!-- Pop Up Konfirmasi Pembatalan -->
<div id="cancelModal" class="custom-modal">
  <div class="custom-modal-content">
    <div class="custom-modal-icon">
      <span>!</span>
    </div>
    <div class="custom-modal-title">Close</div>
    <div class="custom-modal-text">Apakah anda yakin ingin membatalkan pesanan?</div>
    <div class="custom-modal-actions">
      <button type="button" id="cancelNo" class="btn-cancel">Batal</button>
      <button type="button" id="cancelYes" class="btn-ok">Oke</button>
    </div>
  </div>
</div>
<script src="{{ asset('js/pilihlokasi.js') }}"></script>
</body>
</html>

