@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Tambah Sarana Prasarana</h1>
            <p class="text-muted mb-0">Tambahkan lokasi baru atau item ke dalam sistem inventaris</p>
        </div>
        <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Alert Section -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Terjadi Kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-times-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Mode Selection -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <h5 class="fw-semibold mb-3">Pilih Jenis Tambah Data</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-check card-mode p-3 border rounded-3 mb-3" onclick="selectMode('item')">
                        <input class="form-check-input" type="radio" name="mode" id="modeItem" value="item" checked>
                        <label class="form-check-label w-100" for="modeItem">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-cube fa-2x text-primary me-3"></i>
                                <div>
                                    <h6 class="fw-semibold mb-1">Tambah Item Baru</h6>
                                    <p class="text-muted mb-0 small">Tambahkan item sarana prasarana baru</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check card-mode p-3 border rounded-3 mb-3" onclick="selectMode('lokasi')">
                        <input class="form-check-input" type="radio" name="mode" id="modeLokasi" value="lokasi">
                        <label class="form-check-label w-100" for="modeLokasi">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-map-marker-alt fa-2x text-success me-3"></i>
                                <div>
                                    <h6 class="fw-semibold mb-1">Tambah Lokasi Baru</h6>
                                    <p class="text-muted mb-0 small">Tambahkan lokasi baru dan pilih item yang ada</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Tambah Item -->
    <div class="card shadow-sm border-0" id="itemFormCard">
        <div class="card-header bg-light py-3">
            <h5 class="card-title mb-0">
                <i class="fas fa-cube me-2 text-primary"></i>
                Form Tambah Item
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data" id="itemForm">
                @csrf

                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <!-- Nama Item -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Nama Item <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-cube text-muted"></i>
                                </span>
                                <input type="text" name="nama_item"
                                       class="form-control @error('nama_item') is-invalid @enderror"
                                       value="{{ old('nama_item') }}"
                                       placeholder="Masukkan nama item" required>
                            </div>
                            @error('nama_item')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Lokasi - GANTI DENGAN TAGS INPUT -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Lokasi <span class="text-danger">*</span></label>

                            <!-- Input untuk mengetik lokasi baru -->
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" id="lokasiSearch" class="form-control"
                                       placeholder="Ketik nama lokasi, lalu pilih dari daftar">
                            </div>

                            <!-- Daftar lokasi yang bisa dipilih -->
                            <div id="lokasiResults" class="border rounded-2 bg-light p-2 mb-2" style="max-height: 150px; overflow-y: auto; display: none;">
                                <!-- Hasil pencarian akan muncul di sini -->
                            </div>

                            <!-- Lokasi yang sudah dipilih -->
                            <div id="selectedLokasiContainer" class="selected-tags-container">
                                @foreach(old('lokasi', []) as $selectedLokasiId)
                                    @php
                                        $selectedLokasi = $lokasis->firstWhere('id_lokasi', $selectedLokasiId);
                                    @endphp
                                    @if($selectedLokasi)
                                        <span class="selected-tag" data-id="{{ $selectedLokasi->id_lokasi }}">
                                            {{ $selectedLokasi->nama_lokasi }}
                                            <span class="remove-tag" onclick="removeLokasi({{ $selectedLokasi->id_lokasi }})">×</span>
                                        </span>
                                    @endif
                                @endforeach
                            </div>

                            <!-- Hidden input untuk menyimpan ID lokasi yang dipilih -->
                            <input type="hidden" name="lokasi[]" id="lokasiHidden" value="{{ implode(',', old('lokasi', [])) }}">

                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Ketik nama lokasi, lalu pilih dari daftar yang muncul
                            </div>
                            @error('lokasi')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Foto Upload -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Foto Item</label>
                            <div class="file-upload-area border rounded-3 p-4 text-center bg-light" onclick="document.getElementById('fotoInput').click()" style="cursor: pointer;">
                                <input type="file" name="foto" id="fotoInput"
                                       class="form-control @error('foto') is-invalid @enderror d-none"
                                       accept="image/*" onchange="previewImage(this)">
                                <div class="upload-content" id="uploadContent">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-3"></i>
                                    <h5 class="text-muted">Upload Foto Item</h5>
                                    <p class="text-muted small mb-2">Klik untuk memilih file atau seret file kesini</p>
                                    <span class="text-muted small">Format: JPG, PNG, GIF (Maks. 2MB)</span>
                                </div>
                                <div class="file-preview mt-3" id="filePreview"></div>
                            </div>
                            @error('foto')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                      rows="8" placeholder="Deskripsikan item secara detail" required>{{ old('deskripsi') }}</textarea>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-lightbulb me-1"></i>Deskripsi yang jelas membantu identifikasi
                                </small>
                                <small class="text-muted">
                                    <span id="charCount">0</span> karakter
                                </small>
                            </div>
                            @error('deskripsi')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                                <i class="fas fa-save me-2"></i>
                                <span class="btn-text">Simpan Item</span>
                                <div class="spinner-border spinner-border-sm d-none ms-2" id="btnSpinner"></div>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Form Tambah Lokasi -->
    <div class="card shadow-sm border-0" id="lokasiFormCard" style="display: none;">
        <div class="card-header bg-light py-3">
            <h5 class="card-title mb-0">
                <i class="fas fa-map-marker-alt me-2 text-success"></i>
                Form Tambah Lokasi
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.items.lokasi.store') }}" method="POST" id="lokasiForm">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <!-- Nama Lokasi -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Nama Lokasi <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-map-marker-alt text-muted"></i>
                                </span>
                                <input type="text" name="nama_lokasi"
                                       class="form-control @error('nama_lokasi') is-invalid @enderror"
                                       value="{{ old('nama_lokasi') }}"
                                       placeholder="Contoh: Lab Komputer, Perpustakaan, Ruang Guru" required>
                            </div>
                            @error('nama_lokasi')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Berikan nama lokasi yang jelas dan mudah dikenali
                            </div>
                        </div>

                        <!-- Pilih Item yang Sudah Ada - GANTI DENGAN TAGS INPUT -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Pilih Item yang Ada</label>

                            <!-- Input untuk mengetik item -->
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" id="itemSearch" class="form-control"
                                       placeholder="Ketik nama item, lalu pilih dari daftar">
                            </div>

                            <!-- Daftar item yang bisa dipilih -->
                            <div id="itemResults" class="border rounded-2 bg-light p-2 mb-2" style="max-height: 150px; overflow-y: auto; display: none;">
                                <!-- Hasil pencarian akan muncul di sini -->
                            </div>

                            <!-- Item yang sudah dipilih -->
                            <div id="selectedItemsContainer" class="selected-tags-container">
                                @foreach(old('items', []) as $selectedItemId)
                                    @php
                                        $selectedItem = $allItems->firstWhere('id_item', $selectedItemId);
                                    @endphp
                                    @if($selectedItem)
                                        <span class="selected-tag" data-id="{{ $selectedItem->id_item }}">
                                            {{ $selectedItem->nama_item }}
                                            <span class="remove-tag" onclick="removeItem({{ $selectedItem->id_item }})">×</span>
                                        </span>
                                    @endif
                                @endforeach
                            </div>

                            <!-- Hidden input untuk menyimpan ID item yang dipilih -->
                            <input type="hidden" name="items[]" id="itemsHidden" value="{{ implode(',', old('items', [])) }}">

                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Ketik nama item, lalu pilih dari daftar yang muncul (opsional)
                            </div>
                            @error('items')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Info Panel -->
                        <div class="alert alert-info">
                            <h6 class="alert-heading mb-2">
                                <i class="fas fa-lightbulb me-2"></i>Tips Menambah Lokasi
                            </h6>
                            <ul class="mb-0 small ps-3">
                                <li>Beri nama lokasi yang spesifik dan mudah dikenali</li>
                                <li>Anda bisa memilih item yang sudah ada untuk langsung ditempatkan di lokasi ini</li>
                                <li>Item yang belum memiliki lokasi akan ditandai "Belum ada lokasi"</li>
                                <li>Item bisa memiliki lebih dari satu lokasi</li>
                            </ul>
                        </div>

                        <!-- Statistik Item -->
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title mb-3">
                                    <i class="fas fa-chart-bar me-2"></i>Statistik Item
                                </h6>
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="border-end">
                                            <div class="h5 mb-1 text-primary">{{ $totalItems }}</div>
                                            <small class="text-muted">Total Item</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="h5 mb-1 text-success">{{ $itemsWithLocation }}</div>
                                        <small class="text-muted">Sudah Ada Lokasi</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-success px-4" id="submitLokasiBtn">
                                <i class="fas fa-plus me-2"></i>
                                <span class="btn-text">Tambah Lokasi</span>
                                <div class="spinner-border spinner-border-sm d-none ms-2" id="btnLokasiSpinner"></div>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Data dari PHP
const allLokasis = @json($lokasis);
const allItems = @json($allItems);

// CARA PALING SIMPLE - PASTI WORK
function selectMode(mode) {
    document.getElementById('modeItem').checked = (mode === 'item');
    document.getElementById('modeLokasi').checked = (mode === 'lokasi');

    if (mode === 'item') {
        document.getElementById('itemFormCard').style.display = 'block';
        document.getElementById('lokasiFormCard').style.display = 'none';
    } else {
        document.getElementById('itemFormCard').style.display = 'none';
        document.getElementById('lokasiFormCard').style.display = 'block';
    }
}

// SISTEM PENCARIAN LOKASI
function setupLokasiSearch() {
    const searchInput = document.getElementById('lokasiSearch');
    const resultsContainer = document.getElementById('lokasiResults');
    const selectedContainer = document.getElementById('selectedLokasiContainer');
    const hiddenInput = document.getElementById('lokasiHidden');

    let selectedLokasiIds = hiddenInput.value ? hiddenInput.value.split(',') : [];

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();

        if (searchTerm.length < 2) {
            resultsContainer.style.display = 'none';
            return;
        }

        // Filter lokasi berdasarkan pencarian
        const filteredLokasis = allLokasis.filter(lokasi =>
            lokasi.nama_lokasi.toLowerCase().includes(searchTerm) &&
            !selectedLokasiIds.includes(lokasi.id_lokasi.toString())
        );

        if (filteredLokasis.length > 0) {
            resultsContainer.innerHTML = filteredLokasis.map(lokasi => `
                <div class="search-result-item p-2 border-bottom cursor-pointer"
                     onclick="selectLokasi(${lokasi.id_lokasi}, '${lokasi.nama_lokasi.replace(/'/g, "\\'")}')">
                    <i class="fas fa-map-marker-alt text-success me-2"></i>
                    ${lokasi.nama_lokasi}
                </div>
            `).join('');
            resultsContainer.style.display = 'block';
        } else {
            resultsContainer.innerHTML = '<div class="p-2 text-muted">Tidak ada lokasi ditemukan</div>';
            resultsContainer.style.display = 'block';
        }
    });

    // Sembunyikan results ketika klik di luar
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
            resultsContainer.style.display = 'none';
        }
    });
}

// Pilih lokasi dari hasil pencarian
function selectLokasi(id, nama) {
    const selectedContainer = document.getElementById('selectedLokasiContainer');
    const hiddenInput = document.getElementById('lokasiHidden');
    const searchInput = document.getElementById('lokasiSearch');
    const resultsContainer = document.getElementById('lokasiResults');

    let selectedLokasiIds = hiddenInput.value ? hiddenInput.value.split(',') : [];

    if (!selectedLokasiIds.includes(id.toString())) {
        selectedLokasiIds.push(id);

        // Update hidden input
        hiddenInput.value = selectedLokasiIds.join(',');

        // Tambahkan tag yang dipilih
        const tag = document.createElement('span');
        tag.className = 'selected-tag';
        tag.setAttribute('data-id', id);
        tag.innerHTML = `${nama} <span class="remove-tag" onclick="removeLokasi(${id})">×</span>`;
        selectedContainer.appendChild(tag);

        // Reset pencarian
        searchInput.value = '';
        resultsContainer.style.display = 'none';
    }
}

// Hapus lokasi yang dipilih
function removeLokasi(id) {
    const hiddenInput = document.getElementById('lokasiHidden');
    let selectedLokasiIds = hiddenInput.value ? hiddenInput.value.split(',') : [];

    selectedLokasiIds = selectedLokasiIds.filter(lokasiId => lokasiId !== id.toString());
    hiddenInput.value = selectedLokasiIds.join(',');

    // Hapus tag dari UI
    const tag = document.querySelector(`.selected-tag[data-id="${id}"]`);
    if (tag) {
        tag.remove();
    }
}

// SISTEM PENCARIAN ITEM (sama seperti lokasi)
function setupItemSearch() {
    const searchInput = document.getElementById('itemSearch');
    const resultsContainer = document.getElementById('itemResults');
    const selectedContainer = document.getElementById('selectedItemsContainer');
    const hiddenInput = document.getElementById('itemsHidden');

    let selectedItemIds = hiddenInput.value ? hiddenInput.value.split(',') : [];

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();

        if (searchTerm.length < 2) {
            resultsContainer.style.display = 'none';
            return;
        }

        // Filter item berdasarkan pencarian
        const filteredItems = allItems.filter(item =>
            item.nama_item.toLowerCase().includes(searchTerm) &&
            !selectedItemIds.includes(item.id_item.toString())
        );

        if (filteredItems.length > 0) {
            resultsContainer.innerHTML = filteredItems.map(item => `
                <div class="search-result-item p-2 border-bottom cursor-pointer"
                     onclick="selectItem(${item.id_item}, '${item.nama_item.replace(/'/g, "\\'")}')">
                    <i class="fas fa-cube text-primary me-2"></i>
                    ${item.nama_item}
                </div>
            `).join('');
            resultsContainer.style.display = 'block';
        } else {
            resultsContainer.innerHTML = '<div class="p-2 text-muted">Tidak ada item ditemukan</div>';
            resultsContainer.style.display = 'block';
        }
    });

    // Sembunyikan results ketika klik di luar
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
            resultsContainer.style.display = 'none';
        }
    });
}

// Pilih item dari hasil pencarian
function selectItem(id, nama) {
    const selectedContainer = document.getElementById('selectedItemsContainer');
    const hiddenInput = document.getElementById('itemsHidden');
    const searchInput = document.getElementById('itemSearch');
    const resultsContainer = document.getElementById('itemResults');

    let selectedItemIds = hiddenInput.value ? hiddenInput.value.split(',') : [];

    if (!selectedItemIds.includes(id.toString())) {
        selectedItemIds.push(id);

        // Update hidden input
        hiddenInput.value = selectedItemIds.join(',');

        // Tambahkan tag yang dipilih
        const tag = document.createElement('span');
        tag.className = 'selected-tag';
        tag.setAttribute('data-id', id);
        tag.innerHTML = `${nama} <span class="remove-tag" onclick="removeItem(${id})">×</span>`;
        selectedContainer.appendChild(tag);

        // Reset pencarian
        searchInput.value = '';
        resultsContainer.style.display = 'none';
    }
}

// Hapus item yang dipilih
function removeItem(id) {
    const hiddenInput = document.getElementById('itemsHidden');
    let selectedItemIds = hiddenInput.value ? hiddenInput.value.split(',') : [];

    selectedItemIds = selectedItemIds.filter(itemId => itemId !== id.toString());
    hiddenInput.value = selectedItemIds.join(',');

    // Hapus tag dari UI
    const tag = document.querySelector(`.selected-tag[data-id="${id}"]`);
    if (tag) {
        tag.remove();
    }
}

// Fungsi lainnya tetap sama
function previewImage(input) {
    const file = input.files[0];
    const preview = document.getElementById('filePreview');
    const uploadContent = document.getElementById('uploadContent');

    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            preview.innerHTML = '<div class="alert alert-danger py-2">Ukuran file terlalu besar. Maksimal 2MB</div>';
            return;
        }

        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            preview.innerHTML = '<div class="alert alert-danger py-2">Format file tidak didukung. Gunakan JPG, PNG, atau GIF</div>';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            uploadContent.style.display = 'none';
            preview.innerHTML = `
                <div class="text-center">
                    <img src="${e.target.result}" class="preview-image mb-2" alt="Preview" style="max-width: 200px; max-height: 150px; border-radius: 8px;">
                    <div class="text-muted small">${file.name} (${(file.size / 1024).toFixed(1)} KB)</div>
                    <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="removeImage()">
                        <i class="fas fa-times me-1"></i>Hapus
                    </button>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    document.getElementById('fotoInput').value = '';
    document.getElementById('uploadContent').style.display = 'block';
    document.getElementById('filePreview').innerHTML = '';
}

function setupCharacterCounter() {
    const textarea = document.querySelector('textarea[name="deskripsi"]');
    const charCount = document.getElementById('charCount');

    if (textarea && charCount) {
        textarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
        textarea.dispatchEvent(new Event('input'));
    }
}

// Initialize everything
document.addEventListener('DOMContentLoaded', function() {
    selectMode('item');
    setupLokasiSearch();
    setupItemSearch();
    setupCharacterCounter();

    document.getElementById('itemForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.querySelector('.btn-text').textContent = 'Menyimpan...';
    });

    document.getElementById('lokasiForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitLokasiBtn');
        btn.disabled = true;
        btn.querySelector('.btn-text').textContent = 'Menambah...';
    });
});
</script>

<style>
/* Style untuk sistem tags manual */
.selected-tags-container {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 8px;
}

.selected-tag {
    background-color: #31326F;
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.remove-tag {
    cursor: pointer;
    font-weight: bold;
    font-size: 1.1rem;
    line-height: 1;
    padding: 0 2px;
}

.remove-tag:hover {
    color: #ffeb3b;
}

.search-result-item {
    cursor: pointer;
    transition: background-color 0.2s;
}

.search-result-item:hover {
    background-color: #e9ecef;
}

.cursor-pointer {
    cursor: pointer;
}

/* Style lainnya tetap sama */
.file-upload-area {
    border: 2px dashed #d1d5db;
    transition: all 0.3s ease;
    min-height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.file-upload-area:hover {
    border-color: #31326F;
    background-color: #f8fafc;
}

.preview-image {
    max-width: 200px;
    max-height: 150px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.card-mode {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent !important;
}

.card-mode:hover {
    border-color: #31326F !important;
    background-color: #EFF2F8;
}

.form-check-input:checked + .form-check-label .card-mode {
    border-color: #31326F !important;
    background-color: #EFF2F8;
}
</style>

@endsection
