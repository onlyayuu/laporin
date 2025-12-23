<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #31326F;
            --secondary: #637AB9;
            --light: #D9D9D9;
            --background: #EFF2F8;
        }

        body {
            background-color: var(--background);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(49, 50, 111, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(49, 50, 111, 0.15);
        }

        .card-header-custom {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1.5rem;
            border-bottom: none;
        }

        .btn-custom {
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background-color: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(49, 50, 111, 0.3);
        }

        .info-box {
            background-color: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .info-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .info-title {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--light);
            padding-bottom: 0.5rem;
        }

        .status-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .status-badge:hover {
            transform: scale(1.05);
        }

        .description-box {
            background-color: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--secondary);
            transition: all 0.3s ease;
        }

        .description-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .feedback-box {
            background-color: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border-left: 4px solid #28a745;
            transition: all 0.3s ease;
        }

        .feedback-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .completion-box {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
            transition: all 0.3s ease;
        }

        .completion-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
        }

        .result-box {
            background: linear-gradient(135deg, #17a2b8, #20c997);
            color: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 15px rgba(23, 162, 184, 0.3);
            transition: all 0.3s ease;
        }

        .result-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(23, 162, 184, 0.4);
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: background-color 0.2s ease;
        }

        .info-row:hover {
            background-color: rgba(217, 217, 217, 0.3);
            border-radius: 5px;
        }

        .info-label {
            font-weight: 600;
            color: var(--primary);
            flex: 1;
        }

        .info-value {
            flex: 2;
            color: #555;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(49, 50, 111, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(49, 50, 111, 0); }
            100% { box-shadow: 0 0 0 0 rgba(49, 50, 111, 0); }
        }

        .icon-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary);
        }

        .section-title {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .image-gallery {
            background-color: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .image-gallery:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .gallery-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .gallery-img:hover {
            transform: scale(1.03);
        }

        .no-image {
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--light);
            border-radius: 10px;
            color: var(--primary);
            font-style: italic;
        }

        /* Modal untuk gambar yang diperbesar */
        .modal-content {
            border-radius: 15px;
            border: none;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-bottom: none;
            border-radius: 15px 15px 0 0;
        }

        .modal-body {
            padding: 0;
        }

        .modal-img {
            width: 100%;
            border-radius: 0 0 15px 15px;
        }

        /* Timeline Styles */
        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .timeline-marker {
            position: absolute;
            left: -2rem;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #e5e7eb;
        }

        .timeline-content h6 {
            margin: 0;
            font-size: 0.9rem;
            font-weight: 600;
            color: white;
        }

        .timeline-content p {
            margin: 0;
            font-size: 0.8rem;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
            <h2 class="fw-bold" style="color: var(--primary);">
                <i class="fas fa-clipboard-list me-2"></i>Detail Pengaduan
            </h2>
            <a href="{{ route('user.pengaduan.index') }}" class="btn btn-custom">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <div class="card fade-in">
            <div class="card-header-custom">
                <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Pengaduan</h4>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="info-box">
                            <div class="section-title">
                                <div class="icon-circle">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <h5 class="info-title mb-0">Data Pengaduan</h5>
                            </div>

                            <div class="info-row">
                                <div class="info-label">Judul</div>
                                <div class="info-value">{{ $pengaduan->nama_pengaduan }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Barang</div>
                                <div class="info-value">{{ $pengaduan->item ? $pengaduan->item->nama_item : 'Tidak tersedia' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Lokasi</div>
                                <div class="info-value">{{ $pengaduan->lokasi }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Status</div>
                                <div class="info-value">
                                    <span class="status-badge
                                        @if($pengaduan->status == 'Diajukan') bg-warning text-dark
                                        @elseif($pengaduan->status == 'Disetujui') bg-primary
                                        @elseif($pengaduan->status == 'Diproses') bg-info
                                        @elseif($pengaduan->status == 'Selesai') bg-success
                                        @elseif($pengaduan->status == 'Ditolak') bg-danger
                                        @else bg-secondary @endif">
                                        @if($pengaduan->status == 'Diajukan')
                                            <i class="fas fa-clock me-1"></i>
                                        @elseif($pengaduan->status == 'Disetujui')
                                            <i class="fas fa-check me-1"></i>
                                        @elseif($pengaduan->status == 'Diproses')
                                            <i class="fas fa-cogs me-1"></i>
                                        @elseif($pengaduan->status == 'Selesai')
                                            <i class="fas fa-check-circle me-1"></i>
                                        @elseif($pengaduan->status == 'Ditolak')
                                            <i class="fas fa-times-circle me-1"></i>
                                        @endif
                                        {{ $pengaduan->status }}
                                    </span>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Tanggal Pengajuan</div>
                                <div class="info-value">{{ $pengaduan->tgl_pengajuan }}</div>
                            </div>
                            @if($pengaduan->petugas)
                            <div class="info-row">
                                <div class="info-label">Petugas Penanganan</div>
                                <div class="info-value">{{ $pengaduan->petugas->nama }}</div>
                            </div>
                            @endif
                        </div>

                        <!-- Bagian Gambar Kondisi Awal -->
                        <div class="image-gallery">
                            <div class="section-title">
                                <div class="icon-circle">
                                    <i class="fas fa-camera"></i>
                                </div>
                                <h5 class="info-title mb-0">Foto Kondisi Awal</h5>
                            </div>

                            @if($pengaduan->foto)
                                <div class="row">
                                    <div class="col-12">
                                        <img src="{{ asset('storage/' . $pengaduan->foto) }}"
                                             alt="Foto Pengaduan Awal"
                                             class="gallery-img"
                                             data-bs-toggle="modal"
                                             data-bs-target="#imageModalAwal">
                                    </div>
                                </div>
                                <div class="mt-2 text-center">
                                    <small class="text-muted">Klik gambar untuk memperbesar</small>
                                </div>
                            @else
                                <div class="no-image">
                                    <i class="fas fa-image me-2"></i>Tidak ada foto yang diunggah
                                </div>
                            @endif
                        </div>

                        <!-- ✅ BAGIAN BARU: Foto Hasil Perbaikan -->
                        @if($pengaduan->foto_selesai)
                        <div class="image-gallery">
                            <div class="section-title">
                                <div class="icon-circle" style="background-color: #d1fae5; color: #065f46;">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <h5 class="info-title mb-0" style="color: #065f46;">Foto Hasil Perbaikan</h5>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <img src="{{ asset('storage/' . $pengaduan->foto_selesai) }}"
                                         alt="Foto Hasil Perbaikan"
                                         class="gallery-img"
                                         data-bs-toggle="modal"
                                         data-bs-target="#imageModalHasil">
                                </div>
                            </div>
                            <div class="mt-2 text-center">
                                <small class="text-muted">Klik gambar untuk memperbesar</small>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="col-lg-6">
                        <div class="description-box">
                            <div class="section-title">
                                <div class="icon-circle">
                                    <i class="fas fa-align-left"></i>
                                </div>
                                <h5 class="info-title mb-0">Deskripsi Masalah</h5>
                            </div>
                            <p class="mb-0">{{ $pengaduan->deskripsi }}</p>
                        </div>

                        @if($pengaduan->saran_petugas)
                            <div class="feedback-box">
                                <div class="section-title">
                                    <div class="icon-circle">
                                        <i class="fas fa-comment-dots"></i>
                                    </div>
                                    <h5 class="info-title mb-0">Tanggapan Petugas</h5>
                                </div>
                                <p class="mb-0">{{ $pengaduan->saran_petugas }}</p>
                            </div>
                        @endif

                        <!-- ✅ BAGIAN BARU: Hasil Perbaikan -->
                        @if($pengaduan->status == 'Selesai')
                        <div class="result-box pulse">
                            <div class="section-title">
                                <div class="icon-circle" style="background-color: rgba(255,255,255,0.2); color: white;">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <h5 class="mb-0 text-white">Hasil Perbaikan</h5>
                            </div>

                            <!-- Timeline Progress -->
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-white"></div>
                                    <div class="timeline-content">
                                        <h6>Diajukan</h6>
                                        <p>{{ \Carbon\Carbon::parse($pengaduan->tgl_pengajuan)->format('d M Y H:i') }}</p>
                                    </div>
                                </div>

                                @if($pengaduan->tgl_selesai)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-white"></div>
                                    <div class="timeline-content">
                                        <h6>Selesai Diperbaiki</h6>
                                        <p>{{ \Carbon\Carbon::parse($pengaduan->tgl_selesai)->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>

                            @if($pengaduan->foto_selesai)
                            <div class="mt-3 p-3 bg-white bg-opacity-10 rounded">
                                <p class="mb-2">
                                    <i class="fas fa-camera me-2"></i>
                                    <strong>Foto hasil perbaikan sudah tersedia</strong>
                                </p>
                                <small>Lihat foto di bagian kalaman untuk melihat bukti perbaikan</small>
                            </div>
                            @endif
                        </div>
                        @endif

                        @if($pengaduan->tgl_selesai)
                            <div class="completion-box">
                                <div class="section-title">
                                    <div class="icon-circle" style="background-color: rgba(255,255,255,0.2); color: white;">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <h5 class="mb-0">Tanggal Selesai</h5>
                                </div>
                                <p class="mb-0 fs-5">{{ \Carbon\Carbon::parse($pengaduan->tgl_selesai)->format('d M Y H:i') }}</p>
                                <small>Pengaduan telah diselesaikan oleh petugas</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk gambar kondisi awal -->
    @if($pengaduan->foto)
    <div class="modal fade" id="imageModalAwal" tabindex="-1" aria-labelledby="imageModalAwalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalAwalLabel">Foto Kondisi Awal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('storage/' . $pengaduan->foto) }}"
                         alt="Foto Kondisi Awal"
                         class="modal-img">
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal untuk gambar hasil perbaikan -->
    @if($pengaduan->foto_selesai)
    <div class="modal fade" id="imageModalHasil" tabindex="-1" aria-labelledby="imageModalHasilLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalHasilLabel">Foto Hasil Perbaikan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('storage/' . $pengaduan->foto_selesai) }}"
                         alt="Foto Hasil Perbaikan"
                         class="modal-img">
                </div>
            </div>
        </div>
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animasi sederhana untuk elemen saat di-scroll
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.fade-in');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });

            elements.forEach(element => {
                element.style.opacity = 0;
                element.style.transform = 'translateY(20px)';
                element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(element);
            });

            // Animasi untuk gambar saat di-hover
            const images = document.querySelectorAll('.gallery-img');
            images.forEach(img => {
                img.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.03)';
                });

                img.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });

            // Auto show completion box if status is Selesai
            @if($pengaduan->status == 'Selesai')
            setTimeout(() => {
                const completionBox = document.querySelector('.result-box');
                if (completionBox) {
                    completionBox.style.transform = 'scale(1.02)';
                    setTimeout(() => {
                        completionBox.style.transform = 'scale(1)';
                    }, 300);
                }
            }, 1000);
            @endif
        });
    </script>
</body>
</html>
