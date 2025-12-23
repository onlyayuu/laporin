@extends('layouts.user')

@section('content')
<div class="pengaduan-container">
    <!-- Header Section -->
    <div class="pengaduan-header">
        <div class="header-main">
            <div class="title-section">
                <i class="fas fa-clipboard-list title-icon"></i>
                <div>
                    <h1>Daftar Pengaduan Saya</h1>
                    <p>Kelola dan pantau semua pengaduan yang telah Anda ajukan</p>
                </div>
            </div>
            <a href="{{ route('user.pengaduan.create') }}" class="btn-create">
                <i class="fas fa-plus"></i>
                Ajukan Baru
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-number">{{ $pengaduans->count() }}</span>
                    <span class="stat-label">Total</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon process">
                    <i class="fas fa-spinner"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-number">{{ $pengaduans->where('status', 'Diproses')->count() }}</span>
                    <span class="stat-label">Diproses</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon done">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-number">{{ $pengaduans->where('status', 'Selesai')->count() }}</span>
                    <span class="stat-label">Selesai</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Section -->
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
        <button class="alert-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Search & Filter Section -->
    <div class="search-filter-section">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Cari pengaduan...">
            <button class="clear-search" id="clearSearch">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="filter-group">
            <select id="statusFilter" class="filter-select">
                <option value="">Semua Status</option>
                <option value="Diajukan">Diajukan</option>
                <option value="Disetujui">Disetujui</option>
                <option value="Diproses">Diproses</option>
                <option value="Selesai">Selesai</option>
                <option value="Ditolak">Ditolak</option>
            </select>
        </div>
    </div>

    <!-- Pengaduan List -->
    @if($pengaduans->count() > 0)
    <div class="pengaduan-list" id="pengaduanList">
        @foreach($pengaduans as $pengaduan)
        <div class="pengaduan-item"
             data-status="{{ $pengaduan->status }}"
             data-search="{{ strtolower($pengaduan->nama_pengaduan . ' ' . $pengaduan->lokasi . ' ' . $pengaduan->id_pengaduan) }}">
            <div class="item-header">
                <div class="item-id">
                    <span>#{{ $pengaduan->id_pengaduan }}</span>
                </div>
                <div class="status-badge status-{{ strtolower($pengaduan->status) }}">
                    <i class="status-icon
                        @if($pengaduan->status == 'Diajukan') fas fa-clock
                        @elseif($pengaduan->status == 'Disetujui') fas fa-check
                        @elseif($pengaduan->status == 'Diproses') fas fa-cog
                        @elseif($pengaduan->status == 'Selesai') fas fa-flag-checkered
                        @elseif($pengaduan->status == 'Ditolak') fas fa-times
                        @else fas fa-question @endif">
                    </i>
                    {{ $pengaduan->status }}
                </div>
            </div>

            <div class="item-content">
                <h3 class="item-title">{{ $pengaduan->nama_pengaduan }}</h3>

                <div class="item-meta">
                    <div class="meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $pengaduan->lokasi }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-calendar"></i>
                        <span>{{ $pengaduan->tgl_pengajuan }}</span>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="progress-container">
                    <div class="progress-labels">
                        <span>Progress</span>
                        <span class="progress-percent">
                            @if($pengaduan->status == 'Diajukan') 25%
                            @elseif($pengaduan->status == 'Disetujui') 50%
                            @elseif($pengaduan->status == 'Diproses') 75%
                            @elseif($pengaduan->status == 'Selesai') 100%
                            @elseif($pengaduan->status == 'Ditolak') 0%
                            @else 0% @endif
                        </span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill
                            @if($pengaduan->status == 'Diajukan') progress-25
                            @elseif($pengaduan->status == 'Disetujui') progress-50
                            @elseif($pengaduan->status == 'Diproses') progress-75
                            @elseif($pengaduan->status == 'Selesai') progress-100
                            @elseif($pengaduan->status == 'Ditolak') progress-0
                            @else progress-0 @endif">
                        </div>
                    </div>
                </div>
            </div>

            <div class="item-actions">
                <a href="{{ route('user.pengaduan.show', $pengaduan->id_pengaduan) }}" class="btn-detail">
                    <i class="fas fa-eye"></i>
                    Lihat Detail
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty Search State -->
    <div class="empty-search" id="emptySearch" style="display: none;">
        <i class="fas fa-search"></i>
        <h3>Pengaduan tidak ditemukan</h3>
        <p>Coba ubah kata kunci pencarian atau filter status</p>
    </div>

    <!-- Pagination -->
    <div class="pagination-container">
        <div class="pagination-info">
            Menampilkan {{ $pengaduans->count() }} dari {{ $pengaduans->total() }} pengaduan
        </div>
        <div class="pagination-links">
            {{ $pengaduans->links() }}
        </div>
    </div>
    @else
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-inbox"></i>
        </div>
        <h3>Belum ada pengaduan</h3>
        <p>Mulai ajukan pengaduan pertama Anda untuk masalah yang ditemui</p>
        <a href="{{ route('user.pengaduan.create') }}" class="btn-create-first">
            <i class="fas fa-plus"></i>
            Ajukan Pengaduan Pertama
        </a>
    </div>
    @endif
