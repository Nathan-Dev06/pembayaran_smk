@extends('layouts.admin')

@section('title', 'Buat Tagihan Baru')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 fw-bold text-dark">Buat Tagihan Baru</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.tagihan.index') }}">Tagihan</a></li>
        <li class="breadcrumb-item active">Buat Baru</li>
    </ol>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-primary"><i class="bi bi-plus-circle"></i> Form Input Tagihan</h6>
        </div>
        <div class="card-body p-4">

            <form action="{{ route('admin.tagihan.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    <div class="col-md-12">
                        <label class="form-label fw-bold small text-muted">Nama Siswa</label>
                        <input type="text" class="form-control" name="nama_siswa" placeholder="Ketik nama siswa..." required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Kelas</label>
                        <select class="form-select" name="kelas" required>
                            <option value="" selected disabled>-- Pilih Kelas --</option>
                            <option value="X">Kelas X</option>
                            <option value="XI">Kelas XI</option>
                            <option value="XII">Kelas XII</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Jurusan</label>
                        <select class="form-select" name="jurusan" required>
                            <option value="" selected disabled>-- Pilih Jurusan --</option>
                            <option value="TKR">Teknik Kendaraan Ringan (TKR)</option>
                            <option value="RPL">Rekayasa Perangkat Lunak (RPL)</option>
                            <option value="TMI">Teknik Mekanik Industri (TMI)</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Periode Tagihan</label>
                        <div class="input-group">
                            <select class="form-select" name="bulan">
                                <option value="Januari">Januari</option>
                                <option value="Februari">Februari</option>
                                <option value="Maret">Maret</option>
                                <option value="April">April</option>
                                <option value="Mei">Mei</option>
                                <option value="Juni">Juni</option>
                                <option value="Juli">Juli</option>
                                <option value="Agustus">Agustus</option>
                                <option value="September">September</option>
                                <option value="Oktober">Oktober</option>
                                <option value="November">November</option>
                                <option value="Desember" selected>Desember</option>
                            </select>
                            <input type="number" class="form-control" name="tahun" value="2025" placeholder="Tahun">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Jenis Pembayaran / Nama Tagihan</label>
                        <input type="text" class="form-control" name="jenis_pembayaran" placeholder="Contoh: Uang Gedung / SPP Desember / Uang Ujian" required>
                        <div class="form-text small">Ini akan muncul di kolom 'Jenis Pembayaran' pada tabel.</div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold small text-muted">Nominal Tagihan (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold text-secondary">Rp</span>
                            <input type="number" class="form-control" name="nominal" placeholder="0" required>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold small text-muted">Catatan (Opsional)</label>
                        <textarea class="form-control" name="keterangan" rows="2" placeholder="Tulis catatan tambahan..."></textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-end mt-4 gap-2">
                    <a href="{{ route('admin.tagihan.index') }}" class="btn btn-light text-secondary border">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Tagihan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
