@extends('layouts.petugas')

@section('title', 'History Pengaduan Selesai - Sistem Pengaduan')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-history page-title-icon"></i>
                History Pengaduan Selesai
            </h1>
            <p class="page-subtitle">Daftar lengkap pengaduan yang telah diselesaikan</p>
        </div>
        <div class="header-stats">
            <div class="stat-card">
                <div class="stat-icon completed">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ count($pengaduan) }}</div>
                    <div class="stat-label">Total Selesai</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card history-card">
        <div class="card-header history-header">
            <div class="header-title-section">
                <h3 class="card-title">
                    <i class="fas fa-clipboard-check me-2"></i>
                    Daftar Pengaduan Yang Sudah Selesai
                </h3>
                <p class="card-subtitle">Monitor dan tinjau kembali pengaduan yang telah ditangani</p>
            </div>
            <div class="header-actions">
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" id="searchInput" placeholder="Cari pengaduan...">
                    <div class="search-tools">
                        <button class="btn-tool" id="clearSearch" title="Hapus pencarian">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Statistics Overview -->
            <div class="stats-overview">
                <div class="stat-item">
                    <div class="stat-badge primary">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div class="stat-details">
                        <span class="stat-value">This Month</span>
                        <span class="stat-label">Pengaduan Selesai</span>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-badge success">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-details">
                        <span class="stat-value">98%</span>
                        <span class="stat-label">Tingkat Penyelesaian</span>
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="table-container">
                <div class="table-responsive">
                    <table class="history-table" id="historyTable">
                        <thead>
                            <tr>
                                <th class="column-number">#</th>
                                <th class="column-pengaduan">
                                    <div class="column-header">
                                        <span>Nama Pengaduan</span>
                                        <i class="fas fa-sort sort-icon" data-sort="pengaduan"></i>
                                    </div>
                                </th>
                                <th class="column-pelapor">
                                    <div class="column-header">
                                        <span>Pelapor</span>
                                        <i class="fas fa-sort sort-icon" data-sort="pelapor"></i>
                                    </div>
                                </th>
                                <th class="column-tanggal">
                                    <div class="column-header">
                                        <span>Tanggal Pengajuan</span>
                                        <i class="fas fa-sort sort-icon" data-sort="pengajuan"></i>
                                    </div>
                                </th>
                                <th class="column-tanggal">
                                    <div class="column-header">
                                        <span>Tanggal Selesai</span>
                                        <i class="fas fa-sort sort-icon" data-sort="selesai"></i>
                                    </div>
                                </th>
                                <th class="column-saran">Saran Petugas</th>
                                <th class="column-actions">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengaduan as $key => $p)
                            <tr class="history-item" data-pengaduan="{{ strtolower($p->nama_pengaduan) }}" data-pelapor="{{ strtolower($p->user->nama_pengguna) }}" data-pengajuan="{{ $p->tgl_pengajuan }}" data-selesai="{{ $p->tgl_selesai }}">
                                <td class="cell-number">
                                    <div class="number-badge">{{ $key + 1 }}</div>
                                </td>
                                <td class="cell-pengaduan">
                                    <div class="pengaduan-info">
                                        <h6 class="pengaduan-title">{{ $p->nama_pengaduan }}</h6>
                                        <div class="pengaduan-meta">
                                            <span class="status-badge completed">
                                                <i class="fas fa-check-circle"></i>
                                                Selesai
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="cell-pelapor">
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($p->user->nama_pengguna, 0, 2)) }}
                                        </div>
                                        <div class="user-details">
                                            <span class="user-name">{{ $p->user->nama_pengguna }}</span>
                                            <span class="user-role">Pelapor</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="cell-tanggal">
                                    <div class="date-info">
                                        <i class="fas fa-calendar-alt date-icon"></i>
                                        <span class="date-value">{{ $p->tgl_pengajuan }}</span>
                                    </div>
                                </td>
                                <td class="cell-tanggal">
                                    <div class="date-info completed">
                                        <i class="fas fa-flag-checkered date-icon"></i>
                                        <span class="date-value">{{ $p->tgl_selesai }}</span>
                                    </div>
                                </td>
                                <td class="cell-saran">
                                    <div class="saran-content">
                                        @if($p->saran_petugas)
                                            <p class="saran-text">{{ Str::limit($p->saran_petugas, 60) }}</p>
                                            @if(strlen($p->saran_petugas) > 60)
                                                <button class="btn-read-more" data-saran="{{ $p->saran_petugas }}">
                                                    Baca Selengkapnya
                                                </button>
                                            @endif
                                        @else
                                            <span class="no-saran">- Tidak ada saran -</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="cell-actions">
                                    <div class="action-buttons">
                                        <a href="{{ route('petugas.pengaduan.show', $p->id_pengaduan) }}" class="btn-action btn-detail" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                            <span>Detail</span>
                                        </a>
                                        <button class="btn-action btn-quick-view" data-pengaduan="{{ $p->id_pengaduan }}" title="Tinjau Cepat">
                                            <i class="fas fa-search-plus"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr class="no-data">
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-inbox"></i>
                                        </div>
                                        <h4 class="empty-title">Belum ada history pengaduan selesai</h4>
                                        <p class="empty-description">
                                            Semua pengaduan yang telah diselesaikan akan muncul di sini.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Table Footer -->
            @if(count($pengaduan) > 0)
            <div class="table-footer">
                <div class="footer-info">
                    <span class="info-text">
                        Menampilkan <strong>{{ count($pengaduan) }}</strong> pengaduan selesai
                    </span>
                </div>
                <div class="footer-export">
                    <button class="btn-export" id="exportBtn">
                        <i class="fas fa-download me-2"></i>
                        Ekspor Data
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Saran Modal -->
<div class="modal fade" id="saranModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-comment-dots me-2"></i>
                    Saran Petugas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="saranFullText" class="saran-full-text"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary-dark: #31326F;
    --primary-medium: #637AB9;
    --neutral-light: #D9D9D9;
    --background-light: #EFF2F8;
    --white: #ffffff;
    --success: #28a745;
    --warning: #ffc107;
    --danger: #dc3545;
    --shadow: 0 4px 12px rgba(49, 50, 111, 0.1);
    --shadow-lg: 0 8px 25px rgba(49, 50, 111, 0.15);
    --transition: all 0.3s ease;
    --radius: 12px;
    --radius-sm: 8px;
}

