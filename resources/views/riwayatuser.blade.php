<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi</title>
    <link rel="stylesheet" href="{{ asset('css/riwayatuser.css') }}">
</head>
<body>
    <header class="animate-fade-slide-in">
        <button aria-label="Kembali ke halaman sebelumnya" id="backBtn"
            onclick="window.location.href='{{ url('/dashboard') }}'">
            &lt; Riwayat Pesanan
        </button>
    </header>
    <div class="riwayat-container animate-fade-slide-in">
        <div class="riwayat-stats">
            <div class="stat-item green">
                <div class="stat-value">{{ $totalTransaksi }}</div>
                <div class="stat-label">Total Transaksi</div>
            </div>
            <div class="stat-item blue">
                <div class="stat-value">{{ $sedangAktif }}</div>
                <div class="stat-label">Belum Selesai</div>
            </div>
            <div class="stat-item purple">
                <div class="stat-value">Rp. {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
                <div class="stat-label">Total Pengeluaran</div>
            </div>
        </div>

        @foreach($riwayats as $riwayat)
            <div class="riwayat-card animate-fade-slide-in">
                <div class="riwayat-card-header">
                    @php
                        $img = 'motor-harian.jpg';
                        if (strtolower($riwayat->jenis_layanan ?? '') !== '' && str_contains(strtolower($riwayat->jenis_layanan), 'mobil')) {
                            $img = 'mobil-harian.jpg';
                        }
                    @endphp
                    <img src="{{ asset('image/' . $img) }}" class="vehicle-img" alt="Kendaraan">
                    <div class="vehicle-info">
                        <div class="vehicle-title">{{ $riwayat->merk }} - {{ $riwayat->plat_nomor }}</div>
                        <div class="vehicle-owner">{{ $riwayat->nama_kontak ?? '-' }}</div>
                    </div>
                    @php
                        $statusMap = [
                            'completed'  => ['label' => 'Selesai',    'class' => 'green'],
                            'confirmed'  => ['label' => 'Menunggu-konfirmasi','class' => 'blue'],
                            'pending'    => ['label' => 'Menunggu-pembayaran',   'class' => 'yellow'],
                            'cancelled'  => ['label' => 'Dibatalkan', 'class' => 'red'],
                        ];
                        $status = strtolower($riwayat->status_pesanan);
                        $statusInfo = $statusMap[$status] ?? ['label' => ucfirst($status), 'class' => 'gray'];
                    @endphp
                    <span class="status-badge {{ $statusInfo['class'] }}">
                        {{ $statusInfo['label'] }}
                    </span>
                </div>
                <div class="riwayat-card-body">
                    <div class="riwayat-info">
                        <div>
                            <div class="info-label">Check In</div>
                            <div class="info-value">
                                <b>{{ \Carbon\Carbon::parse($riwayat->tanggal_mulai)->format('Y-m-d H:i') }}</b>
                            </div>
                            <div class="info-label">Durasi</div>
                            <div class="info-value">
                                {{
                                    \Carbon\Carbon::parse($riwayat->tanggal_mulai)
                                        ->diffInHours(\Carbon\Carbon::parse($riwayat->tanggal_selesai))
                                }} jam
                            </div>
                            <div class="info-label">Layanan</div>
                            <div class="info-value">
                                <span class="layanan-badge">{{ $riwayat->jenis_layanan ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="riwayat-info-right">
                            <div class="info-label">Check Out</div>
                            <div class="info-value">
                                <b>{{ \Carbon\Carbon::parse($riwayat->tanggal_selesai)->format('Y-m-d H:i') }}</b>
                            </div>
                            <div class="info-label">Total Biaya</div>
                            <div class="info-value green">
                                Rp. {{ number_format(($riwayat->biaya_layanan ?? 0) + ($riwayat->biaya_jemput ?? 0), 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <script src="{{ asset('js/riwayatuser.js') }}"></script>
</body>
</html>