@extends('layouts.admin')

@section('content')
<div class="container-fluid py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">📊 Laporan Pengaduan</h2>
            <p class="text-muted mb-0">Pantau seluruh data pengaduan berdasarkan periode waktu tertentu.</p>
        </div>
    </div>

    <!-- Filter Tanggal -->
    <div class="card border-0 shadow-sm mb-4 rounded-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.laporan') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control rounded-3" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control rounded-3" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary rounded-3 w-100">
                            <i class="fas fa-filter me-2"></i>Filter Laporan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3 bg-primary bg-opacity-10 hover-card">
                <h4 class="fw-bold text-primary mb-1">{{ $statistik['total'] }}</h4>
                <small class="fw-semibold text-secondary">Total Pengaduan</small>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3 bg-warning bg-opacity-10 hover-card">
                <h4 class="fw-bold text-warning mb-1">{{ $statistik['diajukan'] }}</h4>
                <small class="fw-semibold text-secondary">Diajukan</small>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3 bg-info bg-opacity-10 hover-card">
                <h4 class="fw-bold text-info mb-1">{{ $statistik['diproses'] }}</h4>
                <small class="fw-semibold text-secondary">Diproses</small>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3 bg-success bg-opacity-10 hover-card">
                <h4 class="fw-bold text-success mb-1">{{ $statistik['selesai'] }}</h4>
                <small class="fw-semibold text-secondary">Selesai</small>
            </div>
        </div>
    </div>

    <!-- Data Laporan -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-list me-2 text-primary"></i>Data Laporan</h5>
            <div>
                <span class="badge bg-light text-dark me-2">{{ $pengaduan->count() }} data</span>
                @if($pengaduan->count() > 0)
                <a href="{{ route('admin.laporan.pdfAll', request()->query()) }}" class="btn btn-sm btn-danger">
                    <i class="fas fa-file-pdf me-1"></i>Download Semua PDF
                </a>
                @endif
            </div>
        </div>

        <div class="card-body">
            @if($pengaduan->count() > 0)
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">#</th>
                                <th>Judul Pengaduan</th>
                                <th>User</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Tanggal Pengajuan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengaduan as $p)
                            <tr class="align-middle">
                                <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $p->nama_pengaduan }}</td>
                                <td>{{ $p->user->nama_pengguna }}</td>
                                <td><i class="fas fa-map-marker-alt text-primary me-1"></i>{{ $p->lokasi }}</td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2
                                        @if($p->status == 'Diajukan') bg-warning text-dark
                                        @elseif($p->status == 'Disetujui') bg-primary
                                        @elseif($p->status == 'Diproses') bg-info
                                        @elseif($p->status == 'Selesai') bg-success
                                        @elseif($p->status == 'Ditolak') bg-danger
                                        @else bg-secondary @endif">
                                        {{ $p->status }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($p->tgl_pengajuan)->format('d M Y') }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.laporan.show', $p->id_pengaduan) }}"
                                           class="btn btn-outline-primary"
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.laporan.pdfSingle', $p->id_pengaduan) }}"
                                           class="btn btn-outline-danger"
                                           title="Download PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Info Periode -->
                <div class="mt-4 p-3 bg-light rounded-3">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                            </small>
                        </div>
                        <div class="col-md-6 text-end">
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                Data diperbarui: {{ now()->format('d M Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>

            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-box-open fa-3x mb-3 opacity-50"></i>
                    <h5 class="fw-semibold">Tidak ada data pengaduan</h5>
                    <p class="mb-0">Tidak ada data pengaduan dalam periode yang dipilih.</p>
                    <small class="text-muted">
                        Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                    </small>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    @if($pengaduan->count() > 0)
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center">
                    <i class="fas fa-chart-bar fa-2x text-primary mb-3"></i>
                    <h6 class="fw-semibold">Ringkasan Statistik</h6>
                    <div class="row mt-3">
                        <div class="col-6">
                            <div class="border-end">
                                <div class="h5 text-primary mb-1">{{ $statistik['diajukan'] }}</div>
                                <small class="text-muted">Diajukan</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="h5 text-success mb-1">{{ $statistik['selesai'] }}</div>
                            <small class="text-muted">Selesai</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center">
                    <i class="fas fa-download fa-2x text-danger mb-3"></i>
                    <h6 class="fw-semibold">Ekspor Laporan</h6>
                    <p class="text-muted small mb-3">Download laporan dalam format PDF</p>
                    <a href="{{ route('admin.laporan.pdfAll', request()->query()) }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf me-1"></i>Download Semua PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Efek hover & animasi -->
<style>
.hover-card {
    transition: all 0.3s ease;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.1);
}
.table-hover tbody tr:hover {
    background-color: #f8f9fa !important;
    transition: background-color 0.2s ease;
}
.card {
    border-radius: 12px;
    border: 1px solid #E2E8F0;
}
.btn {
    border-radius: 8px;
}
.badge {
    font-size: 0.75rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add loading state to PDF buttons
    const pdfButtons = document.querySelectorAll('a[href*="pdf"]');
    pdfButtons.forEach(button => {
        button.addEventListener('click', function() {
            const originalHTML = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Loading...';
            this.disabled = true;

            // Reset after 5 seconds
            setTimeout(() => {
                this.innerHTML = originalHTML;
                this.disabled = false;
            }, 5000);
        });
    });

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert && alert.style) {
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 300);
            }
        }, 5000);
    });
});
</script>
@endsection
