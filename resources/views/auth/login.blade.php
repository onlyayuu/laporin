<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - LAPORIN</title>
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
        .login-container {
            background: var(--white);
            border-radius: 25px;
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 420px;
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
        .login-header {
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
            margin-bottom: 25px;
            position: relative;
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

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(49, 50, 111, 0.4);
        }

        .submit-btn:active {
            transform: translateY(-1px);
        }

        /* Error messages */
        .error-message {
            color: var(--accent);
            font-size: 0.8rem;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Sign up text */
        .sign-up {
            margin-top: 25px;
            font-size: 0.9rem;
            color: var(--primary);
            text-align: center;
            animation: fadeIn 0.8s ease-out 0.6s both;
        }

        .sign-up a {
            color: var(--primary-dark);
            font-weight: 600;
            text-decoration: none;
            position: relative;
            transition: var(--transition);
        }

        .sign-up a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: var(--transition);
        }

        .sign-up a:hover {
            color: var(--accent);
        }

        .sign-up a:hover::after {
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

        /* Success animation */
        @keyframes success {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 25px;
            }

            .brand {
                font-size: 1.7rem;
            }

            .welcome-text {
                font-size: 1.3rem;
            }

            input[type="text"],
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

    <div class="login-container">
        <div class="form-decoration form-decoration-1"></div>
        <div class="form-decoration form-decoration-2"></div>

        <div class="login-header">
            <div class="logo-container">
                <div class="logo">L</div>
                <div class="brand">LAPORIN</div>
            </div>
            <h1 class="welcome-text">Welcome Back!</h1>
            <p class="subtitle">Silakan login untuk melanjutkan</p>
        </div>

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf
            <input type="hidden" name="remember" value="1" />

            <div class="form-group">
                <label for="id_user">Username</label>
                <div class="input-wrapper">
                    <input
                        id="id_user"
                        name="username"
                        type="text"
                        placeholder="Masukkan username Anda"
                        value="{{ old('username') }}"
                        required
                        autofocus
                    />
                    <i class="fas fa-user input-icon"></i>
                </div>
                @error('username')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper password-wrapper">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Masukkan password Anda"
                        required
                    />
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility()" aria-label="Toggle password visibility">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-sign-in-alt"></i> Log In
            </button>
        </form>

        <div class="sign-up">
            <a href="{{ route('register') }}">Belum punya akun? Daftar disini</a>
        </div>
    </div>

    <footer>
        © Copyright 2025 LAPORIN - Sistem Pengaduan Sarpras
    </footer>

    <script>
        // Toggle password visibility
        function togglePasswordVisibility() {
            const pwInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password i');

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

        // Form submission animation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const submitBtn = document.querySelector('.submit-btn');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            submitBtn.style.animation = 'success 0.5s ease-in-out';
        });

        // Input focus effects
        const inputs = document.querySelectorAll('input[type="text"], input[type="password"]');
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
                group.style.animation = `slideUp 0.6s ease-out ${0.3 + index * 0.1}s both`;
            });
        });
    </script>
</body>
</html>
