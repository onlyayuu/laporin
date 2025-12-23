<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporin - Sistem Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #31326F;
            --secondary: #637AB9;
            --light: #D9D9D9;
            --background: #EFF2F8;
            --white: #FFFFFF;
            --text: #333333;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --radius: 12px;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--background);
            font-family: 'Poppins', 'Inter', 'Segoe UI', sans-serif;
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Navbar Sederhana */
        .navbar-simple {
            background: var(--white);
            box-shadow: var(--shadow);
            padding: 0.8rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            height: 80px;
            transition: var(--transition);
        }

        .navbar-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0 2rem;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            margin-left: 0;
            transition: var(--transition);
        }

        .logo-img {
            height: 60px;
            width: auto;
            object-fit: contain;
            transition: var(--transition);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .user-name {
            color: var(--primary);
            font-weight: 500;
            font-size: 1rem;
            position: relative;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            background: rgba(49, 50, 111, 0.05);
            transition: var(--transition);
        }

        .logout-btn {
            background: transparent;
            border: 1px solid var(--secondary);
            color: var(--secondary);
            padding: 0.5rem 1.2rem;
            border-radius: 6px;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            position: relative;
            overflow: hidden;
        }

        .logout-btn:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--secondary);
            transition: var(--transition);
            z-index: -1;
        }

        .logout-btn:hover {
            color: white;
        }

        .logout-btn:hover:before {
            left: 0;
        }

        /* Main Layout */
        .main-container {
            display: flex;
            min-height: calc(100vh - 80px);
        }

        /* Sidebar Fixed */
        .sidebar {
            width: 280px;
            background: var(--white);
            box-shadow: var(--shadow);
            padding: 2rem 0;
            transition: var(--transition);
            position: fixed;
            top: 80px;
            left: 0;
            height: calc(100vh - 80px);
            overflow-y: auto;
            z-index: 99;
            border-radius: 0 var(--radius) var(--radius) 0;
        }

        .sidebar-header {
            padding: 0 1.5rem 1.5rem;
            border-bottom: 1px solid var(--light);
            margin-bottom: 1rem;
        }

        .sidebar-header h5 {
            color: var(--primary);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .nav-item {
            margin-bottom: 0.5rem;
            position: relative;
        }

        .nav-link {
            color: var(--text);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: var(--transition);
            border-left: 3px solid transparent;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .nav-link:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(99, 122, 185, 0.1), transparent);
            transition: var(--transition);
        }

        .nav-link:hover:before {
            left: 100%;
        }

        .nav-link:hover {
            background: var(--background);
            color: var(--primary);
            border-left-color: var(--secondary);
            transform: translateX(5px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(99, 122, 185, 0.1), rgba(49, 50, 111, 0.05));
            color: var(--primary);
            border-left-color: var(--primary);
            font-weight: 500;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.03);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
            transition: var(--transition);
        }

        .nav-link:hover i {
            transform: scale(1.1);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            background: var(--background);
            margin-left: 280px;
            transition: var(--transition);
        }

        .content-area {
            background: var(--white);
            border-radius: var(--radius);
            padding: 2rem;
            box-shadow: var(--shadow);
            border: 1px solid rgba(0, 0, 0, 0.03);
            position: relative;
            overflow: hidden;
        }

        .content-area:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.5s ease;
        }

        .content-area.loaded:before {
            transform: scaleX(1);
        }

        /* Toggle Sidebar Button */
        .toggle-sidebar-btn {
            display: none;
            position: fixed;
            top: 90px;
            left: 20px;
            background: var(--secondary);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 101;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-sidebar-btn:hover {
            background: var(--primary);
            transform: scale(1.05);
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: 8px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .alert:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.08);
            color: #0f5132;
        }

        .alert-success:before {
            background: #28a745;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.08);
            color: #721c24;
        }

        .alert-danger:before {
            background: #dc3545;
        }

        /* Floating Elements */
        .floating-elements {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 99;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .floating-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(49, 50, 111, 0.3);
            transition: var(--transition);
            cursor: pointer;
            border: none;
        }

        .floating-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(49, 50, 111, 0.4);
        }

        /* Mobile Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.expanded {
                margin-left: 0;
            }

            .toggle-sidebar-btn {
                display: flex;
            }

            .logo-img {
                height: 50px;
            }

            .navbar-container {
                padding: 0 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .navbar-container {
                padding: 0 1rem;
            }

            .user-info {
                gap: 1rem;
            }

            .logo-img {
                height: 45px;
            }
        }

        @media (max-width: 576px) {
            .navbar-simple {
                height: 70px;
                padding: 0.6rem 0;
            }

            .navbar-brand {
                font-size: 1.1rem;
            }

            .main-content {
                padding: 1rem;
            }

            .content-area {
                padding: 1.25rem;
            }

            .alert {
                padding: 0.875rem 1rem;
            }

            .logo-img {
                height: 40px;
            }

            .user-name {
                display: none;
            }

            .sidebar {
                top: 70px;
                height: calc(100vh - 70px);
            }

            .toggle-sidebar-btn {
                top: 80px;
            }

            .logout-btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }

            .navbar-container {
                padding: 0 0.5rem;
            }
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .slide-in-left {
            animation: slideInLeft 0.4s ease-out;
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(99, 122, 185, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(99, 122, 185, 0); }
            100% { box-shadow: 0 0 0 0 rgba(99, 122, 185, 0); }
        }

        /* Smooth transitions */
        .navbar-brand,
        .main-content,
        .sidebar {
            transition: var(--transition);
        }

        /* Logo positioning untuk desktop */
        @media (min-width: 993px) {
            .navbar-brand {
                position: absolute;
                left: 2rem;
                top: 50%;
                transform: translateY(-50%);
            }

            .user-info {
                margin-left: auto;
                margin-right: 2rem;
            }
        }

        /* Loading animation */
        .loading-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transform: scaleX(0);
            transform-origin: left;
            z-index: 9999;
            transition: transform 0.3s ease;
        }

        /* Card hover effects */
        .card-hover {
            transition: var(--transition);
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <!-- Loading Bar -->
    <div class="loading-bar" id="loadingBar"></div>

    <!-- Navbar Sederhana -->
    <nav class="navbar navbar-simple">
        <div class="navbar-container">
            <!-- Logo di pojok kiri -->
            <a class="navbar-brand" href="{{ route('user.dashboard') }}">
                <img src="{{ asset('asset/LAPORIN.png') }}" alt="Laporin Logo" class="logo-img">
            </a>

            <div class="user-info">
                <span class="user-name">{{ Auth::user()->nama_pengguna }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Toggle Sidebar Button -->
    <button class="toggle-sidebar-btn" id="toggleSidebarBtn">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Floating Elements -->
    <div class="floating-elements">
        <button class="floating-btn pulse" id="scrollToTop" title="Kembali ke atas">
            <i class="fas fa-arrow-up"></i>
        </button>
        <button class="floating-btn" id="toggleTheme" title="Ubah tema">
            <i class="fas fa-moon"></i>
        </button>
    </div>

    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h5><i class="fas fa-user-circle"></i> Menu Pengguna</h5>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link {{ Request::routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
                <a class="nav-link {{ Request::routeIs('user.pengaduan.index') ? 'active' : '' }}" href="{{ route('user.pengaduan.index') }}">
                    <i class="fas fa-history"></i>
                    Riwayat Pengaduan
                </a>
                <a class="nav-link {{ Request::routeIs('user.pengaduan.create') ? 'active' : '' }}" href="{{ route('user.pengaduan.create') }}">
                    <i class="fas fa-plus-circle"></i>
                    Ajukan Pengaduan
                </a>
                <a class="nav-link {{ Request::routeIs('user.edukasi') ? 'active' : '' }}" href="{{ route('user.edukasi') }}">
                    <i class="fas fa-graduation-cap"></i>
                    Edukasi
                </a>
                <!-- TAMBAHAN MENU PROFILE -->
                <a class="nav-link {{ Request::routeIs('user.profile') ? 'active' : '' }}" href="{{ route('user.profile') }}">
                    <i class="fas fa-user"></i>
                    Profile Saya
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <div class="content-area fade-in" id="contentArea">
                @if(session('success'))
                    <div class="alert alert-success slide-in-left">
                        <i class="fas fa-check-circle text-success"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger slide-in-left">
                        <i class="fas fa-exclamation-circle text-danger"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Sidebar Functionality
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebarBtn');
        const mainContent = document.getElementById('mainContent');
        const navbarBrand = document.querySelector('.navbar-brand');
        const contentArea = document.getElementById('contentArea');
        const loadingBar = document.getElementById('loadingBar');
        const scrollToTopBtn = document.getElementById('scrollToTop');
        const toggleThemeBtn = document.getElementById('toggleTheme');

        // Initialize loading bar
        window.addEventListener('load', function() {
            loadingBar.style.transform = 'scaleX(1)';
            setTimeout(() => {
                loadingBar.style.opacity = '0';
                contentArea.classList.add('loaded');
            }, 500);
        });

        toggleBtn.addEventListener('click', () => {
            const isShowing = sidebar.classList.toggle('show');
            mainContent.classList.toggle('expanded');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 992) {
                if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target) && sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                    mainContent.classList.remove('expanded');
                }
            }
        });

        // Active menu highlighting
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                sidebar.classList.remove('show');
                mainContent.classList.remove('expanded');
            }
        });

        // Scroll to top functionality
        scrollToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Show/hide scroll to top button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.style.display = 'flex';
            } else {
                scrollToTopBtn.style.display = 'none';
            }
        });

        // Theme toggle functionality
        toggleThemeBtn.addEventListener('click', function() {
            document.body.classList.toggle('dark-theme');
            const icon = toggleThemeBtn.querySelector('i');

            if (document.body.classList.contains('dark-theme')) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
                document.documentElement.style.setProperty('--primary', '#637AB9');
                document.documentElement.style.setProperty('--secondary', '#31326F');
                document.documentElement.style.setProperty('--background', '#1a1a2e');
                document.documentElement.style.setProperty('--white', '#16213e');
                document.documentElement.style.setProperty('--text', '#e6e6e6');
                document.documentElement.style.setProperty('--light', '#0f3460');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
                document.documentElement.style.setProperty('--primary', '#31326F');
                document.documentElement.style.setProperty('--secondary', '#637AB9');
                document.documentElement.style.setProperty('--background', '#EFF2F8');
                document.documentElement.style.setProperty('--white', '#FFFFFF');
                document.documentElement.style.setProperty('--text', '#333333');
                document.documentElement.style.setProperty('--light', '#D9D9D9');
            }
        });

        // Add hover effects to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.classList.add('card-hover');
            });
        });
    </script>
</body>
</html>
