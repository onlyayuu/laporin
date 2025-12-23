@extends('layouts.petugas')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Detail Pengaduan</h1>
        <div class="page-actions">
            <a href="{{ url()->previous() }}" class="btn btn-outline">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Detail Pengaduan Card -->
            <div class="table-container">
                <div class="table-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="table-title">Informasi Pengaduan</h3>
                        <div class="status-display">
                            @php
                                $statusConfig = [
                                    'Diajukan' => ['color' => '#6B7280', 'icon' => 'fas fa-clock'],
                                    'Disetujui' => ['color' => '#6366F1', 'icon' => 'fas fa-check-circle'],
                                    'Ditolak' => ['color' => '#EF4444', 'icon' => 'fas fa-times-circle'],
                                    'Diproses' => ['color' => '#F59E0B', 'icon' => 'fas fa-tools'],
                                    'Selesai' => ['color' => '#10B981', 'icon' => 'fas fa-check-double']
                                ];
                                $config = $statusConfig[$pengaduan->status] ?? $statusConfig['Diajukan'];
                            @endphp
                            <div class="status-badge-large" style="--status-color: {{ $config['color'] }}">
                                <i class="{{ $config['icon'] }} me-2"></i>
                                {{ $pengaduan->status }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <!-- Progress Timeline -->
                    <div class="progress-timeline mb-4">
                        <div class="timeline-steps">
                            @php
                                $steps = [
                                    'Diajukan' => ['icon' => 'fas fa-paper-plane', 'date' => $pengaduan->tgl_pengajuan],
                                    'Disetujui' => ['icon' => 'fas fa-check', 'date' => null],
                                    'Diproses' => ['icon' => 'fas fa-tools', 'date' => null],
                                    'Selesai' => ['icon' => 'fas fa-flag-checkered', 'date' => $pengaduan->tgl_selesai]
                                ];
                                $currentStep = array_search($pengaduan->status, array_keys($steps));
                            @endphp

                            @foreach($steps as $step => $data)
                            <div class="timeline-step {{ $loop->index <= $currentStep ? 'active' : '' }}">
                                <div class="step-icon">
                                    <i class="{{ $data['icon'] }}"></i>
                                </div>
                                <div class="step-label">
                                    <div class="step-title">{{ $step }}</div>
                                    @if($data['date'])
                                    <div class="step-date">{{ \Carbon\Carbon::parse($data['date'])->format('d M Y') }}</div>
                                    @endif
                                </div>
                            </div>
                            @if(!$loop->last)
                            <div class="timeline-connector {{ $loop->index < $currentStep ? 'active' : '' }}"></div>
                            @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Pengaduan Details -->
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-heading"></i>
                            </div>
                            <div class="detail-content">
                                <label class="detail-label">Nama Pengaduan</label>
                                <div class="detail-value">{{ $pengaduan->nama_pengaduan }}</div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="detail-content">
                                <label class="detail-label">Pelapor</label>
                                <div class="detail-value">
                                    <div class="user-info-compact">
                                        <div class="user-avatar-xs">
                                            {{ strtoupper(substr($pengaduan->user->nama_pengguna, 0, 2)) }}
                                        </div>
                                        {{ $pengaduan->user->nama_pengguna }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="detail-content">
                                <label class="detail-label">Lokasi</label>
                                <div class="detail-value">{{ $pengaduan->lokasi }}</div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="detail-content">
                                <label class="detail-label">Tanggal Pengajuan</label>
                                <div class="detail-value">
                                    <div class="date-display">
                                        <div class="date-main">{{ \Carbon\Carbon::parse($pengaduan->tgl_pengajuan)->format('d M Y') }}</div>
                                        <div class="date-ago">{{ \Carbon\Carbon::parse($pengaduan->tgl_pengajuan)->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($pengaduan->tgl_selesai)
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-flag-checkered"></i>
                            </div>
                            <div class="detail-content">
                                <label class="detail-label">Tanggal Selesai</label>
                                <div class="detail-value">
                                    <div class="date-display">
                                        <div class="date-main">{{ \Carbon\Carbon::parse($pengaduan->tgl_selesai)->format('d M Y') }}</div>
                                        <div class="date-ago">{{ \Carbon\Carbon::parse($pengaduan->tgl_selesai)->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Deskripsi -->
                    <div class="detail-section">
                        <div class="section-header">
                            <i class="fas fa-align-left me-2"></i>
                            <h4 class="section-title">Deskripsi Pengaduan</h4>
                        </div>
                        <div class="section-content">
                            <div class="description-text">
                                {{ $pengaduan->deskripsi }}
                            </div>
                        </div>
                    </div>

                    <!-- Foto Awal Pengaduan -->
                    @if($pengaduan->foto)
                    <div class="detail-section">
                        <div class="section-header">
                            <i class="fas fa-image me-2"></i>
                            <h4 class="section-title">Foto Awal Pengaduan</h4>
                        </div>
                        <div class="section-content">
                            <div class="image-preview">
                                <img src="{{ asset('storage/' . $pengaduan->foto) }}"
                                     alt="Foto Awal Pengaduan"
                                     class="preview-image"
                                     id="pengaduanImage">
                                <div class="image-overlay">
                                    <button class="btn-zoom" onclick="zoomImage('pengaduanImage')">
                                        <i class="fas fa-search-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- PERBAIKAN: Foto Hasil Perbaikan (dari petugas) -->
                    @if($pengaduan->status == 'Selesai' && $pengaduan->foto_selesai)
                    <div class="detail-section">
                        <div class="section-header">
                            <i class="fas fa-check-circle me-2"></i>
                            <h4 class="section-title">Foto Hasil Perbaikan</h4>
                        </div>
                        <div class="section-content">
                            <div class="image-preview">
                                <img src="{{ asset('storage/' . $pengaduan->foto_selesai) }}"
                                     alt="Foto Hasil Perbaikan"
                                     class="preview-image"
                                     id="selesaiImage">
                                <div class="image-overlay">
                                    <button class="btn-zoom" onclick="zoomImage('selesaiImage')">
                                        <i class="fas fa-search-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="image-caption mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Foto bukti perbaikan yang diupload petugas
                                </small>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Saran Petugas -->
                    @if($pengaduan->status == 'Selesai' && $pengaduan->saran_petugas)
                    <div class="detail-section">
                        <div class="section-header">
                            <i class="fas fa-clipboard-check me-2"></i>
                            <h4 class="section-title">Tindakan & Saran Petugas</h4>
                        </div>
                        <div class="section-content">
                            <div class="saran-box">
                                <div class="saran-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="saran-content">
                                    {{ $pengaduan->saran_petugas }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Actions Card -->
            <div class="table-container mb-4">
                <div class="table-header">
                    <h3 class="table-title">Aksi</h3>
                </div>
                <div class="p-3">
                    <div class="action-buttons">
                        @if($pengaduan->status == 'Disetujui' && !$pengaduan->id_petugas)
                        <form action="{{ route('petugas.pengaduan.take', $pengaduan->id_pengaduan) }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="btn-action-primary w-100">
                                <i class="fas fa-hand-paper me-2"></i>
                                Ambil Pengaduan
                            </button>
                        </form>
                        @endif

                        @if($pengaduan->status == 'Diproses' && $pengaduan->id_petugas == Auth::id())
                        <button type="button" class="btn-action-success w-100" data-bs-toggle="modal" data-bs-target="#selesaiModal">
                            <i class="fas fa-check me-2"></i>
                            Tandai Selesai
                        </button>
                        @endif

                        <!-- UPDATE STATUS SECTION -->
                        @if($pengaduan->id_petugas == Auth::id() && in_array($pengaduan->status, ['Disetujui', 'Diproses']))
                        <div class="status-update-section mt-3">
                            <label class="form-label mb-2">Update Status:</label>
                            <div class="status-buttons">
                                <form action="{{ route('petugas.pengaduan.update-status-manual', $pengaduan->id_pengaduan) }}" method="POST" class="d-inline w-100">
                                    @csrf
                                    <input type="hidden" name="status" value="Diproses">
                                    <button type="submit" class="btn-status-proses w-100 {{ $pengaduan->status == 'Diproses' ? 'active' : '' }}">
                                        <i class="fas fa-tools me-2"></i>
                                        Sedang Diproses
                                    </button>
                                </form>

                                <button type="button" class="btn-status-selesai w-100 mt-2" data-bs-toggle="modal" data-bs-target="#selesaiModal">
                                    <i class="fas fa-check-double me-2"></i>
                                    Tandai Selesai
                                </button>
                            </div>
                        </div>
                        @endif

                        <a href="{{ url()->previous() }}" class="btn-action-secondary w-100 mt-2">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Info Petugas -->
            @if($pengaduan->petugas)
            <div class="table-container">
                <div class="table-header">
                    <h3 class="table-title">Petugas Penanggung Jawab</h3>
                </div>
                <div class="p-3">
                    <div class="petugas-info">
                        <div class="petugas-avatar">
                            {{ strtoupper(substr($pengaduan->petugas->nama, 0, 2)) }}
                        </div>
                        <div class="petugas-details">
                            <div class="petugas-name">{{ $pengaduan->petugas->nama }}</div>
                            <div class="petugas-contact">
                                <i class="fas fa-phone me-2"></i>
                                {{ $pengaduan->petugas->telp }}
                            </div>
                            <div class="petugas-badge">
                                <i class="fas fa-shield-alt me-1"></i>
                                Petugas Bertugas
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Quick Stats -->
            <div class="table-container">
                <div class="table-header">
                    <h3 class="table-title">Statistik Cepat</h3>
                </div>
                <div class="p-3">
                    <div class="quick-stats">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-info">
                                <div class="stat-value">{{ \Carbon\Carbon::parse($pengaduan->tgl_pengajuan)->diffInDays(now()) }} hari</div>
                                <div class="stat-label">Durasi Penanganan</div>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="stat-info">
                                <div class="stat-value">{{ \Carbon\Carbon::parse($pengaduan->tgl_pengajuan)->format('d M Y') }}</div>
                                <div class="stat-label">Diajukan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Selesai -->
@if($pengaduan->status == 'Diproses' && $pengaduan->id_petugas == Auth::id())
<div class="modal fade" id="selesaiModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h5 class="modal-title">Selesaikan Pengaduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('petugas.pengaduan.update-status', $pengaduan->id_pengaduan) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="pengaduan-preview mb-3">
                        <h6 class="preview-title">{{ $pengaduan->nama_pengaduan }}</h6>
                        <p class="preview-desc text-muted">{{ Str::limit($pengaduan->deskripsi, 120) }}</p>
                    </div>

                    <!-- PERBAIKAN: Tambah input upload foto selesai di modal -->
                    <div class="form-group mb-3">
                        <label class="form-label">Upload Foto Hasil Perbaikan</label>
                        <input type="file"
                               name="foto_selesai"
                               id="fotoSelesai"
                               class="form-control"
                               accept="image/*"
                               required>
                        <div class="form-helper">
                            <i class="fas fa-info-circle me-1"></i>
                            Format: JPG, PNG, GIF (Max 2MB)
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tindakan & Saran Petugas</label>
                        <textarea name="saran_petugas" class="form-control modern-textarea"
                                  rows="4"
                                  required
                                  placeholder="Jelaskan tindakan yang sudah dilakukan untuk menyelesaikan pengaduan ini..."></textarea>
                        <div class="form-helper">
                            <i class="fas fa-info-circle me-1"></i>
                            Deskripsi akan membantu pelapor memahami penyelesaian
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-2"></i>Tandai Selesai
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Image Zoom Modal -->
<div class="modal fade" id="imageZoomModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="zoomModalTitle">Foto Pengaduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src=""
                     alt="Foto"
                     class="img-fluid zoomed-image"
                     id="zoomedImage">
            </div>
        </div>
    </div>
</div>

<style>
    /* Progress Timeline */
    .progress-timeline {
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--radius-md);
        border: 1px solid var(--neutral);
    }

    .timeline-steps {
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
    }

    .timeline-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        position: relative;
        z-index: 2;
    }

    .timeline-step.active .step-icon {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(49, 50, 111, 0.3);
    }

    .step-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--neutral);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5rem;
        color: var(--text-light);
        transition: all 0.3s ease;
        font-size: 1.1rem;
    }

    .step-label {
        text-align: center;
    }

    .step-title {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .step-date {
        font-size: 0.7rem;
        color: var(--text-light);
    }

    .timeline-connector {
        flex: 1;
        height: 3px;
        background: var(--neutral);
        margin: 0 1rem;
        position: relative;
        top: -15px;
    }

    .timeline-connector.active {
        background: linear-gradient(90deg, var(--primary), var(--secondary));
    }

    /* Detail Grid */
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .detail-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem;
        background: var(--bg-light);
        border-radius: var(--radius-md);
        border: 1px solid var(--neutral);
        transition: all 0.3s ease;
    }

    .detail-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-color: var(--primary);
    }

    .detail-icon {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-md);
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .detail-content {
        flex: 1;
    }

    .detail-label {
        font-size: 0.8rem;
        color: var(--text-light);
        font-weight: 500;
        margin-bottom: 0.25rem;
        display: block;
    }

    .detail-value {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.9rem;
    }

    /* PERBAIKAN: Style untuk image caption */
    .image-caption {
        text-align: center;
    }

    /* Status Update Section */
    .status-update-section {
        padding: 1rem;
        background: var(--bg-light);
        border-radius: var(--radius-md);
        border: 1px solid var(--neutral);
    }

    .status-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .btn-status-proses, .btn-status-selesai {
        padding: 0.75rem 1rem;
        border: 2px solid var(--neutral);
        border-radius: var(--radius-md);
        background: var(--white);
        color: var(--text-dark);
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-status-proses:hover, .btn-status-proses.active {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border-color: var(--primary);
        transform: translateY(-2px);
    }

    .btn-status-selesai:hover {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border-color: #10b981;
        transform: translateY(-2px);
    }

    /* Action Buttons */
    .btn-action-primary, .btn-action-success, .btn-action-secondary {
        padding: 0.75rem 1rem;
        border: none;
        border-radius: var(--radius-md);
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5rem;
    }

    .btn-action-primary {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    .btn-action-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(49, 50, 111, 0.3);
    }

    .btn-action-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .btn-action-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-action-secondary {
        background: var(--neutral);
        color: var(--text-dark);
    }

    .btn-action-secondary:hover {
        background: var(--text-light);
        color: var(--white);
        transform: translateY(-2px);
    }

    /* Image Preview */
    .image-preview {
        position: relative;
        border-radius: var(--radius-md);
        overflow: hidden;
        max-width: 400px;
    }

    .preview-image {
        width: 100%;
        height: auto;
        transition: transform 0.3s ease;
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .image-preview:hover .image-overlay {
        opacity: 1;
    }

    .btn-zoom {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.9);
        border: none;
        color: var(--primary);
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-zoom:hover {
        background: white;
        transform: scale(1.1);
    }

    /* Saran Box */
    .saran-box {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
        border-radius: var(--radius-md);
        border-left: 4px solid #10b981;
    }

    .saran-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #10b981;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .saran-content {
        flex: 1;
        color: var(--text-dark);
        line-height: 1.5;
    }

    /* Petugas Info */
    .petugas-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .petugas-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .petugas-details {
        flex: 1;
    }

    .petugas-name {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .petugas-contact {
        font-size: 0.875rem;
        color: var(--text-light);
        margin-bottom: 0.5rem;
    }

    .petugas-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        background: rgba(99, 122, 185, 0.1);
        color: var(--primary);
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Quick Stats */
    .quick-stats {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--bg-light);
        border-radius: var(--radius-md);
        border: 1px solid var(--neutral);
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-md);
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-info {
        flex: 1;
    }

    .stat-value {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.9rem;
    }

    .stat-label {
        font-size: 0.8rem;
        color: var(--text-light);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .timeline-steps {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .timeline-connector {
            display: none;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .petugas-info {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<script>
    // PERBAIKAN: Fungsi zoom image yang support multiple images
    function zoomImage(imageId) {
        const image = document.getElementById(imageId);
        const zoomedImage = document.getElementById('zoomedImage');
        const zoomModalTitle = document.getElementById('zoomModalTitle');

        if (image && zoomedImage) {
            zoomedImage.src = image.src;

            // Set judul modal berdasarkan image
            if (imageId === 'selesaiImage') {
                zoomModalTitle.textContent = 'Foto Hasil Perbaikan';
            } else {
                zoomModalTitle.textContent = 'Foto Awal Pengaduan';
            }

            const modal = new bootstrap.Modal(document.getElementById('imageZoomModal'));
            modal.show();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Animate timeline steps
        const timelineSteps = document.querySelectorAll('.timeline-step');
        timelineSteps.forEach((step, index) => {
            step.style.animationDelay = `${index * 0.2}s`;
            step.classList.add('animate__animated', 'animate__fadeInUp');
        });

        // Add hover effects to detail items
        const detailItems = document.querySelectorAll('.detail-item');
        detailItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });

            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Image preview enhancement
        const previewImages = document.querySelectorAll('.preview-image');
        previewImages.forEach(image => {
            image.addEventListener('click', function() {
                zoomImage(this.id);
            });
        });
    });
</script>
@endsection
