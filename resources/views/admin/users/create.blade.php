@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Tambah User Baru</h1>
            <p class="text-muted mb-0">Tambahkan user baru ke dalam sistem</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light py-3">
            <h5 class="card-title mb-0">
                <i class="fas fa-user-plus me-2 text-primary"></i>
                Form Tambah User
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <!-- Username -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <input type="text" name="username" class="form-control"
                                       placeholder="Masukkan username" required>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" name="password" class="form-control"
                                       placeholder="Masukkan password" required>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" name="password_confirmation" class="form-control"
                                       placeholder="Konfirmasi password" required>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <!-- Full Name -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-id-card text-muted"></i>
                                </span>
                                <input type="text" name="nama_pengguna" class="form-control"
                                       placeholder="Masukkan nama lengkap" required>
                            </div>
                        </div>

                        <!-- Role -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-user-tag text-muted"></i>
                                </span>
                                <select name="role" id="roleSelect" class="form-control" required onchange="togglePetugasFields()">
                                    <option value="">Pilih Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="petugas">Petugas</option>
                                    <option value="guru">Guru</option>
                                    <option value="siswa">Siswa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Petugas Additional Fields -->
                <div id="petugasFields" class="card border-primary mt-4" style="display: none;">
                    <div class="card-header bg-primary text-white py-2">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-tools me-2"></i>
                            Informasi Tambahan Petugas
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Gender -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-venus-mars text-muted"></i>
                                        </span>
                                        <select name="gender" class="form-control">
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Phone -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Telepon <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-phone text-muted"></i>
                                        </span>
                                        <input type="text" name="telp" class="form-control"
                                               placeholder="Contoh: 08123456789">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>Simpan User
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function togglePetugasFields() {
    const role = document.getElementById('roleSelect').value;
    const petugasFields = document.getElementById('petugasFields');

    if (role === 'petugas') {
        petugasFields.style.display = 'block';
    } else {
        petugasFields.style.display = 'none';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    togglePetugasFields();
});
</script>

<style>
.card {
    border-radius: 12px;
    border: 1px solid #E2E8F0;
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #D1D5DB;
}

.form-control:focus, .form-select:focus {
    border-color: #31326F;
    box-shadow: 0 0 0 3px rgba(49, 50, 111, 0.1);
}

.input-group-text {
    border-radius: 8px 0 0 8px;
    background-color: #F8FAFC;
    border: 1px solid #D1D5DB;
    border-right: none;
}

.form-control {
    border-left: none;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
}

.btn-primary {
    background: #31326F;
    border: none;
}

.btn-primary:hover {
    background: #25255a;
    transform: translateY(-1px);
}

.btn-outline-secondary {
    border: 1px solid #D1D5DB;
}

.btn-outline-secondary:hover {
    background: #F8FAFC;
    border-color: #31326F;
    color: #31326F;
}
</style>
@endsection
