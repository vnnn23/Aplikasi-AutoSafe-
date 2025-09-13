<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class AdminPesananController extends Controller
{
    public function cancel($id)
    {
        $pesanan = Pesanan::where('id_pesanan', $id)->firstOrFail(); // changed line
        if ($pesanan->status_pesanan == 'confirmed') {
            $pesanan->status_pesanan = 'cancelled';
            $pesanan->save();
        }
        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function complete($id)
    {
        $pesanan = Pesanan::where('id_pesanan', $id)->firstOrFail(); // changed line
        if ($pesanan->status_pesanan == 'confirmed') {
            $pesanan->status_pesanan = 'completed';
            $pesanan->save();
        }
        return back()->with('success', 'Pesanan berhasil dikonfirmasi selesai.');
    }

    public function index()
    {
        $datapesanan = Pesanan::all();

        // Hitung total pendapatan hanya dari pesanan yang selesai
        $totalPendapatan = Pesanan::where('status_pesanan', 'completed')
            ->sum('biaya_layanan');

        // Hitung transaksi aktif (semua status)
        $transaksiAktif = $datapesanan->count();

        return view('riwayatadmin', compact('datapesanan', 'totalPendapatan', 'transaksiAktif'));
    }
}