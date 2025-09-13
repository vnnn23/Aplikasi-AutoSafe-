<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\Datapesanan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $datapesanan = Datapesanan::orderByDesc('created_at')->get();
        $lokasi = Lokasi::all();
        $totalLokasiAktif = Lokasi::where('status', 'aktif')->count();
        $totalTransaksi = Datapesanan::count();
        $totalPendapatan = Datapesanan::sum('biaya_layanan');

        // Hitung jumlah motor/mobil & pendapatan hari ini per lokasi (tambahkan ini)
        foreach ($lokasi as $l) {
            $l->jumlah_motor = Datapesanan::where('nama_lokasi', $l->nama_lokasi)
                ->where('jenis_layanan', 'motor-harian')
                ->count();

            $l->jumlah_mobil = Datapesanan::where('nama_lokasi', $l->nama_lokasi)
                ->where('jenis_layanan', 'mobil-harian')
                ->count();

            $l->pendapatan_hari_ini = Datapesanan::where('nama_lokasi', $l->nama_lokasi)
                ->whereDate('created_at', Carbon::today())
                ->sum('biaya_layanan');
        }

        return view('admindashboard', compact('datapesanan', 'lokasi', 'totalLokasiAktif', 'totalTransaksi', 'totalPendapatan'));
    }
    public function formTambahLokasi()
    {
        return view('tambah_lokasi');
    }
    public function tambahLokasi(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'biaya_jemput' => 'required|numeric',
            'status' => 'required',
        ]);

        Lokasi::create([
            'nama_lokasi' => $request->nama_lokasi,
            'biaya_jemput' => $request->biaya_jemput,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Lokasi berhasil ditambahkan!');
    }

    public function toggleLokasi($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        $lokasi->status = $lokasi->status === 'aktif' ? 'nonaktif' : 'aktif';
        $lokasi->save();

        return redirect()->back()->with('success', 'Status lokasi berhasil diubah.');
    }

    public function hapusLokasi($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        $lokasi->delete();
        return redirect()->back()->with('success', 'Lokasi berhasil dihapus.');
    }

    public function RiwayatUser()
    {
        $datapesanan = \App\Models\Datapesanan::orderByDesc('created_at')->get();
        $totalPendapatan = \App\Models\Datapesanan::sum('biaya_layanan');
        $transaksiAktif = \App\Models\Datapesanan::count();
        return view('riwayatadmin', compact('datapesanan', 'transaksiAktif', 'totalPendapatan'));
    }
    public function kelolaLokasi()
    {
        $lokasi = Lokasi::all();

        // Hitung jumlah motor/mobil & pendapatan hari ini per lokasi
        foreach ($lokasi as $l) {
            $l->jumlah_motor = Datapesanan::where('nama_lokasi', $l->nama_lokasi)
                ->where('jenis_layanan', 'motor-harian')
                ->count();

            $l->jumlah_mobil = Datapesanan::where('nama_lokasi', $l->nama_lokasi)
                ->where('jenis_layanan', 'mobil-harian')
                ->count();

            $l->pendapatan_hari_ini = Datapesanan::where('nama_lokasi', $l->nama_lokasi)
                ->whereDate('created_at', Carbon::today())
                ->sum('biaya_layanan');
        }

        return view('kelolalokasi', compact('lokasi'));
    }

public function cancel($id)
{
    $pesanan = Pesanan::findOrFail($id);
    if ($pesanan->status_pesanan == 'confirmed') {
        $pesanan->status_pesanan = 'cancelled';
        $pesanan->save();
    }
    return back()->with('success', 'Pesanan berhasil dibatalkan.');
}

public function complete($id)
{
    $pesanan = Pesanan::findOrFail($id);
    if ($pesanan->status_pesanan == 'confirmed') {
        $pesanan->status_pesanan = 'completed';
        $pesanan->save();
    }
    return back()->with('success', 'Pesanan berhasil dikonfirmasi selesai.');
}
    public function suratKendaraan()
{
    $datapesanan = Datapesanan::orderByDesc('created_at')->get();

    // Tambahkan konversi BLOB ke base64 di sini!
    foreach ($datapesanan as $p) {
        if (!empty($p->surat)) {
            $finfo = finfo_open();
            $mime = finfo_buffer($finfo, $p->surat, FILEINFO_MIME_TYPE);
            finfo_close($finfo);
            $p->surat_base64 = 'data:' . $mime . ';base64,' . base64_encode($p->surat);
        } else {
            $p->surat_base64 = null;
        }
    }

    // Kirim ke view
    return view('riwayatadmin', compact('datapesanan'));
}
}

