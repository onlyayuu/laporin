<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Semua Pengaduan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }
        .table tr:nth-child(even) { background-color: #f9f9f9; }
        .badge { padding: 3px 6px; border-radius: 3px; font-size: 11px; }
        .bg-warning { background-color: #ffc107; }
        .bg-primary { background-color: #007bff; color: white; }
        .bg-info { background-color: #17a2b8; color: white; }
        .bg-success { background-color: #28a745; color: white; }
        .bg-danger { background-color: #dc3545; color: white; }
        .summary { margin: 20px 0; padding: 15px; background-color: #f8f9fa; border: 1px solid #ddd; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN SEMUA PENGADUAN</h1>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <div class="summary">
        <h4>Ringkasan Statistik</h4>
        <p>Total Pengaduan: <strong>{{ $pengaduan->count() }}</strong></p>
        <p>Diajukan: {{ $pengaduan->where('status', 'Diajukan')->count() }} |
           Diproses: {{ $pengaduan->where('status', 'Diproses')->count() }} |
           Selesai: {{ $pengaduan->where('status', 'Selesai')->count() }} |
           Ditolak: {{ $pengaduan->where('status', 'Ditolak')->count() }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Judul Pengaduan</th>
                <th>User</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Tanggal Pengajuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengaduan as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->nama_pengaduan }}</td>
                <td>{{ $p->user->nama_pengguna }}</td>
                <td>{{ $p->lokasi }}</td>
                <td>
                    <span class="badge
                        @if($p->status == 'Diajukan') bg-warning
                        @elseif($p->status == 'Disetujui') bg-primary
                        @elseif($p->status == 'Diproses') bg-info
                        @elseif($p->status == 'Selesai') bg-success
                        @elseif($p->status == 'Ditolak') bg-danger
                        @else bg-secondary @endif">
                        {{ $p->status }}
                    </span>
                </td>
                <td>{{ \Carbon\Carbon::parse($p->tgl_pengajuan)->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dicetak secara otomatis dari Sistem Pengaduan Sarana Prasarana</p>
        <p>Total Data: {{ $pengaduan->count() }} pengaduan</p>
    </div>
</body>
</html>
