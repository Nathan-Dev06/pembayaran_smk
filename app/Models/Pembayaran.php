<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| PEMBAYARAN MODEL - Model untuk data pembayaran siswa
|--------------------------------------------------------------------------
|
| Model ini merepresentasikan tabel 'pembayarans' di database.
| Setiap pembayaran terhubung dengan satu siswa dan satu tagihan.
|
*/

class Pembayaran extends Model
{
    use HasFactory;

    /**
     * MASS ASSIGNABLE - Atribut yang bisa di-set via create() atau update()
     */
    protected $fillable = [
        'siswa_id',             // Foreign key ke siswas table
        'tagihan_id',           // Foreign key ke tagihans table
        'jumlah',               // Jumlah pembayaran
        'metode_pembayaran',    // Metode: transfer_bank, tunai, e_wallet
        'tanggal_pembayaran',   // Tanggal pembayaran dilakukan
        'nomor_referensi',      // Nomor referensi pembayaran
        'status',               // Status: pending, terverifikasi, ditolak
        'keterangan',           // Keterangan tambahan
    ];

    /**
     * ATTRIBUTE CASTING - Auto convert tipe data
     */
    protected $casts = [
        'tanggal_pembayaran' => 'datetime',
        'jumlah' => 'decimal:2',
    ];

    /**
     * RELATIONSHIP - Hubungan dengan model Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * RELATIONSHIP - Hubungan dengan model Tagihan
     */
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }
}
