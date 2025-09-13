<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Pilih Layanan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="{{ asset('css/layanan.css') }}" />
</head>
<body>
  <header class="flex items-center p-4 bg-white border-b border-gray-300 shadow-sm sticky top-0 z-20">
    <button aria-label="Kembali ke halaman sebelumnya" id="backBtn" class="text-lg font-semibold mr-3 hover:text-green-600 transition-colors"
      onclick="window.location.href='{{ url('dashboard') }}'">
      &lt; Buat Pesanan
    </button>
  </header>

  <main class="animate-fade-slide-in">
    <h1 class="page-title">Pilih jenis layanan yang Anda butuhkan</h1>
    <p class="page-subtitle">Semua layanan dilengkapi dengan keamanan 24 jam dan asuransi</p>

    <form method="POST" action="{{ url('/layanan/konfirmasi') }}">
      @csrf
      <input type="hidden" name="biaya_layanan" value="...">
      <div class="flex flex-col gap-4">
        <label>
          <input type="radio" name="layanan" value="motor-harian" class="sr-only peer" required data-harga="25000">
          <section class="service-card peer-checked:ring-2 peer-checked:ring-green-400 cursor-pointer transition" aria-labelledby="service1-title" role="region" tabindex="0">
            <div class="service-header">
              <div class="service-info">
                <div class="service-image" aria-hidden="true">
                  <img 
                    src="{{ asset('image/motor-harian.jpg') }}" 
                    alt="Skutik motor hitam dengan latar belakang abu-abu terang" 
                    onerror="this.onerror=null;this.src='https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/6b9fe3b1-c898-463e-817f-ebca38457f9d.png';"
                  />
                </div>
                <div class="service-texts">
                  <div class="service-title-wrapper">
                    <h2 id="service1-title" class="service-title">Penitipan Motor - Harian</h2>
                    <span class="badge populer" aria-label="Layanan populer">Populer</span>
                  </div>
                  <p class="service-desc">Cocok untuk parkir harian atau bekerja</p>
                </div>
              </div>
              <div class="price-wrapper" aria-label="Harga per hari">
                Rp. 25.000<span class="price-period">/hari</span>
              </div>
            </div>

            <hr class="divider" />

            <div>
              <p class="includes-title">Termasuk :</p>
              <ul>
                <li class="include-item"><span class="include-icon" aria-hidden="true">✔</span>Pengawasan CCTV 24 jam</li>
                <li class="include-item"><span class="include-icon" aria-hidden="true">✔</span>Asuransi kendaraan</li>
                <li class="include-item"><span class="include-icon" aria-hidden="true">✔</span>Akses mudah</li>
              </ul>
            </div>

            <hr class="divider" />
          </section>
        </label>

        <label>
          <input type="radio" name="layanan" value="mobil-harian" class="sr-only peer" data-harga="45000">
          <section class="service-card peer-checked:ring-2 peer-checked:ring-green-400 cursor-pointer transition" aria-labelledby="service3-title" role="region" tabindex="0">
            <div class="service-header">
              <div class="service-info">
                <div class="service-image" aria-hidden="true">
                  <img 
                    src="{{ asset('image/mobil-harian.jpg') }}" 
                    alt="Mobil putih di area penitipan mobil"
                    onerror="this.onerror=null;this.src='https://placehold.co/48x48?text=Image';"
                  />
                </div>
                <div class="service-texts">
                  <div class="service-title-wrapper">
                    <h2 id="service3-title" class="service-title">Penitipan Mobil - Harian</h2>
                    <span class="badge populer" aria-label="Layanan populer">Populer</span>
                  </div>
                  <p class="service-desc">Aman untuk parkir mobil harian</p>
                </div>
              </div>
              <div class="price-wrapper" aria-label="Harga per hari">
                Rp. 45.000<span class="price-period">/hari</span>
              </div>
            </div>
            <hr class="divider" />
            <div>
              <p class="includes-title">Termasuk :</p>
              <ul>
                <li class="include-item"><span class="include-icon" aria-hidden="true">✔</span>Pengawasan CCTV 24 jam</li>
                <li class="include-item"><span class="include-icon" aria-hidden="true">✔</span>Asuransi kendaraan</li>
                <li class="include-item"><span class="include-icon" aria-hidden="true">✔</span>Akses mudah</li>
              </ul>
            </div>
            <hr class="divider" />
          </section>
        </label>
      <div class="footer-button-wrapper">
        <button class="footer-button" type="button" aria-label="Pilih layanan saat ini" onclick="redirectLayanan()">
          Pilih Layanan
        </button>
      </div>
  </main>

  <script src="{{ asset('js/layanan.js') }}"></script>
</body>
</html>