/* Page Header */
.page-header {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 2rem;
    animation: fadeInDown 0.8s ease;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-content {
    flex: 1;
}

.page-title {
    color: var(--primary-dark);
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.page-title-icon {
    color: var(--primary-medium);
    font-size: 2.5rem;
}

.page-subtitle {
    color: var(--primary-medium);
    font-size: 1.1rem;
    opacity: 0.8;
}

.header-stats {
    display: flex;
    gap: 1rem;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    background: var(--white);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border-left: 4px solid var(--success);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stat-icon.completed {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success);
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-dark);
}

.stat-label {
    color: var(--primary-medium);
    font-size: 0.9rem;
}

/* Main Card */
.history-card {
    border: none;
    border-radius: var(--radius);
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    animation: fadeInUp 0.8s ease;
}

.history-header {
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-medium));
    color: white;
    padding: 1.5rem 2rem;
    border-bottom: none;
    display: flex;
    justify-content: between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.card-title {
    font-weight: 700;
    margin: 0;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
}

.card-subtitle {
    opacity: 0.9;
    margin: 0.25rem 0 0 0;
    font-size: 0.9rem;
}

.header-actions {
    display: flex;
    gap: 1rem;
}

.search-container {
    position: relative;
    display: flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.1);
    border-radius: var(--radius-sm);
    padding: 0.5rem;
    backdrop-filter: blur(10px);
}

.search-icon {
    color: rgba(255, 255, 255, 0.8);
    margin: 0 0.5rem;
}

.search-input {
    background: transparent;
    border: none;
    color: white;
    padding: 0.5rem;
    width: 250px;
    outline: none;
}

.search-input::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

.search-tools {
    display: flex;
    gap: 0.25rem;
}

.btn-tool {
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: rgba(255, 255, 255, 0.8);
    width: 30px;
    height: 30px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
}

.btn-tool:hover {
    background: rgba(255, 255, 255, 0.2);
}

