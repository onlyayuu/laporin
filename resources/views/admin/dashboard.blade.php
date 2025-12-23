@extends('layouts.admin')

@section('content')
<!-- PAGE HEADER -->
<div class="page-header">
    <div class="header-content">
        <h1 class="page-title">Selamat Datang, Admin!</h1>
        <p class="page-subtitle">Dashboard Sistem Pengaduan SAPPRAS</p>
    </div>
    <div class="header-actions">
        <div class="date-display">
            <i class="fas fa-calendar"></i>
            <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>
</div>

<!-- STAT CARDS -->
<div class="stats-grid">
    <div class="stat-card stat-primary">
        <div class="stat-content">
            <div class="stat-main">
                <div class="stat-value">{{ $total_pengaduan }}</div>
                <div class="stat-label">Total Pengaduan</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-file-alt"></i>
            </div>
        </div>
        <div class="stat-footer">
            <i class="fas fa-chart-line"></i>
            <span>Semua waktu</span>
        </div>
    </div>

    <div class="stat-card stat-warning">
        <div class="stat-content">
            <div class="stat-main">
                <div class="stat-value">{{ $pengaduan_diajukan }}</div>
                <div class="stat-label">Menunggu Verifikasi</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
        <div class="stat-footer">
            <i class="fas fa-exclamation-circle"></i>
            <span>Perlu tindakan</span>
        </div>
    </div>

    <div class="stat-card stat-info">
        <div class="stat-content">
            <div class="stat-main">
                <div class="stat-value">{{ $pengaduan_diproses }}</div>
                <div class="stat-label">Sedang Diproses</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-cog"></i>
            </div>
        </div>
        <div class="stat-footer">
            <i class="fas fa-sync-alt"></i>
            <span>Dalam penanganan</span>
        </div>
    </div>

    <div class="stat-card stat-success">
        <div class="stat-content">
            <div class="stat-main">
                <div class="stat-value">{{ $pengaduan_selesai }}</div>
                <div class="stat-label">Selesai</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
        <div class="stat-footer">
            @php
                $completionRate = $total_pengaduan > 0 ? round(($pengaduan_selesai / $total_pengaduan) * 100, 1) : 0;
            @endphp
            <i class="fas fa-percentage"></i>
            <span>{{ $completionRate }}% terselesaikan</span>
        </div>
    </div>
</div>

