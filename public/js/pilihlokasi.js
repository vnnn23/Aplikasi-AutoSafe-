// Tambahkan animasi bertahap pada elemen utama saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
  const page = document.querySelector('.page');
  if (page) {
    page.classList.add('animate-fade-slide-in');
    page.style.animationDelay = '0.1s';
  }
});

// Ambil biaya jemput dari atribut data-biaya radio
document.querySelectorAll('input[name="location"]').forEach(function(radio) {
  radio.addEventListener('change', function() {
    document.querySelectorAll('.location-card').forEach(function(card) {
      card.classList.remove('selected');
    });
    this.closest('.location-card').classList.add('selected');
    document.getElementById('biaya_jemput').value = this.getAttribute('data-biaya') || 0;
  });
});

// Pastikan input hidden terisi saat submit
document.getElementById('locationForm').addEventListener('submit', function(e) {
  const checkedRadio = document.querySelector('input[name="location"]:checked');
  if (checkedRadio) {
    document.getElementById('biaya_jemput').value = checkedRadio.getAttribute('data-biaya') || 0;
  }
});

// Konfirmasi Pembatalan
document.getElementById('backBtn').addEventListener('click', function(e) {
  e.preventDefault();
  document.getElementById('cancelModal').classList.add('show');
});

document.getElementById('cancelNo').addEventListener('click', function() {
  document.getElementById('cancelModal').classList.remove('show');
});

document.getElementById('cancelYes').addEventListener('click', function() {
  document.getElementById('formCancel').submit();
});