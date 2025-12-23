@extends('layouts.petugas')

@section('title', 'Profile Petugas - Laporin')

@section('content')
<div class="container-fluid">
    <!-- Header Profile -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-primary fw-bold"><i class="fas fa-user-circle me-2"></i>Profile Saya</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('petugas.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active text-primary">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <!-- Profile Card -->
            <div class="card border-0 shadow-lg profile-card">
                <div class="card-body p-5">
                    <div class="row align-items-start">
                        <!-- Profile Initials Section -->
                        <div class="col-lg-4 text-center mb-4 mb-lg-0">
                            <div class="profile-initials-wrapper position-relative mx-auto">
                                <div class="profile-initials-container">
                                    <div class="profile-initials-display rounded-circle shadow-lg d-flex align-items-center justify-content-center">
                                        <span class="initials">{{ strtoupper(substr(Auth::user()->nama_pengguna, 0, 2)) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h4 class="fw-bold text-dark mb-1">{{ Auth::user()->nama_pengguna }}</h4>
                                <p class="text-muted mb-2">{{ Auth::user()->email }}</p>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                    <i class="fas fa-user-tag me-1"></i>
                                    {{ ucfirst(Auth::user()->role) }}
                                </span>
                            </div>
                        </div>

                        <!-- Form Edit Section -->
                        <div class="col-lg-8">
                            <form action="{{ route('petugas.profile.update') }}" method="POST" id="profileForm">
                                @csrf
                                @method('PUT')

                                <!-- Informasi Akun -->
                                <div class="section-header mb-4">
                                    <h5 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-user-edit me-2"></i>Informasi Akun
                                    </h5>
                                </div>

                                <div class="row g-3">
                                    <!-- Nama Pengguna -->
                                    <div class="col-md-6">
                                        <label for="nama_pengguna" class="form-label fw-semibold">Nama Pengguna <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-user text-muted"></i>
                                            </span>
                                            <input type="text" class="form-control ps-2 @error('nama_pengguna') is-invalid @enderror"
                                                   id="nama_pengguna" name="nama_pengguna"
                                                   value="{{ old('nama_pengguna', Auth::user()->nama_pengguna) }}" required>
                                        </div>
                                        @error('nama_pengguna')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-envelope text-muted"></i>
                                            </span>
                                            <input type="email" class="form-control ps-2 @error('email') is-invalid @enderror"
                                                   id="email" name="email"
                                                   value="{{ old('email', Auth::user()->email) }}" required>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Jenis Kelamin -->
                                    <div class="col-md-6">
                                        <label for="gender" class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-venus-mars text-muted"></i>
                                            </span>
                                            <select class="form-control ps-2 @error('gender') is-invalid @enderror"
                                                    id="gender" name="gender" required>
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="L" {{ old('gender', $petugas->gender ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="P" {{ old('gender', $petugas->gender ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                        @error('gender')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Nomor Telepon -->
                                    <div class="col-md-6">
                                        <label for="telp" class="form-label fw-semibold">Nomor Telepon</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-phone text-muted"></i>
                                            </span>
                                            <input type="text" class="form-control ps-2 @error('telp') is-invalid @enderror"
                                                   id="telp" name="telp"
                                                   value="{{ old('telp', $petugas->telp ?? '') }}">
                                        </div>
                                        @error('telp')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Username (Readonly) -->
                                    <div class="col-md-6">
                                        <label for="username" class="form-label fw-semibold">Username</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-at text-muted"></i>
                                            </span>
                                            <input type="text" class="form-control ps-2 border-start-0"
                                                   id="username" value="{{ Auth::user()->username }}" readonly
                                                   style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <small class="text-muted">Username tidak dapat diubah</small>
                                    </div>

                                    <!-- Role (Readonly) -->
                                    <div class="col-md-6">
                                        <label for="role" class="form-label fw-semibold">Role</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-user-tag text-muted"></i>
                                            </span>
                                            <input type="text" class="form-control ps-2 border-start-0"
                                                   id="role" value="{{ ucfirst(Auth::user()->role) }}" readonly
                                                   style="background-color: #f8f9fa; cursor: not-allowed;">
                                        </div>
                                        <small class="text-muted">Role tidak dapat diubah</small>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                                    <a href="{{ route('petugas.dashboard') }}" class="btn btn-outline-secondary px-4">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4 btn-save">
                                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ubah Password Card -->
            <div class="card border-0 shadow-lg profile-card mt-4">
                <div class="card-body p-5">
                    <div class="section-header mb-4">
                        <h5 class="fw-bold text-primary mb-3">
                            <i class="fas fa-key me-2"></i>Ubah Password
                        </h5>
                    </div>

                    <form action="{{ route('petugas.profile.password') }}" method="POST" id="passwordForm">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <!-- Password Saat Ini -->
                            <div class="col-12">
                                <label for="current_password" class="form-label fw-semibold">Password Saat Ini <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control ps-2 @error('current_password') is-invalid @enderror"
                                           id="current_password" name="current_password" placeholder="Masukkan password saat ini" required>
                                    <button type="button" class="btn btn-outline-secondary border-start-0 toggle-password" data-target="current_password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password Baru -->
                            <div class="col-12">
                                <label for="new_password" class="form-label fw-semibold">Password Baru <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-key text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control ps-2 @error('new_password') is-invalid @enderror"
                                           id="new_password" name="new_password" placeholder="Password baru (min. 8 karakter)" required>
                                    <button type="button" class="btn btn-outline-secondary border-start-0 toggle-password" data-target="new_password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('new_password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="col-12">
                                <label for="new_password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-check-circle text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control ps-2"
                                           id="new_password_confirmation" name="new_password_confirmation" placeholder="Konfirmasi password baru" required>
                                    <button type="button" class="btn btn-outline-secondary border-start-0 toggle-password" data-target="new_password_confirmation">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-warning px-4 btn-save-password">
                                        <i class="fas fa-key me-2"></i>Ubah Password
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
.profile-card {
    border-radius: 20px;
    background: linear-gradient(135deg, var(--white) 0%, #f8f9ff 100%);
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(49, 50, 111, 0.15) !important;
}

.profile-initials-wrapper {
    max-width: 180px;
}

.profile-initials-container {
    position: relative;
    display: inline-block;
    border-radius: 50%;
    padding: 6px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
}

.profile-initials-display {
    width: 160px;
    height: 160px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border: 4px solid white;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 3rem;
    transition: all 0.4s ease;
}

.initials {
    font-size: 3rem;
    font-weight: bold;
    color: white;
}

.section-header {
    position: relative;
    padding-left: 1rem;
}

.section-header::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 4px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 10px;
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(49, 50, 111, 0.15);
    transform: translateY(-2px);
}

.input-group-text {
    border: 2px solid #e9ecef;
    border-right: none;
    border-radius: 10px 0 0 10px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.input-group-lg .form-control {
    padding: 1rem 1.25rem;
    font-size: 1rem;
}

.input-group-lg .input-group-text {
    padding: 1rem 1.25rem;
}

.form-control:focus + .input-group-text,
.form-control:focus ~ .input-group-text {
    border-color: var(--primary);
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border: none;
    border-radius: 12px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: all 0.6s ease;
}

.btn-primary:hover::before {
    left: 100%;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(49, 50, 111, 0.3);
}

.btn-warning {
    background: linear-gradient(135deg, #ffc107, #fd7e14);
    border: none;
    border-radius: 12px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
    color: white;
}

.btn-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(255, 193, 7, 0.3);
    color: white;
}

.btn-outline-secondary {
    border: 2px solid #dee2e6;
    border-radius: 12px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    border-color: var(--primary);
    color: var(--primary);
    transform: translateY(-2px);
}

.badge {
    font-size: 0.8rem;
    font-weight: 500;
}

.alert-info {
    border-radius: 12px;
    border: none;
}

.info-box {
    border-left: 4px solid var(--primary);
}

.info-item {
    padding: 0.5rem;
}

.info-item i {
    font-size: 1.5rem;
}

.toggle-password {
    border-radius: 0 10px 10px 0;
    transition: all 0.3s ease;
}

.toggle-password:hover {
    background-color: var(--primary);
    color: white;
}

/* Loading animation for save button */
.btn-save.loading,
.btn-save-password.loading {
    pointer-events: none;
    opacity: 0.8;
}

.btn-save.loading i,
.btn-save-password.loading i {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .profile-initials-display {
        width: 120px;
        height: 120px;
    }

    .initials {
        font-size: 2rem;
    }

    .card-body {
        padding: 2rem !important;
    }

    .info-box .row {
        gap: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Password Visibility
    const toggleButtons = document.querySelectorAll('.toggle-password');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetInput = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (targetInput.type === 'password') {
                targetInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                targetInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Form submission loading state
    const profileForm = document.getElementById('profileForm');
    const saveButton = document.querySelector('.btn-save');

    if (profileForm) {
        profileForm.addEventListener('submit', function() {
            saveButton.classList.add('loading');
            saveButton.innerHTML = '<i class="fas fa-spinner me-2"></i>Menyimpan...';
        });
    }

    // Password form submission loading state
    const passwordForm = document.getElementById('passwordForm');
    const savePasswordButton = document.querySelector('.btn-save-password');

    if (passwordForm) {
        passwordForm.addEventListener('submit', function() {
            savePasswordButton.classList.add('loading');
            savePasswordButton.innerHTML = '<i class="fas fa-spinner me-2"></i>Mengubah...';
        });
    }

    // Profile initials hover effect
    const profileInitialsContainer = document.querySelector('.profile-initials-container');
    if (profileInitialsContainer) {
        profileInitialsContainer.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.02)';
        });

        profileInitialsContainer.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    }
});
</script>
@endsection
