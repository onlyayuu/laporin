@extends('layouts.user')

@section('title', 'Edukasi - Laporin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1"><i class="fas fa-graduation-cap text-primary me-2"></i>Pusat Edukasi Laporin</h2>
                    <p class="text-muted">Pelajari pentingnya melaporkan masalah dan cara melakukannya dengan benar</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <button class="btn btn-primary w-100 py-3 nav-edu-btn active" data-target="section1">
                                <i class="fas fa-question-circle me-2"></i>
                                Kenapa Melapor?
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-outline-primary w-100 py-3 nav-edu-btn" data-target="section2">
                                <i class="fas fa-book me-2"></i>
                                Tutorial Melapor
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-outline-primary w-100 py-3 nav-edu-btn" data-target="section3">
                                <i class="fas fa-info-circle me-2"></i>
                                Pentingnya Melapor
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Sections -->
    <div class="row">
        <div class="col-12">
            <!-- Section 1 -->
            <div id="section1" class="edu-section active">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0"><i class="fas fa-question-circle me-2"></i>Kenapa Melapor di Laporin?</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <p class="lead">Laporin merupakan platform pengaduan terintegrasi yang dirancang khusus untuk memudahkan masyarakat dalam menyampaikan aspirasi dan pengaduan secara efektif dan efisien.</p>

                                <h5 class="text-primary mt-4">Keunggulan Platform Laporin</h5>
                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="bg-primary rounded p-2 me-3 text-white">
                                                <i class="fas fa-shield-alt"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">Sistem Keamanan Terjamin</h6>
                                                <p class="small mb-0">Data dan identitas pelapor dilindungi dengan sistem enkripsi yang canggih, memastikan kerahasiaan informasi pribadi Anda tetap terjaga.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="bg-success rounded p-2 me-3 text-white">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">Proses Cepat & Responsif</h6>
                                                <p class="small mb-0">Laporan Anda akan ditindaklanjuti maksimal dalam 3x24 jam oleh tim profesional yang berpengalaman di bidangnya.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="bg-info rounded p-2 me-3 text-white">
                                                <i class="fas fa-user-secret"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">Proteksi Identitas Pelapor</h6>
                                                <p class="small mb-0">Identitas pelapor dirahasiakan sepenuhnya, memberikan rasa aman dan nyaman dalam menyampaikan pengaduan.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="bg-warning rounded p-2 me-3 text-white">
                                                <i class="fas fa-chart-line"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">Transparansi Status Laporan</h6>
                                                <p class="small mb-0">Pantau perkembangan laporan Anda secara real-time melalui dashboard yang mudah dipahami.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="text-primary mt-4">Mengapa Memilih Laporin?</h5>
                                <p>Laporin bukan sekadar platform pengaduan biasa. Kami menghadirkan solusi komprehensif yang menggabungkan teknologi modern dengan pelayanan manusiawi. Setiap laporan yang masuk tidak hanya dicatat, tetapi juga dianalisis untuk memberikan solusi terbaik.</p>

                                <p>Tim Laporin terdiri dari tenaga profesional yang telah melalui pelatihan khusus dalam menangani berbagai jenis pengaduan. Kami memahami bahwa setiap masalah memiliki karakteristik unik dan membutuhkan pendekatan yang berbeda-beda.</p>

                                <p>Dengan menggunakan Laporin, Anda turut berpartisipasi dalam membangun sistem pengaduan yang lebih baik dan terstruktur. Data dari laporan-laporan yang masuk akan menjadi bahan analisis penting untuk perbaikan layanan publik di masa depan.</p>
                            </div>
                            <div class="col-lg-4">
                                <div class="bg-light rounded p-4">
                                    <h6 class="text-primary"><i class="fas fa-lightbulb me-2"></i>Fakta Menarik</h6>
                                    <p class="small mb-3">Berdasarkan survei terbaru, 98% pengguna merasa lebih aman dan nyaman melaporkan masalah melalui platform digital seperti Laporin dibandingkan dengan cara konvensional.</p>

                                    <h6 class="text-primary mt-4"><i class="fas fa-chart-bar me-2"></i>Statistik</h6>
                                    <div class="small">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Laporan Terselesaikan</span>
                                            <span class="fw-bold text-success">85%</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Waktu Tanggap Rata-rata</span>
                                            <span class="fw-bold text-info">24 Jam</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Kepuasan Pengguna</span>
                                            <span class="fw-bold text-warning">95%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2 -->
            <div id="section2" class="edu-section">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0"><i class="fas fa-book me-2"></i>Tutorial Melapor</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-7">
                                <p class="lead">Ikuti panduan lengkap berikut untuk membuat laporan dengan mudah dan efektif melalui platform Laporin.</p>

                                <div class="steps-container">
                                    <div class="step-item mb-4 p-3 border-start border-4 border-primary">
                                        <div class="step-header d-flex align-items-center mb-2">
                                            <div class="step-number bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                                <strong>1</strong>
                                            </div>
                                            <h5 class="mb-0 text-primary">Persiapan Akun</h5>
                                        </div>
                                        <p class="mb-2">Pastikan Anda telah memiliki akun Laporin yang aktif. Proses pendaftaran sangat mudah dan hanya membutuhkan beberapa menit saja.</p>
                                        <ul class="small text-muted">
                                            <li>Gunakan email aktif untuk proses verifikasi</li>
                                            <li>Pilih password yang kuat dan mudah diingat</li>
                                            <li>Lengkapi data profil untuk pengalaman yang lebih personal</li>
                                            <li>Simpan username dan password di tempat yang aman</li>
                                        </ul>
                                    </div>

                                    <div class="step-item mb-4 p-3 border-start border-4 border-success">
                                        <div class="step-header d-flex align-items-center mb-2">
                                            <div class="step-number bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                                <strong>2</strong>
                                            </div>
                                            <h5 class="mb-0 text-success">Identifikasi Masalah</h5>
                                        </div>
                                        <p class="mb-2">Sebelum membuat laporan, pastikan Anda telah mengidentifikasi masalah dengan jelas dan menyiapkan semua bukti pendukung.</p>
                                        <ul class="small text-muted">
                                            <li>Analisis jenis masalah yang ingin dilaporkan</li>
                                            <li>Kumpulkan bukti foto atau video yang relevan</li>
                                            <li>Catat lokasi dan waktu kejadian secara detail</li>
                                            <li>Siapkan deskripsi yang jelas dan objektif</li>
                                            <li>Identifikasi pihak-pihak yang terlibat</li>
                                        </ul>
                                    </div>

                                    <div class="step-item mb-4 p-3 border-start border-4 border-info">
                                        <div class="step-header d-flex align-items-center mb-2">
                                            <div class="step-number bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                                <strong>3</strong>
                                            </div>
                                            <h5 class="mb-0 text-info">Pengisian Formulir</h5>
                                        </div>
                                        <p class="mb-2">Isi formulir laporan dengan data yang lengkap, akurat, dan mudah dipahami. Kualitas informasi menentukan kecepatan penanganan.</p>
                                        <ul class="small text-muted">
                                            <li>Pilih kategori laporan yang paling sesuai</li>
                                            <li>Berikan judul yang jelas dan deskriptif</li>
                                            <li>Tulis kronologi secara berurutan dan detail</li>
                                            <li>Sertakan lokasi spesifik dengan pin map</li>
                                            <li>Unggah bukti pendukung yang relevan</li>
                                            <li>Periksa kembali sebelum mengirim</li>
                                        </ul>
                                    </div>

                                    <div class="step-item p-3 border-start border-4 border-warning">
                                        <div class="step-header d-flex align-items-center mb-2">
                                            <div class="step-number bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                                <strong>4</strong>
                                            </div>
                                            <h5 class="mb-0 text-warning">Submit & Monitoring</h5>
                                        </div>
                                        <p class="mb-2">Setelah mengirim laporan, Anda dapat memantau perkembangannya melalui dashboard. Tim akan memberikan update secara berkala.</p>
                                        <ul class="small text-muted">
                                            <li>Simpan kode tracking dengan baik</li>
                                            <li>Pantau email untuk notifikasi terbaru</li>
                                            <li>Periksa dashboard secara berkala</li>
                                            <li>Beri tanggapan jika diminta tim</li>
                                            <li>Beri rating setelah laporan selesai</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="bg-light rounded p-4">
                                    <h6 class="text-primary"><i class="fas fa-tips me-2"></i>Tips Sukses Melapor</h6>
                                    <div class="small">
                                        <div class="mb-3">
                                            <strong class="text-success">Gunakan Bahasa yang Sopan</strong>
                                            <p class="mb-1">Sampaikan laporan dengan bahasa yang baik, jelas, dan mudah dipahami. Hindari kata-kata yang bersifat emosional atau menuduh.</p>
                                        </div>
                                        <div class="mb-3">
                                            <strong class="text-success">Sertakan Bukti Visual</strong>
                                            <p class="mb-1">Foto dan video merupakan bukti yang sangat membantu. Pastikan bukti visual jelas, relevan, dan mendukung deskripsi laporan.</p>
                                        </div>
                                        <div class="mb-3">
                                            <strong class="text-success">Berikan Informasi Kontak</strong>
                                            <p class="mb-1">Pastikan informasi kontak yang diberikan aktif untuk memudahkan koordinasi lebih lanjut jika diperlukan.</p>
                                        </div>
                                        <div class="mb-3">
                                            <strong class="text-success">Bersabarlah Menunggu</strong>
                                            <p class="mb-1">Proses penanganan membutuhkan waktu. Tim kami bekerja secepat mungkin untuk menyelesaikan setiap laporan.</p>
                                        </div>
                                    </div>

                                    <h6 class="text-primary mt-4"><i class="fas fa-exclamation-triangle me-2"></i>Yang Perlu Dihindari</h6>
                                    <ul class="small text-muted">
                                        <li>Jangan memberikan informasi yang tidak akurat</li>
                                        <li>Hindari laporan yang bersifat fitnah atau hoax</li>
                                        <li>Jangan mengulangi laporan yang sama berkali-kali</li>
                                        <li>Hindari kata-kata kasar atau tidak pantas</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3 -->
            <div id="section3" class="edu-section">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i>Pentingnya Melaporkan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <p class="lead">Melaporkan masalah bukan hanya tentang menyelesaikan persoalan individu, tetapi merupakan bentuk partisipasi aktif dalam membangun masyarakat yang lebih baik.</p>

                                <h5 class="text-primary mt-4">Dampak Positif bagi Masyarakat</h5>

                                <div class="impact-item mb-4 p-3 bg-light rounded">
                                    <h6 class="text-primary"><i class="fas fa-sync-alt me-2"></i>Mendorong Perubahan Sistemik</h6>
                                    <p class="mb-2">Setiap laporan yang terkumpul menjadi data berharga untuk analisis pola masalah. Data ini digunakan oleh pemerintah dan institusi terkait untuk:</p>
                                    <ul class="small text-muted">
                                        <li>Mengidentifikasi area prioritas yang membutuhkan perbaikan</li>
                                        <li>Menyusun kebijakan yang lebih efektif dan tepat sasaran</li>
                                        <li>Mengalokasikan anggaran secara lebih efisien</li>
                                        <li>Meningkatkan kualitas layanan publik secara menyeluruh</li>
                                        <li>Mengembangkan program pencegahan masalah di masa depan</li>
                                    </ul>
                                </div>

                                <div class="impact-item mb-4 p-3 bg-light rounded">
                                    <h6 class="text-success"><i class="fas fa-shield-alt me-2"></i>Perlindungan Komunitas</h6>
                                    <p class="mb-2">Dengan melaporkan masalah, Anda secara aktif melindungi anggota masyarakat lainnya dari mengalami hal serupa. Tindakan preventif ini menciptakan:</p>
                                    <ul class="small text-muted">
                                        <li>Sistem peringatan dini untuk potensi bahaya</li>
                                        <li>Peningkatan kewaspadaan kolektif masyarakat</li>
                                        <li>Pengurangan risiko berulang pada lokasi yang sama</li>
                                        <li>Lingkungan yang lebih aman dan nyaman untuk semua</li>
                                        <li>Budaya saling melindungi dalam komunitas</li>
                                    </ul>
                                </div>

                                <div class="impact-item mb-4 p-3 bg-light rounded">
                                    <h6 class="text-info"><i class="fas fa-users me-2"></i>Pemberdayaan Masyarakat</h6>
                                    <p class="mb-2">Budaya melapor yang sehat menciptakan masyarakat yang proaktif dan peduli. Setiap individu merasa memiliki tanggung jawab untuk:</p>
                                    <ul class="small text-muted">
                                        <li>Berkontribusi aktif dalam perbaikan lingkungan</li>
                                        <li>Mengawasi kualitas layanan publik</li>
                                        <li>Mendorong transparansi dalam pemerintahan</li>
                                        <li>Membangun komunitas yang responsif dan solutif</li>
                                        <li>Menjadi agen perubahan di lingkungannya</li>
                                    </ul>
                                </div>

                                <div class="impact-item p-3 bg-light rounded">
                                    <h6 class="text-warning"><i class="fas fa-balance-scale me-2"></i>Akuntabilitas & Transparansi</h6>
                                    <p class="mb-2">Sistem pelaporan yang baik mendorong semua pihak untuk bertanggung jawab atas tindakan mereka. Hal ini menghasilkan:</p>
                                    <ul class="small text-muted">
                                        <li>Peningkatan kualitas kinerja institusi publik</li>
                                        <li>Mekanisme pengawasan yang lebih efektif</li>
                                        <li>Standar layanan yang terukur dan dapat dievaluasi</li>
                                        <li>Kepercayaan masyarakat yang semakin meningkat</li>
                                        <li>Tata kelola yang lebih baik dan akuntabel</li>
                                    </ul>
                                </div>

                                <h5 class="text-primary mt-4">Tanggung Jawab Sosial Kita</h5>
                                <p>Sebagai anggota masyarakat, kita memiliki tanggung jawab moral untuk turut serta dalam menciptakan lingkungan yang lebih baik. Melaporkan masalah adalah bentuk nyata dari tanggung jawab sosial tersebut. Setiap laporan yang Anda buat tidak hanya menyelesaikan masalah individu, tetapi juga berkontribusi pada perbaikan sistem secara keseluruhan.</p>

                                <p>Bayangkan jika setiap orang memiliki kesadaran untuk melaporkan masalah yang ditemui. Kita akan memiliki data yang lengkap untuk memahami pola masalah, mengidentifikasi akar penyebab, dan mengembangkan solusi yang berkelanjutan. Inilah kekuatan kolaborasi dalam membangun masyarakat yang lebih baik.</p>
                            </div>
                            <div class="col-lg-4">
                                <div class="bg-primary text-white rounded p-4 mb-4">
                                    <h6><i class="fas fa-quote-left me-2"></i>Pesan Penting</h6>
                                    <p class="small mb-0">"Jangan pernah meremehkan kekuatan satu laporan. Setiap suara yang disampaikan dengan benar dapat memicu perubahan besar bagi banyak orang."</p>
                                </div>

                                <div class="bg-light rounded p-4">
                                    <h6 class="text-primary"><i class="fas fa-chart-pie me-2"></i>Data Statistik</h6>
                                    <div class="small">
                                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 border-bottom">
                                            <span>Laporan Terlayani</span>
                                            <span class="fw-bold text-primary">10,000+</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 border-bottom">
                                            <span>Masalah Terselesaikan</span>
                                            <span class="fw-bold text-success">8,500+</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 border-bottom">
                                            <span>Waktu Tanggap Rata-rata</span>
                                            <span class="fw-bold text-info">24 Jam</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center p-2">
                                            <span>Tingkat Kepuasan</span>
                                            <span class="fw-bold text-warning">95%</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-success text-white rounded p-4 mt-4">
                                    <h6><i class="fas fa-hands-helping me-2"></i>Dampak Kolektif</h6>
                                    <p class="small mb-0">Bersama-sama, kita telah membantu meningkatkan kualitas hidup di 150+ wilayah melalui laporan-laporan yang disampaikan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.nav-edu-btn {
    transition: all 0.3s ease;
    border: 2px solid;
    font-weight: 500;
}

.nav-edu-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.edu-section {
    display: none;
}

.edu-section.active {
    display: block;
    animation: fadeIn 0.5s ease-in;
}

.step-item {
    transition: all 0.3s ease;
}

.step-item:hover {
    background-color: #f8f9fa !important;
    transform: translateX(5px);
}

.impact-item {
    transition: all 0.3s ease;
}

.impact-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .nav-edu-btn {
        font-size: 0.9rem;
        padding: 0.75rem 0.5rem !important;
    }

    .step-header {
        flex-direction: column;
        text-align: center;
    }

    .step-number {
        margin-bottom: 10px;
        margin-right: 0 !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navButtons = document.querySelectorAll('.nav-edu-btn');
    const sections = document.querySelectorAll('.edu-section');

    // Function to switch sections
    function switchSection(targetId) {
        // Remove active class from all buttons and sections
        navButtons.forEach(btn => {
            btn.classList.remove('active', 'btn-primary');
            btn.classList.add('btn-outline-primary');
        });
        sections.forEach(section => section.classList.remove('active'));

        // Add active class to target button and section
        const targetButton = document.querySelector(`[data-target="${targetId}"]`);
        const targetSection = document.getElementById(targetId);

        if (targetButton && targetSection) {
            targetButton.classList.remove('btn-outline-primary');
            targetButton.classList.add('active', 'btn-primary');
            targetSection.classList.add('active');

            // Smooth scroll to section
            targetSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    // Add click event to navigation buttons
    navButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            switchSection(targetId);
        });
    });

    // Add intersection observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe elements for animation
    document.querySelectorAll('.step-item, .impact-item').forEach(item => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        item.style.transition = 'all 0.5s ease';
        observer.observe(item);
    });
});
</script>
@endsection
