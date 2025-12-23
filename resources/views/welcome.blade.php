<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORIN - Sistem Pengaduan Sarpras</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Reset & Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary-dark: #31326F;
            --primary: #637AB9;
            --accent: #FF6B6B;
            --light-gray: #D9D9D9;
            --bg-light: #EFF2F8;
            --white: #ffffff;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            color: var(--primary-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0;
            overflow-x: hidden;
        }

        /* Header & Navigation */
        header {
            width: 100%;
            padding: 20px 40px;
            position: fixed;
            top: 0;
            z-index: 1000;
            transition: var(--transition);
        }

        .scrolled {
            padding: 10px 40px !important;
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(15px);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow);
            animation: slideDown 0.8s ease-out;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 20px;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(49, 50, 111, 0.3);
            animation: bounce 2s infinite;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-dark), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links {
            display: flex;
            gap: 25px;
        }

        .nav-link {
            color: var(--primary-dark);
            text-decoration: none;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 8px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .nav-link:hover {
            color: var(--primary);
            transform: translateY(-2px);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 3px;
            background: var(--accent);
            transition: var(--transition);
            border-radius: 10px;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link.active {
            color: var(--accent);
            font-weight: 600;
        }

        .nav-link.active::after {
            width: 100%;
        }

        /* Main Container */
        .welcome-container {
            background: var(--white);
            border-radius: 30px 30px 0 0;
            padding: 100px 40px 60px;
            width: 100%;
            position: relative;
            overflow: hidden;
            animation: fadeIn 0.8s ease-out;
            margin-top: 100px;
            max-width: 1400px;
        }

        section {
            padding: 80px 0;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(3deg); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes heartBeat {
            0%, 100% { transform: scale(1); }
            25% { transform: scale(1.1); }
            50% { transform: scale(0.9); }
            75% { transform: scale(1.05); }
        }

        @keyframes wiggle {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(5deg); }
            75% { transform: rotate(-5deg); }
        }

        /* Hero Section */
        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 60px;
            flex-wrap: wrap;
        }

        .hero-content {
            flex: 1;
            min-width: 300px;
            text-align: left;
            padding-right: 40px;
            animation: slideInLeft 0.8s ease-out;
        }

        .hero-image {
            flex: 1;
            min-width: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: slideInRight 0.8s ease-out;
        }

        .character-container {
            position: relative;
            width: 350px;
            height: 350px;
        }

        .character {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--bg-light), var(--light-gray));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            animation: float 6s ease-in-out infinite;
            overflow: hidden;
        }

        .character-face {
            position: absolute;
            width: 70%;
            height: 70%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .character-eyes {
            display: flex;
            gap: 30px;
            margin-bottom: 15px;
        }

        .character-eye {
            width: 30px;
            height: 30px;
            background: var(--primary-dark);
            border-radius: 50%;
            position: relative;
            animation: blink 4s infinite;
        }

        @keyframes blink {
            0%, 90%, 100% { transform: scaleY(1); }
            95% { transform: scaleY(0.1); }
        }

        .character-mouth {
            width: 60px;
            height: 20px;
            background: var(--accent);
            border-radius: 0 0 30px 30px;
            position: relative;
        }

        .character-accessory {
            position: absolute;
            width: 80px;
            height: 80px;
            background: var(--primary);
            border-radius: 50%;
            top: 40px;
            right: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            animation: wiggle 3s ease-in-out infinite;
        }

        h1 {
            color: var(--primary-dark);
            margin-bottom: 20px;
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.2;
        }

        .highlight {
            color: var(--accent);
            position: relative;
            display: inline-block;
        }

        .highlight::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 0;
            width: 100%;
            height: 10px;
            background: rgba(255, 107, 107, 0.2);
            z-index: -1;
            border-radius: 4px;
        }

        .subtitle {
            color: var(--primary);
            margin-bottom: 35px;
            font-size: 1.2rem;
            line-height: 1.7;
            max-width: 500px;
        }

        /* Section Titles */
        .section-title {
            text-align: center;
            margin-bottom: 50px;
            position: relative;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: var(--primary-dark);
            margin-bottom: 15px;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-dark), var(--accent));
            border-radius: 2px;
        }

        /* About Section */
        .about-content {
            display: flex;
            align-items: center;
            gap: 50px;
            flex-wrap: wrap;
        }

        .about-text {
            flex: 1;
            min-width: 300px;
        }

        .about-text p {
            margin-bottom: 20px;
            line-height: 1.7;
            color: var(--primary);
            font-size: 1.1rem;
        }

        .about-stats {
            display: flex;
            gap: 30px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .stat {
            text-align: center;
            flex: 1;
            min-width: 120px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--accent);
            display: block;
            animation: pulse 2s infinite;
        }

        .stat-label {
            color: var(--primary);
            font-weight: 500;
        }

        .about-visual {
            flex: 1;
            min-width: 300px;
            display: flex;
            justify-content: center;
        }

        .visual-container {
            width: 300px;
            height: 300px;
            position: relative;
        }

        .visual-item {
            position: absolute;
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            animation: float 4s ease-in-out infinite;
        }

        .visual-1 {
            background: var(--primary-dark);
            top: 0;
            left: 0;
            animation-delay: 0s;
        }

        .visual-2 {
            background: var(--primary);
            top: 0;
            right: 0;
            animation-delay: 1s;
        }

        .visual-3 {
            background: var(--accent);
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            animation-delay: 2s;
        }

        /* Services Section */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .service-card {
            background: var(--bg-light);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-dark), var(--accent));
        }

        .service-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 30px;
            animation: pulse 3s infinite;
        }

        .service-card h3 {
            margin-bottom: 15px;
            font-size: 1.4rem;
            color: var(--primary-dark);
        }

        .service-card p {
            color: var(--primary);
            line-height: 1.6;
        }

        /* Contact Section */
        .contact-content {
            display: flex;
            gap: 50px;
            flex-wrap: wrap;
        }

        .contact-info {
            flex: 1;
            min-width: 300px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding: 15px;
            background: var(--bg-light);
            border-radius: 15px;
            transition: var(--transition);
        }

        .contact-item:hover {
            transform: translateX(10px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            margin-right: 15px;
            animation: heartBeat 2s infinite;
        }

        .contact-text h4 {
            margin-bottom: 5px;
            color: var(--primary-dark);
        }

        .contact-text p {
            color: var(--primary);
        }

        .contact-form {
            flex: 1;
            min-width: 300px;
            background: var(--bg-light);
            padding: 30px;
            border-radius: 20px;
            box-shadow: var(--shadow);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--primary-dark);
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--light-gray);
            border-radius: 10px;
            font-size: 16px;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 122, 185, 0.2);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        /* Features */
        .features {
            display: flex;
            justify-content: space-between;
            margin: 60px 0;
            flex-wrap: wrap;
            gap: 25px;
        }

        .feature {
            flex: 1;
            min-width: 250px;
            padding: 30px 20px;
            border-radius: 20px;
            background: var(--bg-light);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .feature:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .feature::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-dark), var(--accent));
        }

        .feature i {
            font-size: 40px;
            color: var(--primary);
            margin-bottom: 20px;
            display: inline-block;
            animation: pulse 2s infinite;
        }

        .feature h3 {
            margin-bottom: 15px;
            font-size: 1.4rem;
            font-weight: 700;
        }

        .feature p {
            font-size: 1rem;
            color: var(--primary);
            line-height: 1.6;
        }

        /* Buttons */
        .button-group {
            display: flex;
            gap: 20px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 16px 35px;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 180px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: var(--transition);
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            color: var(--white);
        }

        .btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(49, 50, 111, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: var(--white);
            transform: translateY(-5px);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--accent), #ff8e8e);
            color: var(--white);
            width: 100%;
            margin-top: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 107, 107, 0.4);
        }

        /* Footer */
        .footer {
            margin-top: 60px;
            color: var(--white);
            text-align: center;
            font-size: 0.9rem;
            opacity: 0.8;
            padding: 20px;
            width: 100%;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            header {
                padding: 15px 20px;
            }

            .navbar {
                flex-direction: column;
                gap: 15px;
                padding: 15px;
            }

            .nav-links {
                gap: 15px;
                flex-wrap: wrap;
                justify-content: center;
            }

            .hero {
                flex-direction: column;
                text-align: center;
                margin-bottom: 40px;
            }

            .hero-content {
                padding-right: 0;
                margin-bottom: 40px;
            }

            h1 {
                font-size: 2.2rem;
            }

            .welcome-container {
                padding: 80px 20px 40px;
                margin-top: 130px;
            }

            .character-container {
                width: 280px;
                height: 280px;
            }

            .button-group {
                justify-content: center;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .about-content, .contact-content {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 0;
            }

            .logo-text {
                font-size: 1.3rem;
            }

            h1 {
                font-size: 1.8rem;
            }

            .feature, .service-card {
                min-width: 100%;
            }

            .btn {
                width: 100%;
                max-width: 280px;
            }

            .character-container {
                width: 240px;
                height: 240px;
            }

            .character-accessory {
                width: 60px;
                height: 60px;
                font-size: 24px;
                top: 30px;
                right: 30px;
            }
        }

        /* Decorative Elements */
        .decoration {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            z-index: 0;
        }

        .decoration-1 {
            width: 200px;
            height: 200px;
            background: var(--primary-dark);
            top: -80px;
            right: -80px;
        }

        .decoration-2 {
            width: 150px;
            height: 150px;
            background: var(--accent);
            bottom: -60px;
            left: -60px;
        }

        /* Floating elements */
        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 1;
        }

        .floating-element {
            position: absolute;
            border-radius: 50%;
            background: var(--primary);
            opacity: 0.1;
            animation: float 8s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            width: 40px;
            height: 40px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 60%;
            right: 10%;
            animation-delay: 1s;
        }

        .floating-element:nth-child(3) {
            width: 30px;
            height: 30px;
            bottom: 20%;
            left: 20%;
            animation-delay: 2s;
        }

        /* Scroll to top button */
        .scroll-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--accent);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 1000;
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
        }

        .scroll-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .scroll-to-top:hover {
            transform: translateY(-5px);
            background: var(--primary-dark);
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo-container">
                <div class="logo">L</div>
                <div class="logo-text">LAPORIN</div>
            </div>
            <div class="nav-links">
                <a href="#home" class="nav-link active">Home</a>
                <a href="#about" class="nav-link">About Sarpras</a>
                <a href="#layanan" class="nav-link">Layanan</a>
                <a href="#kontak" class="nav-link">Kontak</a>
            </div>
        </nav>
    </header>

    <div class="welcome-container">
        <div class="decoration decoration-1"></div>
        <div class="decoration decoration-2"></div>

        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>

        <!-- Home Section -->
        <section id="home">
            <div class="hero">
                <div class="hero-content">
                    <h1>Sistem Pengaduan <span class="highlight">Sarpras</span> Terpercaya</h1>
                    <p class="subtitle">LAPORIN memudahkan Anda melaporkan masalah sarana dan prasarana dengan cepat, mudah, dan transparan. Dapatkan solusi terbaik untuk setiap pengaduan Anda.</p>

                    <div class="button-group">
                        <a href="{{ route('login') }}" class="btn btn-primary">
    <i class="fas fa-sign-in-alt"></i>&nbsp; Login Sekarang
</a>
<a href="{{ route('register') }}" class="btn btn-secondary">
    <i class="fas fa-user-plus"></i>&nbsp; Daftar Akun
</a>
                    </div>
                </div>

                <div class="hero-image">
                    <div class="character-container">
                        <div class="character">
                            <div class="character-face">
                                <div class="character-eyes">
                                    <div class="character-eye"></div>
                                    <div class="character-eye"></div>
                                </div>
                                <div class="character-mouth"></div>
                            </div>
                            <div class="character-accessory">
                                <i class="fas fa-tools"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="features">
                <div class="feature">
                    <i class="fas fa-bullhorn"></i>
                    <h3>Laporkan</h3>
                    <p>Laporkan masalah sarpras dengan mudah melalui platform kami</p>
                </div>
                <div class="feature">
                    <i class="fas fa-tasks"></i>
                    <h3>Proses</h3>
                    <p>Tim kami akan memproses laporan Anda dengan cepat dan tepat</p>
                </div>
                <div class="feature">
                    <i class="fas fa-check-circle"></i>
                    <h3>Selesai</h3>
                    <p>Dapatkan konfirmasi ketika masalah telah terselesaikan</p>
                </div>
                <div class="feature">
                    <i class="fas fa-chart-line"></i>
                    <h3>Pantau</h3>
                    <p>Pantau perkembangan laporan Anda secara real-time</p>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about">
            <div class="section-title">
                <h2>Tentang Sarpras</h2>
            </div>
            <div class="about-content">
                <div class="about-text">
                    <p>Sarana dan Prasarana (Sarpras) merupakan komponen penting dalam menunjang aktivitas sehari-hari di lingkungan kerja, pendidikan, dan masyarakat. Kelancaran operasional sangat bergantung pada kondisi sarpras yang memadai.</p>
                    <p>LAPORIN hadir sebagai solusi digital untuk memudahkan pelaporan dan penanganan masalah sarpras. Dengan sistem yang terintegrasi, setiap laporan dapat ditindaklanjuti dengan cepat dan efisien.</p>
                    <p>Kami berkomitmen untuk memberikan pelayanan terbaik dalam menjaga dan memperbaiki sarana prasarana demi kenyamanan dan produktivitas bersama.</p>

                    <div class="about-stats">
                        <div class="stat">
                            <span class="stat-number" data-count="5000">0</span>
                            <span class="stat-label">Laporan Diproses</span>
                        </div>
                        <div class="stat">
                            <span class="stat-number" data-count="98">0</span>
                            <span class="stat-label">% Kepuasan</span>
                        </div>
                        <div class="stat">
                            <span class="stat-number" data-count="24">0</span>
                            <span class="stat-label">Jam Respon</span>
                        </div>
                    </div>
                </div>
                <div class="about-visual">
                    <div class="visual-container">
                        <div class="visual-item visual-1">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="visual-item visual-2">
                            <i class="fas fa-wrench"></i>
                        </div>
                        <div class="visual-item visual-3">
                            <i class="fas fa-heart"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="layanan">
            <div class="section-title">
                <h2>Layanan Kami</h2>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3>Pelaporan Online</h3>
                    <p>Laporkan masalah sarpras kapan saja dan di mana saja melalui platform digital kami yang mudah digunakan.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3>Perbaikan Cepat</h3>
                    <p>Tim teknisi profesional siap menangani perbaikan dengan cepat dan berkualitas untuk berbagai jenis masalah.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3>Monitoring Real-time</h3>
                    <p>Pantau status laporan Anda secara real-time dan dapatkan notifikasi ketika masalah telah ditangani.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Dukungan 24/7</h3>
                    <p>Tim customer service siap membantu Anda kapan pun dibutuhkan untuk memastikan kelancaran pelaporan.</p>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="kontak">
            <div class="section-title">
                <h2>Kontak Kami</h2>
            </div>
            <div class="contact-content">
                <div class="contact-info">
                    <div class="contact-item">
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Email</h4>
                            <p>laporingaluh1@gmail.com</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Jam Operasional</h4>
                            <p>Senin - Jumat: 08.00 - 17.00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="scroll-to-top">
        <i class="fas fa-chevron-up"></i>
    </div>

    <div class="footer">
        <p>&copy; 2023 LAPORIN - Sistem Pengaduan Sarpras. All rights reserved.</p>
    </div>

    <script>
        // Animasi dan interaktivitas
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll untuk navigasi
            const navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href');
                    const targetSection = document.querySelector(targetId);

                    if (targetSection) {
                        // Update active nav link
                        navLinks.forEach(l => l.classList.remove('active'));
                        this.classList.add('active');

                        // Scroll ke section dengan offset untuk navbar fixed
                        const offsetTop = targetSection.offsetTop - 100;
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Animasi navbar link hover
            navLinks.forEach(link => {
                link.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                });

                link.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Animasi tombol
            const buttons = document.querySelectorAll('.btn');

            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });

                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Efek scroll pada navbar
            window.addEventListener('scroll', function() {
                const header = document.querySelector('header');
                const scrollToTop = document.querySelector('.scroll-to-top');

                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }

                // Tampilkan/tutup scroll to top button
                if (window.scrollY > 500) {
                    scrollToTop.classList.add('show');
                } else {
                    scrollToTop.classList.remove('show');
                }

                // Update active nav link berdasarkan scroll position
                const sections = document.querySelectorAll('section');
                let currentSection = '';

                sections.forEach(section => {
                    const sectionTop = section.offsetTop - 150;
                    const sectionHeight = section.clientHeight;

                    if (window.scrollY >= sectionTop && window.scrollY < sectionTop + sectionHeight) {
                        currentSection = section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${currentSection}`) {
                        link.classList.add('active');
                    }
                });
            });

            // Scroll to top functionality
            document.querySelector('.scroll-to-top').addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Animasi ketik untuk subtitle
            const subtitle = document.querySelector('.subtitle');
            const text = "LAPORIN memudahkan Anda melaporkan masalah sarana dan prasarana dengan cepat, mudah, dan transparan. Dapatkan solusi terbaik untuk setiap pengaduan Anda.";
            subtitle.textContent = '';

            let i = 0;
            function typeWriter() {
                if (i < text.length) {
                    subtitle.textContent += text.charAt(i);
                    i++;
                    setTimeout(typeWriter, 30);
                }
            }

            // Jalankan efek ketik setelah delay
            setTimeout(typeWriter, 1000);

            // Animasi counter untuk stats
            const statNumbers = document.querySelectorAll('.stat-number');

            function animateCounter(element, target) {
                let current = 0;
                const increment = target / 100;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        element.textContent = target;
                        clearInterval(timer);
                    } else {
                        element.textContent = Math.floor(current);
                    }
                }, 20);
            }

            // Observer untuk animasi saat scroll
            const observerOptions = {
                threshold: 0.2,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';

                        // Animate stats counter
                        if (entry.target.id === 'about') {
                            statNumbers.forEach(stat => {
                                const target = parseInt(stat.getAttribute('data-count'));
                                animateCounter(stat, target);
                            });
                        }
                    }
                });
            }, observerOptions);

            // Observe sections for animation
            const sections = document.querySelectorAll('section');
            sections.forEach(section => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(section);
            });

            // Form submission
            document.getElementById('contactForm').addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Terima kasih! Pesan Anda telah berhasil dikirim.');
                this.reset();
            });
        });
    </script>
</body>
</html>
