@extends('layouts.app')

@section('title', 'Import Data Excel')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">Import Data Penerima dari Excel</h5>
            </div>
            <div class="card-body">
                @if(session('errors') && count(session('errors')) > 0)
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Error Details:</h6>
                        <ul class="mb-0">
                            @foreach(session('errors') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-4">
                    <h6>Petunjuk Import:</h6>
                    <ol>
                        <li>Download template Excel terlebih dahulu</li>
                        <li>Isi data sesuai format yang tersedia</li>
                        <li>Upload file Excel (.xlsx, .xls, atau .csv)</li>
                        <li>Maksimal ukuran file: 2MB</li>
                    </ol>
                </div>

                <div class="mb-4">
                    <a href="{{ route('admin.import.template') }}" class="btn btn-info">
                        <i class="fas fa-download me-2"></i>Download Template Excel
                    </a>
                </div>

                <form action="{{ route('admin.import.process') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="excel_file" class="form-label">Pilih File Excel</label>
                        <input type="file" class="form-control @error('excel_file') is-invalid @enderror" 
                               id="excel_file" name="excel_file" accept=".xlsx,.xls,.csv" required>
                        @error('excel_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('recipients.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload me-2"></i>Import Data
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow mt-4">
            <div class="card-header">
                <h6 class="mb-0">Format Data Excel</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Kolom</th>
                                <th>Nama Field</th>
                                <th>Contoh</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>A</td>
                                <td>qr_code</td>
                                <td>CBP0001</td>
                                <td>Kode QR unik</td>
                            </tr>
                            <tr>
                                <td>B</td>
                                <td>child_name</td>
                                <td>Ahmad Fauzi</td>
                                <td>Nama lengkap anak</td>
                            </tr>
                            <tr>
                                <td>C</td>
                                <td>Ayah_name</td>
                                <td>Budi Santoso</td>
                                <td>Nama ayah</td>
                            </tr>
                            <tr>
                                <td>D</td>
                                <td>Ibu_name</td>
                                <td>Siti Aminah</td>
                                <td>Nama ibu</td>
                            </tr>
                            <tr>
                                <td>E</td>
                                <td>birth_place</td>
                                <td>Jakarta</td>
                                <td>Tempat lahir</td>
                            </tr>
                            <tr>
                                <td>F</td>
                                <td>birth_date</td>
                                <td>2010-05-15</td>
                                <td>Tanggal lahir (YYYY-MM-DD)</td>
                            </tr>
                            <tr>
                                <td>G</td>
                                <td>school_level</td>
                                <td>SD</td>
                                <td>SD, SMP, SMA, atau SMK</td>
                            </tr>
                            <tr>
                                <td>H</td>
                                <td>school_name</td>
                                <td>SDN 01 Jakarta</td>
                                <td>Nama sekolah</td>
                            </tr>
                            <tr>
                                <td>I</td>
                                <td>address</td>
                                <td>Jl. Merdeka No. 123</td>
                                <td>Alamat lengkap</td>
                            </tr>
                            <tr>
                                <td>J</td>
                                <td>class</td>
                                <td>5A</td>
                                <td>Kelas</td>
                            </tr>
                            <tr>
                                <td>K</td>
                                <td>shoe_size</td>
                                <td>35</td>
                                <td>Ukuran sepatu</td>
                            </tr>
                            <tr>
                                <td>L</td>
                                <td>shirt_size</td>
                                <td>M</td>
                                <td>XS, S, M, L, XL, XXL</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection