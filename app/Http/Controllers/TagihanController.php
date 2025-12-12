<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TagihanAdmin; // Pakai Model yang baru (sesuai request kamu)

class TagihanController extends Controller
{
    // Pastikan di paling atas ada: use App\Models\TagihanAdmin;

public function index(Request $request)
{
    // BENAR: Ini membaca tabel 'tagihan_admins' yang ada isinya
    $tagihans = TagihanAdmin::latest()->paginate(10);
    
    return view('admin.tagihan.index', compact('tagihans'));
}

    public function create()
    {
        // --- PERBAIKAN DI SINI ---
        // Kita arahkan ke 'create', karena nama file kamu create.blade.php
        return view('admin.tagihan.create');
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'nama_siswa' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'bulan' => 'required',
            'jenis_pembayaran' => 'required',
            'nominal' => 'required|numeric',
        ]);

        // Simpan ke Database Baru (TagihanAdmin)
        TagihanAdmin::create([
            'nama_siswa' => $request->nama_siswa,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun ?? date('Y'),
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
            'status' => 'belum_lunas',
        ]);

        return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan berhasil dibuat!');
    }
}
