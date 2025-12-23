@extends('layouts.user')

@section('title', 'Profile Pengguna - Laporin')

@section('content')
<div class="container-fluid">
    <!-- Header Profile -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-primary fw-bold"><i class="fas fa-user-circle me-2"></i>Profile Saya</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
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
                        <!-- Foto Profile Section -->
                        <div class="col-lg-4 text-center mb-4 mb-lg-0">
                            <div class="profile-image-wrapper position-relative mx-auto">
                                <div class="profile-image-container">
                                    @if(Auth::user()->foto_profil)
                                        <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}"
                                             alt="Profile" class="profile-image rounded-circle shadow-lg" id="profileImagePreview">
                                        <!-- Hapus Foto Button -->
                                        <button type="button" class="btn btn-danger btn-sm rounded-circle delete-photo-btn"
                                                title="Hapus Foto" id="deletePhotoBtn">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @else
                                        <div class="default-profile-image rounded-circle shadow-lg d-flex align-items-center justify-content-center"
                                             id="defaultProfileImage">
                                            <span class="initials">{{ $userInitials }}</span>
                                        </div>
                                    @endif
                                    <div class="profile-overlay rounded-circle">
                                        <button type="button" class="btn btn-light btn-sm rounded-circle shadow" id="uploadPhotoBtn">
                                            <i class="fas fa-camera text-primary"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h4 class="fw-bold text-dark mb-1">{{ Auth::user()->nama_pengguna }}</h4>
                                <p class="text-muted mb-2">{{ Auth::user()->email }}</p>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                    <i class="fas fa-user-tag me-1"></i>
                                    {{ Auth::user()->role ?? 'Pengguna' }}
                                </span>
                            </div>
                        </div>

                        <!-- Form Edit Section -->
                        <div class="col-lg-8">
                            <form action="{{ route('user.profile.update') }}" method="POST" id="profileForm" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Hidden input untuk hapus foto -->
                                <input type="hidden" name="hapus_foto" id="hapus_foto" value="0">
                                <!-- File Input Hidden -->
                                <input type="file" id="fotoInput" name="foto_profil" accept="image/*" class="d-none">

                                <!-- Informasi Akun -->
                                <div class="section-header mb-4">
                                    <h5 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-user-edit me-2"></i>Informasi Akun
                                    </h5>
                                </div>

                                <div class="row g-3">
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

                                    <!-- Nama Pengguna -->
                                    <div class="col-md-6">
                                        <label for="nama_pengguna" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
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
                                    <div class="col-12">
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
                                </div>

                                <!-- Foto Profile Section dalam Form -->
                                <div class="section-header mt-5 mb-4">
                                    <h5 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-camera me-2"></i>Foto Profile
                                    </h5>
                                </div>

                                <div class="row align-items-center mb-4">
                                    <div class="col-auto">
                                        <p class="text-muted mb-2">
                                            Klik ikon kamera untuk mengubah foto profile<br>
                                            <small>Format: JPG, PNG, GIF (Maks. 2MB)</small>
                                        </p>
                                    </div>
                                </div>

                                <!-- Ubah Password Section -->
                                <div class="section-header mt-5 mb-4">
                                    <h5 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-key me-2"></i>Ubah Password
                                    </h5>
                                </div>

                                <div class="password-toggle mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="togglePassword">
                                        <label class="form-check-label fw-semibold" for="togglePassword">
                                            Ubah Password
                                        </label>
                                    </div>
                                </div>

                                <div class="row g-3 password-fields" style="display: none;">
                                    <!-- Password Saat Ini -->
                                    <div class="col-12">
                                        <label for="current_password" class="form-label fw-semibold">Password Saat Ini</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-lock text-muted"></i>
                                            </span>
                                            <input type="password" class="form-control ps-2 @error('current_password') is-invalid @enderror"
                                                   id="current_password" name="current_password" placeholder="Masukkan password saat ini">
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
                                        <label for="new_password" class="form-label fw-semibold">Password Baru</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-key text-muted"></i>
                                            </span>
                                            <input type="password" class="form-control ps-2 @error('new_password') is-invalid @enderror"
                                                   id="new_password" name="new_password" placeholder="Password baru (min. 8 karakter)">
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
                                        <label for="new_password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-check-circle text-muted"></i>
                                            </span>
                                            <input type="password" class="form-control ps-2"
                                                   id="new_password_confirmation" name="new_password_confirmation" placeholder="Konfirmasi password baru">
                                            <button type="button" class="btn btn-outline-secondary border-start-0 toggle-password" data-target="new_password_confirmation">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="alert alert-info border-0 bg-light mt-2">
                                            <small class="d-flex align-items-center">
                                                <i class="fas fa-info-circle me-2 text-primary"></i>
                                                Password minimal 8 karakter. Kosongkan jika tidak ingin mengubah password.
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary px-4">
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

.profile-image-wrapper {
    max-width: 180px;
}

.profile-image-container {
    position: relative;
    display: inline-block;
    border-radius: 50%;
    padding: 6px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
}

.profile-image {
    width: 160px;
    height: 160px;
    object-fit: cover;
    border: 4px solid white;
    transition: all 0.4s ease;
}

.default-profile-image {
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
}

