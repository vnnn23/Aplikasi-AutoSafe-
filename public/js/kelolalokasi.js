document.addEventListener('DOMContentLoaded', function() {
    // Animasi masuk halaman utama
    const mainContent = document.querySelector('.main-content');
    if (mainContent) {
        mainContent.classList.add('animate-fade-in-up-admin');
    }

    const btnTambah = document.getElementById('btnTambahLokasi');
    const modalTambah = document.getElementById('modalTambahLokasi');
    const closeModalTambah = document.getElementById('closeModalTambahLokasi');
    btnTambah.addEventListener('click', function(e) {
      e.preventDefault();
      modalTambah.style.display = 'flex';
    });
    closeModalTambah.addEventListener('click', function() {
      modalTambah.style.display = 'none';
    });
    window.onclick = function(event) {
      if (event.target === modalTambah) {
        modalTambah.style.display = 'none';
      }
      if (event.target === document.getElementById('modalEditLokasi')) {
        document.getElementById('modalEditLokasi').style.display = 'none';
      }
    }
    

    // Edit Lokasi
    document.querySelectorAll('.btn-edit-lokasi').forEach(function(btn) {
      btn.addEventListener('click', function() {
        document.getElementById('modalEditLokasi').style.display = 'flex';
        document.getElementById('edit_id_lokasi').value = btn.dataset.id;
        document.getElementById('edit_nama_lokasi').value = btn.dataset.nama;
        document.getElementById('edit_biaya_jemput').value = btn.dataset.biaya;
        document.getElementById('edit_alamat_lokasi').value = btn.dataset.alamat;
        document.getElementById('edit_nama_manajer').value = btn.dataset.manajer;
        // Set form action
        document.getElementById('formEditLokasi').action = '/lokasi/' + btn.dataset.id;
        document.getElementById('formHapusLokasi').action = '/lokasi/' + btn.dataset.id;
      });
    });
    document.getElementById('closeModalEditLokasi').onclick = function() {
      document.getElementById('modalEditLokasi').style.display = 'none';
    };

    document.querySelector('.logout-btn').addEventListener('click', function() {
      if (confirm('Apakah Anda yakin ingin logout dari akun Admin AutoSafe?')) {
        window.location.href = window.routeLandingpage;
      }
    });
});
