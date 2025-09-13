<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil - AutoSafe</title>
    <link rel="stylesheet" href="{{ asset('css/hasiltransaksi.css') }}">
</head>
<body>
    <!-- Tambahkan setelah audio -->
    <audio id="success-audio" src="{{ asset('audio/success.mp3') }}" preload="auto"></audio>
    <canvas class="confetti" id="confetti-canvas"></canvas>
    <div class="container animate-fade-in-up">
        <div class="success-header">
            <div class="success-icon">
                <!-- SVG centang animasi, lebih modern -->
                <svg class="checkmark-svg" viewBox="0 0 52 52">
                    <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                    <path class="checkmark-check" fill="none" d="M14 27l7 7 16-16"/>
                </svg>
            </div>
            <h1 class="success-title">
                <!-- SVG confetti icon kiri -->
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" style="vertical-align:middle;">
                    <path fill="#22c55e" d="M2 22l5.5-16.5L22 2l-4.5 14.5L2 22z" opacity="0.2"/>
                    <path stroke="#22c55e" stroke-width="2" d="M2 22l5.5-16.5L22 2l-4.5 14.5L2 22z"/>
                    <circle fill="#22c55e" cx="7" cy="7" r="1"/>
                    <circle fill="#22c55e" cx="17" cy="5" r="1"/>
                    <circle fill="#22c55e" cx="12" cy="12" r="1"/>
                </svg>
                Pembayaran Berhasil!
                <!-- SVG confetti icon kanan -->
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" style="vertical-align:middle;">
                    <path fill="#22c55e" d="M2 22l5.5-16.5L22 2l-4.5 14.5L2 22z" opacity="0.2"/>
                    <path stroke="#22c55e" stroke-width="2" d="M2 22l5.5-16.5L22 2l-4.5 14.5L2 22z"/>
                    <circle fill="#22c55e" cx="7" cy="7" r="1"/>
                    <circle fill="#22c55e" cx="17" cy="5" r="1"/>
                    <circle fill="#22c55e" cx="12" cy="12" r="1"/>
                </svg>
            </h1>
            <p class="success-subtitle">Terima kasih telah menggunakan <b>AutoSafe</b> 🚗</p>
        </div>

        <div class="details-section">
            <div class="details-header">
                <h3 class="details-title">Detail Transaksi</h3>
                <span class="status-badge status-badge-gradient">Berhasil</span>
            </div>
            <div class="transaction-info">
                <div class="info-item">
                    <div class="info-label">ID Transaksi</div>
                    <div class="info-value">IDX000{{ $pesanan->id_pesanan ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Tempat</div>
                    <div class="info-value">{{ $pesanan->nama_lokasi ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Tanggal</div>
                    <div class="info-value">
                        {{ \Carbon\Carbon::parse($pesanan->tanggal_mulai ?? now())->format('d/m/Y') }}
                    </div>
                </div>
            </div>
            <div class="details-grid">
                <div class="detail-row">
                    <span class="detail-label">Layanan</span>
                    <span class="detail-value">{{ $pesanan->jenis_layanan ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Kendaraan</span>
                    <span class="detail-value">{{ $pesanan->merk ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Plat Nomor</span>
                    <span class="detail-value">{{ $pesanan->plat_nomor ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Pembayaran</span>
                    <span class="detail-value">{{ $pesanan->metode_pembayaran ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div class="buttons-container">
            <button class="btn btn-primary" onclick="goHome()">
                Kembali ke Beranda
            </button>
            <button class="btn btn-secondary" onclick="viewHistory()">
                Lihat Riwayat
            </button>
        </div>
    </div>

    <script src="{{ asset('js/hasiltransaksi.js') }}"></script>
</body>
</html>
