// Modal Edit Profil
window.openEditModal = function() {
  const modal = document.getElementById('editProfileModal');
  modal.style.display = 'flex';
  setTimeout(() => {
    document.getElementById('modal_nama').focus();
  }, 100);
};
window.closeEditModal = function() {
  document.getElementById('editProfileModal').style.display = 'none';
};

// Modal Logout
document.getElementById('logoutBtn').addEventListener('click', function(e) {
  e.preventDefault();
  document.getElementById('logoutModal').classList.add('show');
});
document.getElementById('logoutCancel').addEventListener('click', function() {
  document.getElementById('logoutModal').classList.remove('show');
});
document.getElementById('logoutOk').addEventListener('click', function() {
  document.getElementById('logout-form').submit();
});

// Tambahkan animasi bertahap pada elemen utama saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
  // Tambahkan animasi pada profile card dan container
  const profileCard = document.querySelector('.profile-card');
  const profileStats = document.querySelector('.profile-stats');
  if (profileCard) {
    profileCard.classList.add('animate-fade-slide-in');
    profileCard.style.animationDelay = '0.1s';
  }
  if (profileStats) {
    profileStats.classList.add('animate-fade-slide-in');
    profileStats.style.animationDelay = '0.3s';
  }
});