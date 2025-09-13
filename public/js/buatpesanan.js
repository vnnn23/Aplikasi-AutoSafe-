// Preview & hapus file upload
const suratInput = document.getElementById('surat');
const suratLabel = document.getElementById('suratLabel');
const previewBox = document.getElementById('previewBox');
const filePreview = document.getElementById('filePreview');
const clearFileBtn = document.getElementById('clearFileBtn');

suratInput.addEventListener('change', () => {
  if (suratInput.files.length > 0) {
    const file = suratInput.files[0];
    suratLabel.textContent = file.name.length > 30 ? file.name.slice(0, 27) + '...' : file.name;
    if (file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function(e) {
        filePreview.src = e.target.result;
        filePreview.classList.remove('hidden');
        previewBox.classList.remove('hidden');
      }
      reader.readAsDataURL(file);
    } else {
      filePreview.src = '';
      filePreview.classList.add('hidden');
      previewBox.classList.remove('hidden');
    }
  } else {
    suratLabel.textContent = 'Upload foto disini';
    filePreview.src = '';
    filePreview.classList.add('hidden');
    previewBox.classList.add('hidden');
  }
});

clearFileBtn.addEventListener('click', () => {
  suratInput.value = '';
  suratLabel.textContent = 'Upload foto disini';
  filePreview.src = '';
  filePreview.classList.add('hidden');
  previewBox.classList.add('hidden');
});


  // Ambil elemen tanggal
  const tanggalMulai = document.getElementById('tanggalMulai');
  const tanggalSelesai = document.getElementById('tanggalSelesai');
  const tanggalJemput = document.getElementById('tanggalJemput');

  // Saat tanggal mulai berubah, set tanggal jemput = tanggal mulai & min tanggal jemput = tanggal mulai
  tanggalMulai.addEventListener('change', function() {
    tanggalSelesai.value = '';
    tanggalJemput.value = this.value;         // <-- Set tanggal jemput sama dengan tanggal mulai
    tanggalSelesai.min = this.value;
    tanggalJemput.min = this.value;
  });

  // Saat tanggal selesai berubah, set min tanggal jemput tetap tanggal mulai
  tanggalSelesai.addEventListener('change', function() {
    tanggalJemput.value = tanggalMulai.value; // <-- Pastikan tanggal jemput tetap tanggal mulai
    tanggalJemput.min = tanggalMulai.value;
  });

  // Set min tanggal mulai ke hari ini
  const today = new Date();
  const yyyy = today.getFullYear();
  const mm = String(today.getMonth() + 1).padStart(2, '0');
  const dd = String(today.getDate()).padStart(2, '0');
  const minDate = `${yyyy}-${mm}-${dd}`;
  tanggalMulai.min = minDate;

  document.getElementById('orderForm').addEventListener('submit', function(e) {
  const requiredFields = [
    'merk', 'surat', 'warna', 'plat', 'catatan',
    'tanggalMulai', 'tanggalSelesai',
    'alamatLengkap', 'patokan', 'instruksi',
    'tanggalJemput', 'waktuJemput',
    'namaKontak', 'nohp'
  ];
  for (const field of requiredFields) {
    const input = document.getElementById(field);
    if (!input || !input.value.trim() || (input.type === 'file' && input.files.length === 0)) {
      e.preventDefault();
      input && input.focus();
      alert('Mohon lengkapi semua field wajib.');
      return false;
    }
  }
  // Tambahkan pop up konfirmasi
  if(!confirm('Apakah Anda yakin data yang diinput sudah benar?')) {
    e.preventDefault();
    return false;
  }
  // Jika user klik OK, form akan terkirim ke server
});

// Fungsi hitung harga dinamis
function hitungHarga() {
  // Ambil jenis layanan dari input hidden
  const layanan = document.querySelector('input[name="layanan"]').value;
  const tglMulai = document.getElementById('tanggalMulai').value;
  const tglSelesai = document.getElementById('tanggalSelesai').value;
  let harga = 0;

  if (tglMulai && tglSelesai) {
    const start = new Date(tglMulai);
    const end = new Date(tglSelesai);
    let diffDays = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
    if (diffDays < 1) diffDays = 1;

    if (layanan === 'motor-harian') {
      harga = 25000 + (diffDays - 1) * 10000;
    } else if (layanan === 'mobil-harian') {
      harga = 45000 + (diffDays - 1) * 15000;
    }
  }

  document.getElementById('hargaPreview').value = harga > 0 ? 'Rp ' + harga.toLocaleString('id-ID') : 'Rp -';
  document.getElementById('biaya_layanan').value = harga;
}

// Trigger saat tanggal berubah
document.getElementById('tanggalMulai').addEventListener('change', hitungHarga);
document.getElementById('tanggalSelesai').addEventListener('change', hitungHarga);

// Inisialisasi harga awal
document.addEventListener('DOMContentLoaded', hitungHarga);

// Tambahkan animasi bertahap pada elemen utama saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
  // Tambahkan animasi pada elemen utama
  const main = document.querySelector('main');
  const banner = document.querySelector('.banner-section');
  if (banner) {
    banner.classList.add('animate-fade-slide-in');
    banner.style.animationDelay = '0.1s';
  }
  if (main) {
    main.classList.add('animate-fade-slide-in');
    main.style.animationDelay = '0.2s';
  }
});