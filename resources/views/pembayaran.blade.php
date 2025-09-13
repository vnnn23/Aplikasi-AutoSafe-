<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Pilih Metode Pembayaran</title>
  <link rel="stylesheet" href="{{ asset('css/pembayaran.css') }}" />
</head>
<body>
  <header>
    <form id="formCancel" method="POST" action="{{ route('pesanan.hapusSementara') }}" style="display:inline;">
      @csrf
      <button type="button" aria-label="Kembali ke halaman sebelumnya" id="backBtn">
        &lt; Pilih Metode Pembayaran
      </button>
    </form>
  </header>
  <div class="page" role="main" aria-label="Pilih Metode Pembayaran">

      @php
      // Ambil data pesanan terakhir user dari database
      $pesanan = \App\Models\Datapesanan::where('id_pengguna', auth()->user()->id_pengguna)
          ->latest('id_pesanan')->first();
    @endphp

    <div class="order-summary" aria-label="Ringkasan Pesanan" style="margin-bottom:24px;">
      <strong class="title">Ringkasan Pesanan</strong>
      <div class="service-name">Layanan Jemput Kendaraan</div>
      <div class="service-type">
        {{ $pesanan->jenis_layanan ?? '-' }}
      </div>
      <div class="service-desc" aria-label="Detail kendaraan: {{ $pesanan->merk ?? '-' }} warna {{ $pesanan->warna ?? '-' }}">
        {{ $pesanan->merk ?? '-' }}<br>{{ $pesanan->warna ?? '-' }}
      </div>
      <div class="price" aria-label="Harga: Rp {{ number_format(($pesanan->biaya_layanan ?? 0) + ($pesanan->biaya_jemput ?? 0), 0, ',', '.') }}">
Rp {{ number_format(($pesanan->biaya_layanan ?? 0) + ($pesanan->biaya_jemput ?? 0), 0, ',', '.') }}
      </div>
      <div class="details">
        <div class="label">Lokasi Penitipan</div>
        <div class="value" aria-label="Lokasi: {{ $pesanan->pilihlokasi ?? '-' }}">
          {{ $pesanan->nama_lokasi ?? '-' }}
        </div>
        <div class="label">Tanggal Jemput</div>
        <div class="value" aria-label="Tanggal jemput: {{ $pesanan->tanggal_jemput ?? '-' }}">
          {{ $pesanan->tanggal_jemput ?? '-' }}
        </div>
        <div class="label">Waktu Jemput</div>
        <div class="value" aria-label="Waktu jemput: {{ $pesanan->waktu_jemput ?? '-' }}">
          {{ $pesanan->waktu_jemput ?? '-' }}
        </div>
        <div class="label">Alamat</div>
        <div class="value" aria-label="Alamat lengkap: {{ $pesanan->alamat_jemput ?? '-' }}">
          {{ $pesanan->alamat_jemput ?? '-' }}
        </div>
      </div>
    </div>

    <h2 class="select-location-title" tabindex="0">Pilih Metode Pembayaran</h2>
    <form id="paymentForm" method="GET" action="{{ route('konfirmasi.pembayaran') }}">
      @csrf
      <div id="selectDesc" class="visually-hidden">Pilih salah satu metode pembayaran dengan menggunakan tombol radio di bawah.</div>
      <div class="locations-list" role="radiogroup" aria-label="Daftar metode pembayaran">
        <label class="location-card selected option-label" tabindex="0" for="pay1" aria-checked="true" role="radio">
          <div class="location-left">
            <input type="radio" name="payment" id="pay1" value="Transfer Bank" checked>
            <div class="location-info">
              <div class="location-name">Transfer Bank</div>
              <div class="location-estimate">Mandiri, BCA, BRI, BNI</div>
            </div>
          </div>
          <div class="location-right">
            <img src="{{ asset('image/transfer-bank.png') }}" alt="Transfer Bank" style="height:32px;width:auto;" />
          </div>
        </label>
        <label class="location-card option-label" tabindex="-1" for="pay2" aria-checked="false" role="radio">
          <div class="location-left">
            <input type="radio" name="payment" id="pay2" value="E-Wallet">
            <div class="location-info">
              <div class="location-name">E-Wallet</div>
              <div class="location-estimate">OVO, GoPay, DANA, ShopeePay</div>
            </div>
          </div>
          <div class="location-right">
              <img src="{{ asset('image/E-Wallet.png') }}" alt="E-Wallet" style="height:32px;width:auto;" />
          </div>
        </label>
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
    <div class="custom-modal-title">Konfirmasi Pembatalan</div>
    <div class="custom-modal-text">Apakah Anda yakin ingin membatalkan pesanan?<br>Data yang sudah diinput akan dihapus.</div>
    <div class="custom-modal-actions">
      <button type="button" id="cancelNo" class="btn-cancel">Batal</button>
      <button type="button" id="cancelYes" class="btn-ok">Oke</button>
    </div>
  </div>
</div>

  <script src="{{ asset('js/pembayaran.js') }}"></script>
  <script>
window.routePesananComplete = "{{ route('pesanan.complete') }}";
window.csrfToken = "{{ csrf_token() }}";
window.urlHasilTransaksi = "{{ url('/hasiltransaksi') }}";
</script>
</body>
</html>

