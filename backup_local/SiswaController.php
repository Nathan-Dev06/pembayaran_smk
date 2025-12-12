<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswas = Siswa::with('user')->paginate(10);
        return view('admin.siswa.index', compact('siswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.siswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nisn' => 'required|string|max:20|unique:siswas',
            'kelas' => 'required|string|max:10',
            'jurusan' => 'required|string|max:50',
            'no_telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
        ]);

        // Create user account
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
            'nisn' => $request->nisn,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        // Create siswa record
        Siswa::create([
            'user_id' => $user->id,
            'nisn' => $request->nisn,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $siswa = Siswa::with(['user', 'tagihans.pembayarans'])->findOrFail($id);
        return view('admin.siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);
        return view('admin.siswa.edit', compact('siswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($siswa->user_id)],
            'nisn' => ['required', 'string', 'max:20', Rule::unique('siswas')->ignore($siswa->id)],
            'kelas' => 'required|string|max:10',
            'jurusan' => 'required|string|max:50',
            'no_telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
        ]);

        // Update user account
        $siswa->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'nisn' => $request->nisn,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        // Update siswa record
        $siswa->update([
            'nisn' => $request->nisn,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->user->delete(); // This will cascade delete the siswa record due to foreign key constraint
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
