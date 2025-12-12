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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade');
            $table->string('nama_tagihan'); // SPP, Uang Gedung, dll
            $table->decimal('jumlah', 15, 2);
            $table->date('tanggal_jatuh_tempo');
            $table->enum('status', ['belum_bayar', 'lunas', 'cicilan'])->default('belum_bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