</div>

<style>
/* Variables */
:root {
    --primary: #31326F;
    --secondary: #637AB9;
    --light: #D9D9D9;
    --background: #EFF2F8;
    --white: #FFFFFF;
    --text: #333333;
    --success: #28a745;
    --warning: #ffc107;
    --info: #17a2b8;
    --danger: #dc3545;
    --shadow: 0 2px 12px rgba(0,0,0,0.08);
    --shadow-hover: 0 4px 20px rgba(0,0,0,0.12);
    --radius: 12px;
    --radius-sm: 8px;
    --transition: all 0.3s ease;
}

/* Container */
.pengaduan-container {
    max-width: 100%;
    padding: 0 1rem;
}

/* Header Section */
.pengaduan-header {
    margin-bottom: 2rem;
}

.header-main {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.title-section {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.title-icon {
    font-size: 2.5rem;
    color: var(--secondary);
}

.title-section h1 {
    color: var(--primary);
    font-weight: 700;
    margin: 0;
    font-size: 1.8rem;
}

.title-section p {
    color: var(--secondary);
    margin: 0.25rem 0 0 0;
    opacity: 0.8;
}

.btn-create {
    background: linear-gradient(135deg, var(--secondary), var(--primary));
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius-sm);
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: var(--transition);
    box-shadow: var(--shadow);
    white-space: nowrap;
}

.btn-create:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
    color: white;
}

/* Stats Section */
.stats-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.stat-card {
    background: var(--white);
    padding: 1.25rem;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: var(--transition);
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
}

.stat-icon.total {
    background: linear-gradient(135deg, var(--secondary), var(--primary));
}

.stat-icon.process {
    background: linear-gradient(135deg, #17a2b8, #138496);
}

.stat-icon.done {
    background: linear-gradient(135deg, #28a745, #1e7e34);
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary);
    line-height: 1;
}

.stat-label {
    color: var(--secondary);
    font-size: 0.85rem;
    margin-top: 0.25rem;
}

/* Alert */
.alert {
    background: rgba(40, 167, 69, 0.1);
    border: 1px solid rgba(40, 167, 69, 0.2);
    border-radius: var(--radius-sm);
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    animation: slideIn 0.5s ease;
}

.alert i {
    color: var(--success);
}

.alert span {
    flex: 1;
    color: var(--text);
}

.alert-close {
    background: none;
    border: none;
    color: var(--secondary);
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 4px;
    transition: var(--transition);
}

.alert-close:hover {
    background: rgba(0,0,0,0.1);
}

/* Search & Filter Section */
.search-filter-section {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.search-box {
    flex: 1;
    min-width: 250px;
    position: relative;
    display: flex;
    align-items: center;
    background: var(--white);
    border-radius: var(--radius-sm);
    box-shadow: var(--shadow);
    border: 1px solid var(--light);
}

.search-box i {
    color: var(--secondary);
    margin: 0 1rem;
}

.search-box input {
    flex: 1;
    border: none;
    outline: none;
    padding: 0.75rem 0;
    background: transparent;
    color: var(--text);
}

.search-box input::placeholder {
    color: var(--light);
}

.clear-search {
    background: none;
    border: none;
    color: var(--light);
    cursor: pointer;
    padding: 0.5rem 1rem;
    transition: var(--transition);
}

.clear-search:hover {
    color: var(--secondary);
}

.filter-group {
    display: flex;
    gap: 0.75rem;
}

.filter-select {
    padding: 0.75rem 1rem;
    border: 1px solid var(--light);
    border-radius: var(--radius-sm);
    background: var(--white);
    color: var(--text);
    outline: none;
    cursor: pointer;
    min-width: 140px;
    transition: var(--transition);
    box-shadow: var(--shadow);
}

.filter-select:focus {
    border-color: var(--secondary);
}

/* Pengaduan List */
.pengaduan-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.pengaduan-item {
    background: var(--white);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    transition: var(--transition);
    animation: fadeInUp 0.5s ease;
}

.pengaduan-item:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

.item-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--background);
}

.item-id {
    color: var(--secondary);
    font-weight: 600;
    font-size: 0.9rem;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.status-diajukan {
    background: rgba(255, 193, 7, 0.1);
    color: #856404;
    border: 1px solid rgba(255, 193, 7, 0.2);
}

.status-disetujui {
    background: rgba(23, 162, 184, 0.1);
    color: #0c5460;
    border: 1px solid rgba(23, 162, 184, 0.2);
}

.status-diproses {
    background: rgba(0, 123, 255, 0.1);
    color: #004085;
    border: 1px solid rgba(0, 123, 255, 0.2);
}

.status-selesai {
    background: rgba(40, 167, 69, 0.1);
    color: #155724;
    border: 1px solid rgba(40, 167, 69, 0.2);
}

.status-ditolak {
    background: rgba(220, 53, 69, 0.1);
    color: #721c24;
    border: 1px solid rgba(220, 53, 69, 0.2);
}

.status-icon {
    font-size: 0.7rem;
}

.item-content {
    padding: 1.5rem;
}

.item-title {
    color: var(--primary);
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 1.1rem;
    line-height: 1.4;
}

.item-meta {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--secondary);
    font-size: 0.85rem;
}

