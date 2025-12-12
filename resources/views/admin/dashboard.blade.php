@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Dashboard Admin</h3>
            </div>
            <div class="card-body">
                <p>Selamat datang di dashboard admin sistem pembayaran digital SMK.</p>

                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Total Siswa</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card success">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Tagihan Lunas</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card warning">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Tagihan Pending</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card danger">
                            <div class="stat-number">Rp 0</div>
                            <div class="stat-label">Total Pembayaran</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection