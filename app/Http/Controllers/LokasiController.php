<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function store(Request $request)
    {
        // Validasi dan simpan data lokasi
        \App\Models\Lokasi::create($request->all());
        return redirect()->route('kelolalokasi')->with('success', 'Lokasi berhasil ditambahkan!');
    }
    
    public function nonaktif($id_lokasi)
    {
        $lokasi = \App\Models\Lokasi::findOrFail($id_lokasi);
        $lokasi->status = 'nonaktif';
        $lokasi->save();
        return redirect()->route('kelolalokasi')->with('success', 'Lokasi dinonaktifkan.');
    }

    public function aktifkan($id_lokasi)
    {
        $lokasi = \App\Models\Lokasi::findOrFail($id_lokasi);
        $lokasi->status = 'aktif';
        $lokasi->save();
        return redirect()->route('kelolalokasi')->with('success', 'Lokasi diaktifkan.');
    }

    public function update(Request $request, $id_lokasi)
    {
        $lokasi = \App\Models\Lokasi::findOrFail($id_lokasi);

        // Validasi data
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'biaya_jemput' => 'required|numeric',
            'alamat_lokasi' => 'required|string|max:255',
            'nama_manajer' => 'required|string|max:255',
        ]);

        // Update data lokasi
        $lokasi->nama_lokasi = $request->nama_lokasi;
        $lokasi->biaya_jemput = $request->biaya_jemput;
        $lokasi->alamat_lokasi = $request->alamat_lokasi;
        $lokasi->nama_manajer = $request->nama_manajer;
        $lokasi->save();

        return redirect()->route('kelolalokasi')->with('success', 'Data lokasi berhasil diubah!');
    }

    public function destroy($id_lokasi)
    {
        $lokasi = \App\Models\Lokasi::findOrFail($id_lokasi);
        $lokasi->delete();

        return redirect()->route('kelolalokasi')->with('success', 'Lokasi berhasil dihapus!');
    }
}

