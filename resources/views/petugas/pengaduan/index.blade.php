@extends('layouts.petugas')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Ambil Pengaduan</h1>
        <div class="page-actions">
            <span class="text-muted">
                <i class="fas fa-hand-paper me-2"></i>
                Daftar Pengaduan Tersedia
            </span>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="table-container mb-4">
        <div class="table-header">
            <h3 class="table-title">Cari & Filter Pengaduan</h3>
        </div>
        <div class="p-3">
            <div class="row g-3">
                <div class="col-md-8">
                    <div class="search-container position-relative">
                        <input type="text" id="searchInput" class="search-input" placeholder="Cari pengaduan...">
                        <i class="fas fa-search search-icon"></i>
                        <button class="search-clear" id="clearSearch">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <select id="statusFilter" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="Disetujui">Disetujui</option>
                        <option value="Diajukan">Diajukan</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengaduan List -->
    <div class="table-container">
        <div class="table-header">
            <h3 class="table-title">Daftar Pengaduan Tersedia</h3>
            <div class="table-actions">
                <button class="btn btn-outline" id="refreshBtn">
                    <i class="fas fa-sync-alt me-2"></i>Refresh
                </button>
                <span class="text-muted small" id="resultCount">
                    {{ $pengaduan->count() }} pengaduan ditemukan
                </span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover" id="pengaduanTable">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Informasi Pengaduan</th>
                        <th width="120">Pelapor</th>
                        <th width="150">Lokasi</th>
                        <th width="120">Tanggal</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaduan as $key => $p)
                    <tr class="pengaduan-row" data-search="{{ strtolower($p->nama_pengaduan . ' ' . $p->lokasi . ' ' . $p->user->nama_pengguna) }}" data-status="{{ $p->status }}">
                        <td>
                            <div class="number-badge">{{ $key + 1 }}</div>
                        </td>
                        <td>
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    @if($p->foto)
                                        <img src="{{ asset('storage/' . $p->foto) }}" alt="Foto Pengaduan"
                                             class="pengaduan-image rounded"
                                             onerror="this.style.display='none'">
                                    @endif
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="pengaduan-title mb-1">{{ $p->nama_pengaduan }}</h6>
                                    <p class="pengaduan-desc mb-1">{{ Str::limit($p->deskripsi, 80) }}</p>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="status-badge status-{{ strtolower($p->status) }}">
                                            <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                                            {{ $p->status }}
                                        </span>
                                        <small class="text-muted">
                                            <i class="far fa-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($p->tgl_pengajuan)->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="user-info-small">
                                <div class="user-avatar-sm">
                                    {{ strtoupper(substr($p->user->nama_pengguna, 0, 2)) }}
                                </div>
                                <span class="user-name-sm">{{ $p->user->nama_pengguna }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="location-info">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                <span>{{ Str::limit($p->lokasi, 25) }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="date-info">
                                <div class="date-day">{{ \Carbon\Carbon::parse($p->tgl_pengajuan)->format('d M') }}</div>
                                <div class="date-year text-muted">{{ \Carbon\Carbon::parse($p->tgl_pengajuan)->format('Y') }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('petugas.pengaduan.show', $p->id_pengaduan) }}"
                                   class="btn-action btn-detail"
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('petugas.pengaduan.take', $p->id_pengaduan) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="btn-action btn-take"
                                            title="Ambil Pengaduan"
                                            onclick="return confirm('Apakah Anda yakin ingin mengambil pengaduan ini?')">
                                        <i class="fas fa-hand-paper"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state text-center py-5">
                                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">Tidak ada pengaduan tersedia</h5>
                                <p class="text-muted mb-0">Semua pengaduan telah ditangani atau sedang diproses</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Search Styles */
    .search-container {
        width: 100%;
    }

    .search-input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border: 2px solid var(--neutral);
        border-radius: var(--radius-md);
        background-color: var(--white);
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(49, 50, 111, 0.1);
        transform: translateY(-2px);
    }

    .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-light);
        transition: color 0.3s ease;
    }

    .search-input:focus + .search-icon {
        color: var(--primary);
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
        transition: all 0.3s ease;
        padding: 0.25rem;
        border-radius: 50%;
    }

    .search-clear:hover {
        background-color: var(--neutral);
        color: var(--text-dark);
    }

    .search-input:not(:placeholder-shown) + .search-icon + .search-clear {
        opacity: 1;
    }

    /* Table Styles */
    .number-badge {
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
        margin: 0 auto;
    }

    .pengaduan-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border: 2px solid var(--neutral);
        transition: all 0.3s ease;
    }

    .pengaduan-row:hover .pengaduan-image {
        border-color: var(--primary);
        transform: scale(1.05);
    }

    .pengaduan-title {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.9rem;
        line-height: 1.3;
        margin-bottom: 0.25rem;
    }

    .pengaduan-desc {
        font-size: 0.8rem;
        color: var(--text-light);
        line-height: 1.4;
        margin-bottom: 0.5rem;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
    }

    .status-disetujui {
        background-color: rgba(99, 122, 185, 0.1);
        color: var(--primary);
        border: 1px solid rgba(99, 122, 185, 0.2);
    }

    .status-diajukan {
        background-color: rgba(255, 193, 7, 0.1);
        color: #b45309;
        border: 1px solid rgba(255, 193, 7, 0.2);
    }

    .user-info-small {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    .user-avatar-sm {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .user-name-sm {
        font-size: 0.8rem;
        font-weight: 500;
        text-align: center;
        line-height: 1.2;
    }

    .location-info {
        display: flex;
        align-items: center;
        font-size: 0.8rem;
        color: var(--text-dark);
    }

    .date-info {
        text-align: center;
    }

    .date-day {
        font-weight: 600;
        color: var(--primary);
        font-size: 0.9rem;
    }

    .date-year {
        font-size: 0.75rem;
    }

    /* Action Buttons */
    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 0.875rem;
    }

    .btn-detail {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    .btn-detail:hover {
        transform: translateY(-2px) scale(1.1);
        box-shadow: 0 4px 12px rgba(49, 50, 111, 0.3);
    }

    .btn-take {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .btn-take:hover {
        transform: translateY(-2px) scale(1.1);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    /* Empty State */
    .empty-state {
        padding: 3rem 1rem;
    }

    /* Animation */
    .pengaduan-row {
        animation: slideInUp 0.5s ease;
        animation-fill-mode: both;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Stagger animation for rows */
    .pengaduan-row:nth-child(1) { animation-delay: 0.1s; }
    .pengaduan-row:nth-child(2) { animation-delay: 0.2s; }
    .pengaduan-row:nth-child(3) { animation-delay: 0.3s; }
    .pengaduan-row:nth-child(4) { animation-delay: 0.4s; }
    .pengaduan-row:nth-child(5) { animation-delay: 0.5s; }

    /* Responsive */
    @media (max-width: 768px) {
        .pengaduan-title {
            font-size: 0.8rem;
        }

        .pengaduan-desc {
            font-size: 0.75rem;
        }

        .location-info, .user-name-sm {
            font-size: 0.75rem;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            font-size: 0.75rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const clearSearch = document.getElementById('clearSearch');
        const refreshBtn = document.getElementById('refreshBtn');
        const resultCount = document.getElementById('resultCount');
        const pengaduanRows = document.querySelectorAll('.pengaduan-row');

        // Search functionality
        function filterPengaduan() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value.toLowerCase();
            let visibleCount = 0;

            pengaduanRows.forEach(row => {
                const searchData = row.getAttribute('data-search');
                const rowStatus = row.getAttribute('data-status').toLowerCase();

                const matchesSearch = searchData.includes(searchTerm);
                const matchesStatus = statusValue === '' || rowStatus === statusValue;

                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                    visibleCount++;
                    // Add animation
                    row.style.animation = 'slideInUp 0.3s ease';
                } else {
                    row.style.display = 'none';
                }
            });

            // Update result count
            resultCount.textContent = `${visibleCount} pengaduan ditemukan`;

            // Show empty state if no results
            const tbody = document.querySelector('#pengaduanTable tbody');
            const emptyRow = tbody.querySelector('tr:last-child');
            if (visibleCount === 0 && emptyRow.cells.length === 1) {
                emptyRow.style.display = '';
            } else if (emptyRow.cells.length === 1) {
                emptyRow.style.display = 'none';
            }
        }

        // Event listeners
        searchInput.addEventListener('input', filterPengaduan);
        statusFilter.addEventListener('change', filterPengaduan);

        clearSearch.addEventListener('click', function() {
            searchInput.value = '';
            searchInput.focus();
            filterPengaduan();
        });

        refreshBtn.addEventListener('click', function() {
            // Add loading animation
            refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
            refreshBtn.disabled = true;

            setTimeout(() => {
                window.location.reload();
            }, 1000);
        });

        // Add hover effects to rows
        pengaduanRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
                this.style.backgroundColor = 'var(--bg-light)';
            });

            row.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
                this.style.backgroundColor = '';
            });
        });

        // Initialize
        filterPengaduan();
    });
</script>
@endsection
