@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Detail Laporan Pengaduan</h1>
            <p class="text-muted mb-0">Informasi lengkap pengaduan #{{ $pengaduan->id_pengaduan }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.laporan') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Laporan
            </a>
            <a href="{{ route('admin.laporan.pdfSingle', $pengaduan->id_pengaduan) }}" class="btn btn-danger">
                <i class="fas fa-file-pdf me-2"></i>Download PDF
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Informasi Pengaduan -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Informasi Pengaduan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">ID Pengaduan</th>
                                    <td>#{{ $pengaduan->id_pengaduan }}</td>
                                </tr>
                                <tr>
                                    <th>Judul Pengaduan</th>
                                    <td class="fw-semibold">{{ $pengaduan->nama_pengaduan }}</td>
                                </tr>
                                <tr>
                                    <th>User</th>
                                    <td>{{ $pengaduan->user->nama_pengguna }}</td>
                                </tr>
                                <tr>
                                    <th>Lokasi</th>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                        {{ $pengaduan->lokasi }}
                                    </td>
                                </tr>
                                @if($pengaduan->petugas)
                                <tr>
                                    <th>Petugas</th>
                                    <td>{{ $pengaduan->petugas->nama }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Status</th>
                                    <td>
                                        <span class="badge
                                            @if($pengaduan->status == 'Diajukan') bg-warning
                                            @elseif($pengaduan->status == 'Disetujui') bg-primary
                                            @elseif($pengaduan->status == 'Diproses') bg-info
                                            @elseif($pengaduan->status == 'Selesai') bg-success
                                            @elseif($pengaduan->status == 'Ditolak') bg-danger
                                            @else bg-secondary @endif">
                                            {{ $pengaduan->status }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <td>{{ \Carbon\Carbon::parse($pengaduan->tgl_pengajuan)->format('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Selesai</th>
                                    <td>
                                        @if($pengaduan->tgl_selesai)
                                            {{ \Carbon\Carbon::parse($pengaduan->tgl_selesai)->format('d F Y H:i') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>ID Item</th>
                                    <td>
                                        @if($pengaduan->id_item)
                                            #{{ $pengaduan->id_item }}
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mt-4">
                        <h6 class="fw-semibold mb-3">Deskripsi Pengaduan</h6>
                        <div class="border rounded p-4 bg-light">
                            {!! nl2br(e($pengaduan->deskripsi ?? 'Tidak ada deskripsi')) !!}
                        </div>
                    </div>

                    <!-- Saran Petugas -->
                    @if($pengaduan->saran_petugas)
                    <div class="mt-4">
                        <h6 class="fw-semibold mb-3">Saran / Tindakan Petugas</h6>
                        <div class="border rounded p-4 bg-warning bg-opacity-10">
                            {!! nl2br(e($pengaduan->saran_petugas)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- ✅ BAGIAN BARU: Hasil Perbaikan -->
                    @if($pengaduan->status == 'Selesai' && $pengaduan->foto_selesai)
                    <div class="mt-4">
                        <h6 class="fw-semibold mb-3 text-success">
                            <i class="fas fa-check-circle me-2"></i>Hasil Perbaikan
                        </h6>
                        <div class="border border-success rounded p-4 bg-success bg-opacity-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Foto Hasil Perbaikan:</strong>
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $pengaduan->foto_selesai) }}"
                                             alt="Foto Hasil Perbaikan"
                                             class="img-fluid rounded border"
                                             style="max-height: 200px;">
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $pengaduan->foto_selesai) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-external-link-alt me-1"></i>Buka Gambar
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <strong>Timeline:</strong>
                                    <div class="mt-2">
                                        <div class="d-flex justify-content-between small text-muted mb-1">
                                            <span>Pengajuan</span>
                                            <span>{{ \Carbon\Carbon::parse($pengaduan->tgl_pengajuan)->format('d M Y') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between small text-success mb-1">
                                            <span>Selesai</span>
                                            <span>{{ \Carbon\Carbon::parse($pengaduan->tgl_selesai)->format('d M Y') }}</span>
                                        </div>
                                        <div class="progress mt-2" style="height: 6px;">
                                            <div class="progress-bar bg-success" style="width: 100%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Informasi -->
        <div class="col-md-4">
            <!-- Foto Pengaduan Awal -->
            @if($pengaduan->foto)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-camera me-2 text-primary"></i>
                        Foto Kondisi Awal
                    </h5>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('storage/' . $pengaduan->foto) }}"
                         alt="Foto Pengaduan"
                         class="img-fluid rounded border"
                         style="max-height: 300px;"
                         onerror="this.src='https://via.placeholder.com/400x300?text=Gambar+Tidak+Tersedia'">
                    <div class="mt-3">
                        <a href="{{ asset('storage/' . $pengaduan->foto) }}"
                           target="_blank"
                           class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-external-link-alt me-1"></i>Buka Gambar
                        </a>
                    </div>
                </div>
            </div>
            @endif


            
            <!-- Informasi Tambahan -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list-alt me-2 text-primary"></i>
                        Informasi Tambahan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Prioritas:</strong><br>
                        <span class="badge
                            @if($pengaduan->prioritas == 'tinggi') bg-danger
                            @elseif($pengaduan->prioritas == 'sedang') bg-warning
                            @elseif($pengaduan->prioritas == 'rendah') bg-success
                            @else bg-secondary @endif">
                            {{ $pengaduan->prioritas ?? 'normal' }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <strong>Kategori:</strong><br>
                        <span class="text-muted">{{ $pengaduan->kategori ?? 'Umum' }}</span>
                    </div>

                    <!-- ✅ BAGIAN BARU: Status Penyelesaian -->
                    @if($pengaduan->status == 'Selesai')
                    <div class="mb-3">
                        <strong>Status Penyelesaian:</strong><br>
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>Tuntas
                        </span>
                    </div>
                    <div class="mb-3">
                        <strong>Durasi Perbaikan:</strong><br>
                        <span class="text-muted">
                            @if($pengaduan->tgl_selesai)
                                {{ \Carbon\Carbon::parse($pengaduan->tgl_pengajuan)->diffInDays($pengaduan->tgl_selesai) }} hari
                            @else
                                -
                            @endif
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 12px;
    border: 1px solid #E2E8F0;
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
}

.table-borderless td, .table-borderless th {
    border: none;
    padding: 8px 0;
}

.badge {
    font-size: 0.8rem;
    padding: 0.5rem 0.75rem;
}

.progress {
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
}
</style>
@endsection
