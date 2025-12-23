<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduUserController extends Controller
{
    public function dashboard()
    {
        // CEK ROLE PENGGUNA (guru/siswa)
        if (!Auth::check() || !in_array(Auth::user()->role, ['guru', 'siswa'])) {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        $user = Auth::user();

        $stats = [
            'total_pengaduan' => Pengaduan::where('id_user', $user->id)->count(),
            'pengaduan_diajukan' => Pengaduan::where('id_user', $user->id)->where('status', 'Diajukan')->count(),
            'pengaduan_disetujui' => Pengaduan::where('id_user', $user->id)->where('status', 'Disetujui')->count(),
            'pengaduan_selesai' => Pengaduan::where('id_user', $user->id)->where('status', 'Selesai')->count(),
        ];

        $pengaduan_terbaru = Pengaduan::with(['item', 'petugas'])
            ->where('id_user', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('user.dashboard', compact('stats', 'pengaduan_terbaru', 'user'));
    }
}
