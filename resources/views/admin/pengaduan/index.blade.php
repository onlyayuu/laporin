@extends('layouts.admin')

@section('content')
<div class="dashboard-container">
    <!-- HEADER -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-exclamation-circle me-2"></i>
                Manajemen Pengaduan
            </h1>
            <p class="page-subtitle">Kelola semua pengaduan dari pengguna sistem</p>
        </div>
        <div class="header-stats">
            <div class="stat-item">
                <div class="stat-number">{{ $totalPengaduan }}</div>
                <div class="stat-label">Total Pengaduan</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $totalBiasa }}</div>
                <div class="stat-label">Pengaduan Biasa</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $totalTemporary }}</div>
                <div class="stat-label">Pengaduan Temporary</div>
            </div>
        </div>
    </div>

    <!-- ALERT BESAR UNTUK TEMPORARY ITEM -->
    @if($totalTemporary > 0)
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
            <div>
                <h4 class="alert-heading mb-1">Ada pengaduan dengan data baru</h4>
                <p class="mb-1">Terdapat <strong>{{ $totalTemporary }} pengaduan</strong> yang menggunakan <strong>BARANG TEMPORARY</strong>.</p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif


    <!-- FILTER DAN PENCARIAN -->
    <div class="filter-card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.pengaduan.index') }}" method="GET" class="filter-form">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Filter Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="Diajukan" {{ request('status') == 'Diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Jenis Pengaduan</label>
                        <select name="jenis_pengaduan" class="form-select">
                            <option value="">Semua Jenis</option>
                            <option value="biasa" {{ request('jenis_pengaduan') == 'biasa' ? 'selected' : '' }}>Pengaduan Biasa</option>
                            <option value="temporary" {{ request('jenis_pengaduan') == 'temporary' ? 'selected' : '' }}>Pengaduan Temporary</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pencarian</label>
                        <div class="input-group">
                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   placeholder="Cari berdasarkan nama, deskripsi, atau lokasi..."
                                   value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-2"></i>Filter
                            </button>
                            <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-refresh me-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- STATISTIK FILTER AKTIF -->
    @if(request()->hasAny(['status', 'jenis_pengaduan', 'search']))
    <div class="alert alert-info mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong>Filter Aktif:</strong>
                @if(request('status'))
                    <span class="badge bg-primary ms-2">Status: {{ request('status') }}</span>
                @endif
                @if(request('jenis_pengaduan'))
                    <span class="badge bg-success ms-2">
                        Jenis: {{ request('jenis_pengaduan') == 'temporary' ? 'Temporary' : 'Biasa' }}
                    </span>
                @endif
                @if(request('search'))
                    <span class="badge bg-info ms-2">Pencarian: "{{ request('search') }}"</span>
                @endif
            </div>
            <div class="filter-results">
                Menampilkan {{ $pengaduans->count() }} dari {{ $pengaduans->total() }} pengaduan
            </div>
        </div>
    </div>
    @endif

    <!-- MAIN CONTENT -->
    <div class="content-card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list me-2"></i>
                Daftar Pengaduan
            </h3>
            <div class="card-actions">
                <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-sm btn-outline-primary" id="refreshBtn">
                    <i class="fas fa-refresh me-1"></i>Refresh
                </a>
            </div>
        </div>

        <div class="card-body">
            @if($pengaduans->count() > 0)
                <div class="table-container">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th width="60" class="text-center">#</th>
                                <th width="350">PENGADUAN</th>
                                <th width="250">USER & LOKASI</th>
                                <th width="140">STATUS</th>
                                <th width="120">TANGGAL</th>
                                <th width="100" class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengaduans as $pengaduan)
                            @php
                                $isTemporary = $pengaduan->id_item && \App\Http\Controllers\Admin\PengaduanController::isTemporaryItem($pengaduan->id_item);
                            @endphp
                            <tr class="table-row animate-in @if($isTemporary) temporary-item-row @endif">
                                <td class="text-center serial-number">
                                    <span class="number">{{ $loop->iteration + ($pengaduans->currentPage() - 1) * $pengaduans->perPage() }}</span>
                                </td>
                                <td class="pengaduan-info">
                                    <div class="pengaduan-title">
                                        {{ $pengaduan->nama_pengaduan }}
                                        @if($isTemporary)
                                        <span class="temporary-badge">
                                            <i class="fas fa-clock me-1"></i>TEMP
                                        </span>
                                        @endif
                                    </div>
                                    <div class="pengaduan-meta">ID: #{{ $pengaduan->id_pengaduan }}</div>
                                    @if($pengaduan->deskripsi)
                                    <div class="pengaduan-desc-truncate" title="{{ $pengaduan->deskripsi }}">
                                        {{ Str::limit($pengaduan->deskripsi, 80) }}
                                    </div>
                                    @endif
                                </td>
                                <td class="user-location-info">
                                    <div class="user-info-combined">
                                        <div class="user-avatar-small">
                                            {{ substr($pengaduan->user->nama_pengguna ?? 'U', 0, 1) }}
                                        </div>
                                        <div class="user-location-details">
                                            <div class="user-name-combined">{{ $pengaduan->user->nama_pengguna ?? 'Unknown User' }}</div>
                                            <div class="location-combined">
                                                <i class="fas fa-map-marker-alt location-icon-small"></i>
                                                <span class="location-text-combined">{{ $pengaduan->lokasi }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="status-cell">
                                    <span class="status-badge status-{{ strtolower($pengaduan->status) }}">
                                        <i class="status-icon
                                            @if($pengaduan->status == 'Diajukan') fas fa-clock
                                            @elseif($pengaduan->status == 'Disetujui') fas fa-check
                                            @elseif($pengaduan->status == 'Diproses') fas fa-cog
                                            @elseif($pengaduan->status == 'Selesai') fas fa-check-double
                                            @elseif($pengaduan->status == 'Ditolak') fas fa-times
                                            @else fas fa-circle @endif"></i>
                                        {{ $pengaduan->status }}
                                    </span>
                                </td>
                                <!-- Di bagian tanggal, ganti: -->
<td class="date-info">
    <div class="date-display">
        <div class="date">{{ date('d M Y', strtotime($pengaduan->tgl_pengajuan)) }}</div>
        <div class="time">{{ date('H:i', strtotime($pengaduan->tgl_pengajuan)) }}</div>
    </div>
</td>
                                <td class="action-cell">
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.pengaduan.show', $pengaduan->id_pengaduan) }}"
                                           class="btn-action btn-view"
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.pengaduan.destroy', $pengaduan->id_pengaduan) }}"
                                              method="POST"
                                              class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn-action btn-delete"
                                                    title="Hapus"
                                                    onclick="return confirm('Hapus pengaduan ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION -->
                <div class="pagination-container">
                    <div class="pagination-info">
                        Menampilkan <strong>{{ $pengaduans->firstItem() ?? 0 }} - {{ $pengaduans->lastItem() ?? 0 }}</strong>
                        dari <strong>{{ $pengaduans->total() }}</strong> pengaduan
                    </div>
                    <div class="pagination-links">
                        {{ $pengaduans->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <h3 class="empty-title">
                        @if(request()->hasAny(['status', 'jenis_pengaduan', 'search']))
                            Tidak Ada Pengaduan yang Sesuai Filter
                        @else
                            Belum Ada Pengaduan
                        @endif
                    </h3>
                    <p class="empty-description">
                        @if(request()->hasAny(['status', 'jenis_pengaduan', 'search']))
                            Coba ubah filter atau kata kunci pencarian Anda.
                        @else
                            Saat ini belum ada pengaduan yang masuk dalam sistem.
                        @endif
                    </p>
                    @if(request()->hasAny(['status', 'jenis_pengaduan', 'search']))
                    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-refresh me-2"></i>Reset Filter
                    </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* STYLING UNTUK FILTER CARD */
.filter-card {
    background: white;
    border-radius: 12px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
}

.filter-card .card-body {
    padding: 1.5rem;
}

.filter-form .form-label {
    font-weight: 600;
    color: var(--dark);
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

/* STYLING UNTUK TEMPORARY ITEM */
.temporary-item-row {
    background: linear-gradient(90deg, #fef2f2 0%, #fef2f2 100%) !important;
    border-left: 4px solid #dc2626 !important;
}

.temporary-item-row:hover {
    background: linear-gradient(90deg, #fee2e2 0%, #fee2e2 100%) !important;
}

.temporary-badge {
    background: #dc2626;
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
    margin-left: 8px;
    display: inline-flex;
    align-items: center;
}

.pengaduan-desc-truncate {
    font-size: 0.75rem;
    color: var(--gray);
    margin-top: 0.25rem;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* STYLING LAINNYA TETAP SAMA... */
:root {
    --primary: #31326F;
    --secondary: #637AB9;
    --accent: #4F46E5;
    --success: #10B981;
    --warning: #F59E0B;
    --danger: #EF4444;
    --info: #3B82F6;
    --light: #F8FAFC;
    --dark: #1E293B;
    --gray: #64748B;
    --border: #E2E8F0;
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

/* DASHBOARD LAYOUT */
.dashboard-container {
    padding: 0;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 12px;
    color: white;
    box-shadow: var(--shadow);
}

.header-content .page-title {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    color: rgb(255, 255, 255);
}

.header-content .page-subtitle {
    opacity: 100;
    margin: 0;
    font-size: 0.95rem;
    color: rgba(255, 255, 255, 0.9);
}

.header-stats {
    display: flex;
    gap: 1rem;
}

.stat-item {
    padding: 1rem 1.5rem;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 8px;
    backdrop-filter: blur(10px);
    text-align: center;
    min-width: 120px;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
    color: white;
}

.stat-label {
    font-size: 0.75rem;
    opacity: 0.9;
    margin-top: 0.25rem;
    color: rgba(255, 255, 255, 0.9);
}

/* CONTENT CARD */
.content-card {
    background: white;
    border-radius: 12px;
    box-shadow: var(--shadow);
    overflow: hidden;
    border: 1px solid var(--border);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid var(--border);
    background: var(--light);
}

.card-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--dark);
    margin: 0;
    display: flex;
    align-items: center;
}

.card-actions {
    display: flex;
    gap: 0.5rem;
}

/* MODERN TABLE - FIXED LAYOUT */
.table-container {
    overflow-x: auto;
    padding: 0;
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    table-layout: fixed;
}

.modern-table th {
    background: var(--light);
    padding: 1rem 0.75rem;
    font-weight: 600;
    font-size: 0.8rem;
    color: var(--gray);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid var(--border);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-align: left;
}

.modern-table td {
    padding: 1rem 0.75rem;
    border-bottom: 1px solid var(--border);
    transition: all 0.3s ease;
    vertical-align: middle;
    overflow: hidden;
    text-overflow: ellipsis;
}

.table-row {
    animation: slideIn 0.5s ease forwards;
    opacity: 0;
    transform: translateY(10px);
}

.table-row:hover {
    background: rgba(99, 122, 185, 0.03);
}

/* SERIAL NUMBER */
.serial-number {
    text-align: center;
}

.number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: var(--light);
    border-radius: 6px;
    font-weight: 600;
    color: var(--dark);
    font-size: 0.875rem;
}

/* PENGGUNA INFO */
.pengaduan-info {
    min-width: 300px;
    max-width: 350px;
}

.pengaduan-title {
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.25rem;
    line-height: 1.4;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.pengaduan-meta {
    font-size: 0.75rem;
    color: var(--gray);
    white-space: nowrap;
}

/* USER & LOCATION COMBINED */
.user-location-info {
    min-width: 200px;
    max-width: 250px;
}

.user-info-combined {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar-small {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.75rem;
    flex-shrink: 0;
}

.user-location-details {
    flex: 1;
    min-width: 0;
}

.user-name-combined {
    font-weight: 600;
    color: var(--dark);
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.location-combined {
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.location-icon-small {
    color: var(--danger);
    font-size: 0.7rem;
    flex-shrink: 0;
}

.location-text-combined {
    font-size: 0.75rem;
    color: var(--gray);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* STATUS BADGES */
.status-cell {
    min-width: 120px;
    max-width: 140px;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
    transition: all 0.3s ease;
    width: fit-content;
    max-width: 100%;
}

.status-diajukan {
    background: rgba(245, 158, 11, 0.1);
    color: #B45309;
    border: 1px solid rgba(245, 158, 11, 0.2);
}

.status-disetujui {
    background: rgba(59, 130, 246, 0.1);
    color: #1D4ED8;
    border: 1px solid rgba(59, 130, 246, 0.2);
}

.status-diproses {
    background: rgba(99, 122, 185, 0.1);
    color: var(--primary);
    border: 1px solid rgba(99, 122, 185, 0.2);
}

.status-selesai {
    background: rgba(16, 185, 129, 0.1);
    color: #047857;
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.status-ditolak {
    background: rgba(239, 68, 68, 0.1);
    color: #DC2626;
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.status-icon {
    font-size: 0.7rem;
    flex-shrink: 0;
}

/* DATE INFO */
.date-info {
    min-width: 100px;
    max-width: 120px;
}

.date-display {
    text-align: left;
}

.date {
    font-weight: 500;
    color: var(--dark);
    font-size: 0.875rem;
    white-space: nowrap;
}

.time {
    font-size: 0.75rem;
    color: var(--gray);
    margin-top: 0.125rem;
    white-space: nowrap;
}

/* ACTION BUTTONS */
.action-cell {
    min-width: 80px;
    max-width: 100px;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    align-items: center;
}

.btn-action {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    cursor: pointer;
    text-decoration: none;
    flex-shrink: 0;
}

.btn-view {
    background: var(--info);
    color: white;
}

.btn-view:hover {
    background: #2563EB;
    transform: translateY(-1px);
}

.btn-delete {
    background: var(--danger);
    color: white;
}

.btn-delete:hover {
    background: #DC2626;
    transform: translateY(-1px);
}

/* PAGINATION */
.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-top: 1px solid var(--border);
    background: var(--light);
}

.pagination-info {
    font-size: 0.875rem;
    color: var(--gray);
}

.pagination-links {
    display: flex;
    gap: 0.5rem;
}

/* EMPTY STATE */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    font-size: 4rem;
    color: var(--border);
    margin-bottom: 1.5rem;
    opacity: 0.5;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.75rem;
}

.empty-description {
    color: var(--gray);
    font-size: 1rem;
    margin: 0;
}

/* ANIMATIONS */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-in {
    animation: slideIn 0.5s ease forwards;
}

/* RESPONSIVE DESIGN */
@media (max-width: 1200px) {
    .modern-table {
        table-layout: auto;
    }
}

@media (max-width: 768px) {
    .dashboard-header {
        flex-direction: column;
        gap: 1.5rem;
        text-align: center;
    }

    .header-stats {
        flex-direction: column;
        width: 100%;
    }

    .stat-item {
        width: 100%;
    }

    .card-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .pagination-container {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .modern-table {
        font-size: 0.875rem;
        min-width: 700px;
    }

    .modern-table th,
    .modern-table td {
        padding: 0.75rem 0.5rem;
    }

    .user-info-combined {
        flex-direction: column;
        gap: 0.5rem;
        text-align: center;
    }

    .action-buttons {
        flex-direction: column;
        gap: 0.25rem;
    }

    .filter-form .row {
        flex-direction: column;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Refresh button animation
    const refreshBtn = document.getElementById('refreshBtn');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function() {
            this.style.transform = 'rotate(180deg)';
            setTimeout(() => {
                window.location.reload();
            }, 300);
        });
    }

    // Add staggered animation to table rows
    const tableRows = document.querySelectorAll('.table-row');
    tableRows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.05}s`;
    });

    // Improved delete functionality dengan SweetAlert
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;

            Swal.fire({
                title: 'Hapus Pengaduan?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading state
                    const deleteBtn = form.querySelector('.btn-delete');
                    const originalHTML = deleteBtn.innerHTML;
                    deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    deleteBtn.disabled = true;

                    // Submit form
                    form.submit();
                }
            });
        });
    });

    // Fallback untuk browser yang tidak support SweetAlert
    if (typeof Swal === 'undefined') {
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Hapus pengaduan ini? Data yang dihapus tidak dapat dikembalikan.')) {
                    e.preventDefault();
                } else {
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    this.disabled = true;
                }
            });
        });
    }

    // Auto submit form when filter changes (optional)
    const filterSelects = document.querySelectorAll('select[name="status"], select[name="jenis_pengaduan"]');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
});
</script>

<!-- Tambahkan SweetAlert2 CDN di head atau sebelum script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
