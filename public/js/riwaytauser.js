// Tambahkan delay animasi bertahap untuk setiap card
document.addEventListener('DOMContentLoaded', function() {
  const cards = document.querySelectorAll('.riwayat-card');
  cards.forEach((card, index) => {
    card.style.animationDelay = `${index * 0.1}s`;
  });
});