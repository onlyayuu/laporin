@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Edit User</h1>
            <p class="text-muted mb-0">Perbarui informasi user</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light py-3">
            <h5 class="card-title mb-0">
                <i class="fas fa-user-edit me-2 text-primary"></i>
                Form Edit User
            </h5>
        </div>
        <div class="card-body p-4">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Terjadi Kesalahan!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user->id_user) }}" method="POST">
                @csrf
                @method('PUT')

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
                                       value="{{ old('username', $user->username) }}"
                                       placeholder="Masukkan username" required>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" name="password" class="form-control"
                                       placeholder="Kosongkan jika tidak ingin mengubah">
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Kosongkan jika tidak ingin mengubah password
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" name="password_confirmation" class="form-control"
                                       placeholder="Konfirmasi password">
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
                                       value="{{ old('nama_pengguna', $user->nama_pengguna) }}"
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
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                    <option value="guru" {{ old('role', $user->role) == 'guru' ? 'selected' : '' }}>Guru</option>
                                    <option value="siswa" {{ old('role', $user->role) == 'siswa' ? 'selected' : '' }}>Siswa</option>
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
                                        <select name="gender" class="form-control" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="L" {{ old('gender', $petugas->gender ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ old('gender', $petugas->gender ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
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
                                               value="{{ old('telp', $petugas->telp ?? '') }}"
                                               placeholder="Contoh: 08123456789" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3 mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>Data gender dan telepon wajib diisi untuk role petugas</small>
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
                                <i class="fas fa-save me-2"></i>Update User
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

        // Set required fields
        const genderField = document.querySelector('select[name="gender"]');
        const telpField = document.querySelector('input[name="telp"]');
        if (genderField) genderField.required = true;
        if (telpField) telpField.required = true;
    } else {
        petugasFields.style.display = 'none';

        // Remove required fields
        const genderField = document.querySelector('select[name="gender"]');
        const telpField = document.querySelector('input[name="telp"]');
        if (genderField) genderField.required = false;
        if (telpField) telpField.required = false;
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Check if current role is petugas
    const currentRole = document.getElementById('roleSelect').value;
    if (currentRole === 'petugas') {
        document.getElementById('petugasFields').style.display = 'block';
    }

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

.form-text {
    font-size: 0.8rem;
    color: #6B7280;
}

.alert {
    border-radius: 8px;
    border: none;
}
</style>
@endsection
