@extends('layouts.admin')

@section('content')
<div class="dashboard-container">
    <!-- HEADER -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-edit me-2"></i>
                Edit Item Sarana Prasarana
            </h1>
            <p class="page-subtitle">Perbarui informasi item {{ $item->nama_item }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.items.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- ALERTS -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- EDIT FORM -->
    <div class="content-card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-pencil-alt me-2"></i>
                Form Edit Item
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.items.update', $item->id_item) }}" method="POST" enctype="multipart/form-data" id="editItemForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- KOLOM KIRI - FORM INPUT -->
                    <div class="col-md-8">
                        <div class="form-section">
                            <h4 class="section-title">Informasi Item</h4>

                            <!-- NAMA ITEM -->
                            <div class="form-group">
                                <label for="nama_item" class="form-label">Nama Item *</label>
                                <input type="text" class="form-control" id="nama_item" name="nama_item"
                                       value="{{ old('nama_item', $item->nama_item) }}" required
                                       placeholder="Masukkan nama item...">
                                <div class="form-text">Nama item harus unik dan deskriptif</div>
                            </div>

                            <!-- DESKRIPSI -->
                            <div class="form-group">
                                <label for="deskripsi" class="form-label">Deskripsi *</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5"
                                          required placeholder="Masukkan deskripsi lengkap item...">{{ old('deskripsi', $item->deskripsi) }}</textarea>
                                <div class="form-text d-flex justify-content-between">
                                    <span>Jelaskan kondisi, spesifikasi, dan detail item</span>
                                    <span id="charCount">0/1000 karakter</span>
                                </div>
                            </div>

                            <!-- FOTO -->
                            <div class="form-group">
                                <label for="foto" class="form-label">Foto Item</label>
                                <div class="file-upload-container">
                                    <input type="file" class="form-control" id="foto" name="foto"
                                           accept="image/*" onchange="previewImage(this)">
                                    <div class="form-text">Format: JPG, PNG, GIF (Maks. 2MB)</div>
                                </div>

                                <!-- PREVIEW FOTO -->
                                <div class="image-preview-container mt-3" id="imagePreview"
                                     style="{{ $item->foto ? '' : 'display: none;' }}">
                                    <div class="preview-header">
                                        <span class="preview-title">Preview Foto</span>
                                        <button type="button" class="btn-remove-image" onclick="removeImage()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="preview-image">
                                        @if($item->foto)
                                            <img src="{{ Storage::disk('public')->url($item->foto) }}"
                                                 alt="Preview" id="previewImage">
                                        @else
                                            <img src="" alt="Preview" id="previewImage">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KOLOM KANAN - LOKASI & ACTIONS -->
                    <div class="col-md-4">
                        <!-- LOKASI DENGAN SEARCH -->
                        <div class="form-section">
                            <h4 class="section-title">Lokasi Item *</h4>
                            <div class="location-search-container">
                                <div class="search-box">
                                    <i class="fas fa-search search-icon"></i>
                                    <input type="text" class="form-control search-input"
                                           id="lokasiSearch" placeholder="Cari lokasi...">
                                    <button type="button" class="search-clear" id="clearSearch">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>

                                <div class="selected-locations-container">
                                    <label class="form-label">Lokasi Terpilih:</label>
                                    <div class="selected-locations" id="selectedLocations">
                                        @foreach($item->lokasis as $lokasi)
                                            <div class="selected-location-item" data-id="{{ $lokasi->id_lokasi }}">
                                                <span class="location-text">
                                                    <i class="fas fa-map-marker-alt me-1"></i>
                                                    {{ $lokasi->nama_lokasi }}
                                                </span>
                                                <button type="button" class="btn-remove-location"
                                                        onclick="removeLocation({{ $lokasi->id_lokasi }})">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <input type="hidden" name="lokasi[]" value="{{ $lokasi->id_lokasi }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="no-selection" id="noSelection"
                                         style="{{ $item->lokasis->count() > 0 ? 'display: none;' : '' }}">
                                        <i class="fas fa-info-circle"></i>
                                        Belum ada lokasi terpilih
                                    </div>
                                </div>

                                <div class="locations-list-container">
                                    <label class="form-label">Daftar Lokasi Tersedia:</label>
                                    <div class="locations-list" id="locationsList">
                                        @foreach($lokasis as $lokasi)
                                            <div class="location-item" data-id="{{ $lokasi->id_lokasi }}"
                                                 data-name="{{ strtolower($lokasi->nama_lokasi) }}"
                                                 onclick="selectLocation({{ $lokasi->id_lokasi }}, '{{ $lokasi->nama_lokasi }}')">
                                                <div class="location-info">
                                                    <i class="fas fa-map-marker-alt me-2"></i>
                                                    <span class="location-name">{{ $lokasi->nama_lokasi }}</span>
                                                    <span class="location-count">({{ $lokasi->items_count }} item)</span>
                                                </div>
                                                <div class="location-check">
                                                    <i class="fas fa-check"></i>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="no-results" id="noResults" style="display: none;">
                                        <i class="fas fa-search"></i>
                                        Tidak ada lokasi yang cocok
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ACTION BUTTONS -->
                        <div class="form-section">
                            <h4 class="section-title">Actions</h4>
                            <div class="action-buttons-vertical">
                                <button type="submit" class="btn btn-primary btn-save">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.items.show', $item->id_item) }}" class="btn btn-info">
                                    <i class="fas fa-eye me-2"></i>Lihat Detail
                                </a>
                                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                                    <i class="fas fa-trash me-2"></i>Hapus Item
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- DELETE FORM -->
            <form action="{{ route('admin.items.destroy', $item->id_item) }}" method="POST" id="deleteForm" class="d-none">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>

<style>
/* VARIABLES */
:root {
    --primary: #31326F;
    --secondary: #637AB9;
    --light-gray: #D9D9D9;
    --background: #EFF2F8;
    --white: #FFFFFF;
    --dark: #1E293B;
    --gray: #64748B;
    --border: #E2E8F0;
    --shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 4px 6px rgba(0, 0, 0, 0.05);
    --success: #10B981;
    --danger: #EF4444;
}

/* DASHBOARD LAYOUT */
.dashboard-container {
    padding: 0;
    background: var(--background);
    min-height: 100vh;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding: 2rem;
    background: var(--white);
    border-radius: 12px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
}

.header-content .page-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    color: var(--dark);
}