.initials {
    font-size: 3rem;
    font-weight: bold;
    color: white;
}

.delete-photo-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    opacity: 0.8;
    transition: all 0.3s ease;
}

.delete-photo-btn:hover {
    opacity: 1;
    transform: scale(1.1);
}

.profile-overlay {
    position: absolute;
    top: 6px;
    left: 6px;
    width: 160px;
    height: 160px;
    background: rgba(49, 50, 111, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.4s ease;
    cursor: pointer;
    border-radius: 50%;
}

.profile-image-container:hover .profile-overlay {
    opacity: 1;
}

.profile-image-container:hover .profile-image,
.profile-image-container:hover .default-profile-image {
    transform: scale(1.05);
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

.password-fields {
    animation: slideDown 0.4s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.toggle-password {
    border-radius: 0 10px 10px 0;
    transition: all 0.3s ease;
}

.toggle-password:hover {
    background-color: var(--primary);
    color: white;
}

.form-check-input:checked {
    background-color: var(--primary);
    border-color: var(--primary);
}

.form-check-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(49, 50, 111, 0.25);
}

/* Loading animation for save button */
.btn-save.loading {
    pointer-events: none;
    opacity: 0.8;
}

.btn-save.loading i {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .profile-image,
    .default-profile-image {
        width: 120px;
        height: 120px;
    }

    .initials {
        font-size: 2rem;
    }

    .profile-overlay {
        width: 120px;
        height: 120px;
    }

    .card-body {
        padding: 2rem !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Password Fields
    const togglePassword = document.getElementById('togglePassword');
    const passwordFields = document.querySelector('.password-fields');

    togglePassword.addEventListener('change', function() {
        if (this.checked) {
            passwordFields.style.display = 'block';
            passwordFields.style.animation = 'slideDown 0.4s ease-out';
        } else {
            passwordFields.style.display = 'none';
            // Clear password fields when hidden
            document.getElementById('current_password').value = '';
            document.getElementById('new_password').value = '';
            document.getElementById('new_password_confirmation').value = '';
        }
    });

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

    // Upload Photo Functionality
    const uploadPhotoBtn = document.getElementById('uploadPhotoBtn');
    const fotoInput = document.getElementById('fotoInput');

    uploadPhotoBtn.addEventListener('click', function() {
        fotoInput.click();
    });

    // Preview image when selected
    fotoInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                // Hide default image if exists
                const defaultImage = document.getElementById('defaultProfileImage');
                if (defaultImage) {
                    defaultImage.style.display = 'none';
                }

                // Create or update image preview
                let preview = document.getElementById('profileImagePreview');
                if (!preview) {
                    preview = document.createElement('img');
                    preview.id = 'profileImagePreview';
                    preview.className = 'profile-image rounded-circle shadow-lg';
                    document.querySelector('.profile-image-container').prepend(preview);
                }

                preview.src = e.target.result;

                // Show delete button
                document.getElementById('deletePhotoBtn').style.display = 'flex';

                // Reset hapus_foto flag
                document.getElementById('hapus_foto').value = '0';
            }

            reader.readAsDataURL(this.files[0]);
        }
    });

    // Delete Photo Functionality
    const deletePhotoBtn = document.getElementById('deletePhotoBtn');
    if (deletePhotoBtn) {
        deletePhotoBtn.addEventListener('click', function() {
            if (confirm('Hapus foto profile?')) {
                // Set hapus_foto flag
                document.getElementById('hapus_foto').value = '1';

                // Hide current image
                const preview = document.getElementById('profileImagePreview');
                if (preview) {
                    preview.style.display = 'none';
                }

                // Show default image with initials
                let defaultImage = document.getElementById('defaultProfileImage');
                if (!defaultImage) {
                    defaultImage = document.createElement('div');
                    defaultImage.id = 'defaultProfileImage';
                    defaultImage.className = 'default-profile-image rounded-circle shadow-lg d-flex align-items-center justify-content-center';

                    // Get user initials
                    const userName = "{{ Auth::user()->nama_pengguna }}";
                    const initials = getInitials(userName);

                    defaultImage.innerHTML = `<span class="initials">${initials}</span>`;
                    document.querySelector('.profile-image-container').prepend(defaultImage);
                } else {
                    defaultImage.style.display = 'flex';
                }

                // Hide delete button
                this.style.display = 'none';

                // Clear file input
                fotoInput.value = '';
            }
        });
    }

    // Function to get user initials
    function getInitials(name) {
        return name
            .split(' ')
            .map(word => word.charAt(0))
            .join('')
            .toUpperCase()
            .substring(0, 2);
    }

    // Form submission loading state
    const profileForm = document.getElementById('profileForm');
    const saveButton = document.querySelector('.btn-save');

    if (profileForm) {
        profileForm.addEventListener('submit', function() {
            saveButton.classList.add('loading');
            saveButton.innerHTML = '<i class="fas fa-spinner me-2"></i>Menyimpan...';
        });
    }

    // Profile image hover effect
    const profileImageContainer = document.querySelector('.profile-image-container');
    if (profileImageContainer) {
        profileImageContainer.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.02)';
        });

        profileImageContainer.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    }
});
</script>
@endsection
