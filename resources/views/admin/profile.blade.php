<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - {{ $user->nama_pengguna }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #2c5aa0;
            --secondary: #6c757d;
            --success: #198754;
            --danger: #dc3545;
            --warning: #ffc107;
            --info: #0dcaf0;
            --light: #f8f9fa;
            --dark: #212529;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .profile-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            margin: 2rem auto;
        }

        .profile-sidebar {
            background: linear-gradient(135deg, var(--primary), #1e4a8a);
            color: white;
            padding: 2rem;
            position: relative;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            border: 4px solid rgba(255,255,255,0.3);
        }

        .profile-avatar i {
            font-size: 3rem;
        }

        .role-badge {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 20px;
            padding: 0.5rem 1.5rem;
            font-size: 0.9rem;
            backdrop-filter: blur(10px);
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        .info-item i {
            width: 20px;
            margin-right: 10px;
            opacity: 0.8;
        }

        .section-title {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--primary);
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(44, 90, 160, 0.25);
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #1e4a8a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(44, 90, 160, 0.3);
        }

        .password-toggle {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        .alert {
            border: none;
            border-radius: 10px;
            padding: 1rem 1.5rem;
        }

        .nav-tabs {
            border-bottom: 2px solid #e9ecef;
        }

        .nav-tabs .nav-link {
            border: none;
            color: var(--secondary);
            font-weight: 500;
            padding: 1rem 2rem;
            border-radius: 0;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary);
            background: none;
            border-bottom: 3px solid var(--primary);
        }

        .tab-content {
            padding: 2rem 0;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="profile-container">
                    <div class="row g-0">
                        <!-- Sidebar Profile -->
                        <div class="col-lg-4">
                            <div class="profile-sidebar">
                                <div class="text-center">
                                    <div class="profile-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <h3 class="mb-2">{{ $user->nama_pengguna }}</h3>
                                    <div class="role-badge mb-4">
                                        {{ strtoupper($user->role) }}
                                    </div>
                                </div>

                                <div class="profile-info">
                                    <div class="info-item">
                                        <i class="fas fa-user"></i>
                                        <div>
                                            <small>Username</small>
                                            <div class="fw-bold">{{ $user->username }}</div>
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <i class="fas fa-envelope"></i>
                                        <div>
                                            <small>Email</small>
                                            <div class="fw-bold">{{ $user->email ?? '-' }}</div>
                                        </div>
                                    </div>

                                    @if($user->role === 'petugas' && isset($petugas))
                                    <div class="info-item">
                                        <i class="fas fa-phone"></i>
                                        <div>
                                            <small>Telepon</small>
                                            <div class="fw-bold">{{ $petugas->telp ?? '-' }}</div>
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <i class="fas fa-venus-mars"></i>
                                        <div>
                                            <small>Gender</small>
                                            <div class="fw-bold">
                                                {{ $petugas->gender == 'L' ? 'Laki-laki' : ($petugas->gender == 'P' ? 'Perempuan' : '-') }}
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="info-item">
                                        <i class="fas fa-calendar"></i>
                                        <div>
                                            <small>Bergabung</small>
                                            <div class="fw-bold">{{ $user->created_at->format('d F Y') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Main Content -->
                        <div class="col-lg-8">
                            <div class="p-4">
                                <!-- Navigation Tabs -->
                                <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit" type="button" role="tab">
                                            <i class="fas fa-edit me-2"></i>Informasi Profile
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">
                                            <i class="fas fa-lock me-2"></i>Ubah Password
                                        </button>
                                    </li>
                                </ul>

                                <!-- Tab Content -->
<div class="tab-content" id="profileTabsContent">
    <!-- Edit Profile Tab -->
    <div class="tab-pane fade show active" id="edit" role="tabpanel">
        <h4 class="section-title">Edit Informasi Profile</h4>
        <form id="editProfileForm">
            @csrf
            <div class="row">
                <!-- Nama Lengkap (Hanya Tampil) -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <div class="form-control bg-light" style="border: 1px solid #dee2e6; padding: 0.75rem; border-radius: 8px;">
                        <strong>{{ $user->nama_pengguna }}</strong>
                    </div>
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle me-1"></i>Nama lengkap tidak dapat diubah
                    </small>
                </div>

                <!-- Username (Bisa Diedit) -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" value="{{ $user->username }}" required>
                    <small class="form-text text-muted">
                        <i class="fas fa-edit me-1"></i>Username dapat diubah
                    </small>
                </div>
            </div>

            <div class="row">
                <!-- Email (Bisa Diedit) -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ $user->email ?? '' }}">
                    <small class="form-text text-muted">
                        <i class="fas fa-edit me-1"></i>Email dapat diubah
                    </small>
                </div>

                <!-- Telepon (Hanya untuk Petugas) -->
                @if($user->role === 'petugas' && isset($petugas))
                <div class="col-md-6 mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="tel" class="form-control" name="telp" value="{{ $petugas->telp ?? '' }}">
                    <small class="form-text text-muted">
                        <i class="fas fa-edit me-1"></i>Nomor telepon dapat diubah
                    </small>
                </div>
                @endif
            </div>

            <!-- Informasi yang Tidak Bisa Diedit -->
            <div class="row">
                <div class="col-12">
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <h6 class="card-title text-muted mb-3">
                                <i class="fas fa-lock me-2"></i>Informasi yang Tidak Dapat Diubah
                            </h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <small class="text-muted">Role</small>
                                    <div class="fw-bold">{{ strtoupper($user->role) }}</div>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Bergabung</small>
                                    <div class="fw-bold">{{ $user->created_at->format('d F Y') }}</div>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">User ID</small>
                                    <div class="fw-bold">#{{ $user->id_user }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

                                    <!-- Ubah Password Tab -->
                                    <div class="tab-pane fade" id="password" role="tabpanel">
                                        <h4 class="section-title">Ubah Password</h4>
                                        <form id="changePasswordForm">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label class="form-label">Password Saat Ini</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                                                        <span class="input-group-text password-toggle">
                                                            <i class="fas fa-eye"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Password Baru</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                                                        <span class="input-group-text password-toggle">
                                                            <i class="fas fa-eye"></i>
                                                        </span>
                                                    </div>
                                                    <div class="form-text text-muted">
                                                        Minimal 8 karakter
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Konfirmasi Password</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                                        <span class="input-group-text password-toggle">
                                                            <i class="fas fa-eye"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-key me-2"></i>Ubah Password
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Alert Area -->
                                <div id="alertArea"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle show/hide password
        document.querySelectorAll('.password-toggle').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'fas fa-eye-slash';
                } else {
                    input.type = 'password';
                    icon.className = 'fas fa-eye';
                }
            });
        });

        // Handle edit profile form
        // Handle edit profile form
document.getElementById('editProfileForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    // Debug: lihat data yang dikirim
    console.log('Data yang dikirim:', Object.fromEntries(formData));

    // Show loading state
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    submitBtn.disabled = true;

    fetch("{{ route('admin.profile.update') }}", {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(Object.fromEntries(formData))
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);

        if (data.success) {
            showAlert(data.message, 'success');
        } else {
            let errorMessage = data.message;
            if (data.errors) {
                console.log('Validation errors:', data.errors);
                // Show first error
                const firstError = Object.values(data.errors)[0];
                errorMessage = firstError;
            }
            showAlert(errorMessage, 'danger');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        showAlert('Terjadi kesalahan jaringan. Coba lagi.', 'danger');
    })
    .finally(() => {
        // Reset button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

function showAlert(message, type) {
    const alertArea = document.getElementById('alertArea');

    // Clear existing alerts
    alertArea.innerHTML = '';

    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show mt-3`;
    alert.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    alertArea.appendChild(alert);

    // Auto remove alert after 5 seconds
    setTimeout(() => {
        if (alert.parentElement) {
            alert.remove();
        }
    }, 5000);
}
    </script>
</body>
</html>
