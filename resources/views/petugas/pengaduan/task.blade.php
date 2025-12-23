@extends('layouts.petugas')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Pengaduan Saya</h1>
        <div class="page-actions">
            <span class="text-muted">
                <i class="fas fa-tasks me-2"></i>
                Daftar Pengaduan Yang Sedang Ditangani
            </span>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="stats-grid mb-4">
        @php
            $total = $pengaduan->count();
            $diproses = $pengaduan->where('status', 'Diproses')->count();
            $disetujui = $pengaduan->where('status', 'Disetujui')->count();
            $progress = $total > 0 ? (($diproses + $disetujui) / $total) * 100 : 0;
        @endphp

        <div class="stat-card">
            <div class="stat-card-content">
                <div class="stat-value">{{ $total }}</div>
                <div class="stat-label">Total Ditangani</div>
                <div class="stat-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-content">
                <div class="stat-value">{{ $diproses }}</div>
                <div class="stat-label">Sedang Diproses</div>
                <div class="stat-icon">
                    <i class="fas fa-tools"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-content">
                <div class="stat-value">{{ $disetujui }}</div>
                <div class="stat-label">Menunggu Diproses</div>
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-content">
                <div class="stat-value">{{ number_format($progress, 0) }}<small>%</small></div>
                <div class="stat-label">Progress Keseluruhan</div>
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengaduan List -->
    <div class="table-container">
        <div class="table-header">
            <h3 class="table-title">Daftar Pengaduan Aktif</h3>
            <div class="table-actions">
                <button class="btn btn-outline" id="refreshBtn">
                    <i class="fas fa-sync-alt me-2"></i>Refresh
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover" id="pengaduanTable">
                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th>Informasi Pengaduan</th>
                        <th width="120">Pelapor</th>
                        <th width="120">Tanggal</th>
                        <th width="120">Status</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaduan as $key => $p)
                    <tr class="pengaduan-row" data-status="{{ $p->status }}">
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
                                    @else
                                        <div class="pengaduan-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="pengaduan-title mb-1">{{ $p->nama_pengaduan }}</h6>
                                    <p class="pengaduan-desc mb-2">{{ Str::limit($p->deskripsi, 100) }}</p>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="progress-container">
                                            <div class="progress-label">
                                                Progress:
                                                <span class="progress-percent">
                                                    @php
                                                        $progressValue = 0;
                                                        if ($p->status == 'Disetujui') $progressValue = 25;
                                                        if ($p->status == 'Diproses') $progressValue = 60;
                                                        if ($p->status == 'Selesai') $progressValue = 100;
                                                    @endphp
                                                    {{ $progressValue }}%
                                                </span>
                                            </div>
                                            <div class="progress-bar-container">
                                                <div class="progress-bar-fill" style="width: {{ $progressValue }}%"></div>
                                            </div>
                                        </div>
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
                            <div class="date-info">
                                <div class="date-day">{{ \Carbon\Carbon::parse($p->tgl_pengajuan)->format('d M') }}</div>
                                <div class="date-year text-muted">{{ \Carbon\Carbon::parse($p->tgl_pengajuan)->format('Y') }}</div>
                                <div class="date-ago text-muted small">{{ \Carbon\Carbon::parse($p->tgl_pengajuan)->diffForHumans() }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="status-container">
                                <span class="status-badge status-{{ strtolower($p->status) }}">
                                    <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                                    {{ $p->status }}
                                </span>
                                @if($p->status == 'Diproses')
                                <div class="status-pulse"></div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center action-buttons">
                                <a href="{{ route('petugas.pengaduan.show', $p->id_pengaduan) }}"
                                   class="btn-action btn-detail"
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <button type="button"
                                        class="btn-action btn-complete complete-btn"
                                        title="Tandai Selesai"
                                        data-pengaduan-id="{{ $p->id_pengaduan }}"
                                        data-pengaduan-nama="{{ $p->nama_pengaduan }}"
                                        data-pengaduan-deskripsi="{{ $p->deskripsi }}">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state text-center py-5">
                                <i class="fas fa-clipboard-list fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada pengaduan yang diambil</h5>
                                <p class="text-muted mb-3">Ambil pengaduan baru untuk mulai menangani</p>
                                <a href="{{ route('petugas.pengaduan.index') }}" class="btn btn-primary">
                                    <i class="fas fa-hand-paper me-2"></i>Ambil Pengaduan
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Sidebar untuk menyelesaikan pengaduan -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>
<div class="completion-sidebar" id="completionSidebar">
    <div class="sidebar-header">
        <div class="sidebar-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h5 class="sidebar-title">Selesaikan Pengaduan</h5>
        <button type="button" class="sidebar-close" id="sidebarClose">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <form id="completionForm" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="sidebar-body">
            <div class="pengaduan-preview mb-3">
                <h6 class="preview-title" id="previewTitle"></h6>
                <p class="preview-desc text-muted" id="previewDesc"></p>
            </div>

            <!-- PERBAIKAN: File upload dengan preview sederhana -->
            <div class="form-group mb-3">
                <label class="form-label">Upload Foto Hasil Perbaikan</label>
                <input type="file"
                       name="foto_selesai"
                       id="fotoSelesai"
                       class="form-control"
                       accept="image/*"
                       required
                       onchange="showFileInfo(this)">
                <div class="form-helper">
                    <i class="fas fa-info-circle me-1"></i>
                    Format: JPG, PNG, GIF (Max 2MB)
                </div>
                <!-- Simple file info display -->
                <div id="fileInfo" class="file-info-display mt-2">
                    <i class="fas fa-check-circle text-success me-1"></i>
                    <span id="fileInfoText"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Saran / Tindakan yang Dilakukan</label>
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
        <div class="sidebar-footer">
            <button type="button" class="btn btn-outline" id="cancelBtn">
                <i class="fas fa-times me-2"></i>Batal
            </button>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check me-2"></i>Tandai Selesai
            </button>
        </div>
    </form>
</div>

<style>
    /* Reset pointer events untuk row, kecuali tombol aksi */
    .pengaduan-row {
        pointer-events: none;
    }

    .pengaduan-row .action-buttons,
    .pengaduan-row .btn-action,
    .pengaduan-row .complete-btn {
        pointer-events: auto !important;
    }

    /* Pastikan tombol aksi bisa diklik */
    .action-buttons {
        position: relative;
        z-index: 1000;
    }

    .btn-action {
        position: relative;
        z-index: 1001;
        pointer-events: auto !important;
    }

    /* Progress Bar Styles */
    .progress-container {
        width: 100%;
    }

    .progress-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.25rem;
        font-size: 0.75rem;
        color: var(--text-light);
    }

    .progress-percent {
        font-weight: 600;
        color: var(--primary);
    }

    .progress-bar-container {
        width: 100%;
        height: 6px;
        background-color: var(--neutral);
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        border-radius: 10px;
        transition: width 1s ease-in-out;
        position: relative;
    }

    .progress-bar-fill::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    /* Pengaduan Image Styles */
    .pengaduan-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border: 2px solid var(--neutral);
        border-radius: var(--radius-md);
        transition: all 0.3s ease;
    }

    .pengaduan-placeholder {
        width: 60px;
        height: 60px;
        border: 2px dashed var(--neutral);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-light);
        font-size: 1.25rem;
        transition: all 0.3s ease;
    }

    .pengaduan-row:hover .pengaduan-image,
    .pengaduan-row:hover .pengaduan-placeholder {
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
    }

    /* Status Styles */
    .status-container {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        white-space: nowrap;
    }

    .status-diproses {
        background-color: rgba(99, 122, 185, 0.1);
        color: var(--primary);
        border: 1px solid rgba(99, 122, 185, 0.2);
    }

    .status-disetujui {
        background-color: rgba(255, 193, 7, 0.1);
        color: #b45309;
        border: 1px solid rgba(255, 193, 7, 0.2);
    }

    .status-pulse {
        width: 8px;
        height: 8px;
        background-color: var(--primary);
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.5); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
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
        pointer-events: auto !important;
    }

    .btn-detail {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    .btn-detail:hover {
        transform: translateY(-2px) scale(1.1);
        box-shadow: 0 4px 12px rgba(49, 50, 111, 0.3);
    }

    .btn-complete {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .btn-complete:hover {
        transform: translateY(-2px) scale(1.1);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    /* Sidebar Styles */
    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1040;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .sidebar-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .completion-sidebar {
        position: fixed;
        top: 0;
        right: -450px;
        width: 450px;
        height: 100%;
        background-color: white;
        z-index: 1050;
        box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        transition: right 0.3s ease;
        overflow-y: auto;
    }

    .completion-sidebar.active {
        right: 0;
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        padding: 1.5rem;
        border-bottom: 1px solid var(--neutral);
        background-color: var(--bg-light);
    }

    .sidebar-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.25rem;
    }

    .sidebar-title {
        color: var(--text-dark);
        font-weight: 600;
        margin: 0;
        flex: 1;
    }

    .sidebar-close {
        background: none;
        border: none;
        font-size: 1.25rem;
        color: var(--text-light);
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .sidebar-close:hover {
        color: var(--text-dark);
    }

    .sidebar-body {
        padding: 1.5rem;
        flex: 1;
    }

    .sidebar-footer {
        padding: 1.5rem;
        border-top: 1px solid var(--neutral);
        display: flex;
        gap: 0.75rem;
    }

    .sidebar-footer .btn {
        flex: 1;
    }

    /* Preview Styles */
    .pengaduan-preview {
        padding: 1rem;
        background-color: var(--bg-light);
        border-radius: var(--radius-md);
        border-left: 4px solid var(--primary);
    }

    .preview-title {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .preview-desc {
        font-size: 0.875rem;
        margin: 0;
    }

    .modern-textarea {
        border: 2px solid var(--neutral);
        border-radius: var(--radius-md);
        padding: 0.75rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        resize: vertical;
    }

    .modern-textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(49, 50, 111, 0.1);
    }

    .form-helper {
        font-size: 0.75rem;
        color: var(--text-light);
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
    }

    /* PERBAIKAN: Style untuk file info display */
    .file-info-display {
        display: none;
        padding: 0.75rem;
        background-color: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: var(--radius-md);
        color: #0369a1;
        font-size: 0.875rem;
        align-items: center;
    }

    .file-info-display.show {
        display: flex !important;
    }

    /* Animation */
    .pengaduan-row {
        animation: slideInUp 0.5s ease;
        animation-fill-mode: both;
        transition: all 0.3s ease;
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

    .pengaduan-row:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        background-color: var(--bg-light) !important;
    }

    /* Empty State */
    .empty-state {
        padding: 3rem 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .pengaduan-title {
            font-size: 0.8rem;
        }

        .pengaduan-desc {
            font-size: 0.75rem;
        }

        .progress-label {
            font-size: 0.7rem;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            font-size: 0.75rem;
        }

        .completion-sidebar {
            width: 100%;
            right: -100%;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const refreshBtn = document.getElementById('refreshBtn');
    const pengaduanRows = document.querySelectorAll('.pengaduan-row');
    const completeBtns = document.querySelectorAll('.complete-btn');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const completionSidebar = document.getElementById('completionSidebar');
    const sidebarClose = document.getElementById('sidebarClose');
    const cancelBtn = document.getElementById('cancelBtn');
    const completionForm = document.getElementById('completionForm');
    const previewTitle = document.getElementById('previewTitle');
    const previewDesc = document.getElementById('previewDesc');

    // Refresh button functionality
    refreshBtn.addEventListener('click', function() {
        refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
        refreshBtn.disabled = true;

        setTimeout(() => {
            window.location.reload();
        }, 1000);
    });

    // Animate progress bars on load
    const progressBars = document.querySelectorAll('.progress-bar-fill');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => {
            bar.style.width = width;
        }, 500);
    });

    // ✅ BENAR: Function untuk buka sidebar
    function openSidebar(pengaduanId, pengaduanNama, pengaduanDeskripsi) {
        // ✅ GUNAKAN ROUTE YANG SESUAI DENGAN routes.php
        completionForm.action = `/petugas/pengaduan/update-status/${pengaduanId}`;

        // Set preview content
        previewTitle.textContent = pengaduanNama;
        previewDesc.textContent = pengaduanDeskripsi;

        // Reset form dan file input
        completionForm.reset();
        hideFileInfo();

        // Show sidebar and overlay
        completionSidebar.classList.add('active');
        sidebarOverlay.classList.add('active');

        // Prevent body scroll
        document.body.style.overflow = 'hidden';

        console.log('✅ Sidebar opened for pengaduan:', pengaduanId);
        console.log('✅ Form action set to:', completionForm.action);
    }

    function closeSidebar() {
        completionSidebar.classList.remove('active');
        sidebarOverlay.classList.remove('active');

        // Restore body scroll
        document.body.style.overflow = '';
    }

    // Event listeners for complete buttons
    completeBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const pengaduanId = this.getAttribute('data-pengaduan-id');
            const pengaduanNama = this.getAttribute('data-pengaduan-nama');
            const pengaduanDeskripsi = this.getAttribute('data-pengaduan-deskripsi');

            console.log('🎯 Opening sidebar for pengaduan:', {
                id: pengaduanId,
                nama: pengaduanNama,
                deskripsi: pengaduanDeskripsi
            });

            openSidebar(pengaduanId, pengaduanNama, pengaduanDeskripsi);
        });
    });

    // Close sidebar events
    sidebarClose.addEventListener('click', closeSidebar);
    cancelBtn.addEventListener('click', closeSidebar);
    sidebarOverlay.addEventListener('click', closeSidebar);

    // ✅ BENAR: Form submission dengan validasi dan debugging
    completionForm.addEventListener('submit', function(e) {
        console.log('🚀 === FORM SUBMISSION STARTED ===');
        console.log('📝 Form action:', this.action);
        console.log('📝 Form method:', this.method);

        const fileInput = document.getElementById('fotoSelesai');
        const saranInput = document.querySelector('textarea[name="saran_petugas"]');

        // Validasi file
        if (!fileInput.files || fileInput.files.length === 0) {
            e.preventDefault();
            alert('❌ Harap upload foto hasil perbaikan!');
            fileInput.focus();
            console.log('❌ Validation failed: No file selected');
            return;
        }

        // Validasi ukuran file (max 2MB)
        const file = fileInput.files[0];
        const fileSizeMB = file.size / 1024 / 1024;
        if (fileSizeMB > 2) {
            e.preventDefault();
            alert('❌ Ukuran file terlalu besar! Maksimal 2MB.');
            fileInput.focus();
            console.log('❌ Validation failed: File too large', fileSizeMB + 'MB');
            return;
        }

        // Validasi tipe file
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            e.preventDefault();
            alert('❌ Format file tidak didukung! Gunakan JPG, PNG, atau GIF.');
            fileInput.focus();
            console.log('❌ Validation failed: Invalid file type', file.type);
            return;
        }

        // Validasi saran
        if (!saranInput.value.trim()) {
            e.preventDefault();
            alert('❌ Harap isi saran/tindakan yang dilakukan!');
            saranInput.focus();
            console.log('❌ Validation failed: Empty saran_petugas');
            return;
        }

        if (saranInput.value.trim().length < 10) {
            e.preventDefault();
            alert('❌ Saran/tindakan minimal 10 karakter!');
            saranInput.focus();
            console.log('❌ Validation failed: Saran too short');
            return;
        }

        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
        submitBtn.disabled = true;

        console.log('✅ All validation passed, submitting form...');
        console.log('📁 File:', file.name, 'Size:', fileSizeMB.toFixed(2) + 'MB');
        console.log('💬 Saran length:', saranInput.value.length + ' characters');

        // Fallback: reset button setelah 15 detik jika masih loading
        setTimeout(() => {
            if (submitBtn.disabled) {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                console.log('⚠️ Form submission timeout after 15 seconds');
                alert('⚠️ Request timeout. Silakan coba lagi.');
            }
        }, 15000);
    });

    // Close sidebar with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && completionSidebar.classList.contains('active')) {
            closeSidebar();
        }
    });

    // Add hover effects to rows
    pengaduanRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
        });

        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });

    // Refresh page when coming back from other tabs (optional)
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            // Page is visible again, you can refresh if needed
            console.log('Page is visible');
        }
    });
});

