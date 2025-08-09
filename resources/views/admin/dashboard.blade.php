@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Penerima
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRecipients }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Belum Register
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $belumRegisterCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-times fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Sudah Register
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sudahRegisterCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Sudah Menerima
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sudahMenerimaCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 bg-white border-bottom">
                <h6 class="m-0 font-weight-bold text-primary">Registrasi Terbaru</h6>
            </div>
            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                @if($recentRegistrations->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentRegistrations as $recipient)
                            <div class="list-group-item py-2 d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $recipient->child_name }}</strong><br>
                                    <small class="text-muted">{{ $recipient->qr_code }}</small>
                                    @if($recipient->user)
                                        <br><small class="text-info">{{ $recipient->user->email }}</small>
                                    @endif
                                </div>
                                <div class="text-end">
                                    <span class="badge {{ $recipient->status_badge_class }}">
                                        {{ $recipient->distribution_status }}
                                    </span>
                                    <br><small class="text-muted">
                                        {{ $recipient->updated_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center">Belum ada registrasi</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 bg-white border-bottom">
                <h6 class="m-0 font-weight-bold text-primary">Distribusi Barang</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4 text-center">
                        <div class="p-3 border rounded shadow-sm">
                            <i class="fas fa-tshirt fa-2x text-primary mb-2"></i>
                            <h4 class="fw-bold mb-1">{{ $uniformCount }}</h4>
                            <div class="text-muted small">Seragam</div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="p-3 border rounded shadow-sm">
                            <i class="fas fa-shoe-prints fa-2x text-success mb-2"></i>
                            <h4 class="fw-bold mb-1">{{ $shoesCount }}</h4>
                            <div class="text-muted small">Sepatu</div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="p-3 border rounded shadow-sm">
                            <i class="fas fa-briefcase fa-2x text-warning mb-2"></i>
                            <h4 class="fw-bold mb-1">{{ $bagCount }}</h4>
                            <div class="text-muted small">Tas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('recipients.create') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-plus me-2"></i>
                            Tambah Penerima
                        </a>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('admin.import') }}" class="btn btn-info btn-block">
                            <i class="fas fa-file-excel me-2"></i>
                            Import Excel
                        </a>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('admin.scan-register') }}" class="btn btn-warning btn-block">
                            <i class="fas fa-qrcode me-2"></i>
                            Register QR
                        </a>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('recipients.scan') }}" class="btn btn-success btn-block">
                            <i class="fas fa-truck me-2"></i>
                            Penyaluran
                        </a>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('recipients.index') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-list me-2"></i>
                            Lihat Data
                        </a>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('recipients.report') }}" class="btn btn-dark btn-block" target="_blank">
                            <i class="fas fa-print me-2"></i>
                            Cetak Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection