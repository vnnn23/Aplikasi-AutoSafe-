<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pembayaran</title>
    <link rel="stylesheet" href="{{ asset('css/konfirmasi.css') }}">
</head>
<body>
<div class="form-container">
    @php
        // Nomor VA default untuk masing-masing bank
        $vaList = [
            'BCA' => $pesanan->va_bca ?? '3901 0855 6789 8012',
            'Mandiri' => $pesanan->va_mandiri ?? '8950 0855 6789 8012',
            'BNI' => $pesanan->va_bni ?? '8810 0855 6789 8012',
            'BRI' => $pesanan->va_bri ?? '8881 0855 6789 8012',
        ];
        $virtualAccount = $vaList['BCA'];
    @endphp

    <div class="metode-pembayaran-label">
        <div>{{ $pesanan->metode_pembayaran }}</div>
    </div>

    @if($pesanan->metode_pembayaran === 'Transfer Bank')
        <form method="POST" action="{{ route('pesanan.konfirmasi', $pesanan->id_pesanan) }}">
            @csrf
            <div class="form-group bank-group">
                <label class="bank-label">Pilih Bank Tujuan</label>
                <div class="bank-list">
                    <label>
                        <input type="radio" name="bank_tujuan" value="BCA" checked onchange="updateVA(this.value)">
                        <img src="{{ asset('image/BCA.jpg') }}" alt="BCA">
                    </label>
                    <label>
                        <input type="radio" name="bank_tujuan" value="Mandiri" onchange="updateVA(this.value)">
                        <img src="{{ asset('image/MANDIRI.jpg') }}" alt="Mandiri">
                    </label>
                    <label>
                        <input type="radio" name="bank_tujuan" value="BNI" onchange="updateVA(this.value)">
                        <img src="{{ asset('image/BNI.jpg') }}" alt="BNI">
                    </label>
                    <label>
                        <input type="radio" name="bank_tujuan" value="BRI" onchange="updateVA(this.value)">
                        <img src="{{ asset('image/BRI.jpg') }}" alt="BRI">
                    </label>
                </div>
                <div class="va-container">
                    <label for="virtual_account" class="va-label">Virtual Account</label>
                    <div class="va-value-container">
                        <span id="virtual_account" class="va-value">
                            {{ $virtualAccount }}
                        </span>
                        <button type="button" onclick="copyVA()" class="btn-copy-va">
                            <img src="{{ asset('image/copy.png') }}" alt="Copy">
                        </button>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-success btn-konfirmasi">
                Konfirmasi Pembayaran
            </button>
        </form>
        <script>
            window.vaList = @json($vaList);
        </script>
    @elseif($pesanan->metode_pembayaran === 'E-Wallet')
        <div class="total-bayar">
            <span>
                Rp {{ number_format(($pesanan->biaya_layanan ?? 0) + ($pesanan->biaya_jemput ?? 0) + ($pesanan->biaya_admin ?? 0), 0, ',', '.') }}
            </span>
        </div>
        <h2 class="form-title">Konfirmasi Pembayaran</h2>
        <form method="POST" action="{{ route('pesanan.konfirmasi', $pesanan->id_pesanan) }}">
            @csrf
            <div class="ewallet-icons">
                <img src="{{ asset('image/ovo.jpg') }}" alt="OVO">
                <img src="{{ asset('image/dana.jpg') }}" alt="DANA">
                <img src="{{ asset('image/gopay.jpg') }}" alt="GoPay">
                <img src="{{ asset('image/qris.jpg') }}" alt="QRIS">
            </div>
            <div id="qris-image" class="qris-image">
                <img src="{{ asset('image/qr.jpg') }}" alt="QRIS">
                <div class="qris-instruksi">Silakan scan QRIS untuk pembayaran</div>
            </div>
            <button type="submit" class="btn-success btn-konfirmasi">
                Konfirmasi Pembayaran
            </button>
        </form>
    @elseif($pesanan->metode_pembayaran === 'Tunai')
        <form method="POST" action="{{ route('pesanan.konfirmasiTunai', $pesanan->id_pesanan) }}">
            @csrf
            <!-- input lain jika perlu -->
            <button type="submit" class="btn-success btn-konfirmasi">Konfirmasi Pembayaran</button>
        </form>
    @endif
</div>
<script src="{{ asset('js/konfirmasipembayaran.js') }}"></script>
</body>
</html>