/* Statistics Overview */
.stats-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: var(--background-light);
    border-radius: var(--radius);
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--white);
    border-radius: var(--radius-sm);
    box-shadow: var(--shadow);
}

.stat-badge {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.stat-badge.primary {
    background: rgba(99, 122, 185, 0.1);
    color: var(--primary-medium);
}

.stat-badge.success {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success);
}

.stat-value {
    font-weight: 600;
    color: var(--primary-dark);
    display: block;
}

.stat-label {
    color: var(--primary-medium);
    font-size: 0.85rem;
}

/* Table Styles */
.table-container {
    background: var(--white);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow);
}

.history-table {
    width: 100%;
    border-collapse: collapse;
}

.history-table thead {
    background: var(--background-light);
}

.history-table th {
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: var(--primary-dark);
    border-bottom: 2px solid var(--neutral-light);
}

.column-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.sort-icon {
    color: var(--primary-medium);
    cursor: pointer;
    opacity: 0.6;
    transition: var(--transition);
}

.sort-icon:hover {
    opacity: 1;
}

.history-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--neutral-light);
    vertical-align: top;
}

.history-item {
    transition: var(--transition);
    animation: slideIn 0.5s ease;
}

.history-item:hover {
    background: var(--background-light);
    transform: translateX(5px);
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

/* Cell Styles */
.cell-number {
    text-align: center;
    width: 60px;
}

.number-badge {
    background: var(--primary-medium);
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.85rem;
    margin: 0 auto;
}

.pengaduan-title {
    font-weight: 600;
    color: var(--primary-dark);
    margin: 0 0 0.5rem 0;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-badge.completed {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success);
}

.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-medium), var(--primary-dark));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.85rem;
}

.user-name {
    font-weight: 600;
    color: var(--primary-dark);
    display: block;
}

.user-role {
    color: var(--primary-medium);
    font-size: 0.8rem;
}

.date-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.date-info.completed {
    color: var(--success);
}

.date-icon {
    opacity: 0.7;
}

.date-value {
    font-weight: 500;
}

.saran-text {
    margin: 0;
    color: var(--primary-dark);
    line-height: 1.4;
}

.no-saran {
    color: var(--neutral-light);
    font-style: italic;
}

.btn-read-more {
    background: none;
    border: none;
    color: var(--primary-medium);
    font-size: 0.8rem;
    cursor: pointer;
    padding: 0;
    margin-top: 0.25rem;
    text-decoration: underline;
    transition: var(--transition);
}

.btn-read-more:hover {
    color: var(--primary-dark);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: var(--radius-sm);
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: var(--transition);
}

.btn-detail {
    background: var(--primary-medium);
    color: white;
}

.btn-detail:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

.btn-quick-view {
    background: var(--background-light);
    color: var(--primary-dark);
    padding: 0.5rem;
}

.btn-quick-view:hover {
    background: var(--neutral-light);
    transform: translateY(-2px);
}

/* Empty State */
.no-data td {
    padding: 3rem 1rem;
    text-align: center;
}

.empty-state {
    max-width: 400px;
    margin: 0 auto;
}

.empty-icon {
    font-size: 4rem;
    color: var(--neutral-light);
    margin-bottom: 1rem;
}

.empty-title {
    color: var(--primary-dark);
    margin-bottom: 0.5rem;
}

.empty-description {
    color: var(--primary-medium);
}

/* Table Footer */
.table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: var(--background-light);
    border-top: 1px solid var(--neutral-light);
}

.info-text {
    color: var(--primary-medium);
}

.btn-export {
    background: var(--white);
    color: var(--primary-dark);
    border: 1px solid var(--neutral-light);
    padding: 0.5rem 1rem;
    border-radius: var(--radius-sm);
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
}

.btn-export:hover {
    background: var(--primary-medium);
    color: white;
    border-color: var(--primary-medium);
}

/* Modal Styles */
.modal-content {
    border: none;
    border-radius: var(--radius);
    box-shadow: var(--shadow-lg);
}

.modal-header {
    background: var(--background-light);
    border-bottom: 1px solid var(--neutral-light);
    padding: 1.5rem;
}

.modal-title {
    color: var(--primary-dark);
    font-weight: 600;
    display: flex;
    align-items: center;
}

