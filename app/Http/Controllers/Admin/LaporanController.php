<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $pengaduan = Pengaduan::with('user')
            ->whereBetween('tgl_pengajuan', [$startDate, $endDate])
            ->orderBy('tgl_pengajuan', 'desc')
            ->get();

        // Statistik
        $statistik = [
            'total' => $pengaduan->count(),
            'diajukan' => $pengaduan->where('status', 'Diajukan')->count(),
            'diproses' => $pengaduan->where('status', 'Diproses')->count(),
            'selesai' => $pengaduan->where('status', 'Selesai')->count(),
            'ditolak' => $pengaduan->where('status', 'Ditolak')->count(),
        ];

        return view('admin.laporan.index', compact(
            'pengaduan',
            'statistik',
            'startDate',
            'endDate'
        ));
    }

    public function show($id)
    {
        // HAPUS with('tanggapan') karena relasi tidak ada
        $pengaduan = Pengaduan::with('user')->findOrFail($id);
        return view('admin.laporan.show', compact('pengaduan'));
    }

    public function pdfSingle($id)
    {
        // HAPUS with('tanggapan') karena relasi tidak ada
        $pengaduan = Pengaduan::with('user')->findOrFail($id);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.pdf-single', compact('pengaduan'));
        return $pdf->download('laporan-pengaduan-'.$pengaduan->id_pengaduan.'.pdf');
    }

    public function pdfAll(Request $request)
    {
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $pengaduan = Pengaduan::with('user')
            ->whereBetween('tgl_pengajuan', [$startDate, $endDate])
            ->orderBy('tgl_pengajuan', 'desc')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.pdf-all', compact('pengaduan', 'startDate', 'endDate'));
        return $pdf->download('laporan-pengaduan-'.$startDate.'-to-'.$endDate.'.pdf');
    }
}
