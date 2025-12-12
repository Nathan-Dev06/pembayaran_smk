@extends('layouts.admin')

@section('title', 'Tambah Siswa')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Siswa Baru</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <form action="{{ route('admin.siswa.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input type="text" class="form-control @error('nis') is-invalid @enderror" id="nis" name="nis" value="{{ old('nis') }}" required>
                                @error('nis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <select class="form-control @error('kelas') is-invalid @enderror" id="kelas" name="kelas" required>
                                    <option value="">Pilih Kelas</option>
                                    <option value="X" {{ old('kelas') == 'X' ? 'selected' : '' }}>X</option>
                                    <option value="XI" {{ old('kelas') == 'XI' ? 'selected' : '' }}>XI</option>
                                    <option value="XII" {{ old('kelas') == 'XII' ? 'selected' : '' }}>XII</option>
                                </select>
                                @error('kelas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email (Opsional)</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection