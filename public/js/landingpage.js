function showLoginAlert(e) {
  e.preventDefault();
  const modal = document.getElementById('loginModal');
  modal.style.display = 'flex';
  // Fokus ke tombol login
  setTimeout(() => document.getElementById('modalLogin').focus(), 100);
}

document.getElementById('modalCancel').onclick = function() {
  document.getElementById('loginModal').style.display = 'none';
};
document.getElementById('modalLogin').onclick = function() {
  window.location.href = '/login';
};

// Tombol Pesan Jemput Kendaraan Sekarang
const orderBtn = document.getElementById('orderBtn');
if(orderBtn) orderBtn.addEventListener('click', showLoginAlert);

// Link Lainnya >
const serviceLink = document.querySelector('.service-link');
if(serviceLink) serviceLink.addEventListener('click', showLoginAlert);

// Service List (Penitipan Motor/Mobil)
document.querySelectorAll('.service-item').forEach(item => {
  item.addEventListener('click', showLoginAlert);
});

// Bottom Navigation: Riwayat & Akun
document.querySelectorAll('.bottom-nav .nav-item').forEach(item => {
  const label = item.textContent.trim().toLowerCase();
  if(label === 'riwayat' || label === 'akun') {
    item.addEventListener('click', showLoginAlert);
  }
});