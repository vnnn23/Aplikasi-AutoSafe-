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

document.querySelectorAll('input[name="payment"]').forEach(function(radio) {
  radio.addEventListener('change', function() {
    // Hapus .selected dari semua location-card
    document.querySelectorAll('.location-card').forEach(function(card) {
      card.classList.remove('selected');
    });
    // Tambahkan .selected pada label yang berisi radio terpilih
    this.closest('.location-card').classList.add('selected');
  });
});

document.getElementById('paymentForm').addEventListener('submit', function(e) {
  const paymentRadio = document.querySelector('input[name="payment"]:checked');
  if (!paymentRadio) {
    alert('Silakan pilih metode pembayaran terlebih dahulu.');
    e.preventDefault();
    return;
  }

  // Jika pembayaran Tunai, update status langsung via AJAX dan redirect
  if (paymentRadio.value === 'Tunai') {
    e.preventDefault();
    fetch("{{ route('pesanan.complete') }}", {
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": "{{ csrf_token() }}",
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        payment: paymentRadio.value
      })
    })
    .then(response => response.json())
    .then(data => {
      window.location.href = "{{ url('/hasiltransaksi') }}";
    });
    return;
  }
  // Jika bukan Tunai, lanjutkan submit form (ke konfirmasi pembayaran)
  // Tidak perlu e.preventDefault() di sini
});

// Tambahkan animasi bertahap pada elemen utama saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
  const page = document.querySelector('.page');
  if (page) {
    page.classList.add('animate-fade-slide-in');
    page.style.animationDelay = '0.1s';
  }
});
