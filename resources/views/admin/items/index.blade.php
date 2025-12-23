{{-- resources/views/admin/items/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="dashboard-container">
    <!-- HEADER -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-building me-2"></i>
                Manajemen Sarana Prasarana
            </h1>
            <p class="page-subtitle">Kelola semua lokasi dan item fasilitas sekolah</p>
        </div>
        <div class="header-stats">
            <div class="stat-item">
                <div class="stat-number">{{ $totalLokasi }}</div>
                <div class="stat-label">Total Lokasi</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $totalItems }}</div>
                <div class="stat-label">Total Item</div>
            </div>
        </div>
    </div>

    <!-- ALERTS -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- QUICK ACTIONS & SEARCH -->
    <div class="content-card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-search me-2"></i>
                Pencarian Global
            </h3>
        </div>
        <div class="card-body">
            <div class="row align-items-end">
                <div class="col-md-8">
                    <div class="form-group mb-0">
                        <label class="form-label">Cari lokasi atau item</label>
                        <div class="search-container-custom">
                            <i class="fas fa-search search-icon-custom"></i>
                            <input type="text" class="search-input-custom" placeholder="Ketik nama lokasi atau item..." id="globalSearch">
                            <button class="search-clear-custom" id="clearGlobalSearch">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label class="form-label">&nbsp;</label>
                        <a href="{{ route('admin.items.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-plus me-2"></i>Tambah Sarpras
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- GANTI bagian modal edit lokasi dengan ini: -->

<!-- SECTION DAFTAR LOKASI -->
<div class="content-card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-location-dot me-2"></i>
            Daftar Lokasi
            <span class="badge bg-primary ms-2">{{ $lokasis->count() }}</span>
        </h3>
    </div>

    <div class="card-body">
        @if($lokasis->count() > 0)
            <div class="locations-grid" id="lokasiGrid">
                @foreach($lokasis as $lokasi)
                <div class="location-card" data-search="{{ strtolower($lokasi->nama_lokasi) }}">
                    <div class="location-content">
                        <div class="location-info">
                            <h4 class="location-title">{{ $lokasi->nama_lokasi }}</h4>
                            <span class="location-badge">{{ $lokasi->items_count }} item</span>
                        </div>
                        <div class="location-actions">
                            <button type="button" class="btn-action btn-edit" title="Edit Lokasi"
                                    onclick="openEditLokasi({{ $lokasi->id_lokasi }}, '{{ $lokasi->nama_lokasi }}')">
                                <i class="fas fa-edit"></i>
                            </button>

                            <form action="{{ route('admin.items.lokasi.destroy', $lokasi->id_lokasi) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus Lokasi"
                                        onclick="return confirm('Hapus lokasi {{ $lokasi->nama_lokasi }}?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3 class="empty-title">Belum Ada Lokasi</h3>
                <p class="empty-description">Gunakan form di atas untuk menambahkan lokasi pertama.</p>
            </div>
        @endif
    </div>
</div>

<!-- SINGLE EDIT LOKASI OFFCANVAS -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="editLokasiOffcanvas" aria-labelledby="editLokasiOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="editLokasiOffcanvasLabel">Edit Lokasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="editLokasiForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_nama_lokasi" class="form-label">Nama Lokasi</label>
                <input type="text" class="form-control" id="edit_nama_lokasi" name="nama_lokasi" required>
            </div>
        </form>
    </div>
    <div class="offcanvas-footer p-3 border-top">
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Batal</button>
            <button type="submit" form="editLokasiForm" class="btn btn-primary flex-fill">
                <i class="fas fa-save me-1"></i> Simpan Perubahan
            </button>
        </div>
    </div>
</div>

<script>
function openEditLokasi(lokasiId, currentNama) {
    // Set form action - SESUAIKAN DENGAN RUTE
    const form = document.getElementById('editLokasiForm');
    form.action = `/admin/items/lokasi/${lokasiId}/update`;

    // Set current value
    document.getElementById('edit_nama_lokasi').value = currentNama;

    // Show offcanvas
    const offcanvas = new bootstrap.Offcanvas(document.getElementById('editLokasiOffcanvas'));
    offcanvas.show();
}
</script>

    <!-- SECTION ITEMS -->
    <div class="content-card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-boxes me-2"></i>
                Daftar Item Sarana Prasarana
                <span class="badge bg-primary ms-2">{{ $items->total() }}</span>
            </h3>
        </div>

        <div class="card-body">
            @if($items->count() > 0)
                <div class="table-container">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th width="60" class="text-center">#</th>
                                <th width="250">Nama Item</th>
                                <th width="200">Lokasi</th>
                                <th width="300">Deskripsi</th>
                                <th width="100" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="itemsTableBody">
                            @foreach($items as $item)
                            <tr class="table-row animate-in" data-search="{{ strtolower($item->nama_item . ' ' . $item->lokasis->pluck('nama_lokasi')->implode(' ')) }}">
                                <td class="text-center serial-number">
                                    <span class="number">{{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}</span>
                                </td>
                                <td class="item-info">
                                    <div class="item-title">{{ $item->nama_item }}</div>
                                    <div class="item-meta">ID: #{{ $item->id_item }}</div>
                                </td>
                                <td class="location-info">
                                    <div class="location-badges">
                                        @php
                                            $maxVisible = 2; // Maksimal tampil 2 lokasi
                                            $totalLokasi = $item->lokasis->count();
                                            $visibleLokasi = $item->lokasis->take($maxVisible);
                                            $hiddenCount = $totalLokasi - $maxVisible;
                                        @endphp

                                        @foreach($visibleLokasi as $lokasi)
                                            <span class="location-badge">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                {{ $lokasi->nama_lokasi }}
                                            </span>
                                        @endforeach

                                        @if($hiddenCount > 0)
                                            <span class="location-badge location-more"
                                                  title="{{ $item->lokasis->slice($maxVisible)->pluck('nama_lokasi')->implode(', ') }}">
                                                +{{ $hiddenCount }} lainnya
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="description-info">
                                    <div class="description-text">{{ Str::limit($item->deskripsi, 80) }}</div>
                                    @if(strlen($item->deskripsi) > 80)
                                        <div class="text-muted small mt-1">...selengkapnya di detail</div>
                                    @endif
                                </td>
                                <td class="action-cell">
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.items.show', $item->id_item) }}"
                                           class="btn-action btn-view"
                                           title="Lihat Detail"
                                           data-tooltip="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.items.edit', $item->id_item) }}"
                                           class="btn-action btn-edit"
                                           title="Edit Item"
                                           data-tooltip="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.items.destroy', $item->id_item) }}"
                                              method="POST"
                                              class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn-action btn-delete"
                                                    title="Hapus Item"
                                                    data-tooltip="Hapus"
                                                    onclick="return confirm('Hapus item ini?')">
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

                <!-- GANTI bagian pagination dengan ini: -->
<!-- PAGINATION MANUAL -->
<div class="pagination-container">
    <div class="pagination-info">
        Menampilkan <strong>{{ $items->firstItem() }} - {{ $items->lastItem() }}</strong>
        dari <strong>{{ $items->total() }}</strong> item
    </div>
    <div class="pagination-links">
        @if ($items->hasPages())
        <div class="pagination-custom">
            {{-- Previous Page Link --}}
            @if ($items->onFirstPage())
                <span class="page-link disabled">
                    <i class="fas fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $items->previousPageUrl() }}" class="page-link">
                    <i class="fas fa-chevron-left"></i>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @php
                $current = $items->currentPage();
                $last = $items->lastPage();
                $start = max(1, $current - 1);
                $end = min($last, $current + 1);
            @endphp

            {{-- First Page Link --}}
            @if ($start > 1)
                <a href="{{ $items->url(1) }}" class="page-link">1</a>
                @if ($start > 2)
                    <span class="page-link dots">...</span>
                @endif
            @endif

            {{-- Page Number Links --}}
            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $current)
                    <span class="page-link active">{{ $i }}</span>
                @else
                    <a href="{{ $items->url($i) }}" class="page-link">{{ $i }}</a>
                @endif
            @endfor

            {{-- Last Page Link --}}
            @if ($end < $last)
                @if ($end < $last - 1)
                    <span class="page-link dots">...</span>
                @endif
                <a href="{{ $items->url($last) }}" class="page-link">{{ $last }}</a>
            @endif

            {{-- Next Page Link --}}
            @if ($items->hasMorePages())
                <a href="{{ $items->nextPageUrl() }}" class="page-link">
                    <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="page-link disabled">
                    <i class="fas fa-chevron-right"></i>
                </span>
            @endif
        </div>
        @endif
    </div>
</div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3 class="empty-title">Belum Ada Sarana Prasarana</h3>
                    <p class="empty-description">Mulai dengan menambahkan item pertama Anda.</p>
                    <a href="{{ route('admin.items.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Tambah Item Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* VARIABLES */
:root {
    --primary: #31326F;
    --secondary: #637AB9;
    --light-gray: #D9D9D9;
    --background: #EFF2F8;
    --white: #FFFFFF;
    --dark: #1E293B;
    --gray: #64748B;
    --border: #E2E8F0;
    --shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 4px 6px rgba(0, 0, 0, 0.05);
}

/* DASHBOARD LAYOUT */
.dashboard-container {
    padding: 0;
    background: var(--background);
    min-height: 100vh;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    padding: 2rem;
    background: var(--white);
    border-radius: 12px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
}

.header-content .page-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    color: var(--dark);
}

.header-content .page-subtitle {
    margin: 0;
    font-size: 0.9rem;
    color: var(--gray);
}

.header-stats {
    display: flex;
    gap: 1rem;
}

.stat-item {
    text-align: center;
    padding: 1rem 1.5rem;
}

.stat-number {
    font-size: 1.75rem;
    font-weight: 700;
    line-height: 1;
    color: var(--primary);
}

.stat-label {
    font-size: 0.8rem;
    margin-top: 0.25rem;
    color: var(--gray);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* CONTENT CARD */
.content-card {
    background: var(--white);
    border-radius: 12px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    margin-bottom: 1.5rem;
    transition: box-shadow 0.2s ease;
}

.content-card:hover {
    box-shadow: var(--shadow-lg);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 1.5rem 1rem;
    border-bottom: 1px solid var(--border);
}

.card-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--dark);
    margin: 0;
    display: flex;
    align-items: center;
}

.card-title i {
    color: var(--primary);
}

.card-body {
    padding: 1.5rem;
}

/* SEARCH & FORM STYLES */
.search-container-custom {
    position: relative;
    width: 100%;
}

.search-input-custom {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border: 1px solid var(--light-gray);
    border-radius: 8px;
    background: var(--white);
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

.search-input-custom:focus {
    outline: none;
    border-color: var(--secondary);
    box-shadow: 0 0 0 3px rgba(99, 122, 185, 0.1);
}

.search-icon-custom {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray);
    font-size: 0.9rem;
}

.search-clear-custom {
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--gray);
    cursor: pointer;
    opacity: 0;
    display: none;
    padding: 0.25rem;
    border-radius: 4px;
}

.search-input-custom:not(:placeholder-shown) + .search-icon-custom + .search-clear-custom {
    opacity: 1;
    display: block;
}

.search-clear-custom:hover {
    color: var(--secondary);
    background: var(--background);
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--dark);
    font-size: 0.9rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--light-gray);
    border-radius: 8px;
    background: var(--white);
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--secondary);
    box-shadow: 0 0 0 3px rgba(99, 122, 185, 0.1);
}

/* BUTTONS */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    cursor: pointer;
    font-size: 0.9rem;
}

.btn-primary {
    background: var(--primary);
    color: var(--white);
}

.btn-primary:hover {
    background: #25255a;
    transform: translateY(-1px);
}

.btn-secondary {
    background: var(--light-gray);
    color: var(--dark);
}

.btn-secondary:hover {
    background: #c8c8c8;
}

/* LOCATIONS GRID */
.locations-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1rem;
}

.location-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 1.25rem;
    transition: all 0.2s ease;
}

.location-card:hover {
    border-color: var(--secondary);
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.location-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.location-info {
    flex: 1;
}

.location-title {
    margin: 0 0 0.5rem 0;
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark);
    line-height: 1.3;
}

.location-badge {
    background: var(--background);
    color: var(--primary);
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.location-actions {
    display: flex;
    gap: 0.5rem;
}

/* ACTION BUTTONS */
.btn-action {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    cursor: pointer;
    font-size: 0.8rem;
}

.btn-view {
    background: var(--secondary);
    color: var(--white);
}

.btn-view:hover {
    background: #5268a1;
    transform: translateY(-1px);
}

.btn-edit {
    background: var(--primary);
    color: var(--white);
}

.btn-edit:hover {
    background: #25255a;
    transform: translateY(-1px);
}

.btn-delete {
    background: #dc3545;
    color: var(--white);
}

.btn-delete:hover {
    background: #c82333;
    transform: translateY(-1px);
}

/* MODERN TABLE */
.table-container {
    overflow-x: auto;
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
    background: var(--white);
}

.modern-table th {
    background: var(--background);
    padding: 1rem 0.75rem;
    font-weight: 600;
    font-size: 0.8rem;
    color: var(--gray);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid var(--border);
    text-align: left;
}

.modern-table td {
    padding: 1rem 0.75rem;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
}

.table-row {
    transition: all 0.2s ease;
}

.table-row:hover {
    background: var(--background);
}

/* SERIAL NUMBER */
.serial-number {
    text-align: center;
}

.number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    background: var(--background);
    border-radius: 6px;
    font-weight: 600;
    color: var(--primary);
    font-size: 0.8rem;
}

/* ITEM INFO */
.item-info {
    min-width: 200px;
}

.item-title {
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.25rem;
    line-height: 1.3;
}

.item-meta {
    font-size: 0.75rem;
    color: var(--gray);
}

/* LOCATION INFO - DIPERBAIKI */
.location-badges {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    max-height: 80px;
    overflow: hidden;
}

.location-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.5rem;
    background: rgba(99, 122, 185, 0.1);
    color: var(--primary);
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 500;
    white-space: nowrap;
    max-width: 180px;
    overflow: hidden;
    text-overflow: ellipsis;
}

.location-badge i {
    font-size: 0.6rem;
    margin-right: 0.25rem;
    flex-shrink: 0;
}

/* Style khusus untuk badge "lebih banyak" */
.location-more {
    background: rgba(49, 50, 111, 0.15) !important;
    color: var(--primary) !important;
    font-style: italic;
    cursor: help;
}

.location-more:hover {
    background: rgba(49, 50, 111, 0.25) !important;
}

/* DESCRIPTION INFO */
.description-text {
    color: var(--dark);
    line-height: 1.4;
    font-size: 0.85rem;
}

/* ACTION CELL */
.action-cell {
    text-align: center;
}

.action-buttons {
    display: flex;
    gap: 0.25rem;
    justify-content: center;
    align-items: center;
}

/* PAGINATION MANUAL - UKURAN KECIL */
.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0 0;
    border-top: 1px solid var(--border);
    margin-top: 1.5rem;
}

.pagination-info {
    font-size: 0.75rem;
    color: var(--gray);
}

.pagination-custom {
    display: flex;
    gap: 0.25rem;
    align-items: center;
}

.page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 28px;
    height: 28px;
    padding: 0 0.5rem;
    border: 1px solid var(--border);
    border-radius: 4px;
    background: var(--white);
    color: var(--primary);
    text-decoration: none;
    font-size: 0.75rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.page-link:hover {
    background: var(--background);
    border-color: var(--secondary);
}

.page-link.active {
    background: var(--primary);
    border-color: var(--primary);
    color: var(--white);
}

.page-link.disabled {
    background: var(--background);
    color: var(--light-gray);
    cursor: not-allowed;
}

.page-link.dots {
    background: transparent;
    border: none;
    color: var(--gray);
    cursor: default;
}

/* EMPTY STATE */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
}

.empty-icon {
    font-size: 3rem;
    color: var(--light-gray);
    margin-bottom: 1rem;
}

.empty-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.empty-description {
    color: var(--gray);
    font-size: 0.9rem;
    margin: 0;
}

/* ALERTS */
.alert {
    border-radius: 8px;
    border: none;
    box-shadow: var(--shadow);
    margin-bottom: 1.5rem;
}

.alert i {
    font-size: 1rem;
}

/* BADGES */
.badge {
    padding: 0.35rem 0.65rem;
    border-radius: 6px;
    font-weight: 500;
    font-size: 0.75rem;
}

.bg-primary {
    background: var(--primary) !important;
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
    animation: slideIn 0.3s ease forwards;
}

/* TOOLTIPS */
.btn-action[data-tooltip] {
    position: relative;
}

.btn-action[data-tooltip]:hover::after {
    content: attr(data-tooltip);
    position: absolute;
    bottom: -30px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--dark);
    color: white;
    padding: 0.5rem 0.75rem;
    border-radius: 4px;
    font-size: 0.7rem;
    white-space: nowrap;
    z-index: 1000;
    pointer-events: none;
}

/* Tambahkan ke bagian CSS yang sudah ada */
.no-results-message {
    grid-column: 1 / -1;
    text-align: center;
    padding: 2rem;
    color: #64748B;
}

.no-results-message i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    opacity: 0.5;
}

.no-results-message h5 {
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
}

.no-results-message p {
    font-size: 0.9rem;
    margin: 0;
}

/* RESPONSIVE DESIGN */
@media (max-width: 768px) {
    .dashboard-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
        padding: 1.5rem;
    }

    .header-stats {
        justify-content: center;
    }

    .card-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .locations-grid {
        grid-template-columns: 1fr;
    }

    .location-content {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .location-actions {
        justify-content: center;
    }

    .pagination-container {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .modern-table {
        font-size: 0.8rem;
        min-width: 600px;
    }

    .action-buttons {
        flex-direction: column;
        gap: 0.25rem;
    }

    .location-badges {
        max-height: 60px;
    }

    .location-badge {
        max-width: 150px;
        font-size: 0.65rem;
    }
}

@media (max-width: 576px) {
    .dashboard-header {
        padding: 1.25rem;
    }

    .card-body {
        padding: 1rem;
    }

    .stat-item {
        padding: 0.75rem 1rem;
    }

    .stat-number {
        font-size: 1.5rem;
    }

    .pagination-container {
        padding: 1rem 0 0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // GLOBAL SEARCH FUNCTIONALITY
    const globalSearch = document.getElementById('globalSearch');
    const clearGlobalSearch = document.getElementById('clearGlobalSearch');
    const itemsTableBody = document.getElementById('itemsTableBody');
    const lokasiGrid = document.getElementById('lokasiGrid');

    function performGlobalSearch() {
        if (!globalSearch) return;

        const searchTerm = globalSearch.value.toLowerCase().trim();

        // Search in items table
        if (itemsTableBody) {
            const itemRows = itemsTableBody.querySelectorAll('tr.table-row');
            let hasItemResults = false;

            itemRows.forEach(row => {
                const searchData = row.getAttribute('data-search') || '';
                if (searchTerm === '' || searchData.includes(searchTerm)) {
                    row.style.display = '';
                    hasItemResults = true;
                } else {
                    row.style.display = 'none';
                }
            });

            // Show/hide no results message for items
            const existingNoResults = itemsTableBody.querySelector('.no-results-message');
            if (existingNoResults) {
                existingNoResults.remove();
            }

            if (!hasItemResults && searchTerm !== '') {
                const noResultsRow = document.createElement('tr');
                noResultsRow.className = 'no-results-message';
                noResultsRow.innerHTML = `
                    <td colspan="5" class="text-center py-4">
                        <i class="fas fa-search fa-2x text-muted mb-2"></i>
                        <h5 class="text-muted mb-1">Tidak ada item yang cocok</h5>
                        <p class="text-muted mb-0">Coba dengan kata kunci lain</p>
                    </td>
                `;
                itemsTableBody.appendChild(noResultsRow);
            }
        }

        // Search in locations grid
        if (lokasiGrid) {
            const locationCards = lokasiGrid.querySelectorAll('.location-card');
            let hasLocationResults = false;

            locationCards.forEach(card => {
                const searchData = card.getAttribute('data-search') || '';
                if (searchTerm === '' || searchData.includes(searchTerm)) {
                    card.style.display = 'block';
                    hasLocationResults = true;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide no results message for locations
            const existingNoResultsLocation = lokasiGrid.querySelector('.no-results-message');
            if (existingNoResultsLocation) {
                existingNoResultsLocation.remove();
            }

            if (!hasLocationResults && searchTerm !== '') {
                const noResultsDiv = document.createElement('div');
                noResultsDiv.className = 'no-results-message text-center py-4';
                noResultsDiv.innerHTML = `
                    <i class="fas fa-search fa-2x text-muted mb-2"></i>
                    <h5 class="text-muted mb-1">Tidak ada lokasi yang cocok</h5>
                    <p class="text-muted mb-0">Coba dengan kata kunci lain</p>
                `;
                lokasiGrid.appendChild(noResultsDiv);
            }
        }
    }

    // Event listeners
    if (globalSearch) {
        globalSearch.addEventListener('input', performGlobalSearch);

        // Clear search functionality
        if (clearGlobalSearch) {
            clearGlobalSearch.addEventListener('click', function() {
                globalSearch.value = '';
                performGlobalSearch();
                globalSearch.focus();
            });

            // Show/hide clear button based on input
            globalSearch.addEventListener('input', function() {
                clearGlobalSearch.style.display = this.value ? 'block' : 'none';
            });

            // Initialize clear button visibility
            clearGlobalSearch.style.display = globalSearch.value ? 'block' : 'none';
        }

        // Clear search when clicking escape
        globalSearch.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                performGlobalSearch();
                this.blur();
            }
        });

        // Add search icon click to focus
        const searchIcon = document.querySelector('.search-icon-custom');
        if (searchIcon) {
            searchIcon.addEventListener('click', function() {
                globalSearch.focus();
            });
        }
    }

    // Add staggered animation to table rows
    const tableRows = document.querySelectorAll('.table-row');
    tableRows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.05}s`;
    });

    // Add CSS for no-results message
    const style = document.createElement('style');
    style.textContent = `
        .no-results-message {
            grid-column: 1 / -1;
            text-align: center;
            padding: 2rem;
            color: #64748B;
        }
        .no-results-message i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            opacity: 0.5;
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection
