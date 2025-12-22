<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/*
|--------------------------------------------------------------------------
| USER MODEL - Model untuk Authenticatable User
|--------------------------------------------------------------------------
|
| Model User merepresentasikan tabel 'users' di database.
| 
| Roles yang tersedia:
| - 'admin': Administrator sistem (full access)
| - 'kepsek': Kepala Sekolah (view reports)
| - 'siswa': Siswa (view own bills & payments)
|
*/

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
public function tagihan()
{
    return $this->hasMany(Tagihan::class, 'siswa_id');
}

    /**
     * MASS ASSIGNABLE - Atribut yang bisa di-set via create() atau update()
     */
    protected $fillable = [
        'name',           // Nama lengkap user
        'email',          // Email (unique)
        'password',       // Password (di-hash)
        'role',           // Role user (admin/kepsek/siswa)
        'nisn',           // Nomor Induk Siswa (untuk siswa)
        'no_telepon',     // Nomor telepon
        'alamat',         // Alamat tempat tinggal
    ];

    /**
     * HIDDEN - Atribut yang tidak muncul di JSON/array
     * Gunakan untuk data sensitive seperti password
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * CASTING - Auto convert tipe data saat retrieve dari database
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