.header-content .page-subtitle {
    margin: 0;
    font-size: 0.9rem;
    color: var(--gray);
}

.header-actions {
    display: flex;
    gap: 0.5rem;
}

/* CONTENT CARD */
.content-card {
    background: var(--white);
    border-radius: 12px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    margin-bottom: 1.5rem;
}

.card-header {
    padding: 1.5rem 1.5rem 1rem;
    border-bottom: 1px solid var(--border);
}

.card-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--dark);
    margin: 0;
    display: flex;
    align-items: center;
}

.card-body {
    padding: 1.5rem;
}

/* FORM SECTIONS */
.form-section {
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--background);
    display: flex;
    align-items: center;
}

.section-title::before {
    content: '';
    width: 4px;
    height: 16px;
    background: var(--primary);
    margin-right: 0.5rem;
    border-radius: 2px;
}

/* FORM ELEMENTS */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--dark);
    font-size: 0.9rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--light-gray);
    border-radius: 8px;
    background: var(--white);
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--secondary);
    box-shadow: 0 0 0 3px rgba(99, 122, 185, 0.1);
}

.form-text {
    font-size: 0.8rem;
    color: var(--gray);
    margin-top: 0.25rem;
}

/* BUTTONS */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    cursor: pointer;
    font-size: 0.9rem;
    gap: 0.5rem;
}

.btn-primary {
    background: var(--primary);
    color: var(--white);
}

.btn-primary:hover {
    background: #25255a;
    transform: translateY(-1px);
}

