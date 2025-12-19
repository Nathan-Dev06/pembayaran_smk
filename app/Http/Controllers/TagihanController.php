<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TagihanAdmin;
use App\Models\Siswa;


class TagihanController extends Controller
{
    public function index(Request $request)
    {
        // Query awal
        $query = TagihanAdmin::query();

        // ================= FILTER =================

        // Filter Kelas
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        // Filter Jurusan
        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->jurusan);
        }

        // Filter Bulan
        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }

        // 🔥 Filter Jenis Pembayaran (SPP, Uang Gedung, dll)
        if ($request->filled('jenis_pembayaran')) {
            $query->where('jenis_pembayaran', 'like', '%' . $request->jenis_pembayaran . '%');
        }

        // Ambil data
        $tagihans = $query->latest()->paginate(10);

        return view('admin.tagihan.index', compact('tagihans'));
    }

    public function create()
    {
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

        // Simpan ke database
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

        return redirect()
            ->route('admin.tagihan.index')
            ->with('success', 'Tagihan berhasil dibuat!');
    }

    public function createMassal()
{
    return view('admin.tagihan.create-massal');
}

public function storeMassal(Request $request)
{
    $request->validate([
        'target' => 'required|in:kelas,angkatan',
        'kelas' => 'required_if:target,kelas',
        'angkatan' => 'required_if:target,angkatan',
        'bulan' => 'required',
        'jenis_pembayaran' => 'required',
        'nominal' => 'required|numeric',
    ]);

    // 🔹 PER KELAS
    if ($request->target === 'kelas') {
        $siswas = Siswa::where('kelas', $request->kelas)->get();
    }

    // 🔹 PER ANGKATAN
    if ($request->target === 'angkatan') {
        $siswas = Siswa::where('angkatan', $request->angkatan)->get();
    }

    foreach ($siswas as $siswa) {
        TagihanAdmin::create([
            'nama_siswa' => $siswa->nama,
            'kelas' => $siswa->kelas,
            'jurusan' => $siswa->jurusan,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun ?? date('Y'),
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'nominal' => $request->nominal,
            'status' => 'belum_lunas',
        ]);
    }

    return redirect()->route('admin.tagihan.index')
        ->with('success', 'Tagihan massal berhasil dibuat!');
}

}
