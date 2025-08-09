@extends('layouts.app')

@section('title', 'Register QR Code')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">Register QR Code</h5>
            </div>
            <div class="card-body">
                <form id="registerForm">
                    <div class="mb-3">
                        <label for="qr_input" class="form-label">Scan QR Code untuk Registrasi</label>
                        <input type="text" class="form-control" id="qr_input"
                               placeholder="Scan atau ketik kode QR di sini..." autofocus>
                        <small class="form-text text-muted">
                            Gunakan scanner atau ketik manual kode QR
                        </small>
                    </div>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-user-check me-2"></i>Register QR
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow" id="resultCard" style="display: none;">
            <div class="card-header">
                <h5 class="mb-0">Hasil Registrasi</h5>
            </div>
            <div class="card-body" id="resultContent">
                <!-- Result will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-submit when QR input changes (for scanner)
    $('#qr_input').on('input', function() {
        const value = $(this).val().trim();
        if (value.length > 5) {
            setTimeout(() => {
                if ($('#qr_input').val().trim() === value) {
                    $('#registerForm').submit();
                }
            }, 500);
        }
    });

    // Handle Enter key
    $('#qr_input').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#registerForm').submit();
        }
    });

    // QR Registration Form
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();

        const qrCode = $('#qr_input').val().trim();
        if (!qrCode) {
            alert('Masukkan kode QR terlebih dahulu');
            return;
        }

        // Show loading
        $('#resultContent').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Memproses registrasi...</div>');
        $('#resultCard').show();

        $.ajax({
            url: '{{ route("admin.register-qr") }}',
            method: 'POST',
            data: {
                qr_code: qrCode,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    displaySuccess(response.recipient, response.message);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                $('#resultCard').show();
                $('#resultContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        ${response.message || 'Terjadi kesalahan'}
                    </div>
                `);
            }
        });
    });

    function displaySuccess(recipient, message) {
        $('#resultContent').html(`
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                ${message}
            </div>

            <div class="recipient-info">
                <h6><strong>${recipient.child_name}</strong></h6>
                <p class="mb-1"><strong>QR Code:</strong> <span class="badge bg-primary">${recipient.qr_code}</span></p>
                <p class="mb-1"><strong>Ayah:</strong> ${recipient.Ayah_name}</p>
                <p class="mb-1"><strong>Ibu:</strong> ${recipient.Ibu_name}</p>
                <p class="mb-1"><strong>Sekolah:</strong> ${recipient.school_name} (${recipient.school_level})</p>
                <p class="mb-1"><strong>Kelas:</strong> ${recipient.class}</p>
                <p class="mb-1"><strong>Status:</strong> <span class="badge bg-warning">Sudah Register</span></p>
            </div>
        `);

        // Reset form after 3 seconds
        setTimeout(() => {
            $('#qr_input').val('').focus();
            $('#resultCard').hide();
        }, 3000);
    }
});
</script>
@endpush