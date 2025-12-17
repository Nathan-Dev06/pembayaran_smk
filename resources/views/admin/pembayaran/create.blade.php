@extends('layouts.admin')

@section('title', 'Input Pembayaran')

@section('content')
<div class="container-fluid px-4">

    <h1 class="mt-4 fw-bold text-dark">Input Pembayaran</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.pembayaran.index') }}">Pembayaran</a></li>
        <li class="breadcrumb-item active">Input Baru</li>
    </ol>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-3">
                <div class="card-header bg-success text-white py-3">
                    <h6 class="m-0 fw-bold"><i class="bi bi-wallet2 me-2"></i> Form Terima Pembayaran</h6>
                </div>
                <div class="card-body p-4">

                    {{-- Form Start --}}
                    <form action="{{ route('admin.pembayaran.store') }}" method="POST">
                        @csrf

                        {{-- 1. PILIH TAGIHAN (Dropdown Cari Siswa) --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Pilih Tagihan Siswa</label>
                            <select name="tagihan_admin_id" class="form-select form-select-lg @error('tagihan_admin_id') is-invalid @enderror" required>
                                <option value="" selected disabled>-- Pilih Siswa yang akan bayar --</option>

                                @foreach($tagihans as $tagihan)
                                    <option value="{{ $tagihan->id }}">
                                        {{-- Tampilan di Dropdown: NAMA - KELAS - JENIS - NOMINAL --}}
                                        {{ $tagihan->nama_siswa }} ({{ $tagihan->kelas }} - {{ $tagihan->jurusan }})
                                        — {{ $tagihan->jenis_pembayaran }} {{ $tagihan->bulan }}
                                        (Rp {{ number_format($tagihan->nominal, 0, ',', '.') }})
                                    </option>
                                @endforeach

                            </select>
                            @error('tagihan_admin_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted">Hanya tagihan yang <b>belum lunas</b> yang muncul di sini.</div>
                        </div>

                        <div class="row">
                            {{-- 2. TANGGAL BAYAR --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">Tanggal Pembayaran</label>
                                <input type="date" name="tanggal_bayar" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>

                            {{-- 3. METODE PEMBAYARAN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">Metode Pembayaran</label>
                                <select name="metode_pembayaran" class="form-select">
                                    <option value="tunai" selected>Tunai (Cash)</option>
                                    <option value="transfer">Transfer Bank</option>
                                </select>
                            </div>
                        </div>

                        {{-- 4. NOMINAL YANG DIBAYARKAN --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Jumlah Uang Diterima (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold">Rp</span>
                                <input type="number" name="jumlah_bayar" class="form-control form-control-lg fw-bold text-success" placeholder="Contoh: 200000" required>
                            </div>
                            <div class="form-text">Pastikan jumlah uang sesuai dengan nominal tagihan.</div>
                        </div>

                        {{-- TOMBOL AKSI --}}
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-light me-md-2 px-4 fw-bold">Batal</a>
                            <button type="submit" class="btn btn-success px-4 fw-bold">
                                <i class="bi bi-save me-1"></i> Simpan Pembayaran
                            </button>
                        </div>

                    </form>
                    {{-- Form End --}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
