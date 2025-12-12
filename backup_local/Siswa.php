<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| SISWA MODEL - Model untuk data siswa
|--------------------------------------------------------------------------
|
| Model ini merepresentasikan tabel 'siswas' di database.
| Setiap siswa terhubung dengan satu user account.
|
*/

class Siswa extends Model
{
    use HasFactory;

    /**
     * MASS ASSIGNABLE - Atribut yang bisa di-set via create() atau update()
     */
    protected $fillable = [
        'user_id',      // Foreign key ke users table
        'nisn',         // Nomor Induk Siswa Nasional
        'kelas',        // Kelas siswa (X, XI, XII)
        'jurusan',      // Jurusan siswa (RPL, TKJ, dll)
    ];

    /**
     * RELATIONSHIP - Hubungan dengan model User
     * Setiap siswa belongs to satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * RELATIONSHIP - Hubungan dengan model Tagihan
     * Setiap siswa has many tagihan
     */
    public function tagihans()
    {
        return $this->hasMany(Tagihan::class);
    }

    /**
     * RELATIONSHIP - Hubungan dengan model Pembayaran
     * Setiap siswa has many pembayaran
     */
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
