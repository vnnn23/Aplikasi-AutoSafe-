document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.filter-search');
    const transaksiCards = document.querySelectorAll('.transaksi-detail-card');
    const countSpan = document.getElementById('transaksi-count');
    const resetBtn = document.querySelector('.filter-reset');

    function filterTransaksi() {
        const keyword = searchInput.value.toLowerCase();
        let visible = 0;
        transaksiCards.forEach(function(card) {
            const nama = card.querySelector('.transaksi-detail-nama')?.textContent.toLowerCase() || '';
            if (nama.includes(keyword)) {
                card.style.display = '';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });
        countSpan.textContent = `Menampilkan ${visible} dari ${transaksiCards.length} transaksi`;
    }

    searchInput.addEventListener('input', filterTransaksi);

    resetBtn.addEventListener('click', function() {
        searchInput.value = '';
        filterTransaksi();
    });
});

document.querySelector('.logout-btn').addEventListener('click', function() {
    if (confirm('Apakah Anda yakin ingin logout dari akun Admin AutoSafe?')) {
        window.location.href = "{{ route('landingpage') }}";
    }
});

document.querySelectorAll('.transaksi-surat img').forEach(function(img) {
  img.style.cursor = 'pointer';
  img.addEventListener('click', function() {
    document.getElementById('modalSuratImg').src = img.src;
    document.getElementById('modalSurat').classList.add('active');
  });
});
document.getElementById('closeModalSurat').onclick = function() {
  document.getElementById('modalSurat').classList.remove('active');
};
document.getElementById('modalSurat').onclick = function(e) {
  if (e.target === this) this.classList.remove('active');
};

// Animasi masuk untuk halaman riwayat admin
document.addEventListener('DOMContentLoaded', function() {
  const mainContent = document.querySelector('.main-content');
  if (mainContent) {
    mainContent.classList.add('animate-fade-in-up-admin');
  }
});