.btn-secondary {
    background: var(--light-gray);
    color: var(--dark);
}

.btn-secondary:hover {
    background: #c8c8c8;
}

.btn-info {
    background: var(--secondary);
    color: var(--white);
}

.btn-info:hover {
    background: #5268a1;
}

.btn-outline-danger {
    background: transparent;
    color: var(--danger);
    border: 1px solid var(--danger);
}

.btn-outline-danger:hover {
    background: var(--danger);
    color: var(--white);
}

/* ACTION BUTTONS VERTICAL */
.action-buttons-vertical {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.action-buttons-vertical .btn {
    width: 100%;
    justify-content: flex-start;
}

/* LOCATION SEARCH SYSTEM */
.location-search-container {
    background: var(--background);
    border-radius: 8px;
    padding: 1rem;
}

.search-box {
    position: relative;
    margin-bottom: 1rem;
}

.search-input {
    padding-left: 2.5rem !important;
    padding-right: 2.5rem !important;
}

.search-icon {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray);
    font-size: 0.9rem;
    z-index: 2;
}

.search-clear {
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--gray);
    cursor: pointer;
    opacity: 0;
    display: none;
    padding: 0.25rem;
    border-radius: 4px;
    z-index: 2;
}

.search-input:not(:placeholder-shown) + .search-icon + .search-clear {
    opacity: 1;
    display: block;
}

.search-clear:hover {
    color: var(--secondary);
    background: var(--white);
}

/* SELECTED LOCATIONS */
.selected-locations-container {
    margin-bottom: 1.5rem;
}

.selected-locations {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    max-height: 150px;
    overflow-y: auto;
}

.selected-location-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--white);
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    border: 1px solid var(--success);
    animation: slideIn 0.2s ease;
}

.location-text {
    display: flex;
    align-items: center;
    font-size: 0.85rem;
    color: var(--dark);
    font-weight: 500;
}

.location-text i {
    color: var(--success);
    font-size: 0.7rem;
}

.btn-remove-location {
    background: none;
    border: none;
    color: var(--danger);
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 4px;
    font-size: 0.7rem;
    transition: all 0.2s ease;
}

.btn-remove-location:hover {
    background: var(--danger);
    color: var(--white);
}

.no-selection {
    text-align: center;
    padding: 1rem;
    color: var(--gray);
    font-size: 0.85rem;
    background: var(--white);
    border-radius: 6px;
    border: 1px dashed var(--border);
}

.no-selection i {
    margin-right: 0.5rem;
}

/* LOCATIONS LIST */
.locations-list-container {
    border-top: 1px solid var(--border);
    padding-top: 1rem;
}

.locations-list {
    max-height: 200px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.location-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--white);
    padding: 0.75rem;
    border-radius: 6px;
    border: 1px solid var(--border);
    cursor: pointer;
    transition: all 0.2s ease;
}

.location-item:hover {
    border-color: var(--secondary);
    transform: translateY(-1px);
    box-shadow: var(--shadow);
}

.location-info {
    display: flex;
    align-items: center;
    flex: 1;
}

.location-name {
    font-weight: 500;
    color: var(--dark);
    font-size: 0.85rem;
}

.location-count {
    font-size: 0.75rem;
    color: var(--gray);
    margin-left: 0.5rem;
}

.location-check {
    color: var(--success);
    opacity: 0;
    transition: opacity 0.2s ease;
}

.location-item.selected .location-check {
    opacity: 1;
}

.location-item.hidden {
    display: none;
}

.no-results {
    text-align: center;
    padding: 1.5rem;
    color: var(--gray);
    font-size: 0.85rem;
}

.no-results i {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    display: block;
}

/* IMAGE PREVIEW */
.file-upload-container {
    margin-bottom: 0.5rem;
}

.image-preview-container {
    background: var(--background);
    border-radius: 8px;
    border: 1px solid var(--border);
    overflow: hidden;
}

.preview-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 1rem;
    background: var(--white);
    border-bottom: 1px solid var(--border);
}