// ✅ BENAR: Fungsi untuk menampilkan info file
function showFileInfo(input) {
    const fileInfo = document.getElementById('fileInfo');
    const fileInfoText = document.getElementById('fileInfoText');

    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileName = file.name;
        const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB
        const fileType = file.type;

        fileInfoText.textContent = `File terpilih: ${fileName} (${fileSize} MB) - ${fileType}`;
        fileInfo.classList.add('show');

        console.log('📁 File selected:', {
            name: fileName,
            size: fileSize + 'MB',
            type: fileType
        });
    } else {
        hideFileInfo();
    }
}

// ✅ BENAR: Fungsi untuk menyembunyikan info file
function hideFileInfo() {
    const fileInfo = document.getElementById('fileInfo');
    fileInfo.classList.remove('show');
    console.log('📁 File info hidden');
}

// ✅ Tambahan: Drag and drop functionality (optional)
function setupDragAndDrop() {
    const fileInput = document.getElementById('fotoSelesai');
    const fileInfo = document.getElementById('fileInfo');

    if (!fileInput || !fileInfo) return;

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        fileInfo.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    // Highlight drop area when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        fileInfo.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        fileInfo.addEventListener(eventName, unhighlight, false);
    });

    // Handle dropped files
    fileInfo.addEventListener('drop', handleDrop, false);

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight() {
        fileInfo.style.backgroundColor = 'rgba(99, 122, 185, 0.1)';
        fileInfo.style.borderColor = 'var(--primary)';
    }

    function unhighlight() {
        fileInfo.style.backgroundColor = '';
        fileInfo.style.borderColor = '';
    }

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        if (files.length > 0) {
            fileInput.files = files;
            showFileInfo(fileInput);
        }
    }
}

// Initialize drag and drop when page loads
document.addEventListener('DOMContentLoaded', function() {
    setupDragAndDrop();
});
</script>
@endsection
