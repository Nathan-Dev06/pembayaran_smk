<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Nama tabel disesuaikan dengan file migration kamu: 'pembayaran_admins'
        Schema::create('pembayaran_admins', function (Blueprint $table) {
            $table->id();

            // 1. RELASI KE TABEL TAGIHAN ADMINS
            // Ini fungsinya menyimpan ID Tagihan (misal: ID 1 punya Yonathan)
            $table->unsignedBigInteger('tagihan_admin_id');

            // 2. DATA PEMBAYARAN
            $table->date('tanggal_bayar');
            $table->decimal('jumlah_bayar', 15, 0);

            // 3. METODE PEMBAYARAN
            // Pilihannya nanti: 'tunai', 'transfer'
            $table->string('metode_pembayaran');

            // Bukti Transfer (Boleh kosong/nullable kalau bayar Tunai)
            $table->string('bukti_transfer')->nullable();

            // 4. STATUS (Penting buat verifikasi)
            // 'menunggu', 'diterima', 'ditolak'
            $table->string('status_konfirmasi')->default('diterima');

            // 5. PETUGAS (Siapa yang input?)
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_admins');
    }
};