<!-- MAIN CONTENT GRID -->
<div class="content-grid">
    <!-- LEFT COLUMN - MAIN CONTENT -->
    <div class="content-column main-content">
        <!-- PENGADUAN MENUNGGU VERIFIKASI -->
        <div class="content-card">
            <div class="card-header">
                <div class="card-title-section">
                    <h3 class="card-title">
                        <i class="fas fa-clock card-title-icon"></i>
                        Pengaduan Menunggu Verifikasi
                    </h3>
                    <div class="card-badge">{{ $pengaduan_diajukan }}</div>
                </div>
                <a href="{{ route('admin.pengaduan.index') }}?status=Diajukan" class="card-action">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                @if($pengaduan_menunggu->count() > 0)
                    <div class="data-table">
                        <div class="table-header">
                            <div class="table-row header-row">
                                <div class="table-cell">Judul Pengaduan</div>
                                <div class="table-cell">User</div>
                                <div class="table-cell">Lokasi</div>
                                <div class="table-cell">Tanggal</div>
                                <div class="table-cell">Aksi</div>
                            </div>
                        </div>
                        <div class="table-body">
                            @foreach($pengaduan_menunggu as $p)
                            <div class="table-row data-row">
                                <div class="table-cell">
                                    <div class="cell-content">
                                        <div class="primary-text">{{ Str::limit($p->nama_pengaduan, 35) }}</div>
                                    </div>
                                </div>
                                <div class="table-cell">
                                    <div class="cell-content">
                                        <div class="user-info">
                                            <i class="fas fa-user"></i>
                                            <span>{{ $p->user->nama_pengguna }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-cell">
                                    <div class="cell-content">
                                        <div class="location-info">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>{{ Str::limit($p->lokasi, 20) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-cell">
                                    <div class="cell-content">
                                        <div class="date-info">
                                            <i class="fas fa-calendar"></i>
                                            <span>{{ date('d M Y', strtotime($p->created_at)) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-cell">
                                    <div class="cell-content">
                                        <a href="{{ route('admin.pengaduan.show', $p->id_pengaduan) }}" class="action-btn view-btn" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h4 class="empty-title">Tidak Ada Pengaduan Menunggu</h4>
                        <p class="empty-desc">Semua pengaduan telah diverifikasi</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- AKTIVITAS TERBARU -->
        <div class="content-card">
            <div class="card-header">
                <div class="card-title-section">
                    <h3 class="card-title">
                        <i class="fas fa-history card-title-icon"></i>
                        Aktivitas Terbaru
                    </h3>
                </div>
                <a href="{{ route('admin.pengaduan.index') }}" class="card-action">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                @if($pengaduan_terbaru->count() > 0)
                    <div class="activity-list">
                        @foreach($pengaduan_terbaru as $p)
                        <div class="activity-item">
                            <div class="activity-icon status-{{ strtolower($p->status) }}">
                                @if($p->status == 'Diajukan')
                                    <i class="fas fa-clock"></i>
                                @elseif($p->status == 'Diproses')
                                    <i class="fas fa-cog"></i>
                                @elseif($p->status == 'Selesai')
                                    <i class="fas fa-check-circle"></i>
                                @elseif($p->status == 'Disetujui')
                                    <i class="fas fa-thumbs-up"></i>
                                @elseif($p->status == 'Ditolak')
                                    <i class="fas fa-times-circle"></i>
                                @else
                                    <i class="fas fa-question-circle"></i>
                                @endif
                            </div>
                            <div class="activity-content">
                                <div class="activity-main">
                                    <span class="activity-title">{{ Str::limit($p->nama_pengaduan, 50) }}</span>
                                    <span class="activity-badge status-{{ strtolower($p->status) }}">{{ $p->status }}</span>
                                </div>
                                <div class="activity-meta">
                                    <span class="activity-user">
                                        <i class="fas fa-user"></i>
                                        {{ $p->user->nama_pengguna }}
                                    </span>
                                    <span class="activity-time">
                                        <i class="fas fa-clock"></i>
                                        {{ date('d M Y', strtotime($p->created_at)) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <h4 class="empty-title">Belum Ada Aktivitas</h4>
                        <p class="empty-desc">Tidak ada pengaduan terbaru</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN - SIDEBAR -->
    <div class="content-column sidebar-content">
        <!-- AKSI CEPAT -->
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bolt card-title-icon"></i>
                    Aksi Cepat
                </h3>
            </div>
            <div class="card-body">
                <div class="quick-actions-grid">
                    <a href="{{ route('admin.pengaduan.index') }}" class="quick-action-btn">
                        <div class="action-icon">
                            <i class="fas fa-list"></i>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Kelola Pengaduan</span>
                            <span class="action-desc">Lihat semua</span>
                        </div>
                        <div class="action-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>

                    <a href="{{ route('admin.pengaduan.index') }}?status=Diajukan" class="quick-action-btn">
                        <div class="action-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Verifikasi</span>
                            <span class="action-desc">Pengaduan menunggu</span>
                        </div>
                        <div class="action-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>

                    <a href="{{ route('admin.pengaduan.index') }}?status=Diproses" class="quick-action-btn">
                        <div class="action-icon">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Follow Up</span>
                            <span class="action-desc">Pengaduan diproses</span>
                        </div>
                        <div class="action-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>

                    <a href="{{ route('admin.pengaduan.index') }}?status=Selesai" class="quick-action-btn">
                        <div class="action-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Review</span>
                            <span class="action-desc">Pengaduan selesai</span>
                        </div>
                        <div class="action-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- OVERVIEW SISTEM -->
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie card-title-icon"></i>
                    Overview Sistem
                </h3>
            </div>
            <div class="card-body">
                <div class="system-stats">
                    <div class="system-stat">
                        <div class="stat-icon-wrapper">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value">{{ $total_users }}</span>
                            <span class="stat-label">Total Users</span>
                        </div>
                    </div>
                    <div class="system-stat">
                        <div class="stat-icon-wrapper">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value">{{ $total_petugas }}</span>
                            <span class="stat-label">Petugas</span>
                        </div>
                    </div>
                    <div class="system-stat">
                        <div class="stat-icon-wrapper">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value">{{ $total_items }}</span>
                            <span class="stat-label">Items</span>
                        </div>
                    </div>
                    <div class="system-stat">
                        <div class="stat-icon-wrapper">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value">{{ $total_lokasi }}</span>
                            <span class="stat-label">Lokasi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DISTRIBUSI STATUS -->
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar card-title-icon"></i>
                    Distribusi Status
                </h3>
            </div>
            <div class="card-body">
                <div class="status-distribution">
                    <div class="status-item">
                        <div class="status-info">
                            <span class="status-label">Diajukan</span>
                            <span class="status-count">{{ $pengaduan_diajukan }}</span>
                        </div>
                        <div class="status-bar">
                            <div class="status-progress progress-diajukan"
                                 style="width: {{ $total_pengaduan > 0 ? ($pengaduan_diajukan / $total_pengaduan) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="status-item">
                        <div class="status-info">
                            <span class="status-label">Diproses</span>
                            <span class="status-count">{{ $pengaduan_diproses }}</span>
                        </div>
                        <div class="status-bar">
                            <div class="status-progress progress-diproses"
                                 style="width: {{ $total_pengaduan > 0 ? ($pengaduan_diproses / $total_pengaduan) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="status-item">
                        <div class="status-info">
                            <span class="status-label">Selesai</span>
                            <span class="status-count">{{ $pengaduan_selesai }}</span>
                        </div>
                        <div class="status-bar">
                            <div class="status-progress progress-selesai"
                                 style="width: {{ $total_pengaduan > 0 ? ($pengaduan_selesai / $total_pengaduan) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* VARIABLES */
:root {
    --primary-dark: #31326F;
    --primary-medium: #637AB9;
    --neutral-light: #D9D9D9;
    --background: #EFF2F8;
    --white: #FFFFFF;
    --text-primary: #2D3748;
    --text-secondary: #718096;
    --text-muted: #A0AEC0;
    --border: #E2E8F0;
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --radius: 12px;
    --radius-sm: 8px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* BASE STYLES */
* {
    box-sizing: border-box;
}

body {
    background-color: var(--background);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    color: var(--text-primary);
    line-height: 1.6;
}

/* PAGE HEADER */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border);
}

.header-content {
    flex: 1;
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-dark);
    margin: 0 0 0.5rem 0;
    line-height: 1.2;
}

.page-subtitle {
    color: var(--text-secondary);
    font-size: 1.1rem;
    margin: 0;
    font-weight: 400;
}

.date-display {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background: var(--white);
    border-radius: var(--radius-sm);
    border: 1px solid var(--border);
    color: var(--text-secondary);
    font-size: 0.9rem;
    font-weight: 500;
}

.date-display i {
    color: var(--primary-medium);
}

/* STATS GRID */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2.5rem;
}

.stat-card {
    background: var(--white);
    border-radius: var(--radius);
    padding: 1.5rem;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-dark), var(--primary-medium));
}

.stat-primary::before { background: linear-gradient(90deg, #31326F, #637AB9); }
.stat-warning::before { background: linear-gradient(90deg, #F59E0B, #FBBF24); }
.stat-info::before { background: linear-gradient(90deg, #06B6D4, #22D3EE); }
.stat-success::before { background: linear-gradient(90deg, #10B981, #34D399); }

.stat-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.stat-main {
    flex: 1;
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--primary-dark);
    line-height: 1;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.9rem;
    color: var(--text-secondary);
    font-weight: 500;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--white);
    background: rgba(99, 122, 185, 0.1);
}

.stat-primary .stat-icon { background: rgba(49, 50, 111, 0.1); color: #31326F; }
.stat-warning .stat-icon { background: rgba(245, 158, 11, 0.1); color: #F59E0B; }
.stat-info .stat-icon { background: rgba(6, 182, 212, 0.1); color: #06B6D4; }
.stat-success .stat-icon { background: rgba(16, 185, 129, 0.1); color: #10B981; }

.stat-footer {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
    color: var(--text-muted);
    padding-top: 0.75rem;
    border-top: 1px solid var(--border);
}

.stat-footer i {
    font-size: 0.7rem;
}

/* CONTENT GRID */
.content-grid {
    display: grid;
    grid-template-columns: 2fr 6fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

.content-column {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* CONTENT CARDS */
.content-card {
    background: var(--white);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    overflow: hidden;
    transition: var(--transition);
}

.content-card:hover {
    box-shadow: var(--shadow-lg);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--border);
    background: var(--white);
}

.card-title-section {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--primary-dark);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-title-icon {
    color: var(--primary-medium);
    font-size: 1rem;
}

.card-badge {
    background: var(--primary-medium);
    color: var(--white);
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.card-action {
    color: var(--primary-medium);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: var(--transition);
}

.card-action:hover {
    color: var(--primary-dark);
    transform: translateX(2px);
}

.card-body {
    padding: 1.5rem;
}

/* DATA TABLE */
.data-table {
    border-radius: var(--radius-sm);
    overflow: hidden;
    border: 1px solid var(--border);
}

.table-header {
    background: var(--background);
}

.table-row {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr 0.5fr;
    gap: 1rem;
    padding: 1rem 1.5rem;
    align-items: center;
}

.header-row {
    font-weight: 600;
    color: var(--text-secondary);
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid var(--border);
}

.data-row {
    transition: var(--transition);
    border-bottom: 1px solid var(--border);
}

.data-row:last-child {
    border-bottom: none;
}

.data-row:hover {
    background: var(--background);
}

.table-cell {
    display: flex;
    align-items: center;
}

.cell-content {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.primary-text {
    font-weight: 500;
    color: var(--text-primary);
}

.user-info, .location-info, .date-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.user-info i, .location-info i, .date-info i {
    color: var(--primary-medium);
    font-size: 0.8rem;
}

.action-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 6px;
    background: var(--background);
    color: var(--text-secondary);
    text-decoration: none;
    transition: var(--transition);
}

.view-btn:hover {
    background: var(--primary-medium);
    color: var(--white);
}

/* ACTIVITY LIST */
.activity-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    border-radius: var(--radius-sm);
    border: 1px solid var(--border);
    transition: var(--transition);
}

.activity-item:hover {
    border-color: var(--primary-medium);
    transform: translateX(4px);
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.status-diajukan { background: rgba(245, 158, 11, 0.1); color: #F59E0B; }
.status-diproses { background: rgba(6, 182, 212, 0.1); color: #06B6D4; }
.status-selesai { background: rgba(16, 185, 129, 0.1); color: #10B981; }
.status-disetujui { background: rgba(49, 50, 111, 0.1); color: #31326F; }
.status-ditolak { background: rgba(239, 68, 68, 0.1); color: #EF4444; }

.activity-content {
    flex: 1;
}

.activity-main {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.5rem;
}

.activity-title {
    font-weight: 500;
    color: var(--text-primary);
    flex: 1;
    margin-right: 1rem;
}

.activity-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.activity-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.activity-user, .activity-time {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* QUICK ACTIONS */
.quick-actions-grid {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.quick-action-btn {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: var(--radius-sm);
    background: var(--background);
    border: 1px solid var(--border);
    text-decoration: none;
    color: inherit;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.quick-action-btn::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: var(--primary-medium);
    transform: scaleY(0);
    transition: var(--transition);
}

.quick-action-btn:hover {
    background: var(--white);
    border-color: var(--primary-medium);
    transform: translateX(4px);
}

.quick-action-btn:hover::before {
    transform: scaleY(1);
}

.action-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-medium);
    font-size: 1.1rem;
    flex-shrink: 0;
    border: 1px solid var(--border);
}

.action-content {
    flex: 1;
}

.action-title {
    display: block;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.action-desc {
    display: block;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.action-arrow {
    color: var(--text-muted);
    transition: var(--transition);
}

.quick-action-btn:hover .action-arrow {
    color: var(--primary-medium);
    transform: translateX(2px);
}

/* SYSTEM STATS */
.system-stats {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.system-stat {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: var(--radius-sm);
    background: var(--background);
    border: 1px solid var(--border);
    transition: var(--transition);
}

.system-stat:hover {
    border-color: var(--primary-medium);
    transform: translateX(4px);
}

.stat-icon-wrapper {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-medium);
    font-size: 1.2rem;
    border: 1px solid var(--border);
}

.stat-info {
    flex: 1;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-dark);
    display: block;
    line-height: 1;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.9rem;
    color: var(--text-secondary);
    font-weight: 500;
}

/* STATUS DISTRIBUTION */
.status-distribution {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.status-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.status-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.status-label {
    font-size: 0.9rem;
    color: var(--text-primary);
    font-weight: 500;
}

.status-count {
    font-size: 0.9rem;
    color: var(--text-secondary);
    font-weight: 600;
}

.status-bar {
    height: 6px;
    background: var(--neutral-light);
    border-radius: 3px;
    overflow: hidden;
}

.status-progress {
    height: 100%;
    border-radius: 3px;
    transition: width 1s ease-in-out;
}

.progress-diajukan { background: #F59E0B; }
.progress-diproses { background: #06B6D4; }
.progress-selesai { background: #10B981; }

/* EMPTY STATES */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: var(--text-muted);
}

.empty-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--text-secondary);
    margin: 0 0 0.5rem 0;
}

.empty-desc {
    margin: 0;
    font-size: 0.9rem;
}

/* RESPONSIVE DESIGN */
@media (max-width: 1200px) {
    .content-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .sidebar-content {
        order: -1;
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .table-row {
        grid-template-columns: 1fr;
        gap: 0.5rem;
        padding: 1rem;
    }

    .header-row {
        display: none;
    }

    .data-row {
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        margin-bottom: 0.75rem;
    }

    .table-cell {
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid var(--border);
    }

    .table-cell:last-child {
        border-bottom: none;
        justify-content: center;
        padding-top: 1rem;
    }

    .cell-content::before {
        content: attr(data-label);
        font-weight: 600;
        color: var(--text-secondary);
        font-size: 0.8rem;
        text-transform: uppercase;
        min-width: 80px;
    }

    .activity-main {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .activity-meta {
        flex-direction: column;
        gap: 0.25rem;
    }
}

@media (max-width: 480px) {
    .page-title {
        font-size: 1.5rem;
    }

    .stat-value {
        font-size: 2rem;
    }

    .card-body {
        padding: 1rem;
    }

    .content-card {
        border-radius: var(--radius-sm);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animation to stat cards
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('animate-in');
    });

    // Add hover effects to interactive elements
    const interactiveElements = document.querySelectorAll('.quick-action-btn, .activity-item, .system-stat');
    interactiveElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(4px)';
        });
        element.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // Progress bar animation
    const progressBars = document.querySelectorAll('.status-progress');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => {
            bar.style.width = width;
        }, 500);
    });
});
</script>
@endsection
