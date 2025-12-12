@extends('layouts.admin')

@section('title', 'Manajemen Siswa')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Siswa</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Siswa
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $index => $siswa)
                            <tr>
                                <td>{{ $siswas->firstItem() + $index }}</td>
                                <td>{{ $siswa->nis }}</td>
                                <td>{{ $siswa->nama }}</td>
                                <td>{{ $siswa->kelas }}</td>
                                <td>{{ $siswa->email }}</td>
                                <td>
                                    <a href="{{ route('admin.siswa.show', $siswa->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $siswas->links() }}
            </div>
        </div>
    </div>
</div>
@endsection