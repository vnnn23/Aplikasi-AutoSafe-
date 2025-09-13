// Script untuk fitur pembayaran di halaman konfirmasi pembayaran

// Tambahkan animasi pada form-container saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
  const form = document.querySelector('.form-container');
  if (form) {
    form.classList.add('animate-fade-slide-in');
    form.style.animationDelay = '0.1s';
  }
});

// Untuk Transfer Bank: update VA dan copy VA
if (typeof window.vaList !== "undefined") {
  window.updateVA = function(bank) {
    document.getElementById('virtual_account').innerText = window.vaList[bank];
  };
  window.copyVA = function() {
    const va = document.getElementById('virtual_account').innerText;
    navigator.clipboard.writeText(va);
    alert('Virtual Account berhasil disalin!');
  };
}

// Data VA untuk masing-masing bank (harus diisi dari blade sebagai window.vaList)
function updateVA(bank) {
    document.getElementById('virtual_account').innerText = window.vaList[bank];
}
function copyVA() {
    const va = document.getElementById('virtual_account').innerText;
    navigator.clipboard.writeText(va);
    alert('Virtual Account berhasil disalin!');
}

function toggleQrisForm() {
    var radios = document.getElementsByName('ewallet_tujuan');
    var showQris = false;
    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked && radios[i].value === 'QRIS') {
            showQris = true;
            break;
        }
    }
    document.getElementById('ewallet-form-fields').style.display = showQris ? 'none' : 'block';
    document.getElementById('qris-image').style.display = showQris ? 'block' : 'none';

    // Hilangkan required jika QRIS, aktifkan jika bukan QRIS
    var inputs = document.querySelectorAll('#ewallet-form-fields input');
    inputs.forEach(function(input) {
        if (showQris) {
            input.removeAttribute('required');
        } else {
            input.setAttribute('required', 'required');
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    if (typeof toggleQrisForm === 'function') toggleQrisForm();

    // Auto focus ke input berikutnya
    document.querySelectorAll('.pin-bulat').forEach((el, idx, arr) => {
        el.addEventListener('input', function() {
            if (this.value.length === 1 && idx < arr.length - 1) {
                arr[idx + 1].focus();
            }
        });
        el.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && idx > 0) {
                arr[idx - 1].focus();
            }
        });
    });

    // Tambahkan animasi pada form-container saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.querySelector('.form-container');
      if (form) {
        form.classList.add('animate-fade-slide-in');
        form.style.animationDelay = '0.1s';
      }
    });
});