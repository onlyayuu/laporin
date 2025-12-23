<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengaduan #{{ $pengaduan->id_pengaduan }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .info-section { margin-bottom: 20px; }
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 8px; border-bottom: 1px solid #ddd; }
        .info-table tr:nth-child(even) { background-color: #f9f9f9; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .bg-warning { background-color: #ffc107; color: #000; }
        .bg-primary { background-color: #007bff; color: #fff; }
        .bg-info { background-color: #17a2b8; color: #fff; }
        .bg-success { background-color: #28a745; color: #fff; }
        .bg-danger { background-color: #dc3545; color: #fff; }
        .content-box { border: 1px solid #ddd; padding: 15px; margin: 10px 0; background-color: #f8f9fa; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENGADUAN</h1>
        <h3>#{{ $pengaduan->id_pengaduan }}</h3>
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <div class="info-section">
        <h4>Informasi Pengaduan</h4>
        <table class="info-table">
            <tr>
                <td width="30%"><strong>ID Pengaduan</strong></td>
                <td>#{{ $pengaduan->id_pengaduan }}</td>
            </tr>
            <tr>
                <td><strong>Judul Pengaduan</strong></td>
                <td>{{ $pengaduan->nama_pengaduan }}</td>
            </tr>
            <tr>
                <td><strong>User</strong></td>
                <td>{{ $pengaduan->user->nama_pengguna }}</td>
            </tr>
            <tr>
                <td><strong>Lokasi</strong></td>
                <td>{{ $pengaduan->lokasi }}</td>
            </tr>
            <tr>
                <td><strong>Status</strong></td>
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
                <td><strong>Tanggal Pengajuan</strong></td>
                <td>{{ \Carbon\Carbon::parse($pengaduan->tgl_pengajuan)->format('d F Y H:i') }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Selesai</strong></td>
                <td>
                    @if($pengaduan->tgl_selesai)
                        {{ \Carbon\Carbon::parse($pengaduan->tgl_selesai)->format('d F Y H:i') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="info-section">
        <h4>Deskripsi Pengaduan</h4>
        <div class="content-box">
            {{ $pengaduan->deskripsi ?? 'Tidak ada deskripsi' }}
        </div>
    </div>

    

    @if($pengaduan->saran_petugas)
    <div class="info-section">
        <h4>Saran Petugas</h4>
        <div class="content-box">
            {{ $pengaduan->saran_petugas }}
        </div>
    </div>
    @endif

    <div class="footer">
        <p>Laporan ini dicetak secara otomatis dari Sistem Pengaduan Sarana Prasarana</p>
    </div>
</body>
</html>
