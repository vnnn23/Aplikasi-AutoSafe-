<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('datapesanan', function (Blueprint $table) {
            $table->increments('id_pesanan');
            $table->unsignedInteger('id_pengguna');
            $table->string('jenis_layanan');
            $table->string('merk');
            $table->string('warna');
            $table->string('surat');
            $table->string('plat_nomor');
            $table->string('catatan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('alamat_jemput');
            $table->string('patokan');
            $table->string('instruksi');
            $table->date('tanggal_jemput');
            $table->time('waktu_jemput');
            $table->string('nama_kontak');
            $table->string('no_hp_kontak');
            $table->string('no_hp_kontak_cadangan')->nullable();
            $table->string('nama_lokasi')->nullable();
            $table->string('metode_pembayaran')->nullable();
            $table->string('biaya_layanan')->nullable();
            $table->string('biaya_jemput')->nullable();            
            $table->integer('biaya_admin')->nullable();
            $table->enum('status_pesanan', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datapesanan');
    }
};
