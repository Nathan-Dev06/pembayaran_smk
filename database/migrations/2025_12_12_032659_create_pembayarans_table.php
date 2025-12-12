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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade');
            $table->foreignId('tagihan_id')->constrained()->onDelete('cascade');
            $table->decimal('jumlah_bayar', 15, 2);
            $table->date('tanggal_pembayaran');
            $table->string('metode_pembayaran'); // Transfer, Tunai, dll
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
