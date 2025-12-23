@extends('layouts.user')

@section('content')
<div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header mb-3">
        <h2>Dashboard {{ ucfirst(Auth::user()->role) }}</h2>
        <p>Hello, {{ Auth::user()->nama_pengguna }}! Selamat datang kembali.</p>
    </div>

    <!-- Banner Slider -->
    <div class="banner-slider mb-8">
        <div class="banner-slide active" style="background-image: url('https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.1&auto=format&fit=crop&w=1200&q=80')">
            <div class="banner-content">
                <h4>Selamat Datang di Sistem Pengaduan Laporin</h4>
                <p>Ajukan pengaduan Anda dengan mudah dan cepat</p>
            </div>
        </div>
        <div class="banner-slide" style="background-image: url('https://images.unsplash.com/photo-1581092921461-eab62e97a780?ixlib=rb-4.0.1&auto=format&fit=crop&w=1200&q=80')">
            <div class="banner-content">
                <h4>Update Sistem Laporin v2.1</h4>
                <p>Fitur real-time tracking dan notifikasi terkini</p>
            </div>
        </div>
        <div class="banner-dots">
            <div class="banner-dot active"></div>
            <div class="banner-dot"></div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions mb-3">
        <div class="action-card" onclick="window.location.href='{{ route('user.pengaduan.create') }}'">
            <div class="action-icon">
                <i class="fas fa-plus"></i>
            </div>
            <div class="action-text">
                <h5>Ajukan Pengaduan</h5>
                <p>Buat pengaduan baru</p>
            </div>
        </div>
        <div class="action-card" onclick="window.location.href='{{ route('user.pengaduan.index') }}'">
            <div class="action-icon">
                <i class="fas fa-history"></i>
            </div>
            <div class="action-text">
                <h5>Riwayat</h5>
                <p>Lihat pengaduan Anda</p>
            </div>
        </div>
        <div class="action-card" onclick="showEdukasiSection()">
            <div class="action-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="action-text">
                <h5>Panduan</h5>
                <p>Pelajari cara penggunaan</p>
            </div>
        </div>
        <div class="action-card" onclick="showHelpModal()">
            <div class="action-icon">
                <i class="fas fa-headset"></i>
            </div>
            <div class="action-text">
                <h5>Bantuan</h5>
                <p>Hubungi support</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content-wrapper">
        <!-- Stats Cards -->
        <div class="stats-section mb-3">
            <div class="section-header">
                <h5 class="section-title">Statistik Pengaduan</h5>
            </div>
            <div class="stats-grid">
                @php
                    // HITUNG STATISTIK LANGSUNG DI VIEW - SESUAIKAN DENGAN SISTEM
                    $userId = Auth::id();

                    // Total pengaduan user
                    $total_pengaduan = \App\Models\Pengaduan::where('id_user', $userId)->count();

                    // Pengaduan aktif (Diajukan, Disetujui, Diproses)
                    $pengaduan_aktif = \App\Models\Pengaduan::where('id_user', $userId)
                        ->whereIn('status', ['Diajukan', 'Disetujui', 'Diproses'])
                        ->count();

                    // Pengaduan selesai
                    $pengaduan_selesai = \App\Models\Pengaduan::where('id_user', $userId)
                        ->where('status', 'Selesai')
                        ->count();

                    // Pengaduan bulan ini
                    $pengaduan_bulan_ini = \App\Models\Pengaduan::where('id_user', $userId)
                        ->whereMonth('tgl_pengajuan', now()->month)
                        ->whereYear('tgl_pengajuan', now()->year)
                        ->count();
                @endphp

                <div class="stat-card blue">
                    <div class="stat-card-content">
                        <div class="stat-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $total_pengaduan }}</h3>
                            <p>Total Pengaduan</p>
                        </div>
                    </div>
                </div>

                <div class="stat-card orange">
                    <div class="stat-card-content">
                        <div class="stat-icon">
                            <i class="fas fa-spinner"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $pengaduan_aktif }}</h3>
                            <p>Sedang Diproses</p>
                        </div>
                    </div>
                </div>

                <div class="stat-card green">
                    <div class="stat-card-content">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $pengaduan_selesai }}</h3>
                            <p>Selesai</p>
                        </div>
                    </div>
                </div>

                <div class="stat-card purple">
                    <div class="stat-card-content">
                        <div class="stat-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $pengaduan_bulan_ini }}</h3>
                            <p>Bulan Ini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Pengaduan Terbaru -->
            <div class="complaints-section">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Pengaduan Terbaru</h5>
                        <a href="{{ route('user.pengaduan.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Baru
                        </a>
                    </div>
                    <div class="card-body">
                        @php
                            // AMBIL DATA PENGAJUAN TERBARU USER
                            $pengaduan_terbaru = \App\Models\Pengaduan::with('item')
                                ->where('id_user', Auth::id())
                                ->orderBy('tgl_pengajuan', 'desc')
                                ->limit(5)
                                ->get();
                        @endphp

                        @if($pengaduan_terbaru->count() > 0)
                            <div class="complaints-list">
                                @foreach($pengaduan_terbaru as $p)
                                <div class="complaint-item">
                                    <div class="complaint-info">
                                        <h6 class="complaint-title">{{ Str::limit($p->nama_pengaduan, 40) }}</h6>
                                        <div class="complaint-meta">
                                            <span class="item">
                                                @if($p->item)
                                                    {{ $p->item->nama_item }}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                            <span class="date">{{ \Carbon\Carbon::parse($p->tgl_pengajuan)->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="complaint-status">
                                        <span class="status-badge status-{{ strtolower($p->status) }}">
                                            {{ $p->status }}
                                        </span>
                                        <a href="{{ route('user.pengaduan.show', $p->id_pengaduan) }}" class="btn-view">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p>Belum ada pengaduan</p>
                                <a href="{{ route('user.pengaduan.create') }}" class="btn btn-primary">
                                    Ajukan Pengaduan Pertama
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar Content -->
            <div class="sidebar-content">
                <!-- Edukasi Section -->
                <div class="edukasi-section mb-3">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="fas fa-graduation-cap me-1"></i>
                            Panduan
                        </h5>
                    </div>
                    <div class="edukasi-list">
                        <div class="edukasi-item" onclick="showGuideModal('pengaduan')">
                            <div class="edukasi-icon">
                                <i class="fas fa-file-upload"></i>
                            </div>
                            <div class="edukasi-text">
                                <h6>Cara Ajukan Pengaduan</h6>
                                <p>Langkah-langkah mengajukan pengaduan</p>
                            </div>
                        </div>

                        <div class="edukasi-item" onclick="showGuideModal('foto')">
                            <div class="edukasi-icon">
                                <i class="fas fa-camera"></i>
                            </div>
                            <div class="edukasi-text">
                                <h6>Tips Foto Bukti</h6>
                                <p>Pastikan foto bukti jelas</p>
                            </div>
                        </div>

                        <div class="edukasi-item" onclick="showGuideModal('proses')">
                            <div class="edukasi-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="edukasi-text">
                                <h6>Proses Penanganan</h6>
                                <p>Tim kami menindaklanjuti dalam 24 jam</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Berita & Info -->
                <div class="news-section">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-newspaper me-1"></i>
                                Berita Terbaru
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="news-list">
                                <div class="news-item">
                                    <div class="news-icon">
                                        <i class="fas fa-sync-alt"></i>
                                    </div>
                                    <div class="news-content">
                                        <h6>Update Sistem v2.1</h6>
                                        <p>Fitur real-time tracking tersedia</p>
                                        <span class="news-time">2 hari lalu</span>
                                    </div>
                                </div>

                                <div class="news-item">
                                    <div class="news-icon">
                                        <i class="fas fa-tools"></i>
                                    </div>
                                    <div class="news-content">
                                        <h6>Maintenance</h6>
                                        <p>15 Des 2024, 00:00-04:00 WIB</p>
                                        <span class="news-time">3 hari lalu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Help Modal -->
<div class="modal-overlay" id="helpModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5>Bantuan & Support</h5>
            <button class="modal-close" onclick="closeHelpModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="help-contact">
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="help-info">
                        <h6>Telepon</h6>
                        <p>+62 21 1234 5678</p>
                    </div>
                </div>
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="help-info">
                        <h6>Email</h6>
                        <p>support@laporin.com</p>
                    </div>
                </div>
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="help-info">
                        <h6>Jam Operasional</h6>
                        <p>Senin - Jumat: 08:00 - 17:00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Guide Modal -->
<div class="modal-overlay" id="guideModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 id="guideModalTitle">Panduan</h5>
            <button class="modal-close" onclick="closeGuideModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div id="guideModalContent">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>
</div>

<!-- CSS TIDAK DIUBAH SAMA SEKALI - PERSIS SEPERTI ASLINYA -->
<style>
    /* CSS Variables - Optimized for Mobile */
    :root {
        --primary: #31326f;
        --secondary: #637ab9;
        --light: #e9ecef;
        --background: #f8f9fa;
        --text: #333;
        --shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        --transition: all 0.2s ease;
        --border-radius: 8px;
    }

    /* Base Mobile-First Styles */
    * {
        box-sizing: border-box;
        -webkit-tap-highlight-color: transparent;
    }

    body {
        margin: 0;
        padding: 0;
        background-color: var(--background);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
        line-height: 1.4;
    }

    /* Dashboard Container - Mobile Optimized */
    .dashboard-container {
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
        padding: 0.5rem;
        overflow-x: hidden;
    }

    /* Header - Compact for Mobile */
    .dashboard-header {
        margin-bottom: 1rem;
        padding: 0.5rem 0;
    }

    .dashboard-header h2 {
        color: var(--primary);
        font-weight: 700;
        margin-bottom: 0.25rem;
        font-size: 1.3rem;
        line-height: 1.2;
    }

    .dashboard-header p {
        color: var(--secondary);
        font-weight: 400;
        margin: 0;
        font-size: 0.85rem;
        opacity: 0.9;
    }

    /* Banner Slider - Compact */
    .banner-slider {
    position: relative;
    height: 180px; /* GEDEIN TINGGINYA DI SINI */
    border-radius: var(--border-radius);
    overflow: hidden;
    margin-bottom: 1rem;
    box-shadow: var(--shadow);
    /* PASTIKAN GA ADA BACKGROUND DISINI */
}

.banner-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 0.5s ease;
    display: flex;
    align-items: center;
    padding: 1rem;
    /* PASTIKAN ADA BACKGROUND SIZE */
    background-size: cover;
    background-position: center;
}

    .banner-slide.active {
        opacity: 1;
    }

    .banner-content {
        color: white;
        width: 100%;
    }

    .banner-content h4 {
        font-weight: 600;
        margin-bottom: 0.2rem;
        font-size: 0.95rem;
        line-height: 1.2;
    }

    .banner-content p {
        font-weight: 400;
        margin: 0;
        font-size: 0.75rem;
        opacity: 0.9;
        line-height: 1.2;
    }

    .banner-dots {
        position: absolute;
        bottom: 6px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 4px;
        z-index: 3;
    }

    .banner-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: var(--transition);
    }

    .banner-dot.active {
        background: white;
        transform: scale(1.1);
    }

    /* Quick Actions - Compact Grid */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .action-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 0.75rem 0.5rem;
        box-shadow: var(--shadow);
        transition: var(--transition);
        cursor: pointer;
        border: 1px solid var(--light);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        min-height: 60px;
    }

    .action-card:active {
        transform: scale(0.98);
        background: var(--background);
    }

    .action-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(99, 122, 185, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        color: var(--secondary);
        transition: var(--transition);
        flex-shrink: 0;
    }

    .action-text {
        flex: 1;
        min-width: 0;
    }

    .action-card h5 {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 0.1rem;
        font-size: 0.8rem;
        line-height: 1.1;
    }

    .action-card p {
        color: var(--secondary);
        font-size: 0.65rem;
        margin: 0;
        line-height: 1.1;
    }

    /* Stats Cards - Compact Grid */
    .stats-section {
        margin-bottom: 1rem;
    }

    .section-header {
        margin-bottom: 0.75rem;
    }

    .section-title {
        font-weight: 600;
        color: var(--primary);
        margin: 0;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.5rem;
    }

    .stat-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 0.75rem;
        box-shadow: var(--shadow);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        border: 1px solid var(--light);
        min-height: 70px;
    }

    .stat-card:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
    }

    .stat-card.blue:before { background: linear-gradient(90deg, var(--primary), var(--secondary)); }
    .stat-card.orange:before { background: linear-gradient(90deg, #FF9F43, #E67E22); }
    .stat-card.green:before { background: linear-gradient(90deg, #2ECC71, #27AE60); }
    .stat-card.purple:before { background: linear-gradient(90deg, #9B59B6, #8E44AD); }

    .stat-card-content {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .stat-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        color: white;
        flex-shrink: 0;
    }

    .stat-card.blue .stat-icon { background: linear-gradient(135deg, var(--primary), var(--secondary)); }
    .stat-card.orange .stat-icon { background: linear-gradient(135deg, #FF9F43, #E67E22); }
    .stat-card.green .stat-icon { background: linear-gradient(135deg, #2ECC71, #27AE60); }
    .stat-card.purple .stat-icon { background: linear-gradient(135deg, #9B59B6, #8E44AD); }

    .stat-info h3 {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0;
        line-height: 1;
        color: var(--primary);
    }

    .stat-info p {
        font-size: 0.65rem;
        color: var(--secondary);
        margin: 0.15rem 0 0 0;
        line-height: 1.1;
    }

    /* Content Grid - Single Column for Mobile */
    .content-grid {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    /* Complaints Section */
    .complaints-section .card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        background: white;
    }

    .card-header {
        background: white;
        border-bottom: 1px solid var(--light);
        padding: 0.75rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title {
        color: var(--primary);
        font-weight: 600;
        margin: 0;
        font-size: 0.85rem;
    }

    .btn-primary {
        background: var(--secondary);
        border: none;
        border-radius: 4px;
        padding: 0.3rem 0.5rem;
        font-weight: 500;
        transition: var(--transition);
        font-size: 0.7rem;
        color: white;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.2rem;
        white-space: nowrap;
    }

    .btn-primary:active {
        transform: scale(0.95);
    }

    .card-body {
        padding: 0.75rem;
    }

    .complaints-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .complaint-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 0.6rem;
        background: var(--background);
        border-radius: 6px;
        transition: var(--transition);
        gap: 0.5rem;
    }

    .complaint-item:active {
        background: rgba(99, 122, 185, 0.1);
    }

    .complaint-info {
        flex: 1;
        min-width: 0;
    }

    .complaint-title {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 0.2rem;
        font-size: 0.75rem;
        line-height: 1.1;
        word-wrap: break-word;
    }

    .complaint-meta {
        display: flex;
        flex-direction: column;
        gap: 0.1rem;
        font-size: 0.6rem;
        color: var(--secondary);
    }

    .complaint-status {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        flex-shrink: 0;
    }

    .status-badge {
        padding: 0.15rem 0.3rem;
        border-radius: 3px;
        font-size: 0.55rem;
        font-weight: 500;
        color: white;
        white-space: nowrap;
    }

    .status-diajukan { background: #ffc107; }
    .status-disetujui { background: #007bff; }
    .status-diproses { background: #17a2b8; }
    .status-selesai { background: #28a745; }
    .status-ditolak { background: #dc3545; }

    .btn-view {
        color: var(--secondary);
        background: none;
        border: none;
        padding: 0.2rem;
        border-radius: 3px;
        transition: var(--transition);
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        font-size: 0.7rem;
    }

    .btn-view:active {
        background: rgba(99, 122, 185, 0.1);
    }

    .empty-state {
        text-align: center;
        padding: 1.5rem 0.75rem;
        color: var(--secondary);
    }

    .empty-state i {
        font-size: 2rem;
        margin-bottom: 0.75rem;
        opacity: 0.5;
    }

    .empty-state p {
        margin-bottom: 1rem;
        font-size: 0.8rem;
    }

    /* Sidebar Content */
    .sidebar-content {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    /* Edukasi Section - Compact */
    .edukasi-section {
        background: white;
        border-radius: var(--border-radius);
        padding: 0.75rem;
        box-shadow: var(--shadow);
        border: 1px solid var(--light);
    }

    .edukasi-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .edukasi-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem;
        border-radius: 6px;
        transition: var(--transition);
        cursor: pointer;
        background: var(--background);
    }

    .edukasi-item:active {
        background: rgba(99, 122, 185, 0.1);
    }

    .edukasi-icon {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        background: var(--secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    .edukasi-text {
        flex: 1;
        min-width: 0;
    }

    .edukasi-text h6 {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 0.1rem;
        font-size: 0.7rem;
        line-height: 1.1;
    }

    .edukasi-text p {
        color: var(--secondary);
        font-size: 0.6rem;
        margin: 0;
        line-height: 1.1;
    }

    /* News Section */
    .news-section .card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        background: white;
    }

    .news-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .news-item {
        display: flex;
        gap: 0.5rem;
        padding: 0.6rem;
        border-radius: 6px;
        transition: var(--transition);
        cursor: pointer;
    }

    .news-item:active {
        background: var(--background);
    }

    .news-icon {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        background: rgba(99, 122, 185, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--secondary);
        font-size: 0.7rem;
        flex-shrink: 0;
    }

    .news-content {
        flex: 1;
        min-width: 0;
    }

    .news-content h6 {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 0.1rem;
        font-size: 0.7rem;
        line-height: 1.1;
    }

    .news-content p {
        color: var(--secondary);
        font-size: 0.6rem;
        margin-bottom: 0.1rem;
        line-height: 1.1;
    }

    .news-time {
        font-size: 0.55rem;
        color: #6c757d;
    }

    /* Modal Styles - Mobile Optimized */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        padding: 0.5rem;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: var(--border-radius);
        width: 100%;
        max-width: 320px;
        max-height: 80vh;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
        padding: 0.75rem;
        border-bottom: 1px solid var(--light);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h5 {
        margin: 0;
        color: var(--primary);
        font-size: 0.9rem;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 1rem;
        color: var(--secondary);
        cursor: pointer;
        padding: 0.2rem;
    }

    .modal-body {
        padding: 0.75rem;
        max-height: 60vh;
        overflow-y: auto;
    }

    .help-contact, .guide-content {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .help-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.6rem;
        background: var(--background);
        border-radius: 6px;
    }

    .help-icon {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        background: var(--secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    .help-info h6 {
        margin: 0 0 0.15rem 0;
        color: var(--primary);
        font-size: 0.75rem;
    }

    .help-info p {
        margin: 0;
        color: var(--secondary);
        font-size: 0.65rem;
    }

    /* Very Small Mobile Optimization */
    @media (max-width: 320px) {
        .dashboard-container {
            padding: 0.25rem;
        }

        .quick-actions {
            grid-template-columns: 1fr;
            gap: 0.4rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 0.4rem;
        }

        .action-card, .stat-card {
            min-height: 55px;
            padding: 0.6rem 0.4rem;
        }

        /* Buat banner extra large */
.banner-slider {
    height: 200px;
}

.banner-content h4 {
    font-size: 1.8rem;
    margin-bottom: 0.5rem;
}

.banner-content p {
    font-size: 1.1rem;
}

.banner-slide {
    padding: 2.5rem;
}
    }

    /* Tablet Styles */
    @media (min-width: 768px) {
        .dashboard-container {
            padding: 1rem;
            max-width: 1200px;
        }

        .quick-actions {
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
        }

        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
        }

        .content-grid {
            flex-direction: row;
            gap: 1rem;
        }

        .complaints-section {
            flex: 2;
        }

        .sidebar-content {
            flex: 1;
            min-width: 250px;
        }

        .banner-slider {
            height: 120px;
        }

        .banner-content h4 {
            font-size: 1.1rem;
        }

        .modal-content {
            max-width: 400px;
        }
    }

    /* Desktop Styles */
    @media (min-width: 1024px) {
        .banner-slider {
            height: 140px;
        }

        .banner-content h4 {
            font-size: 1.3rem;
        }

        .action-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .stat-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .complaint-item:hover {
            background: rgba(99, 122, 185, 0.05);
        }

        .edukasi-item:hover {
            background: rgba(99, 122, 185, 0.05);
        }

        .news-item:hover {
            background: var(--background);
        }
    }
</style>

<!-- JAVASCRIPT TIDAK DIUBAH SAMA SEKALI - PERSIS SEPERTI ASLINYA -->
<script>
    // Banner Slider
    const bannerSlides = document.querySelectorAll('.banner-slide');
    const bannerDots = document.querySelectorAll('.banner-dot');
    let currentSlide = 0;
    let bannerInterval;

    function showSlide(n) {
        bannerSlides.forEach(slide => slide.classList.remove('active'));
        bannerDots.forEach(dot => dot.classList.remove('active'));

        currentSlide = (n + bannerSlides.length) % bannerSlides.length;

        bannerSlides[currentSlide].classList.add('active');
        bannerDots[currentSlide].classList.add('active');
    }

    function startBannerSlider() {
        bannerInterval = setInterval(() => {
            showSlide(currentSlide + 1);
        }, 4000);
    }

    function stopBannerSlider() {
        clearInterval(bannerInterval);
    }

    // Start banner slider
    startBannerSlider();

    // Banner slider controls
    bannerDots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            stopBannerSlider();
            showSlide(index);
            startBannerSlider();
        });
    });

    function showEdukasiSection() {
        // Scroll to edukasi section
        const edukasiSection = document.querySelector('.edukasi-section');
        if (edukasiSection) {
            edukasiSection.scrollIntoView({ behavior: 'smooth', block: 'center' });

            // Highlight effect
            edukasiSection.style.boxShadow = '0 0 0 2px var(--secondary)';
            setTimeout(() => {
                edukasiSection.style.boxShadow = '';
            }, 1000);
        }
    }

    // Help Modal Functions
    function showHelpModal() {
        const modal = document.getElementById('helpModal');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeHelpModal() {
        const modal = document.getElementById('helpModal');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    // Guide Modal Functions
    function showGuideModal(type) {
        const modal = document.getElementById('guideModal');
        const title = document.getElementById('guideModalTitle');
        const content = document.getElementById('guideModalContent');

        if (modal && title && content) {
            let guideTitle = '';
            let guideContent = '';

            switch(type) {
                case 'pengaduan':
                    guideTitle = 'Cara Ajukan Pengaduan';
                    guideContent = `
                        <div class="guide-content">
                            <p><strong>Langkah-langkah mengajukan pengaduan:</strong></p>
                            <ol style="margin: 0.5rem 0; padding-left: 1rem; font-size: 0.75rem;">
                                <li style="margin-bottom: 0.3rem;">Login ke sistem Laporin</li>
                                <li style="margin-bottom: 0.3rem;">Klik tombol "Ajukan Pengaduan"</li>
                                <li style="margin-bottom: 0.3rem;">Isi form pengaduan dengan lengkap</li>
                                <li style="margin-bottom: 0.3rem;">Upload foto bukti yang jelas</li>
                                <li>Submit pengaduan dan tunggu konfirmasi</li>
                            </ol>
                        </div>
                    `;
                    break;

                case 'foto':
                    guideTitle = 'Tips Foto Bukti';
                    guideContent = `
                        <div class="guide-content">
                            <p><strong>Pastikan foto bukti memenuhi kriteria:</strong></p>
                            <ul style="margin: 0.5rem 0; padding-left: 1rem; font-size: 0.75rem;">
                                <li style="margin-bottom: 0.3rem;">Foto dari berbagai angle</li>
                                <li style="margin-bottom: 0.3rem;">Pencahayaan yang cukup</li>
                                <li style="margin-bottom: 0.3rem;">Tampilkan kerusakan dengan jelas</li>
                                <li style="margin-bottom: 0.3rem;">Gambar tidak blur atau goyang</li>
                                <li>Include objek referensi untuk skala</li>
                            </ul>
                        </div>
                    `;
                    break;

                case 'proses':
                    guideTitle = 'Proses Penanganan';
                    guideContent = `
                        <div class="guide-content">
                            <p><strong>Alur penanganan pengaduan:</strong></p>
                            <ul style="margin: 0.5rem 0; padding-left: 1rem; font-size: 0.75rem;">
                                <li style="margin-bottom: 0.3rem;"><strong>Diajukan:</strong> Pengaduan diterima sistem</li>
                                <li style="margin-bottom: 0.3rem;"><strong>Disetujui:</strong> Admin memverifikasi kelayakan</li>
                                <li style="margin-bottom: 0.3rem;"><strong>Diproses:</strong> Tim teknis menangani</li>
                                <li style="margin-bottom: 0.3rem;"><strong>Selesai:</strong> Pengaduan telah ditangani</li>
                                <li><strong>Verifikasi:</strong> Konfirmasi penyelesaian</li>
                            </ul>
                            <p style="font-size: 0.7rem; margin-top: 0.5rem; color: var(--secondary);">
                                Tim kami akan menindaklanjuti dalam 24 jam kerja.
                            </p>
                        </div>
                    `;
                    break;
            }

            title.textContent = guideTitle;
            content.innerHTML = guideContent;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeGuideModal() {
        const modal = document.getElementById('guideModal');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    // Close modals when clicking outside
    document.addEventListener('click', function(event) {
        const helpModal = document.getElementById('helpModal');
        const guideModal = document.getElementById('guideModal');

        if (helpModal && event.target === helpModal) {
            closeHelpModal();
        }

        if (guideModal && event.target === guideModal) {
            closeGuideModal();
        }
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeHelpModal();
            closeGuideModal();
        }
    });

    // Prevent body scroll when modal is open
    document.addEventListener('touchmove', function(event) {
        const helpModal = document.getElementById('helpModal');
        const guideModal = document.getElementById('guideModal');

        if ((helpModal && helpModal.classList.contains('active')) ||
            (guideModal && guideModal.classList.contains('active'))) {
            event.preventDefault();
        }
    }, { passive: false });

    // Initialize on load
    document.addEventListener('DOMContentLoaded', function() {
        // Any initialization code if needed
    });
</script>
@endsection
