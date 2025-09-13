<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datapesanan extends Model
{
    use HasFactory;
    protected $table = 'datapesanan';
    protected $primaryKey = 'id_pesanan';
    public $incrementing = true;
    protected $fillable = [
        'id_pengguna','jenis_layanan','merk','surat','warna','plat_nomor','catatan',
        'tanggal_mulai','tanggal_selesai','alamat_jemput','patokan','instruksi',
        'tanggal_jemput','waktu_jemput','nama_kontak','no_hp_kontak','no_hp_kontak_cadangan',
        'biaya_layanan','biaya_jemput','nama_lokasi','metode_pembayaran','status_pesanan'
    ];
}
