<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PesananController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DashboardAutoSafeController;
use App\Http\Controllers\LokasiController;
use App\Models\Lokasi; // <- pastikan import model berada di sini
use App\Http\Controllers\AdminPesananController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/AutoSafe', function () {
    return view('AutoSafe');
});

// User
Route::get('register', [UserController::class, 'showRegister'])->name('register');
Route::post('register', [UserController::class, 'prosesregister'])->name('prosesregister');
Route::get('login', [UserController::class, 'showLogin'])->name('login');
Route::post('login', [UserController::class, 'proseslogin'])->name('proseslogin');

// Admin
Route::get('login-admin', [AdminController::class, 'showLogin'])->name('loginadmin');
Route::post('login-admin', [AdminController::class, 'proseslogin'])->name('prosesloginadmin');
Route::get('/register-admin-secret', [AdminController::class, 'showRegisterAdmin'])->name('registeradminsecret');
Route::post('/register-admin-secret', [AdminController::class, 'prosesRegisterAdmin'])->name('prosesregisteradminsecret');

// Dashboard
Route::get('/dashboard', function () {
    // ganti kondisi where sesuai kolom di database (mis. 'status' => 'aktif' atau 'aktif' => 1)
    $lokasiAktif = Lokasi::where('status', 'aktif')->orderBy('nama_lokasi')->get();
    return view('dashboard', compact('lokasiAktif'));
})->name('dashboard');
Route::get('/admindashboard', [AdminDashboardController::class, 'index'])->name('admindashboard');
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/landingpage');
})->name('logout');
Route::get('/infoakun', [PesananController::class, 'infoAkun'])->name('infoakun');
Route::get('/layanan',function () {
    return view('layanan');
})->name('layanan');
Route::get('/buatpesanan', function () {
    return view('buatpesanan');
})->name('buatpesanan');
Route::get('/landingpage',function () {
    return view('landingpage');
})->name('landingpage');
Route::post('/buatpesanan', [PesananController::class, 'store'])->middleware('auth')->name('buatpesanan.store');
Route::get('/pilihlokasi', function () {
    $lokasi = Lokasi::where('status', 'aktif')->get();
    return view('pilihlokasi', compact('lokasi'));
})->name('pilihlokasi');
Route::post('/pilihlokasi', [PesananController::class, 'simpanLokasi'])->name('pilihlokasi.simpan');
Route::get('/pembayaran', function () {
    return view('pembayaran');
})->name('pembayaran');
Route::post('/pembayaran/simpan', [PesananController::class, 'simpanPembayaran'])->name('pembayaran.simpan');
Route::post('/pesanan/hapus-sementara', [PesananController::class, 'hapusSementara'])->name('pesanan.hapusSementara');
Route::post('/pesanan/{id}/konfirmasi-tunai', [PesananController::class, 'konfirmasiTunai'])->name('pesanan.konfirmasiTunai');
Route::get('/hasiltransaksi/{id}', [PesananController::class, 'hasilTransaksi'])->name('hasiltransaksi');
Route::post('/pesanan/complete', [PesananController::class, 'completePesanan'])->name('pesanan.complete');
// Konfirmasi pesanan
Route::post('/pesanan/{id}/konfirmasi', [PesananController::class, 'konfirmasi'])->name('pesanan.konfirmasi');
Route::get('/konfirmasi-pembayaran', [PesananController::class, 'halamanKonfirmasiPembayaran'])->name('konfirmasi.pembayaran');
Route::get('/riwayatuser', [PesananController::class, 'halamanRiwayatUser'])->name('riwayat.user');
// Edit Profil User
Route::post('/editprofil', [App\Http\Controllers\UserController::class, 'updateProfil'])->middleware('auth')->name('updateprofil');
Route::post('/admin/lokasi/{id}/toggle', [AdminDashboardController::class, 'toggleLokasi'])->name('admin.toggleLokasi');
Route::get('/admin/lokasi/tambah', [AdminDashboardController::class, 'formTambahLokasi'])->name('admin.lokasi.form');
Route::post('/admin/lokasi/tambah', [AdminDashboardController::class, 'tambahLokasi'])->name('admin.lokasi.tambah');
Route::delete('/admin/lokasi/{id}/hapus', [AdminDashboardController::class, 'hapusLokasi'])->name('admin.hapusLokasi');
Route::post('/admin/lokasi/{id}/toggle', [AdminDashboardController::class, 'toggleLokasi'])->name('admin.toggleLokasi');
Route::get('/riwayat-admin', [AdminDashboardController::class, 'RiwayatUser'])->name('riwayatadmin');
Route::get('/kelola-lokasi', [AdminDashboardController::class, 'kelolaLokasi'])->name('kelolalokasi');
Route::get('/lokasi/tambah', [LokasiController::class, 'create'])->name('lokasi.tambah');
Route::post('/lokasi/store', [LokasiController::class, 'store'])->name('lokasi.store');
Route::patch('/lokasi/{id_lokasi}/nonaktif', [LokasiController::class, 'nonaktif'])->name('lokasi.nonaktif');
Route::patch('/lokasi/{id_lokasi}/aktifkan', [LokasiController::class, 'aktifkan'])->name('lokasi.aktifkan');
// Update lokasi (edit)
Route::patch('/lokasi/{id_lokasi}', [App\Http\Controllers\LokasiController::class, 'update'])->name('lokasi.update');

// Hapus lokasi
Route::delete('/lokasi/{id_lokasi}', [App\Http\Controllers\LokasiController::class, 'destroy'])->name('lokasi.destroy');
Route::get('/admin/export/pdf', [AdminController::class, 'exportPdf'])->name('admin.export.pdf');

Route::post('/admin/pesanan/{id}/cancel', [AdminPesananController::class, 'cancel'])->name('admin.pesanan.cancel');
Route::post('/admin/pesanan/{id}/complete', [AdminPesananController::class, 'complete'])->name('admin.pesanan.complete');
Route::get('/landingpage', function () {
    // Ambil lokasi aktif dari DB, sesuaikan nama kolom Anda
    $lokasiAktif = \App\Models\Lokasi::where('status', 'aktif')->orderBy('nama_lokasi')->get();

    return view('landingpage', compact('lokasiAktif'));
})->name('landingpage');
