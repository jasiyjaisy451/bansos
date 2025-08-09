@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <img src="https://bazma.id/wp-content/uploads/2023/05/logo-bazma-1.png" alt="Logo Bazma" style="height: 60px;" class="me-3">
                            <span class="fw-bold fs-4">X</span>
                            <img src="https://akiradata.co.id/wp-content/uploads/2020/05/logo-pertamina.png" alt="Logo Pertamina" style="height: 60px;" class="ms-3">
                        </div>
                        <h3 class="fw-bold text-primary">Daftar Penerima Bantuan</h3>
                        <p class="text-muted">Registrasi dengan QR Code Anda</p>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                            <label for="email" class="form-label">Alamat Email</label>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        <div class="mb-3">
                            <label for="qr_code" class="form-label">QR Code</label>
                            <input id="qr_code" type="text" class="form-control @error('qr_code') is-invalid @enderror"
                                   name="qr_code" value="{{ old('qr_code') }}" required placeholder="Masukkan QR Code Anda">
                            <small class="form-text text-muted">QR Code yang tertera pada kartu penerima bantuan</small>

                            @error('qr_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                            <label for="password" class="form-label">Password</label>
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                            <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                Daftar Sekarang
                                </button>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <p class="mb-0">Sudah punya akun? 
                                <a href="{{ route('login') }}" class="text-decoration-none">Masuk di sini</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