.preview-title {
    font-weight: 600;
    color: var(--dark);
    font-size: 0.9rem;
}

.btn-remove-image {
    background: none;
    border: none;
    color: var(--danger);
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 4px;
    font-size: 0.8rem;
}

.btn-remove-image:hover {
    background: var(--danger);
    color: var(--white);
}

.preview-image {
    padding: 1rem;
    text-align: center;
}

.preview-image img {
    max-width: 100%;
    max-height: 200px;
    border-radius: 4px;
    object-fit: cover;
}

/* ALERTS */
.alert {
    border-radius: 8px;
    border: none;
    box-shadow: var(--shadow);
    margin-bottom: 1.5rem;
}

.alert i {
    font-size: 1rem;
}

/* ANIMATIONS */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* SCROLLBAR STYLING */
.locations-list::-webkit-scrollbar,
.selected-locations::-webkit-scrollbar {
    width: 6px;
}

.locations-list::-webkit-scrollbar-track,
.selected-locations::-webkit-scrollbar-track {
    background: var(--background);
    border-radius: 3px;
}

.locations-list::-webkit-scrollbar-thumb,
.selected-locations::-webkit-scrollbar-thumb {
    background: var(--light-gray);
    border-radius: 3px;
}

.locations-list::-webkit-scrollbar-thumb:hover,
.selected-locations::-webkit-scrollbar-thumb:hover {
    background: var(--gray);
}

/* RESPONSIVE DESIGN */
@media (max-width: 768px) {
    .dashboard-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
        padding: 1.5rem;
    }

    .header-actions {
        justify-content: center;
    }

    .card-body {
        padding: 1rem;
    }

    .row {
        flex-direction: column;
    }

    .col-md-8, .col-md-4 {
        width: 100%;
    }

    .action-buttons-vertical .btn {
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .dashboard-header {
        padding: 1.25rem;
    }

    .location-search-container {
        padding: 0.75rem;
    }

    .location-item {
        padding: 0.5rem;
    }

    .selected-location-item {
        padding: 0.4rem 0.6rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // CHARACTER COUNT FOR DESCRIPTION
    const descTextarea = document.getElementById('deskripsi');
    const charCount = document.getElementById('charCount');

    function updateCharCount() {
        const count = descTextarea.value.length;
        charCount.textContent = `${count}/1000 karakter`;

        if (count > 1000) {
            charCount.style.color = 'var(--danger)';
        } else {
            charCount.style.color = 'var(--gray)';
        }
    }

    descTextarea.addEventListener('input', updateCharCount);
    updateCharCount(); // Initial count

    // LOCATION SEARCH FUNCTIONALITY
    const lokasiSearch = document.getElementById('lokasiSearch');
    const clearSearch = document.getElementById('clearSearch');
    const locationsList = document.getElementById('locationsList');
    const locationItems = locationsList.querySelectorAll('.location-item');
    const noResults = document.getElementById('noResults');

    if (lokasiSearch) {
        lokasiSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            let hasVisibleItems = false;

            locationItems.forEach(item => {
                const locationName = item.getAttribute('data-name');
                if (locationName.includes(searchTerm) || searchTerm === '') {
                    item.classList.remove('hidden');
                    hasVisibleItems = true;
                } else {
                    item.classList.add('hidden');
                }
            });

            // Show/hide no results message
            noResults.style.display = hasVisibleItems || searchTerm === '' ? 'none' : 'block';
        });

        // Clear search functionality
        if (clearSearch) {
            clearSearch.addEventListener('click', function() {
                lokasiSearch.value = '';
                lokasiSearch.dispatchEvent(new Event('input'));
                lokasiSearch.focus();
            });
        }

        // Show/hide clear button based on input
        lokasiSearch.addEventListener('input', function() {
            clearSearch.style.display = this.value ? 'block' : 'none';
        });

        // Clear search when clicking escape
        lokasiSearch.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                this.dispatchEvent(new Event('input'));
                this.blur();
            }
        });
    }

    // Mark initially selected locations
    const selectedLocations = document.getElementById('selectedLocations');
    const selectedLocationIds = Array.from(selectedLocations.querySelectorAll('input[type="hidden"]'))
        .map(input => parseInt(input.value));

    locationItems.forEach(item => {
        const locationId = parseInt(item.getAttribute('data-id'));
        if (selectedLocationIds.includes(locationId)) {
            item.classList.add('selected');
        }
    });
});