.modal-body {
    padding: 1.5rem;
}

.saran-full-text {
    line-height: 1.6;
    color: var(--primary-dark);
    margin: 0;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .header-stats {
        width: 100%;
    }

    .history-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .header-actions {
        width: 100%;
    }

    .search-input {
        width: 100%;
    }

    .stats-overview {
        grid-template-columns: 1fr;
    }

    .action-buttons {
        flex-direction: column;
    }

    .table-footer {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .user-info {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const clearSearch = document.getElementById('clearSearch');
    const historyItems = document.querySelectorAll('.history-item');
    const readMoreButtons = document.querySelectorAll('.btn-read-more');
    const sortIcons = document.querySelectorAll('.sort-icon');
    const exportBtn = document.getElementById('exportBtn');

    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        historyItems.forEach(item => {
            const pengaduanText = item.getAttribute('data-pengaduan');
            const pelaporText = item.getAttribute('data-pelapor');
            const pengajuanText = item.getAttribute('data-pengajuan');
            const selesaiText = item.getAttribute('data-selesai');

            const match = pengaduanText.includes(searchTerm) ||
                         pelaporText.includes(searchTerm) ||
                         pengajuanText.includes(searchTerm) ||
                         selesaiText.includes(searchTerm);

            item.style.display = match ? '' : 'none';
        });
    });

    // Clear search
    clearSearch.addEventListener('click', function() {
        searchInput.value = '';
        searchInput.dispatchEvent(new Event('input'));
        searchInput.focus();
    });

    // Read more functionality for saran
    readMoreButtons.forEach(button => {
        button.addEventListener('click', function() {
            const saranText = this.getAttribute('data-saran');
            document.getElementById('saranFullText').textContent = saranText;

            // Show modal (you might need to initialize Bootstrap modal here)
            const modal = new bootstrap.Modal(document.getElementById('saranModal'));
            modal.show();
        });
    });

    // Sort functionality
    let currentSort = { column: null, direction: 'asc' };

    sortIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const column = this.getAttribute('data-sort');
            sortTable(column);
        });
    });

    function sortTable(column) {
        const tbody = document.querySelector('#historyTable tbody');
        const rows = Array.from(tbody.querySelectorAll('.history-item'));

        rows.sort((a, b) => {
            let aValue, bValue;

            switch(column) {
                case 'pengaduan':
                    aValue = a.getAttribute('data-pengaduan');
                    bValue = b.getAttribute('data-pengaduan');
                    break;
                case 'pelapor':
                    aValue = a.getAttribute('data-pelapor');
                    bValue = b.getAttribute('data-pelapor');
                    break;
                case 'pengajuan':
                    aValue = new Date(a.getAttribute('data-pengajuan'));
                    bValue = new Date(b.getAttribute('data-pengajuan'));
                    break;
                case 'selesai':
                    aValue = new Date(a.getAttribute('data-selesai'));
                    bValue = new Date(b.getAttribute('data-selesai'));
                    break;
                default:
                    return 0;
            }

            if (currentSort.column === column && currentSort.direction === 'asc') {
                return aValue < bValue ? 1 : -1;
            } else {
                return aValue > bValue ? 1 : -1;
            }
        });

        // Update sort state
        if (currentSort.column === column) {
            currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
        } else {
            currentSort.column = column;
            currentSort.direction = 'asc';
        }

        // Update sort icons
        sortIcons.forEach(icon => {
            icon.className = 'fas fa-sort sort-icon';
            if (icon.getAttribute('data-sort') === column) {
                icon.className = `fas fa-sort-${currentSort.direction === 'asc' ? 'up' : 'down'} sort-icon`;
            }
        });

        // Re-append sorted rows
        rows.forEach(row => tbody.appendChild(row));
    }

    // Export functionality
    exportBtn.addEventListener('click', function() {
        // Simple export simulation
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengekspor...';
        this.disabled = true;

        setTimeout(() => {
            this.innerHTML = '<i class="fas fa-download me-2"></i>Ekspor Data';
            this.disabled = false;

            // Show success message
            alert('Data berhasil diekspor!');
        }, 2000);
    });

    // Add animation to table rows
    historyItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
    });
});
</script>
@endsection
