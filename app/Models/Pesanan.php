<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'datapesanan'; // Ganti ke nama tabel yang benar
    protected $guarded = [];

    protected $primaryKey = 'id_pesanan'; // add this line
}