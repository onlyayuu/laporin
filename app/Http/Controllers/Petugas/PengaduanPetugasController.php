<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanPetugasController extends Controller
{
    // ✅ TAMBAHKAN METHOD INDEX YANG HILANG
    public function index()
    {
        $pengaduan = Pengaduan::with(['user', 'item'])
                    ->where('status', 'Disetujui')
                    ->whereNull('id_petugas')
                    ->orderBy('tgl_pengajuan', 'DESC')
                    ->get();

        return view('petugas.pengaduan.index', compact('pengaduan'));
    }

    // Helper function untuk mendapatkan petugas dari user yang login
    private function getPetugasFromUser()
    {
        $user = Auth::user();

        // Cari petugas berdasarkan nama (asumsi nama sama di kedua tabel)
        $petugas = Petugas::where('nama', $user->nama_pengguna)->first();

        if (!$petugas) {
            // Jika tidak ditemukan, buat petugas baru otomatis
            $petugas = Petugas::create([
                'nama' => $user->nama_pengguna,
                'gender' => 'L', // default
                'telp' => '-'
            ]);
        }

        return $petugas;
    }

    // Menu: Task/Pengaduan Saya (yang sudah diambil petugas)
    public function task()
    {
        $petugas = $this->getPetugasFromUser();

        $pengaduan = Pengaduan::with(['user', 'item'])
                    ->where('id_petugas', $petugas->id_petugas)
                    ->where('status', 'Diproses')
                    ->orderBy('tgl_pengajuan', 'DESC')
                    ->get();

        return view('petugas.pengaduan.task', compact('pengaduan'));
    }

    // Menu: History (yang sudah selesai)
    public function history()
    {
        $petugas = $this->getPetugasFromUser();

        $pengaduan = Pengaduan::with(['user', 'item'])
                    ->where('id_petugas', $petugas->id_petugas)
                    ->where('status', 'Selesai')
                    ->orderBy('tgl_selesai', 'DESC')
                    ->get();

        return view('petugas.pengaduan.history', compact('pengaduan'));
    }

    // Detail pengaduan (bisa digunakan untuk semua menu)
    public function show($id)
    {
        $pengaduan = Pengaduan::with(['user', 'item', 'petugas'])
                    ->findOrFail($id);

        return view('petugas.pengaduan.show', compact('pengaduan'));
    }

    // Ambil pengaduan (dari menu index)
    public function take($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if ($pengaduan->id_petugas !== null) {
            return redirect()->route('petugas.pengaduan.index')
                    ->with('error', 'Pengaduan sudah diambil petugas lain');
        }

        $petugas = $this->getPetugasFromUser();

        $pengaduan->update([
            'id_petugas' => $petugas->id_petugas, // ✅ PAKAI id_petugas
            'status' => 'Diproses'
        ]);

        return redirect()->route('petugas.pengaduan.task')
                ->with('success', 'Pengaduan berhasil diambil');
    }

    // Update status SELESAI (dari menu task)
    public function updateStatus(Request $request, $id)
    {
        // PERBAIKAN 1: Tambah validasi untuk foto_selesai
        $request->validate([
            'saran_petugas' => 'required|string|min:10',
            'foto_selesai' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // Max 2MB
        ]);

        $petugas = $this->getPetugasFromUser();

        $pengaduan = Pengaduan::where('id_petugas', $petugas->id_petugas)
                    ->where('id_pengaduan', $id)
                    ->firstOrFail();

        // PERBAIKAN 2: Handle upload foto selesai
        if ($request->hasFile('foto_selesai')) {
            $fotoSelesai = $request->file('foto_selesai')->store('pengaduan-selesai', 'public');
        }

        $pengaduan->update([
            'status' => 'Selesai',
            'saran_petugas' => $request->saran_petugas,
            'foto_selesai' => $fotoSelesai, // PERBAIKAN 3: Simpan foto_selesai
            'tgl_selesai' => now()
        ]);

        return redirect()->route('petugas.pengaduan.task')
                ->with('success', 'Pengaduan telah diselesaikan dengan foto bukti');
    }
}