// LOCATION SELECTION FUNCTIONS
function selectLocation(locationId, locationName) {
    const selectedLocations = document.getElementById('selectedLocations');
    const noSelection = document.getElementById('noSelection');
    const locationItem = document.querySelector(`.location-item[data-id="${locationId}"]`);

    // Check if already selected
    const existingSelection = selectedLocations.querySelector(`input[value="${locationId}"]`);
    if (existingSelection) {
        return; // Already selected
    }

    // Create selected location item
    const selectedItem = document.createElement('div');
    selectedItem.className = 'selected-location-item';
    selectedItem.setAttribute('data-id', locationId);
    selectedItem.innerHTML = `
        <span class="location-text">
            <i class="fas fa-map-marker-alt me-1"></i>
            ${locationName}
        </span>
        <button type="button" class="btn-remove-location" onclick="removeLocation(${locationId})">
            <i class="fas fa-times"></i>
        </button>
        <input type="hidden" name="lokasi[]" value="${locationId}">
    `;

    selectedLocations.appendChild(selectedItem);

    // Mark as selected in locations list
    locationItem.classList.add('selected');

    // Hide no selection message
    noSelection.style.display = 'none';
}

function removeLocation(locationId) {
    const selectedLocations = document.getElementById('selectedLocations');
    const noSelection = document.getElementById('noSelection');
    const locationItem = document.querySelector(`.location-item[data-id="${locationId}"]`);

    // Remove from selected locations
    const selectedItem = selectedLocations.querySelector(`[data-id="${locationId}"]`);
    if (selectedItem) {
        selectedItem.remove();
    }

    // Remove selected class from locations list
    if (locationItem) {
        locationItem.classList.remove('selected');
    }

    // Show no selection message if no locations selected
    if (selectedLocations.children.length === 0) {
        noSelection.style.display = 'block';
    }
}

// IMAGE PREVIEW FUNCTIONS
function previewImage(input) {
    const preview = document.getElementById('previewImage');
    const previewContainer = document.getElementById('imagePreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage() {
    const preview = document.getElementById('previewImage');
    const previewContainer = document.getElementById('imagePreview');
    const fileInput = document.getElementById('foto');

    preview.src = '';
    previewContainer.style.display = 'none';
    fileInput.value = '';
}

// DELETE CONFIRMATION
function confirmDelete() {
    if (confirm('Apakah Anda yakin ingin menghapus item ini?\nTindakan ini tidak dapat dibatalkan.')) {
        document.getElementById('deleteForm').submit();
    }
}

// FORM VALIDATION
document.getElementById('editItemForm').addEventListener('submit', function(e) {
    const selectedLocations = document.querySelectorAll('input[name="lokasi[]"]');
    const namaItem = document.getElementById('nama_item').value.trim();
    const deskripsi = document.getElementById('deskripsi').value.trim();

    let isValid = true;
    let errorMessage = '';

    // Validate nama item
    if (!namaItem) {
        isValid = false;
        errorMessage += '• Nama item harus diisi\n';
    }

    // Validate deskripsi
    if (!deskripsi) {
        isValid = false;
        errorMessage += '• Deskripsi harus diisi\n';
    }

    // Validate locations
    if (selectedLocations.length === 0) {
        isValid = false;
        errorMessage += '• Pilih minimal satu lokasi\n';
    }

    if (!isValid) {
        e.preventDefault();
        alert('Silakan perbaiki kesalahan berikut:\n\n' + errorMessage);
    }
});
</script>
@endsection
