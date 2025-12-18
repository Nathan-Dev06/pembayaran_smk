@extends('layouts.admin')

@section('title', 'Buat Tagihan Massal')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 fw-bold text-dark">Buat Tagihan Massal</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.tagihan.index') }}">Tagihan</a></li>
        <li class="breadcrumb-item active">Tagihan Massal</li>
    </ol>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-success">
                <i class="bi bi-people-fill me-1"></i> Form Tagihan Massal
            </h6>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('admin.tagihan.massal.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- Target Tagihan --}}
                    <div class="col-md-12">
                        <label class="form-label fw-bold small text-muted">
                            Target Tagihan
                        </label>
                        <select class="form-select" name="target" id="target" required>
                            <option value="" selected disabled>-- Pilih Target --</option>
                            <option value="kelas">Per Kelas</option>
                            <option value="angkatan">Per Angkatan</option>
                        </select>
                    </div>

                    {{-- PER KELAS --}}
                    <div class="col-md-6 d-none" id="form-kelas">
                        <label class="form-label fw-bold small text-muted">Kelas</label>
                        <select class="form-select" name="kelas">
                            <option value="" selected disabled>-- Pilih Kelas --</option>
                            <option value="10RPL">10 RPL</option>
                            <option value="10TKR">10 TKR </oMIion>
                            <option value="10TMI">10 TMI </option>
                            <option value="11RPL">11 RPL</option>
                            <option value="11TKR">11 TKR </oMIion>
                            <option value="11TMI">11 TMI </option>
                            <option value="12RPL">12 RPL</option>
                            <option value="12TKR">12 TKR </oMIion>
                            <option value="12TMI">12 TMI </option>
                        </select>
                    </div>

                    {{-- PER ANGKATAN --}}
                    <div class="col-md-6 d-none" id="form-angkatan">
                        <label class="form-label fw-bold small text-muted">Angkatan</label>
                        <input type="number" class="form-control" name="angkatan" placeholder="Contoh: 2024">
                    </div>

                    {{-- Periode --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Periode Bulan</label>
                        <select class="form-select" name="bulan" required>
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
                            <option value="Desember">Desember</option>
                        </select>
                    </div>

                    {{-- Tahun --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Tahun</label>
                        <input type="number" class="form-control" name="tahun" value="{{ date('Y') }}">
                    </div>

                    {{-- Jenis Pembayaran --}}
                    <div class="col-md-12">
                        <label class="form-label fw-bold small text-muted">Jenis Pembayaran</label>
                        <input type="text" class="form-control" name="jenis_pembayaran"
                               placeholder="Contoh: SPP / Uang Gedung / Uang Ujian" required>
                    </div>

                    {{-- Nominal --}}
                    <div class="col-md-12">
                        <label class="form-label fw-bold small text-muted">Nominal Tagihan</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="nominal" required>
                        </div>
                    </div>

                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-end mt-4 gap-2">
                    <a href="{{ route('admin.tagihan.index') }}"
                       class="btn btn-light border text-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-save me-1"></i> Simpan Tagihan Massal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT TARGET --}}
<script>
    document.getElementById('target').addEventListener('change', function () {
        document.getElementById('form-kelas').classList.add('d-none');
        document.getElementById('form-angkatan').classList.add('d-none');

        if (this.value === 'kelas') {
            document.getElementById('form-kelas').classList.remove('d-none');
        }

        if (this.value === 'angkatan') {
            document.getElementById('form-angkatan').classList.remove('d-none');
        }
    });
</script>
@endsection
