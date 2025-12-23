@extends('layouts.petugas')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Dashboard Petugas</h1>
        <div class="page-actions">
            <span class="text-muted">
                <i class="fas fa-calendar-alt me-2"></i>
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </span>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        @php
            // Gunakan data dari controller
            $stats = $stats ?? [
                'total_diambil' => 0,
                'diproses' => 0,
                'selesai' => 0,
                'menunggu_diambil' => 0
            ];

            // Hitung statistik tambahan dari data yang ada
            $pengaduanBulanIni = \App\Models\Pengaduan::where('id_petugas', Auth::user()->petugas->id_petugas ?? 0)
                ->whereMonth('tgl_pengajuan', now()->month)
                ->whereYear('tgl_pengajuan', now()->year)
                ->count();

            // Rata-rata waktu penyelesaian
            $rataWaktuPenyelesaian = \App\Models\Pengaduan::where('id_petugas', Auth::user()->petugas->id_petugas ?? 0)
                ->where('status', 'Selesai')
                ->whereNotNull('tgl_selesai')
                ->selectRaw('AVG(DATEDIFF(tgl_selesai, tgl_pengajuan)) as avg_days')
                ->first()->avg_days ?? 0;

            // Persentase penyelesaian
            $totalSelesai = $stats['selesai'];
            $totalDitangani = $stats['total_diambil'];
            $persentaseSelesai = $totalDitangani > 0 ? ($totalSelesai / $totalDitangani) * 100 : 0;
        @endphp

        <a href="{{ route('petugas.pengaduan.task') }}" class="stat-card-link">
            <div class="stat-card stat-card-primary">
                <div class="stat-card-content">
                    <div class="stat-value">{{ $stats['total_diambil'] }}</div>
                    <div class="stat-label">Total Diambil</div>
                    <div class="stat-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('petugas.pengaduan.task') }}?status=Diproses" class="stat-card-link">
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-value">{{ $stats['diproses'] }}</div>
                    <div class="stat-label">Sedang Diproses</div>
                    <div class="stat-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('petugas.pengaduan.task') }}?status=Selesai" class="stat-card-link">
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-value">{{ $stats['selesai'] }}</div>
                    <div class="stat-label">Selesai</div>
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('petugas.pengaduan.index') }}" class="stat-card-link">
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-value">{{ $stats['menunggu_diambil'] }}</div>
                    <div class="stat-label">Menunggu Diambil</div>
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </a>

        <!-- Additional Stats -->
        <div class="stat-card">
            <div class="stat-card-content">
                <div class="stat-value">{{ $pengaduanBulanIni }}</div>
                <div class="stat-label">Pengaduan Bulan Ini</div>
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-content">
                <div class="stat-value">{{ number_format($rataWaktuPenyelesaian, 1) }} <small>hari</small></div>
                <div class="stat-label">Rata-rata Waktu Penyelesaian</div>
                <div class="stat-icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-content">
                <div class="stat-value">{{ number_format($persentaseSelesai, 1) }}<small>%</small></div>
                <div class="stat-label">Tingkat Penyelesaian</div>
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="table-container">
                <div class="table-header">
                    <h3 class="table-title">Aksi Cepat</h3>
                </div>
                <div class="p-3">
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('petugas.pengaduan.index') }}" class="btn btn-primary">
                            <i class="fas fa-hand-paper me-2"></i>Ambil Pengaduan Baru
                        </a>
                        <a href="{{ route('petugas.pengaduan.task') }}" class="btn btn-outline">
                            <i class="fas fa-tasks me-2"></i>Lihat Tugas Saya
                        </a>
                        <a href="{{ route('petugas.pengaduan.history') }}" class="btn btn-outline">
                            <i class="fas fa-history me-2"></i>Riwayat Selesai
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Pengaduan Tersedia -->
        <div class="col-lg-6 mb-4">
            <div class="table-container">
                <div class="table-header">
                    <h3 class="table-title">Pengaduan Tersedia</h3>
                    <a href="{{ route('petugas.pengaduan.index') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    @if(isset($pengaduan_terbaru) && $pengaduan_terbaru->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Pengaduan</th>
                                    <th>Pelapor</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengaduan_terbaru as $p)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                @if($p->foto)
                                                    <img src="{{ asset('storage/' . $p->foto) }}" alt="Foto Pengaduan" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="fw-semibold" style="font-size: 0.875rem;">{{ Str::limit($p->nama_pengaduan, 30) }}</div>
                                                <small class="text-muted">{{ Str::limit($p->lokasi, 20) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($p->user)
                                            {{ $p->user->nama_pengguna }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($p->tgl_pengajuan)->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('petugas.pengaduan.show', $p->id_pengaduan) }}" class="btn btn-sm btn-outline" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada pengaduan tersedia</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pengaduan Saya yang Aktif -->
        <div class="col-lg-6 mb-4">
            <div class="table-container">
                <div class="table-header">
                    <h3 class="table-title">Pengaduan Saya yang Aktif</h3>
                    <a href="{{ route('petugas.pengaduan.task') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    @php
                        // Ambil data pengaduan aktif dari petugas yang login
                        $petugasId = Auth::user()->petugas->id_petugas ?? 0;
                        $pengaduanAktif = \App\Models\Pengaduan::with('user')
                            ->where('id_petugas', $petugasId)
                            ->whereIn('status', ['Diproses', 'Disetujui'])
                            ->orderBy('tgl_pengajuan', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp

                    @if($pengaduanAktif->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Pengaduan</th>
                                    <th>Status</th>
                                    <th>Progress</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengaduanAktif as $p)
                                <tr>
                                    <td>
                                        <div class="fw-semibold" style="font-size: 0.875rem;">{{ Str::limit($p->nama_pengaduan, 35) }}</div>
                                        <small class="text-muted">
                                            @if($p->user)
                                                Oleh: {{ $p->user->nama_pengguna }}
                                            @else
                                                Oleh: -
                                            @endif
                                        </small>
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = [
                                                'Diajukan' => 'badge-diajukan',
                                                'Disetujui' => 'badge-diproses',
                                                'Ditolak' => 'badge-ditolak',
                                                'Diproses' => 'badge-diproses',
                                                'Selesai' => 'badge-selesai'
                                            ][$p->status] ?? 'badge-diajukan';
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $p->status }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $progress = 0;
                                            if ($p->status == 'Disetujui') $progress = 25;
                                            if ($p->status == 'Diproses') $progress = 60;
                                            if ($p->status == 'Selesai') $progress = 100;
                                        @endphp
                                        <div class="progress" style="height: 6px; width: 80px;">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%; background-color: var(--primary);"
                                                 aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small class="text-muted">{{ $progress }}%</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('petugas.pengaduan.show', $p->id_pengaduan) }}" class="btn btn-sm btn-outline" title="Kelola">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada pengaduan aktif</p>
                            <a href="{{ route('petugas.pengaduan.index') }}" class="btn btn-primary btn-sm">Ambil Pengaduan</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Overview -->
    <div class="row">
        <div class="col-12">
            <div class="table-container">
                <div class="table-header">
                    <h3 class="table-title">Ringkasan Aktivitas 7 Hari Terakhir</h3>
                </div>
                <div class="p-3">
                    @php
                        $petugasId = Auth::user()->petugas->id_petugas ?? 0;
                        $activities = \App\Models\Pengaduan::where('id_petugas', $petugasId)
                            ->where('tgl_pengajuan', '>=', now()->subDays(7))
                            ->selectRaw('DATE(tgl_pengajuan) as date, status, COUNT(*) as count')
                            ->groupBy('date', 'status')
                            ->orderBy('date', 'desc')
                            ->get()
                            ->groupBy('date');
                    @endphp

                    @if($activities->count() > 0)
                        <div class="row">
                            @foreach($activities->take(4) as $date => $dayActivities)
                            <div class="col-md-3 mb-3">
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary">
                                            {{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y') }}
                                        </h6>
                                        @foreach($dayActivities as $activity)
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="small">{{ $activity->status }}</span>
                                            <span class="badge bg-primary rounded-pill">{{ $activity->count }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <p class="text-muted">Tidak ada aktivitas dalam 7 hari terakhir</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .progress-bar {
        transition: width 0.6s ease;
    }

    .stat-card {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .table-container {
        animation: slideUp 0.5s ease;
    }

    .badge-diajukan { background-color: #6c757d; color: white; }
    .badge-diproses { background-color: #17a2b8; color: white; }
    .badge-ditolak { background-color: #dc3545; color: white; }
    .badge-selesai { background-color: #28a745; color: white; }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate progress bars
        const progressBars = document.querySelectorAll('.progress-bar');
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0';
            setTimeout(() => {
                bar.style.width = width;
            }, 300);
        });

        // Auto refresh stats every 30 seconds
        setInterval(() => {
            // Optional: Implement AJAX refresh here if needed
            console.log('Dashboard auto-refresh ready');
        }, 30000);
    });
</script>
@endsection
