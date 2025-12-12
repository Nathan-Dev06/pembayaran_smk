<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('tagihan_admins', function (Blueprint $table) {
        $table->id();
        // Kolom-kolom sesuai Form Input kamu
        $table->string('nama_siswa');
        $table->string('kelas');
        $table->string('jurusan');       // Baru
        $table->string('bulan');
        $table->integer('tahun');
        $table->string('jenis_pembayaran');
        $table->decimal('nominal', 15, 0); // Pakai 0 di belakang koma biar bulat
        $table->text('keterangan')->nullable();
        $table->string('status')->default('belum_lunas'); // Default otomatis
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan_admins');
    }
};
