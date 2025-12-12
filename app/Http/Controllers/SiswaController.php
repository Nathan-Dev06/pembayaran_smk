<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    // Menampilkan daftar siswa
    public function index()
    {
        // PERBAIKAN: Menggunakan paginate() agar fitur halaman (links) berfungsi
        $siswas = Siswa::paginate(10);
        return view('admin.siswa.index', compact('siswas'));
    }

    // Menampilkan form untuk menambahkan siswa baru
    public function create()
    {
        return view('admin.siswa.create');
    }

    // Menyimpan data siswa baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswas,nis',
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'email' => 'nullable|email|unique:siswas,email',
        ]);

        Siswa::create($request->all());

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit siswa
    public function edit(Siswa $siswa)
    {
        return view('admin.siswa.edit', compact('siswa'));
    }

    // Mengupdate data siswa
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis' => 'required|unique:siswas,nis,' . $siswa->id,
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'email' => 'nullable|email|unique:siswas,email,' . $siswa->id,
        ]);

        $siswa->update($request->all());

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diupdate.');
    }

    // Menghapus data siswa
    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
