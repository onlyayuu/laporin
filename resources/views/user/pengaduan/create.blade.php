<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Pengaduan Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4bb543;
            --warning: #ffc107;
            --danger: #dc3545;
            --radius: 12px;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .pengaduan-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header-section {
            background: white;
            border-radius: var(--radius);
            padding: 25px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
            animation: fadeInDown 0.8s ease;
        }

        .header-section h1 {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 5px;
        }

        .header-section p {
            color: #6c757d;
            margin-bottom: 0;
        }

        .btn-back {
            background: var(--light);
            color: var(--dark);
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            font-weight: 500;
            transition: var(--transition);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .btn-back:hover {
            background: #e9ecef;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-back i {
            margin-right: 8px;
        }

        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
        }

        .step-indicator::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 4px;
            background: #e9ecef;
            z-index: 1;
        }

        .step {
            position: relative;
            z-index: 2;
            text-align: center;
            flex: 1;
        }

        .step-circle {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: white;
            border: 4px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-weight: 600;
            color: #6c757d;
            transition: var(--transition);
            position: relative;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .step.active .step-circle {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
            transform: scale(1.1);
        }

        .step.completed .step-circle {
            background: var(--success);
            border-color: var(--success);
            color: white;
        }

        .step.completed .step-circle::after {
            content: '✓';
            font-weight: bold;
        }

        .step-label {
            font-size: 14px;
            font-weight: 500;
            color: #6c757d;
            transition: var(--transition);
        }

        .step.active .step-label {
            color: var(--primary);
            font-weight: 600;
        }

        .step-content {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .step-content.active {
            display: block;
        }

        .form-card {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 30px;
            margin-bottom: 25px;
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .form-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .form-card h3 {
            color: var(--primary);
            margin-bottom: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .form-card h3 i {
            margin-right: 10px;
            background: rgba(67, 97, 238, 0.1);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #495057;
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e1e5eb;
            transition: var(--transition);
            box-shadow: none;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 500;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }

        .btn-primary:hover {
            background: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .image-preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .image-preview {
            position: relative;
            width: 150px;
            height: 150px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .image-preview:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(220, 53, 69, 0.8);
            color: white;
            border: none;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .remove-image:hover {
            background: var(--danger);
            transform: scale(1.1);
        }

        .upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            background: #f8f9fa;
        }

        .upload-area:hover {
            border-color: var(--primary);
            background: rgba(67, 97, 238, 0.03);
        }

        .upload-area i {
            font-size: 48px;
            color: #6c757d;
            margin-bottom: 15px;
            transition: var(--transition);
        }

        .upload-area:hover i {
            color: var(--primary);
        }

        .upload-text {
            color: #6c757d;
            margin-bottom: 5px;
        }

        .upload-hint {
            font-size: 14px;
            color: #adb5bd;
        }

        .alert-info {
            background: rgba(76, 201, 240, 0.1);
            border: 1px solid rgba(76, 201, 240, 0.3);
            border-radius: 10px;
            color: #0c5460;
        }

        .manual-input-card {
            background: #f8f9fa !important;
            border: 1px dashed #dee2e6;
        }

        .error-message {
            color: var(--danger);
            font-size: 0.875rem;
            margin-top: 5px;
            display: none;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .step-indicator {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 20px;
            }

            .step-indicator::before {
                display: none;
            }

            .step {
                display: flex;
                align-items: center;
                margin-bottom: 15px;
                width: 100%;
            }

            .step-circle {
                margin: 0 15px 0 0;
                flex-shrink: 0;
            }

            .navigation-buttons {
                flex-direction: column;
                gap: 10px;
            }

            .navigation-buttons button {
                width: 100%;
            }

            .image-preview {
                width: 120px;
                height: 120px;
            }
        }
    </style>
</head>
<body>
    <div class="pengaduan-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h1>Ajukan Pengaduan Baru</h1>
                    <p>Laporkan masalah yang Anda temukan dengan mudah</p>
                </div>
                <a href="{{ route('user.pengaduan.index') }}" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Step Indicator -->
        <div class="step-indicator">
            <div class="step active" data-step="1">
                <div class="step-circle">1</div>
                <div class="step-label">Informasi Pengaduan</div>
            </div>
            <div class="step" data-step="2">
                <div class="step-circle">2</div>
                <div class="step-label">Lokasi & Barang</div>
            </div>
            <div class="step" data-step="3">
                <div class="step-circle">3</div>
                <div class="step-label">Unggah Gambar</div>
            </div>
        </div>

        <form action="{{ route('user.pengaduan.store') }}" method="POST" id="pengaduanForm" enctype="multipart/form-data">
            @csrf

            <!-- Step 1: Informasi Pengaduan -->
            <div class="step-content active" id="step1">
                <div class="form-card">
                    <h3><i class="fas fa-info-circle"></i> Informasi Pengaduan</h3>
                    <div class="mb-3">
                        <label class="form-label">Judul Pengaduan</label>
                        <input type="text" name="nama_pengaduan" class="form-control" placeholder="Masukkan judul pengaduan" required>
                        <div class="error-message" id="judulError">Harap masukkan judul pengaduan</div>
                        <div class="form-text">Buat judul yang jelas dan deskriptif tentang masalah Anda.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Masalah</label>
                        <textarea name="deskripsi" class="form-control" rows="6" placeholder="Jelaskan masalah yang Anda temukan secara detail..." required></textarea>
                        <div class="error-message" id="deskripsiError">Harap masukkan deskripsi masalah</div>
                        <div class="form-text">Jelaskan dengan jelas apa masalahnya, kapan pertama kali terjadi, dan bagaimana masalah tersebut mempengaruhi.</div>
                    </div>
                </div>
                <div class="navigation-buttons">
                    <div></div>
                    <button type="button" class="btn btn-primary" onclick="nextStep(1)">Lanjut <i class="fas fa-arrow-right ms-2"></i></button>
                </div>
            </div>

            <!-- Step 2: Lokasi & Barang -->
            <div class="step-content" id="step2">
                <div class="form-card">
                    <h3><i class="fas fa-map-marker-alt"></i> Lokasi & Barang</h3>

                    <!-- SISTEM LOKASI & BARANG YANG SAMA PERSIS -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pilih Lokasi</label>
                        <select name="id_lokasi" class="form-control" id="selectLokasi" required>
                            <option value="">- Pilih Lokasi -</option>
                            @foreach($lokasis as $lokasi)
                                <option value="{{ $lokasi->id_lokasi }}">
                                    {{ $lokasi->nama_lokasi }}
                                </option>
                            @endforeach
                        </select>
                                <div class="error-message" id="lokasiError">Harap pilih lokasi</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pilih Barang</label>
                        <select name="id_item" class="form-control" id="selectItem" required>
                            <option value="">- Pilih Barang -</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id_item }}" data-lokasi="{{ $item->listLokasi->pluck('id_lokasi')->implode(',') }}">
                                    {{ $item->nama_item }}
                                </option>
                            @endforeach
                        </select>
                                <div class="error-message" id="barangError">Harap pilih barang</div>
                                <small class="text-muted">
                                    Jika barang tidak ada di list,
                                    <a href="javascript:void(0)" id="btnManualTemporary" class="text-primary">klik di sini untuk input manual</a>
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- INPUT BARANG BARU YANG SAMA PERSIS -->
                    <div class="mb-3">
                        <label class="form-label">Input Barang Baru</label>
                        <div class="card manual-input-card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Nama Barang Baru</label>
                                    <input type="text" name="nama_barang_baru" class="form-control" id="inputBarangBaru"
                                           placeholder="Masukkan nama barang jika tidak ada di list" disabled>
                                    <div class="error-message" id="barangBaruError">Harap masukkan nama barang baru</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Lokasi Barang Baru</label>
                                    <input type="text" name="lokasi_barang_baru" class="form-control" id="inputLokasiBaru"
                                           placeholder="Masukkan lokasi barang baru" disabled>
                                    <small class="text-muted">Kosongkan jika menggunakan lokasi yang dipilih di atas</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info" id="infoTemporary" style="display: none;">
                        <i class="fas fa-info-circle"></i> Barang baru akan diajukan sebagai usulan dan perlu persetujuan admin.
                    </div>
                </div>
                <div class="navigation-buttons">
                    <button type="button" class="btn btn-outline-primary" onclick="prevStep(2)"><i class="fas fa-arrow-left me-2"></i> Kembali</button>
                    <button type="button" class="btn btn-primary" onclick="nextStep(2)">Lanjut <i class="fas fa-arrow-right ms-2"></i></button>
                </div>
            </div>

            <!-- Step 3: Unggah Gambar -->
<div class="step-content" id="step3">
    <div class="form-card">
        <h3><i class="fas fa-camera"></i> Unggah Gambar</h3>
        <div class="mb-3">
            <label class="form-label">Unggah Foto Pendukung</label>
            <div class="upload-area" id="uploadArea">
                <i class="fas fa-cloud-upload-alt"></i>
                <p class="upload-text">Klik atau seret gambar ke sini</p>
                <p class="upload-hint">Format yang didukung: JPG, PNG, GIF (Maks. 5MB)</p>
                <!-- UBAH NAME DARI images[] MENJADI foto -->
                <input type="file" id="fileInput" name="foto" accept="image/*" style="display: none;">
            </div>
            <div class="error-message" id="gambarError">Harap unggah minimal satu foto pendukung</div>
            @error('foto')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="image-preview-container" id="imagePreviewContainer">
            <!-- Gambar yang diunggah akan muncul di sini -->
        </div>
    </div>
    <div class="navigation-buttons">
        <button type="button" class="btn btn-outline-primary" onclick="prevStep(3)"><i class="fas fa-arrow-left me-2"></i> Kembali</button>
        <button type="submit" class="btn btn-primary" id="submitBtn">
            <i class="fas fa-paper-plane me-2"></i> Ajukan Pengaduan
        </button>
    </div>
</div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectLokasi = document.getElementById('selectLokasi');
        const selectItem = document.getElementById('selectItem');
        const submitBtn = document.getElementById('submitBtn');
        const form = document.getElementById('pengaduanForm');
        const inputBarangBaru = document.getElementById('inputBarangBaru');
        const inputLokasiBaru = document.getElementById('inputLokasiBaru');
        const infoTemporary = document.getElementById('infoTemporary');
        const btnManualTemporary = document.getElementById('btnManualTemporary');

        // Mode temporary item
        let isTemporaryMode = false;

        // Simpan semua data barang untuk filtering
        const allItems = [];
        @foreach($items as $item)
            @php
                $lokasiIds = $item->listLokasi->pluck('id_lokasi')->toArray();
                $lokasiString = !empty($lokasiIds) ? implode(',', $lokasiIds) : '';
            @endphp
            allItems.push({
                id: {{ $item->id_item }},
                name: "{{ $item->nama_item }}",
                locations: [{{ $lokasiString }}]
            });
        @endforeach

        // FUNGSI UNTUK AKTIFKAN TEMPORARY MODE
        function activateTemporaryMode() {
            if (!selectLokasi.value) {
                showError('lokasiError', 'Pilih lokasi terlebih dahulu!');
                return false;
            }

            console.log('Aktifkan manual temporary mode');
            isTemporaryMode = true;
            inputBarangBaru.disabled = false;
            inputBarangBaru.required = true;
            inputLokasiBaru.disabled = false;
            selectItem.disabled = true;
            selectItem.required = false;
            infoTemporary.style.display = 'block';

            // Auto-fill lokasi barang baru
            const selectedLokasiText = selectLokasi.options[selectLokasi.selectedIndex].text;
            inputLokasiBaru.value = selectedLokasiText;

            // Focus ke input barang baru
            inputBarangBaru.focus();

            updateStep2Button();
            return true;
        }

        // FUNGSI UNTUK NONAKTIFKAN TEMPORARY MODE
        function deactivateTemporaryMode() {
            console.log('Nonaktifkan temporary mode');
            isTemporaryMode = false;
            inputBarangBaru.disabled = true;
            inputBarangBaru.required = false;
            inputLokasiBaru.disabled = true;
            inputLokasiBaru.required = false;
            selectItem.disabled = false;
            selectItem.required = true;
            infoTemporary.style.display = 'none';

            // Clear input temporary
            inputBarangBaru.value = '';
            inputLokasiBaru.value = '';

            updateStep2Button();
        }

        // Toggle mode temporary item otomatis
        function toggleTemporaryMode() {
            const availableOptions = selectItem.querySelectorAll('option[value!=""]');
            const hasValidItems = availableOptions.length > 0 &&
                                 !availableOptions[0].textContent.includes('Tidak ada barang');

            if (!hasValidItems && selectLokasi.value) {
                // Auto aktifkan temporary mode jika benar-benar tidak ada barang
                activateTemporaryMode();
            } else {
                // Nonaktifkan temporary mode jika ada barang
                deactivateTemporaryMode();
            }
        }

        // Filter barang berdasarkan lokasi
        function filterItemsByLokasi(lokasiId) {
            // Reset semua opsi barang (kecuali opsi default)
            const defaultOption = selectItem.querySelector('option[value=""]');
            selectItem.innerHTML = '';
            if (defaultOption) selectItem.appendChild(defaultOption);

            if (lokasiId) {
                // Filter barang yang tersedia di lokasi ini
                const filteredItems = allItems.filter(item => {
                    return item.locations[0] !== '' && item.locations.includes(parseInt(lokasiId));
                });

                if (filteredItems.length > 0) {
                    filteredItems.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.name;
                        option.setAttribute('data-lokasi', item.locations.join(','));
                        selectItem.appendChild(option);
                    });
                } else {
                    // Tidak ada barang di lokasi ini
                    const noItemOption = document.createElement('option');
                    noItemOption.value = "";
                    noItemOption.textContent = "- Tidak ada barang di lokasi ini -";
                    selectItem.appendChild(noItemOption);
                }
            } else {
                // Tampilkan semua barang jika tidak ada lokasi dipilih
                allItems.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;
                    option.setAttribute('data-lokasi', item.locations.join(','));
                    selectItem.appendChild(option);
                });
            }

            toggleTemporaryMode();
            updateStep2Button();
        }

        // Update button state untuk step 2
        function updateStep2Button() {
            const nextButtonStep2 = document.querySelector('#step2 .btn-primary');
            const isValid = validateStep(2);

            if (nextButtonStep2) {
                nextButtonStep2.disabled = !isValid;
            }
        }

        // Update button state untuk step 3
        function updateStep3Button() {
            const submitButton = document.getElementById('submitBtn');
            const isValid = validateStep(3);

            if (submitButton) {
                submitButton.disabled = !isValid;
            }
        }

        // Event listener untuk perubahan lokasi
        selectLokasi.addEventListener('change', function() {
            console.log('Lokasi dipilih:', this.value);
            hideError('lokasiError');
            filterItemsByLokasi(this.value);
        });

        // Event listener untuk perubahan barang
        selectItem.addEventListener('change', function() {
            console.log('Barang dipilih:', this.value);
            hideError('barangError');
            updateStep2Button();
        });

        // Event listener untuk manual temporary mode
        btnManualTemporary.addEventListener('click', function() {
            activateTemporaryMode();
        });

        // Event listener untuk input temporary
        inputBarangBaru.addEventListener('input', function() {
            hideError('barangBaruError');
            updateStep2Button();
        });

        inputLokasiBaru.addEventListener('input', updateStep2Button);

        // Event listener untuk input text di step 1
        document.querySelector('input[name="nama_pengaduan"]').addEventListener('input', function() {
            hideError('judulError');
            updateStep1Button();
        });
        document.querySelector('textarea[name="deskripsi"]').addEventListener('input', function() {
            hideError('deskripsiError');
            updateStep1Button();
        });

        // Update button state untuk step 1
        function updateStep1Button() {
            const nextButtonStep1 = document.querySelector('#step1 .btn-primary');
            const isValid = validateStep(1);

            if (nextButtonStep1) {
                nextButtonStep1.disabled = !isValid;
            }
        }

        // Validasi form sebelum submit
        form.addEventListener('submit', function(e) {
            console.log('Form submitted, mode:', isTemporaryMode ? 'Temporary' : 'Normal');
            if (!validateStep(3)) {
                e.preventDefault();
                // Tidak ada alert lagi di sini
            }
        });

        // Inisialisasi awal - tampilkan semua barang
        filterItemsByLokasi('');
        updateStep1Button();
    });

    // FUNGSI UNTUK MENAMPILKAN DAN MENYEMBUNYIKAN ERROR
    function showError(elementId, message) {
        const errorElement = document.getElementById(elementId);
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
    }

    function hideError(elementId) {
        const errorElement = document.getElementById(elementId);
        if (errorElement) {
            errorElement.style.display = 'none';
        }
    }

    // FUNGSI STEP NAVIGATION
    function goToStep(step) {
        // Sembunyikan semua step
        document.querySelectorAll('.step-content').forEach(content => {
            content.classList.remove('active');
        });

        // Tampilkan step yang dipilih
        document.getElementById(`step${step}`).classList.add('active');

        // Update step indicator
        document.querySelectorAll('.step').forEach((stepEl, index) => {
            if (index + 1 <= step) {
                stepEl.classList.add('active');
                if (index + 1 < step) {
                    stepEl.classList.add('completed');
                } else {
                    stepEl.classList.remove('completed');
                }
            } else {
                stepEl.classList.remove('active');
                stepEl.classList.remove('completed');
            }
        });
    }

    function nextStep(currentStep) {
        // Validasi step saat ini sebelum lanjut
        if (validateStep(currentStep)) {
            goToStep(currentStep + 1);

            // Update button state untuk step berikutnya
            if (currentStep + 1 === 2) {
                setTimeout(updateStep2Button, 100);
            } else if (currentStep + 1 === 3) {
                setTimeout(updateStep3Button, 100);
            }
        }
    }

    function prevStep(currentStep) {
        goToStep(currentStep - 1);
    }

    // Validasi step - VERSI TANPA ALERT
    function validateStep(step) {
        let isValid = true;

        // Sembunyikan semua error message terlebih dahulu
        document.querySelectorAll('.error-message').forEach(error => {
            error.style.display = 'none';
        });

        switch(step) {
            case 1:
                const judul = document.querySelector('input[name="nama_pengaduan"]').value.trim();
                const deskripsi = document.querySelector('textarea[name="deskripsi"]').value.trim();

                if (!judul) {
                    showError('judulError', 'Harap masukkan judul pengaduan');
                    isValid = false;
                }

                if (!deskripsi) {
                    showError('deskripsiError', 'Harap masukkan deskripsi masalah');
                    isValid = false;
                }

                return isValid;

            case 2:
                const lokasi = document.getElementById('selectLokasi').value;
                const barang = document.getElementById('selectItem').value;
                const namaBarangBaru = document.getElementById('inputBarangBaru').value.trim();

                if (!lokasi) {
                    showError('lokasiError', 'Harap pilih lokasi');
                    isValid = false;
                }

                // Jika mode temporary aktif, validasi input manual
                if (document.getElementById('selectItem').disabled) {
                    if (!namaBarangBaru) {
                        showError('barangBaruError', 'Harap masukkan nama barang baru');
                        isValid = false;
                    }
                } else {
                    // Mode normal, validasi pilihan barang
                    if (!barang) {
                        showError('barangError', 'Harap pilih barang');
                        isValid = false;
                    }
                }

                return isValid;

            case 3:
                // Untuk step 3, hanya perlu pastikan ada gambar
                const fileInput = document.getElementById('fileInput');
                const imagePreviewContainer = document.getElementById('imagePreviewContainer');

                // Cek apakah ada gambar yang sudah diupload
                const hasImages = imagePreviewContainer.children.length > 0;

                if (!hasImages) {
                    showError('gambarError', 'Harap unggah minimal satu foto pendukung');
                    isValid = false;
                }

                return isValid;

            default:
                return true;
        }
    }

    // EVENT LISTENER UNTUK UPLOAD GAMBAR
    document.getElementById('uploadArea').addEventListener('click', function() {
        document.getElementById('fileInput').click();
    });

    document.getElementById('fileInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const previewContainer = document.getElementById('imagePreviewContainer');

        // Clear previous preview
        previewContainer.innerHTML = '';

        if (!file) return;

        // Validasi tipe file
        if (!file.type.match('image.*')) {
            showError('gambarError', 'Hanya file gambar yang diizinkan');
            return;
        }

        // Validasi ukuran file (maks 5MB)
        if (file.size > 5 * 1024 * 1024) {
            showError('gambarError', 'Ukuran file maksimal 5MB');
            return;
        }

        hideError('gambarError');

        const reader = new FileReader();

        reader.onload = function(e) {
            const preview = document.createElement('div');
            preview.className = 'image-preview';

            const img = document.createElement('img');
            img.src = e.target.result;

            const removeBtn = document.createElement('button');
            removeBtn.className = 'remove-image';
            removeBtn.innerHTML = '<i class="fas fa-times"></i>';
            removeBtn.addEventListener('click', function() {
                preview.remove();
                // Reset file input juga
                document.getElementById('fileInput').value = '';
                // Update button state
                updateStep3Button();
            });

            preview.appendChild(img);
            preview.appendChild(removeBtn);
            previewContainer.appendChild(preview);

            // Update button state setelah upload gambar
            updateStep3Button();
        };

        reader.readAsDataURL(file);
    });

    // Fungsi untuk update button step 3
    function updateStep3Button() {
        const submitButton = document.getElementById('submitBtn');
        const isValid = validateStep(3);

        if (submitButton) {
            submitButton.disabled = !isValid;
        }
    }

    // Inisialisasi step
    goToStep(1);
</script>
</body>
</html>
