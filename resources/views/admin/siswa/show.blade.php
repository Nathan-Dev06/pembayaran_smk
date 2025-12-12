@extends('layouts.admin')

@section('title', 'Detail Siswa')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Siswa</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Lengkap:</label>
                            <p class="form-control-plaintext">{{ $siswa->user->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email:</label>
                            <p class="form-control-plaintext">{{ $siswa->user->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>NISN:</label>
                            <p class="form-control-plaintext">{{ $siswa->nisn }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>No. Telepon:</label>
                            <p class="form-control-plaintext">{{ $siswa->user->no_telepon ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kelas:</label>
                            <p class="form-control-plaintext">{{ $siswa->kelas }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jurusan:</label>
                            <p class="form-control-plaintext">{{ $siswa->jurusan }}</p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Alamat:</label>
                    <p class="form-control-plaintext">{{ $siswa->user->alamat ?? '-' }}</p>
                </div>

                <div class="form-group">
                    <label>Dibuat pada:</label>
                    <p class="form-control-plaintext">{{ $siswa->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tagihan Siswa</h3>
            </div>
            <div class="card-body">
                @if($siswa->tagihans->count() > 0)
                    <div class="list-group">
                        @foreach($siswa->tagihans as $tagihan)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $tagihan->nama_tagihan }}</h5>
                                    <small class="text-muted">
                                        @if($tagihan->status == 'lunas')
                                            <span class="badge badge-success">Lunas</span>
                                        @elseif($tagihan->status == 'cicilan')
                                            <span class="badge badge-warning">Cicilan</span>
                                        @else
                                            <span class="badge badge-danger">Belum Bayar</span>
                                        @endif
                                    </small>
                                </div>
                                <p class="mb-1">Jumlah: Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}</p>
                                <small>Jatuh Tempo: {{ $tagihan->tanggal_jatuh_tempo->format('d M Y') }}</small>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-muted">Belum ada tagihan untuk siswa ini.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection