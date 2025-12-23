@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Detail Item</h1>
            <p class="text-muted mb-0">Informasi lengkap sarana prasarana</p>
        </div>
        <div>
            <a href="{{ route('admin.items.edit', $item->id_item) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary ms-2">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Alert Section -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Left Column - Foto dan Info Utama -->
        <div class="col-md-4">
            <!-- Foto Item -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light py-3">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-image me-2 text-primary"></i>
                        Foto Item
                    </h6>
                </div>
                <div class="card-body text-center p-4">
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}"
                             class="img-fluid rounded-3 shadow-sm"
                             alt="{{ $item->nama_item }}"
                             style="max-height: 300px; width: auto;">
                    @else
                        <div class="text-muted py-5">
                            <i class="fas fa-image fa-4x mb-3"></i>
                            <p class="mb-0">Tidak ada foto</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Informasi Item -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light py-3">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Informasi Item
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%"><strong>ID Item</strong></td>
                            <td>{{ $item->id_item }}</td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat</strong></td>
                            <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diupdate</strong></td>
                            <td>{{ $item->updated_at->format('d M Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column - Detail Item -->
        <div class="col-md-8">
            <!-- Detail Item -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light py-3">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-cube me-2 text-primary"></i>
                        Detail Item
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Nama Item -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">Nama Item</label>
                        <div class="p-3 bg-light rounded-3">
                            <h5 class="mb-0 text-dark">{{ $item->nama_item }}</h5>
                        </div>
                    </div>

                    <!-- Lokasi -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">Lokasi</label>
                        <div class="p-3 bg-light rounded-3">
                            @if($item->lokasis->count() > 0)
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($item->lokasis as $lokasi)
                                        <span class="badge bg-primary px-3 py-2">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            {{ $lokasi->nama_lokasi }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    Belum ada lokasi ditentukan
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">Deskripsi</label>
                        <div class="p-3 bg-light rounded-3">
                            @if($item->deskripsi)
                                <p class="mb-0 text-dark" style="line-height: 1.6; white-space: pre-line;">{{ $item->deskripsi }}</p>
                            @else
                                <span class="text-muted">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    Tidak ada deskripsi
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Pengaduan (jika ada) -->
            @if($item->pengaduan && $item->pengaduan->count() > 0)
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light py-3">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-history me-2 text-primary"></i>
                        Riwayat Pengaduan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Deskripsi Masalah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($item->pengaduan as $pengaduan)
                                <tr>
                                    <td>{{ $pengaduan->created_at->format('d M Y') }}</td>
                                    <td>{{ Str::limit($pengaduan->deskripsi_masalah, 50) }}</td>
                                    <td>
                                        @if($pengaduan->status_pengaduan == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($pengaduan->status_pengaduan == 'diproses')
                                            <span class="badge bg-info">Diproses</span>
                                        @elseif($pengaduan->status_pengaduan == 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $pengaduan->status_pengaduan }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex gap-2 justify-content-end border-top pt-4">
                <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                </a>
                <a href="{{ route('admin.items.edit', $item->id_item) }}" class="btn btn-warning px-4">
                    <i class="fas fa-edit me-2"></i>Edit Item
                </a>
                <form action="{{ route('admin.items.destroy', $item->id_item) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fas fa-trash me-2"></i>Hapus Item
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.card {
    border-radius: 12px;
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,.125);
    border-radius: 12px 12px 0 0 !important;
}

.badge {
    font-size: 0.85rem;
    padding: 0.5rem 1rem;
}

.table-borderless td {
    border: none !important;
    padding: 0.5rem 0;
}

.bg-light {
    background-color: #f8f9fa !important;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}
</style>
@endsection
