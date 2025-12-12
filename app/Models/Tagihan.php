<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| TAGIHAN MODEL - Model untuk data tagihan siswa
|--------------------------------------------------------------------------
|
| Model ini merepresentasikan tabel 'tagihans' di database.
| Setiap tagihan terhubung dengan satu siswa.
|
*/

class Tagihan extends Model
{
    use HasFactory;

    /**
     * MASS ASSIGNABLE - Atribut yang bisa di-set via create() atau update()
     */
    protected $fillable = [
        'siswa_id',             // Foreign key ke siswas table
        'bulan',                // Bulan tagihan (Januari, Februari, dll)
        'tahun',                // Tahun tagihan
        'jumlah',               // Jumlah tagihan dalam rupiah
        'keterangan',           // Keterangan tambahan
        'status',               // Status: menunggu, dibayar, terlambat
        'tanggal_jatuh_tempo',  // Tanggal deadline pembayaran
    ];

    /**
     * ATTRIBUTE CASTING - Auto convert tipe data
     */
    protected $casts = [
        'tanggal_jatuh_tempo' => 'date',
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
     * RELATIONSHIP - Hubungan dengan model Pembayaran
     */
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