.meta-item i {
    width: 14px;
    color: var(--secondary);
}

/* Progress Bar */
.progress-container {
    margin-top: 1rem;
}

.progress-labels {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
    font-size: 0.85rem;
    color: var(--text);
}

.progress-percent {
    font-weight: 600;
    color: var(--secondary);
}

.progress-bar {
    width: 100%;
    height: 6px;
    background: var(--light);
    border-radius: 3px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    border-radius: 3px;
    transition: width 0.8s ease;
}

.progress-0 { width: 0%; background: var(--danger); }
.progress-25 { width: 25%; background: var(--warning); }
.progress-50 { width: 50%; background: var(--info); }
.progress-75 { width: 75%; background: var(--secondary); }
.progress-100 { width: 100%; background: var(--success); }

/* Item Actions */
.item-actions {
    padding: 1rem 1.5rem;
    background: var(--background);
    border-top: 1px solid var(--light);
    text-align: center;
}

.btn-detail {
    background: var(--secondary);
    color: white;
    padding: 0.5rem 1.5rem;
    border-radius: var(--radius-sm);
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: var(--transition);
}

.btn-detail:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-1px);
}

/* Empty States */
.empty-search, .empty-state {
    text-align: center;
    padding: 3rem 2rem;
    animation: fadeIn 0.5s ease;
}

.empty-search i, .empty-state i {
    font-size: 4rem;
    color: var(--light);
    margin-bottom: 1rem;
}

.empty-search h3, .empty-state h3 {
    color: var(--primary);
    margin-bottom: 0.5rem;
}

.empty-search p, .empty-state p {
    color: var(--secondary);
    margin-bottom: 2rem;
}

.btn-create-first {
    background: linear-gradient(135deg, var(--secondary), var(--primary));
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius-sm);
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: var(--transition);
    box-shadow: var(--shadow);
}

.btn-create-first:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
    color: white;
}

/* Pagination */
.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 0;
    margin-top: 2rem;
    border-top: 1px solid var(--light);
    flex-wrap: wrap;
    gap: 1rem;
}

.pagination-info {
    color: var(--secondary);
    font-size: 0.9rem;
}

.pagination-links .pagination {
    margin: 0;
}

.pagination-links .page-link {
    color: var(--secondary);
    border: 1px solid var(--light);
    padding: 0.5rem 0.75rem;
    transition: var(--transition);
}

.pagination-links .page-item.active .page-link {
    background: var(--secondary);
    border-color: var(--secondary);
    color: white;
}

.pagination-links .page-link:hover {
    background: var(--background);
    color: var(--primary);
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .pengaduan-container {
        padding: 0 0.75rem;
    }

    .header-main {
        flex-direction: column;
        align-items: stretch;
    }

    .title-section {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }

    .stats-section {
        grid-template-columns: 1fr;
    }

    .search-filter-section {
        flex-direction: column;
    }

    .search-box {
        min-width: auto;
    }

    .filter-group {
        flex-direction: column;
    }

    .filter-select {
        min-width: auto;
    }

    .item-meta {
        grid-template-columns: 1fr;
    }

    .pagination-container {
        flex-direction: column;
        text-align: center;
    }
}

@media (max-width: 480px) {
    .title-section h1 {
        font-size: 1.5rem;
    }

    .pengaduan-item {
        margin: 0 -0.75rem;
        border-radius: 0;
        box-shadow: none;
        border-bottom: 1px solid var(--light);
    }

    .pengaduan-item:hover {
        transform: none;
        box-shadow: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const clearSearch = document.getElementById('clearSearch');
    const statusFilter = document.getElementById('statusFilter');
    const pengaduanList = document.getElementById('pengaduanList');
    const emptySearch = document.getElementById('emptySearch');
    const pengaduanItems = document.querySelectorAll('.pengaduan-item');

    // Search functionality
    searchInput.addEventListener('input', filterPengaduan);
    statusFilter.addEventListener('change', filterPengaduan);

    // Clear search
    clearSearch.addEventListener('click', function() {
        searchInput.value = '';
        filterPengaduan();
        searchInput.focus();
    });

    function filterPengaduan() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;

        let visibleItems = 0;

        pengaduanItems.forEach(item => {
            const searchData = item.getAttribute('data-search');
            const statusData = item.getAttribute('data-status');

            const searchMatch = searchData.includes(searchTerm);
            const statusMatch = statusValue === '' || statusData === statusValue;

            if (searchMatch && statusMatch) {
                item.style.display = 'block';
                visibleItems++;

                // Add animation
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, 50);
            } else {
                item.style.opacity = '0';
                item.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    item.style.display = 'none';
                }, 300);
            }
        });

        // Show/hide empty state
        if (visibleItems === 0) {
            emptySearch.style.display = 'block';
        } else {
            emptySearch.style.display = 'none';
        }
    }

    // Add staggered animation
    pengaduanItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
    });
});
</script>
@endsection
