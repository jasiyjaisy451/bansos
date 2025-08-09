@extends('layouts.user')

@section('title', 'Dashboard Penerima')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="welcome-card mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-2">Selamat Datang, {{ $recipient->child_name }}!</h4>
                            <p class="text-muted mb-0">Berikut adalah status penerimaan bantuan pendidikan Anda</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <span class="badge {{ $recipient->status_badge_class }} fs-6 px-3 py-2">
                                {{ $recipient->distribution_status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Data Penerima</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold" style="width: 40%;">QR Code:</td>
                                <td><span class="badge bg-primary">{{ $recipient->qr_code }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Nama Anak:</td>
                                <td>{{ $recipient->child_name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Nama Ayah:</td>
                                <td>{{ $recipient->Ayah_name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Nama Ibu:</td>
                                <td>{{ $recipient->Ibu_name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Tempat, Tanggal Lahir:</td>
                                <td>{{ $recipient->birth_place }}, {{ $recipient->birth_date->format('d F Y') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold" style="width: 40%;">Sekolah:</td>
                                <td>{{ $recipient->school_name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Tingkat:</td>
                                <td>{{ $recipient->school_level }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kelas:</td>
                                <td>{{ $recipient->class }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Alamat:</td>
                                <td>{{ $recipient->address }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Ukuran:</td>
                                <td>Sepatu {{ $recipient->shoe_size }}, Baju {{ $recipient->shirt_size }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0"><i class="fas fa-gift me-2"></i>Status Penerimaan Bantuan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        <div class="status-item p-3 border rounded {{ $recipient->uniform_received ? 'border-success bg-light-success' : 'border-secondary' }}">
                            <i class="fas fa-tshirt fa-3x mb-3 {{ $recipient->uniform_received ? 'text-success' : 'text-muted' }}"></i>
                            <h6 class="fw-bold">Seragam Sekolah</h6>
                            <span class="badge {{ $recipient->uniform_received ? 'bg-success' : 'bg-secondary' }}">
                                {{ $recipient->uniform_received ? 'Sudah Diterima' : 'Belum Diterima' }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <div class="status-item p-3 border rounded {{ $recipient->shoes_received ? 'border-success bg-light-success' : 'border-secondary' }}">
                            <i class="fas fa-shoe-prints fa-3x mb-3 {{ $recipient->shoes_received ? 'text-success' : 'text-muted' }}"></i>
                            <h6 class="fw-bold">Sepatu Sekolah</h6>
                            <span class="badge {{ $recipient->shoes_received ? 'bg-success' : 'bg-secondary' }}">
                                {{ $recipient->shoes_received ? 'Sudah Diterima' : 'Belum Diterima' }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <div class="status-item p-3 border rounded {{ $recipient->bag_received ? 'border-success bg-light-success' : 'border-secondary' }}">
                            <i class="fas fa-briefcase fa-3x mb-3 {{ $recipient->bag_received ? 'text-success' : 'text-muted' }}"></i>
                            <h6 class="fw-bold">Tas Sekolah</h6>
                            <span class="badge {{ $recipient->bag_received ? 'bg-success' : 'bg-secondary' }}">
                                {{ $recipient->bag_received ? 'Sudah Diterima' : 'Belum Diterima' }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($recipient->status === 'sudah_menerima')
                    <div class="alert alert-success mt-3">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Selamat!</strong> Anda telah menerima semua bantuan pendidikan.
                        @if($recipient->distributed_at)
                            <br><small>Diterima pada: {{ $recipient->distributed_at->format('d F Y, H:i') }} WIB</small>
                        @endif
                    </div>
                @elseif($recipient->status === 'sudah_register')
                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Status:</strong> Anda sudah terdaftar dan dapat mengambil bantuan di lokasi penyaluran.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h6 class="mb-0"><i class="fas fa-qrcode me-2"></i>QR Code Anda</h6>
            </div>
            <div class="card-body text-center">
                <img src="{{ route('recipients.qr-code', $recipient) }}" alt="QR Code" class="img-fluid mb-3" style="max-width: 200px;">
                <p class="fw-bold">{{ $recipient->qr_code }}</p>
                <small class="text-muted">Tunjukkan QR Code ini saat pengambilan bantuan</small>
            </div>
        </div>

        @if($recipient->status === 'sudah_menerima')
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-white border-bottom">
                <h6 class="mb-0"><i class="fas fa-file-pdf me-2"></i>Dokumen</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('recipients.receipt', $recipient) }}" class="btn btn-success" target="_blank">
                        <i class="fas fa-download me-2"></i>Unduh Bukti Penerimaan
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection