<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petugas - Sistem Pengaduan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #31326F;
            --secondary: #637AB9;
            --neutral: #D9D9D9;
            --background: #EFF2F8;
            --white: #FFFFFF;
            --text-dark: #1A1D29;
            --text-light: #6B7280;
            --radius-lg: 16px;
            --radius-md: 12px;
            --radius-sm: 8px;
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* LAYOUT */
        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background-color: var(--white);
            box-shadow: var(--shadow-md);
            padding: 1.5rem 1rem;
            transition: all 0.3s ease;
            z-index: 1000;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transform: translateX(0);
        }

        .sidebar.collapsed {
            width: 80px;
            transform: translateX(0);
        }

        .sidebar-header {
            padding: 0 0.75rem 1.5rem;
            border-bottom: 1px solid var(--neutral);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-image {
            width: 70px;
            height: 70px;
            border-radius: 8px;
            object-fit: contain;
        }

        .sidebar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary);
            text-decoration: none;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .sidebar-brand {
            opacity: 0;
            visibility: hidden;
        }

        .toggle-btn {
            background: none;
            border: none;
            color: var(--primary);
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
        }

        .toggle-btn:hover {
            background-color: var(--background);
        }

        .nav-link {
            color: var(--text-dark);
            font-weight: 500;
            border-radius: var(--radius-md);
            margin: 4px 0;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            white-space: nowrap;
        }

        .nav-link:hover, .nav-link.active {
            background-color: var(--secondary);
            color: var(--white);
            transform: translateX(5px);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .nav-text {
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .nav-text {
            opacity: 0;
            visibility: hidden;
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            margin-left: 260px;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        /* TOP NAVBAR */
        .top-navbar {
            background-color: var(--white);
            box-shadow: var(--shadow-sm);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 999;
            position: sticky;
            top: 0;
            transition: all 0.3s ease;
        }

        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--primary);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: var(--radius-sm);
        }

        .mobile-toggle:hover {
            background-color: var(--background);
        }

        .search-container {
            position: relative;
            width: 320px;
            transition: all 0.3s ease;
        }

        .search-container:focus-within {
            transform: scale(1.02);
        }

        .search-container:focus-within .search-icon {
            color: var(--secondary);
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid var(--neutral);
            border-radius: var(--radius-md);
            background-color: var(--background);
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(99, 122, 185, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            transition: color 0.2s ease;
            cursor: pointer;
        }

        .search-clear {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-light);
            cursor: pointer;
            opacity: 0;
            transition: all 0.2s ease;
            display: none;
        }

        .search-input:not(:placeholder-shown) + .search-icon + .search-clear {
            opacity: 1;
            display: block;
        }

        .search-clear:hover {
            color: var(--secondary);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .nav-icon {
            position: relative;
            color: var(--text-dark);
            font-size: 1.25rem;
            transition: all 0.2s ease;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: var(--radius-sm);
        }

        .nav-icon:hover {
            color: var(--secondary);
            background-color: var(--background);
            transform: scale(1.1);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #EF4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: var(--radius-md);
            transition: all 0.2s ease;
        }

        .user-profile:hover {
            background-color: var(--background);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            transition: transform 0.2s ease;
        }

        .user-profile:hover .user-avatar {
            transform: rotate(10deg);
        }

        .user-name {
            font-weight: 500;
            font-size: 0.875rem;
        }

        /* CONTENT AREA */
        .content-area {
            padding: 2rem;
            flex: 1;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            animation: slideIn 0.6s ease;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .page-title {
            font-weight: 700;
            font-size: 1.75rem;
            color: var(--text-dark);
            margin: 0;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-actions {
            display: flex;
            gap: 0.75rem;
        }

        /* STAT CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            border: 1px solid transparent;
            animation: cardSlide 0.5s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        @keyframes cardSlide {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .stat-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-5px) scale(1.02);
        }

        .stat-card-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .stat-card-content {
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 1;
        }

        .stat-value {
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .stat-icon {
            align-self: flex-end;
            margin-top: -2rem;
            opacity: 0.8;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.2) rotate(5deg);
        }

        /* TABLE SECTION */
        .table-container {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .table-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--neutral);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-title {
            font-weight: 600;
            font-size: 1.125rem;
            margin: 0;
        }

        .table-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn {
            border-radius: var(--radius-md);
            font-weight: 500;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transition: all 0.3s ease;
            transform: translate(-50%, -50%);
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--neutral);
            color: var(--text-dark);
        }

        .btn-outline:hover {
            background-color: var(--background);
            border-color: var(--secondary);
            transform: translateY(-2px);
        }

        .table {
            margin: 0;
            transition: all 0.3s ease;
            width: 100%;
        }

        .table thead th {
            background-color: var(--background);
            border-bottom: 1px solid var(--neutral);
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: sticky;
            top: 0;
        }

        .table tbody td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--neutral);
            transition: all 0.2s ease;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: var(--background);
        }

        .table tbody tr:hover td {
            border-color: var(--secondary);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            font-weight: 500;
            padding: 0.375rem 0.75rem;
            border-radius: var(--radius-sm);
            font-size: 0.75rem;
            transition: all 0.2s ease;
        }

        .badge:hover {
            transform: scale(1.05);
        }

        .badge-diajukan {
            background-color: rgba(255, 213, 107, 0.2);
            color: #B45309;
        }

        .badge-diproses {
            background-color: rgba(176, 217, 255, 0.2);
            color: #1E40AF;
        }

        .badge-selesai {
            background-color: rgba(161, 227, 161, 0.2);
            color: #047857;
        }

        .badge-ditolak {
            background-color: rgba(254, 178, 178, 0.2);
            color: #DC2626;
        }

        /* ALERT */
        .alert {
            border-radius: var(--radius-md);
            border: none;
            box-shadow: var(--shadow-sm);
            animation: slideIn 0.5s ease;
        }

        /* FOOTER */
        footer {
            text-align: center;
            color: var(--text-light);
            padding: 1.5rem;
            font-size: 0.875rem;
            border-top: 1px solid var(--neutral);
            background-color: var(--white);
        }

        /* OVERLAY FOR MOBILE */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* Dropdown Styles */
        .dropdown-menu {
            min-width: 200px;
            border: 1px solid var(--neutral);
            box-shadow: var(--shadow-lg);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dropdown-item-text small {
            font-size: 0.75rem;
        }

        .user-info i.fa-chevron-down {
            transition: transform 0.3s ease;
        }

        .user-info[aria-expanded="true"] i.fa-chevron-down {
            transform: rotate(180deg);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: var(--radius-md);
            transition: all 0.2s ease;
            min-width: 160px;
        }

        .user-info:hover {
            background-color: var(--background);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .user-details {
            display: flex;
            flex-direction: column;
            gap: 2px;
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-weight: 500;
            font-size: 0.875rem;
            color: var(--text-dark);
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--text-light);
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .stat-card-link {
            text-decoration: none;
            display: block;
            transition: all 0.3s ease;
        }

        .stat-card-link:hover {
            transform: translateY(-5px);
            text-decoration: none;
        }

        .stat-card {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            border: 2px solid transparent;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-3px);
            border-color: var(--secondary);
        }

        .stat-card-active {
            border-color: var(--primary);
            box-shadow: var(--shadow-md);
            position: relative;
        }

        .stat-card-active::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .stat-card-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .stat-card-primary:hover {
            background: linear-gradient(135deg, var(--secondary), var(--primary));
        }

        /* Hover effects for non-primary cards */
        .stat-card:not(.stat-card-primary):hover .stat-value {
            color: var(--primary);
            transform: scale(1.1);
        }

        .stat-card:not(.stat-card-primary):hover .stat-label {
            color: var(--primary);
        }

        .stat-card-content {
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 1;
        }

        .stat-value {
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 0.25rem;
            transition: all 0.3s ease;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
            transition: all 0.3s ease;
        }

        .stat-icon {
            align-self: flex-end;
            margin-top: -2rem;
            opacity: 0.8;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.2) rotate(5deg);
            opacity: 1;
        }

        /* Active state indicator */
        .stat-card-active .stat-value {
            font-weight: 800;
        }

        /* Pulse animation for active card */
        @keyframes pulse-active {
            0% { box-shadow: 0 0 0 0 rgba(99, 122, 185, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(99, 122, 185, 0); }
            100% { box-shadow: 0 0 0 0 rgba(99, 122, 185, 0); }
        }

        .stat-card-active {
            animation: pulse-active 2s infinite;
        }

        /* RESPONSIVE */
        @media (max-width: 1200px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
            }

            .main-content.expanded {
                margin-left: 0 !important;
            }

            .mobile-toggle {
                display: block;
            }

            .sidebar-overlay {
                display: block;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .sidebar-overlay.active {
                opacity: 1;
                visibility: visible;
            }
        }

        @media (max-width: 768px) {
            .top-navbar {
                padding: 1rem;
            }

            .content-area {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .user-details {
                display: none;
            }

            .user-info {
                min-width: auto;
                gap: 0.5rem;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .page-actions {
                width: 100%;
                justify-content: flex-end;
            }

            .search-container {
                width: 200px;
            }
        }

        @media (max-width: 576px) {
            .table-actions {
                flex-direction: column;
                width: 100%;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .search-container {
                width: 150px;
            }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- SIDEBAR OVERLAY FOR MOBILE -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- SIDEBAR -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="#" class="sidebar-brand">
                    <div class="logo-container">
                        <img src="/asset/LAPORIN.png" alt="Logo Petugas" class="logo-image">
                    </div>
                </a>
                <button class="toggle-btn" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}" href="{{ route('petugas.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('petugas.pengaduan.task') ? 'active' : '' }}"
                       href="{{ route('petugas.pengaduan.task') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span class="nav-text">Pengaduan Saya</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('petugas.pengaduan.index') ? 'active' : '' }}"
                       href="{{ route('petugas.pengaduan.index') }}">
                        <i class="fas fa-hand-paper"></i>
                        <span class="nav-text">Ambil Pengaduan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('petugas.pengaduan.history') ? 'active' : '' }}"
                       href="{{ route('petugas.pengaduan.history') }}">
                        <i class="fas fa-history"></i>
                        <span class="nav-text">History</span>
                    </a>
                </li>

                <li class="nav-item mt-4">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="nav-text">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </li>
            </ul>
        </div>

        <!-- MAIN CONTENT -->
        <div class="main-content" id="mainContent">
            <!-- TOP NAVBAR -->
            <div class="top-navbar">
                <button class="mobile-toggle" id="mobileToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="search-container">
                    <!-- Search functionality can be added here if needed -->
                </div>

                <div class="nav-actions">
                    @auth
                    <!-- User Profile Dropdown -->
                    <div class="user-profile dropdown">
                        <div class="user-info" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar">
                                {{ strtoupper(substr(Auth::user()->nama_pengguna, 0, 2)) }}
                            </div>
                            <div class="user-details">
                                <div class="user-name">{{ Auth::user()->nama_pengguna }}</div>
                                <div class="user-role">Petugas</div>
                            </div>
                            <i class="fas fa-chevron-down ms-2" style="font-size: 0.7rem; opacity: 0.7;"></i>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span class="dropdown-item-text">
                                    <small>Logged in as:</small>
                                    <br>
                                    <strong>{{ Auth::user()->nama_pengguna }}</strong>
                                    <br>
                                    <small class="text-muted">Petugas</small>
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('petugas.profile') }}">
                                    <i class="fas fa-user me-2"></i>Profil Saya
                                </a>
                            </li>

                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endauth

                    @guest
                    <div class="user-profile">
                        <div class="user-avatar">?</div>
                        <div class="user-name">Guest</div>
                    </div>
                    @endguest
                </div>
            </div>

            <!-- CONTENT AREA -->
            <div class="content-area">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>

            <footer>© 2025 Sistem Pengaduan — by Galuh Ayu 🌷</footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar Toggle Functionality
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const mobileToggle = document.getElementById('mobileToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        // Toggle sidebar collapse/expand
        function toggleSidebarState() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');

            // Change icon based on state
            const icon = toggleSidebar.querySelector('i');
            if (sidebar.classList.contains('collapsed')) {
                icon.className = 'fas fa-chevron-right';
            } else {
                icon.className = 'fas fa-bars';
            }
        }

        // Toggle mobile sidebar
        function toggleMobileSidebar() {
            sidebar.classList.toggle('mobile-open');
            sidebarOverlay.classList.toggle('active');
        }

        // Event listeners
        toggleSidebar.addEventListener('click', toggleSidebarState);
        mobileToggle.addEventListener('click', toggleMobileSidebar);
        sidebarOverlay.addEventListener('click', toggleMobileSidebar);

        // Close sidebar when clicking on a link (mobile)
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 1200) {
                    toggleMobileSidebar();
                }
            });
        });

        // Add hover effects to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.stat-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px) scale(1.02)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Add loading animation
            const contentArea = document.querySelector('.content-area');
            contentArea.style.opacity = '0';
            contentArea.style.transform = 'translateY(20px)';

            setTimeout(() => {
                contentArea.style.transition = 'all 0.5s ease';
                contentArea.style.opacity = '1';
                contentArea.style.transform = 'translateY(0)';
            }, 100);
        });

        // AUTO FIX BOOTSTRAP MODAL - INSTAN FIX!
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🔧 Auto-fixing Bootstrap modal syntax...');

            // Fix 1: data-dismiss -> data-bs-dismiss + close button
            document.querySelectorAll('[data-dismiss="modal"]').forEach(btn => {
                btn.setAttribute('data-bs-dismiss', 'modal');
                btn.removeAttribute('data-dismiss');

                // Jika ini tombol close dengan class "close", ubah ke "btn-close"
                if(btn.classList.contains('close')) {
                    btn.classList.remove('close');
                    btn.classList.add('btn-close');
                    btn.innerHTML = ''; // Hapus &times;
                }
            });

            // Fix 2: data-toggle -> data-bs-toggle
            document.querySelectorAll('[data-toggle="modal"]').forEach(btn => {
                btn.setAttribute('data-bs-toggle', 'modal');
                btn.removeAttribute('data-toggle');
            });

            // Fix 3: Perbaiki modal backdrop yang bermasalah
            const originalShow = bootstrap.Modal.prototype.show;
            bootstrap.Modal.prototype.show = function() {
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
                return originalShow.apply(this, arguments);
            };

            console.log('🎉 All Bootstrap modal issues fixed!');
        });

        // Force refresh modal events
        document.addEventListener('DOMContentLoaded', function() {
            // Re-initialize semua modal
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                new bootstrap.Modal(modal);
            });
        });
    </script>

    @yield('scripts')
    @yield('styles')
</body>
</html>
