<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - LAPORIN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reset & base */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary-dark: #31326F;
            --primary: #637AB9;
            --accent: #FF6B6B;
            --light-gray: #D9D9D9;
            --bg-light: #EFF2F8;
            --white: #ffffff;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            color: var(--primary-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background Elements */
        .bg-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 0;
        }

        .bg-element {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .bg-element:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .bg-element:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .bg-element:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        /* Main container */
        .register-container {
            background: var(--white);
            border-radius: 25px;
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 480px;
            padding: 40px;
            position: relative;
            z-index: 1;
            animation: slideUp 0.8s ease-out;
            overflow: hidden;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header */
        .register-header {
            text-align: center;
            margin-bottom: 30px;
            animation: fadeIn 0.8s ease-out 0.2s both;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .logo {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 24px;
            font-weight: bold;
            box-shadow: 0 8px 20px rgba(49, 50, 111, 0.3);
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .brand {
            font-weight: 800;
            font-size: 2rem;
            background: linear-gradient(135deg, var(--primary-dark), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 0.05em;
        }

        .welcome-text {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 5px;
        }

        .subtitle {
            color: var(--primary);
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* Form styles */
        form {
            animation: fadeIn 0.8s ease-out 0.4s both;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
            animation: slideInRight 0.6s ease-out both;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        label {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--primary-dark);
            display: block;
            margin-bottom: 8px;
            transition: var(--transition);
        }

        .input-wrapper {
            position: relative;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            border: 2px solid var(--light-gray);
            border-radius: 15px;
            background: var(--bg-light);
            font-size: 1rem;
            padding: 15px 20px;
            outline: none;
            transition: var(--transition);
            color: var(--primary-dark);
            font-weight: 500;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: var(--primary);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(99, 122, 185, 0.2);
            transform: translateY(-2px);
        }

        input::placeholder {
            color: #999;
            font-weight: normal;
        }

        .input-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            transition: var(--transition);
        }

        input:focus + .input-icon {
            color: var(--accent);
        }

        /* Password field */
        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--primary);
            transition: var(--transition);
            background: none;
            border: none;
            font-size: 1.2rem;
            z-index: 2;
        }

        .toggle-password:hover {
            color: var(--accent);
            transform: translateY(-50%) scale(1.1);
        }

        /* Submit button */
        .submit-btn {
            width: 100%;
            padding: 16px 0;
            border: none;
            border-radius: 15px;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            color: var(--white);
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 10px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(49, 50, 111, 0.3);
        }

        .submit-btn.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: var(--transition);
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:hover:not(.loading) {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(49, 50, 111, 0.4);
        }

        .submit-btn:active {
            transform: translateY(-1px);
        }

        /* Error messages */
        .alert {
            border-radius: 15px;
            border: none;
            animation: shake 0.5s ease-in-out;
        }

        .alert-danger {
            background: rgba(255, 107, 107, 0.1);
            color: var(--accent);
            border-left: 4px solid var(--accent);
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Login link */
        .login-link {
            margin-top: 25px;
            font-size: 0.9rem;
            color: var(--primary);
            text-align: center;
            animation: fadeIn 0.8s ease-out 0.6s both;
        }

        .login-link a {
            color: var(--primary-dark);
            font-weight: 600;
            text-decoration: none;
            position: relative;
            transition: var(--transition);
        }

        .login-link a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: var(--transition);
        }

        .login-link a:hover {
            color: var(--accent);
        }

        .login-link a:hover::after {
            width: 100%;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px 0;
            font-size: 0.8rem;
            color: var(--white);
            opacity: 0.8;
            margin-top: 30px;
            animation: fadeIn 0.8s ease-out 0.8s both;
        }

        /* Decorative elements in form */
        .form-decoration {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            z-index: -1;
        }

        .form-decoration-1 {
            width: 120px;
            height: 120px;
            background: var(--primary-dark);
            top: -40px;
            right: -40px;
        }

        .form-decoration-2 {
            width: 80px;
            height: 80px;
            background: var(--accent);
            bottom: -30px;
            left: -30px;
        }

        /* Password strength indicator */
        .password-strength {
            height: 4px;
            border-radius: 2px;
            margin-top: 5px;
            transition: var(--transition);
        }

        .strength-weak { background: var(--accent); width: 25%; }
        .strength-medium { background: orange; width: 50%; }
        .strength-strong { background: #25D366; width: 100%; }

        /* Responsive */
        @media (max-width: 480px) {
            .register-container {
                padding: 30px 25px;
            }

            .brand {
                font-size: 1.7rem;
            }

            .welcome-text {
                font-size: 1.3rem;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"] {
                padding: 12px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="bg-elements">
        <div class="bg-element"></div>
        <div class="bg-element"></div>
        <div class="bg-element"></div>
    </div>

    <div class="register-container">
        <div class="form-decoration form-decoration-1"></div>
        <div class="form-decoration form-decoration-2"></div>

        <div class="register-header">
            <div class="logo-container">
                <div class="logo">L</div>
                <div class="brand">LAPORIN</div>
            </div>
            <h1 class="welcome-text">Buat Akun Baru</h1>
            <p class="subtitle">Daftar untuk mulai menggunakan LAPORIN</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group" style="animation-delay: 0.1s">
                <label for="username">Username</label>
                <div class="input-wrapper">
                    <input
                        id="username"
                        name="username"
                        type="text"
                        placeholder="Masukkan username"
                        value="{{ old('username') }}"
                        required
                        autofocus
                    />
                    <i class="fas fa-user input-icon"></i>
                </div>
            </div>

            <div class="form-group" style="animation-delay: 0.2s">
                <label for="nama_pengguna">Nama Lengkap</label>
                <div class="input-wrapper">
                    <input
                        id="nama_pengguna"
                        name="nama_pengguna"
                        type="text"
                        placeholder="Masukkan nama lengkap"
                        value="{{ old('nama_pengguna') }}"
                        required
                    />
                    <i class="fas fa-id-card input-icon"></i>
                </div>
            </div>

            <div class="form-group" style="animation-delay: 0.3s">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <input
                        id="email"
                        name="email"
                        type="email"
                        placeholder="Masukkan email"
                        value="{{ old('email') }}"
                        required
                    />
                    <i class="fas fa-envelope input-icon"></i>
                </div>
            </div>

            <div class="form-group" style="animation-delay: 0.4s">
                <label for="password">Password</label>
                <div class="input-wrapper password-wrapper">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Buat password"
                        required
                    />
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password')" aria-label="Toggle password visibility">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="password-strength" id="passwordStrength"></div>
            </div>

            <div class="form-group" style="animation-delay: 0.5s">
                <label for="password_confirmation">Konfirmasi Password</label>
                <div class="input-wrapper password-wrapper">
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        placeholder="Konfirmasi password"
                        required
                    />
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password_confirmation')" aria-label="Toggle password visibility">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div id="passwordMatch" class="mt-2" style="font-size: 0.8rem;"></div>
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </button>
        </form>

        <div class="login-link">
            <a href="{{ route('login') }}">Sudah punya akun? Login</a>
        </div>
    </div>

    <footer>
        © Copyright 2025 LAPORIN - Sistem Pengaduan Sarpras
    </footer>

    <script>
        // Toggle password visibility
        function togglePasswordVisibility(fieldId) {
            const pwInput = document.getElementById(fieldId);
            const toggleIcon = pwInput.parentElement.querySelector('.toggle-password i');

            if (pwInput.type === 'password') {
                pwInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                pwInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('passwordStrength');
            let strength = 0;

            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/\d/)) strength++;
            if (password.match(/[^a-zA-Z\d]/)) strength++;

            strengthBar.className = 'password-strength';
            if (password.length === 0) {
                strengthBar.style.width = '0';
            } else if (strength <= 1) {
                strengthBar.className += ' strength-weak';
            } else if (strength <= 2) {
                strengthBar.className += ' strength-medium';
            } else {
                strengthBar.className += ' strength-strong';
            }
        });

        // Password confirmation check
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            const matchText = document.getElementById('passwordMatch');

            if (confirmPassword === '') {
                matchText.innerHTML = '';
            } else if (password === confirmPassword) {
                matchText.innerHTML = '<i class="fas fa-check-circle" style="color: #25D366;"></i> Password cocok';
            } else {
                matchText.innerHTML = '<i class="fas fa-times-circle" style="color: var(--accent);"></i> Password tidak cocok';
            }
        });

        // Form submission - FIXED VERSION
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;

            // Only show loading state, don't prevent default submission
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Membuat akun...';
            submitBtn.classList.add('loading');

            // Form akan tetap tersubmit secara normal ke Laravel
            // Laravel yang akan handle redirect setelah berhasil
        });

        // Input focus effects
        const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });

        // Add floating animation to form elements on load
        document.addEventListener('DOMContentLoaded', function() {
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach((group, index) => {
                group.style.animationDelay = `${0.1 + index * 0.1}s`;
            });
        });

        // Reset button state jika form validation gagal
        // Ini akan di-trigger ketika Laravel return back dengan errors
        window.addEventListener('pageshow', function() {
            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn.classList.contains('loading')) {
                submitBtn.innerHTML = '<i class="fas fa-user-plus"></i> Daftar Sekarang';
                submitBtn.classList.remove('loading');
            }
        });
    </script>
</body>
</html>
