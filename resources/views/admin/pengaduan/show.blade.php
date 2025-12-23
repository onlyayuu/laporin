@extends('layouts.admin')

@section('content')
@php
    // PERBAIKAN: Gunakan id_pengaduan dan handle error
    $isTemporary = \App\Http\Controllers\Admin\PengaduanController::isTemporaryItem($pengaduan->id_pengaduan);

    // PERBAIKAN: Ambil data temporary dengan cara sederhana
    $temporaryData = null;
    if ($isTemporary && $pengaduan->id_item) {
        $temporaryData = DB::table('temporary_item')
            ->where('id_item', $pengaduan->id_item)
            ->whereNotNull('nama_barang_baru')
            ->first();
    }
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Detail Pengaduan</h2>
    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<!-- PERBAIKAN: Alert temporary harus muncul jika memang temporary -->
@if($isTemporary)
<div class="alert alert-danger">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>PENGADUAN BARANG TEMPORARY!</strong>
    Barang ini adalah temporary item yang memerlukan penanganan khusus.

    <!-- TAMBAHKAN BUTTON ACCEPT TEMPORARY -->
    <div class="mt-3">
        <form action="{{ route('admin.pengaduan.acceptTemporary', $pengaduan->id_pengaduan) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success me-2">
                <i class="fas fa-check-circle me-1"></i>Terima & Tambahkan ke Items
            </button>
        </form>

        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
            <i class="fas fa-times me-1"></i>Tolak Item
        </button>
    </div>

    <!-- Debug info -->
    <div class="mt-2">
        <small>ID Pengaduan: {{ $pengaduan->id_pengaduan }}</small><br>
        <small>ID Item: {{ $pengaduan->id_item }}</small><br>
        <small>Temporary Data: {{ $temporaryData ? 'Ada' : 'Tidak Ada' }}</small>
    </div>
</div>
@endif

<!-- Modal untuk Tolak Item -->
@if($isTemporary)
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Tolak Temporary Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menolak temporary item ini?</p>
                <p class="text-danger"><small>Tindakan ini akan menghapus data temporary dari sistem.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.pengaduan.rejectTemporary', $pengaduan->id_pengaduan) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Tolak Item</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<div class="card @if($isTemporary) border-danger @endif">
    <div class="card-header @if($isTemporary) bg-danger text-white @endif">
        <h5 class="card-title mb-0">
            <i class="fas fa-info-circle me-2"></i>
            Informasi Pengaduan
            @if($isTemporary)
            <span class="badge bg-light text-danger ms-2">
                <i class="fas fa-clock me-1"></i>TEMPORARY ITEM
            </span>
            @endif
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>Informasi Pengaduan</h5>
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">ID Pengaduan</th>
                        <td>#{{ $pengaduan->id_pengaduan }}</td>
                    </tr>
                    <tr>
                        <th>Judul</th>
                        <td>{{ $pengaduan->nama_pengaduan }}</td>
                    </tr>
                    <tr>
                        <th>User</th>
                        <td>{{ $pengaduan->user->nama_pengguna }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>{{ $pengaduan->lokasi }}</td>
                    </tr>
                    <tr>
                        <th>ID Item</th>
                        <td>{{ $pengaduan->id_item ?? 'Tidak ada' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
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
                        <td>{{ $pengaduan->tgl_pengajuan }}</td>
                    </tr>

                    <!-- PERBAIKAN: Tampilkan data temporary jika ada -->
                    @if($isTemporary && $temporaryData)
                    <tr class="table-danger">
                        <th colspan="2" class="text-center">
                            <strong>INFORMASI TEMPORARY ITEM</strong>
                        </th>
                    </tr>
                    <tr class="table-danger">
                        <th>Nama Barang Baru</th>
                        <td>
                            <strong>{{ $temporaryData->nama_barang_baru ?? 'Data tidak ditemukan' }}</strong>
                        </td>
                    </tr>
                    <tr class="table-danger">
                        <th>Lokasi Barang Baru</th>
                        <td>
                            <strong>{{ $temporaryData->lokasi_barang_baru ?? 'Data tidak ditemukan' }}</strong>
                        <br>
                            <small class="text-muted">ID Temporary: {{ $temporaryData->id_temporary ?? 'N/A' }}</small>
                        </td>
                    </tr>
                    @endif
                </table>
            </div>

            <div class="col-md-6">
                <h5>Deskripsi Pengaduan</h5>
                <div class="border p-3 rounded bg-light">
                    {{ $pengaduan->deskripsi ?? 'Tidak ada deskripsi' }}
                </div>

                <!-- GAMBAR -->
                @if($pengaduan->foto)
                <h5 class="mt-4">Gambar Pengaduan</h5>
                <div class="mb-3">
                    <!-- Langsung pakai storage/ -->
                    <img src="{{ asset('storage/pengaduan_images/' . basename($pengaduan->foto)) }}"
                         alt="Gambar Pengaduan"
                         class="img-fluid rounded border"
                         style="max-height: 300px;">

                    <div class="mt-2">
                        <a href="{{ asset('storage/pengaduan_images/' . basename($pengaduan->foto)) }}"
                           target="_blank" class="btn btn-sm btn-success">
                            <i class="fas fa-external-link-alt me-1"></i>Buka di Tab Baru
                        </a>
                    </div>
                </div>
                @endif

                @if($pengaduan->saran_petugas)
                <h5 class="mt-4">Saran Petugas</h5>
                <div class="border p-3 rounded bg-light">
                    {{ $pengaduan->saran_petugas }}
                </div>
                @endif
            </div>
        </div>

        <!-- Form Update Status - DIUBAH: HAPUS PILIH PETUGAS -->
        <hr>
        <h5>Update Status Pengaduan</h5>
        <form action="{{ route('admin.pengaduan.updateStatus', $pengaduan->id_pengaduan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Diajukan" {{ $pengaduan->status == 'Diajukan' ? 'selected' : '' }}>Diajukan</option>
                        <option value="Disetujui" {{ $pengaduan->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Ditolak" {{ $pengaduan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">&nbsp;</label>
                    <div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-1"></i>Update Status
                        </button>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <label class="form-label">Saran Petugas</label>
                    <textarea name="saran_petugas" class="form-control" rows="3"
                              placeholder="Masukkan saran atau catatan untuk pengaduan ini...">{{ $pengaduan->saran_petugas }}</textarea>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle image error
    const img = document.querySelector('img');
    if (img) {
        img.addEventListener('error', function() {
            // Jika gambar error, tampilkan placeholder
            this.src = 'https://via.placeholder.com/300x200?text=Gambar+Tidak+Tersedia';
            this.alt = 'Gambar tidak tersedia';
        });
    }
});
</script>
@endsection
