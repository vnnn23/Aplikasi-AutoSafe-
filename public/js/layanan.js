function goBack() {
  if(window.history.length > 1) {
    window.history.back();
  } else {
    alert('Tidak ada halaman sebelumnya.');
  }
}

// Accessible keyboard support for header "button"
const header = document.querySelector('.header');
if (header) {
  header.addEventListener('keydown', (event) => {
    if(event.key === 'Enter' || event.key === ' ') {
      event.preventDefault();
      goBack();
    }
  });
}

function redirectLayanan() {
  const layanan = document.querySelector('input[name="layanan"]:checked');
  if (!layanan) {
    alert('Silakan pilih layanan terlebih dahulu.');
    return;
  }
  window.location.href = "/buatpesanan?layanan=" + encodeURIComponent(layanan.value);
}

// Set harga ke input hidden saat radio dipilih
document.querySelectorAll('input[name="layanan"]').forEach(function(radio) {
  radio.addEventListener('change', function() {
    const hargaInput = document.getElementById('biaya_layanan');
    if (hargaInput) {
      hargaInput.value = this.getAttribute('data-harga');
    }
  });
});