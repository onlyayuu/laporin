<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Petugas;
use Illuminate\Support\Facades\Auth;

class DashboardPetugasController extends Controller
{
    private function getPetugasFromUser()
    {
        $user = Auth::user();
        $petugas = Petugas::where('nama', $user->nama_pengguna)->first();

        if (!$petugas) {
            $petugas = Petugas::create([
                'nama' => $user->nama_pengguna,
                'gender' => 'L',
                'telp' => '-'
            ]);
        }

        return $petugas;
    }

    public function index()
    {
        $petugas = $this->getPetugasFromUser();

        $stats = [
            'total_diambil' => Pengaduan::where('id_petugas', $petugas->id_petugas)->count(),
            'diproses' => Pengaduan::where('id_petugas', $petugas->id_petugas)
                            ->where('status', 'Diproses')->count(),
            'selesai' => Pengaduan::where('id_petugas', $petugas->id_petugas)
                            ->where('status', 'Selesai')->count(),
            'menunggu_diambil' => Pengaduan::where('status', 'Disetujui')
                                    ->whereNull('id_petugas')->count()
        ];

        $pengaduan_terbaru = Pengaduan::with('user')
                                ->where('status', 'Disetujui')
                                ->whereNull('id_petugas')
                                ->orderBy('tgl_pengajuan', 'DESC')
                                ->limit(5)
                                ->get();

        return view('petugas.dashboard', compact('stats', 'pengaduan_terbaru'));
    }
}
