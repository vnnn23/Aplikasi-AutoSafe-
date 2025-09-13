<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Datapesanan;
use Auth;

class PesananController extends Controller
{
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'layanan' => 'required',
            'merk' => 'required',
            'surat' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'warna' => 'required',
            'plat' => 'required',
            'catatan' => 'required',
            'tanggalMulai' => 'required|date',
            'tanggalSelesai' => 'required|date',
            'alamatLengkap' => 'required',
            'patokan' => 'required',
            'instruksi' => 'required',
            'tanggalJemput' => 'required|date',
            'waktuJemput' => 'required',
            'namaKontak' => 'required',
            'nohp' => 'required',
        ]);

        // Simpan file ke folder storage/app/public/uploads
        $path = $request->file('surat')->store('uploads', 'public');

        // Path yang akan disimpan ke database
        $suratPath = 'storage/' . $path;

        Datapesanan::create([
            'id_pengguna'        => auth()->user()->id_pengguna,
            'jenis_layanan'      => $request->layanan,
            'merk'               => $request->merk,
            'surat'              => $suratPath, // gunakan path yang baru
            'warna'              => $request->warna,
            'plat_nomor'         => $request->plat,
            'catatan'            => $request->catatan,
            'tanggal_mulai'      => $request->tanggalMulai,
            'tanggal_selesai'    => $request->tanggalSelesai,
            'alamat_jemput'      => $request->alamatLengkap,
            'patokan'            => $request->patokan,
            'instruksi'          => $request->instruksi,
            'tanggal_jemput'     => $request->tanggalJemput,
            'waktu_jemput'       => $request->waktuJemput,
            'nama_kontak'        => $request->namaKontak,
            'no_hp_kontak'       => $request->nohp,
            'no_hp_kontak_cadangan' => $request->nohpcadangan,
            'biaya_layanan'      => $request->biaya_layanan,
            'created_at'         => now()
        ]);

        session(['form_pesanan' => $request->except(['surat', '_token'])]);
        return redirect('/pilihlokasi');
    }

    public function simpanLokasi(Request $request)
    {
        $request->validate([
            'location' => 'required',
            'biaya_jemput' => 'required|numeric',
        ]);

        $pesanan = \App\Models\Datapesanan::where('id_pengguna', auth()->user()->id_pengguna)
            ->latest('id_pesanan')->first();

        if ($pesanan) {
            $pesanan->update([
                'pilihlokasi' => $request->location,
                'biaya_jemput' => $request->biaya_jemput,
                'nama_lokasi' => $request->location,
            ]);
        }

        return redirect()->route('pembayaran');
    }

    public function simpanPembayaran(Request $request)
    {
        $request->validate([
            'payment' => 'required'
        ]);

        // Ambil pesanan terakhir user (atau dari session jika ada)
        $pesanan = \App\Models\Datapesanan::where('id_pengguna', auth()->user()->id_pengguna)
            ->latest('id_pesanan')->first();

        if ($pesanan) {
            $pesanan->metode_pembayaran = $request->payment; // pastikan kolom ini ada di tabel datapesanan
            $pesanan->biaya_admin = $request->biaya_admin;
            $pesanan->save();
        }

        // Redirect ke halaman sukses atau dashboard
        return redirect('/pembayaran')->with('success', 'Metode pembayaran berhasil dipilih!');
    }

    public function edit($id)
    {
        $pesanan = Datapesanan::findOrFail($id);
        return view('editpesanan', compact('pesanan'));
    }

    public function update(Request $request, $id)
    {
        $pesanan = Datapesanan::findOrFail($id);

        $request->validate([
            'merk' => 'required',
            'warna' => 'required',
            'plat' => 'required',
            'catatan' => 'required',
            'tanggalMulai' => 'required|date',
            'tanggalSelesai' => 'required|date',
            'alamatLengkap' => 'required',
            'nohp' => 'required',
            'nohpcadangan' => 'required',
        ]);

        $pesanan->update([
            'merk' => $request->merk,
            'warna' => $request->warna,
            'plat_nomor' => $request->plat,
            'catatan' => $request->catatan,
            'tanggal_mulai' => $request->tanggalMulai,
            'tanggal_selesai' => $request->tanggalSelesai,
            'alamat_jemput' => $request->alamatLengkap,
            'no_hp_kontak' => $request->nohp,
            'no_hp_kontak_cadangan' => $request->nohpcadangan,
        ]);

        return redirect('/dashboard')->with('success', 'Pesanan berhasil diupdate!');
    }

    public function hapusSementara(Request $request)
    {
        // Hapus pesanan terakhir user (atau sesuai logika Anda)
        $pesanan = \App\Models\Datapesanan::where('id_pengguna', auth()->user()->id_pengguna)
            ->latest('id_pesanan')->first();
        if ($pesanan) {
            $pesanan->delete();
        }
        session()->forget('form_pesanan');
        return redirect('/dashboard');
    }

    public function completePesanan(Request $request)
    {
        $pesanan = \App\Models\Datapesanan::where('id_pengguna', auth()->user()->id_pengguna)
            ->latest('id_pesanan')->first();

        if ($pesanan) {
            $pesanan->update([
                'status_pesanan' => 'confirmed',
                'metode_pembayaran' => $request->payment,
            ]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
    public function hasilTransaksi($id)
    {
        $pesanan = \App\Models\Datapesanan::findOrFail($id);
        return view('hasiltransaksi', compact('pesanan'));
    }

public function halamanKonfirmasiPembayaran(Request $request)
{
    $pesanan = \App\Models\Datapesanan::where('id_pengguna', auth()->user()->id_pengguna)
        ->latest('id_pesanan')->first();

    // Simpan metode pembayaran ke database jika ada di request
    if ($request->has('payment') && $pesanan) {
        $pesanan->update([
            'metode_pembayaran' => $request->payment
        ]);
    }

    return view('konfirmasipembayara', compact('pesanan'));
}

public function konfirmasi(Request $request, $id)
{
    $pesanan = Datapesanan::findOrFail($id);
    $pesanan->status_pesanan = 'confirmed';
    $pesanan->save();

    return redirect()->route('hasiltransaksi', ['id' => $pesanan->id_pesanan]);
}
public function konfirmasiTunai(Request $request, $id)
{
    $pesanan = \App\Models\Datapesanan::findOrFail($id);
    $pesanan->status_pesanan = 'confirmed';
    $pesanan->save();

    return redirect()->route('hasiltransaksi', ['id' => $pesanan->id_pesanan]);
}

public function halamanRiwayatUser()
{
    $userId = auth()->user()->id_pengguna;

    // Ambil semua pesanan user
    $riwayats = \App\Models\Datapesanan::where('id_pengguna', $userId)
        ->orderByDesc('tanggal_mulai')
        ->get();

    // Total transaksi = semua pesanan user
    $totalTransaksi = $riwayats->count();

    // Sedang aktif = status_pesanan bukan 'completed' (misal: pending, aktif, dsb)
    $sedangAktif = $riwayats->where('status_pesanan', '!=', 'completed')->count();

    // Total pengeluaran = jumlah biaya_layanan + biaya_jemput semua transaksi
    $totalPengeluaran = $riwayats->sum(function($item) {
        return ($item->biaya_layanan ?? 0) + ($item->biaya_jemput ?? 0);
    });

    return view('riwayatuser', compact('riwayats', 'totalTransaksi', 'sedangAktif', 'totalPengeluaran'));
}
public function infoAkun()
{
    $userId = auth()->user()->id_pengguna;

    // Ambil semua pesanan user
    $riwayats = \App\Models\Datapesanan::where('id_pengguna', $userId)->get();

    // Total Transaksi = semua pesanan user
    $totalAktifitas = $riwayats->count();

    // Total Pengeluaran = jumlah biaya_layanan + biaya_jemput untuk pesanan berstatus completed atau confirmed
    $riwayatSelesaiAtauTerkonfirmasi = \App\Models\Datapesanan::where('id_pengguna', $userId)
        ->whereIn('status_pesanan', ['completed', 'confirmed'])
        ->get();

    $totalPengeluaran = $riwayatSelesaiAtauTerkonfirmasi->sum(function($item) {
        return ($item->biaya_layanan ?? 0) + ($item->biaya_jemput ?? 0);
    });

    return view('infoakunuser', compact('totalAktifitas', 'totalPengeluaran'));
}
public function toggleLokasi($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        $lokasi->status = $lokasi->status === 'aktif' ? 'nonaktif' : 'aktif';
        $lokasi->save();

        return redirect()->back()->with('success', 'Status lokasi berhasil diubah.');
    }

    public function RiwayatUser()
    {
        // Ambil semua pesanan user
        $pesanans = \App\Models\Datapesanan::where('id_pengguna', auth()->user()->id_pengguna)
            ->orderByDesc('tanggal_mulai')
            ->get();

        // Total transaksi = semua pesanan user
        $totalTransaksi = $pesanans->count();

        // Sedang aktif = status_pesanan bukan 'completed' (misal: pending, aktif, dsb)
        $sedangAktif = $pesanans->where('status_pesanan', '!=', 'completed')->count();

        // Total pengeluaran = jumlah biaya_layanan + biaya_jemput semua transaksi
        $totalPengeluaran = $pesanans->sum(function($item) {
            return ($item->biaya_layanan ?? 0) + ($item->biaya_jemput ?? 0);
        });

        // Total biaya_layanan hanya untuk status completed dan confirmed
        $totalBiayaLayanan = \App\Models\Datapesanan::where('id_pengguna', auth()->user()->id_pengguna)
            ->whereIn('status_pesanan', ['completed', 'confirmed'])
            ->sum('biaya_layanan');

        $totalLokasiAktif = \App\Models\Lokasi::where('status', 'aktif')->count();

        return view('admindashboard', compact('pesanans', 'totalTransaksi', 'sedangAktif', 'totalPengeluaran', 'totalBiayaLayanan', 'totalLokasiAktif'));
    }
}
