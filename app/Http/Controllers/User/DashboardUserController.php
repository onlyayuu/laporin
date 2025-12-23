<?php
// app/Http/Controllers/User/DashboardController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // PAKAI id_user BUKAN Auth::id()
        $pengaduan_terbaru = Pengaduan::where('id_user', $user->id_user)
            ->with(['item'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $stats = [
            'total_pengaduan' => Pengaduan::where('id_user', $user->id_user)->count(),
            'pengaduan_diajukan' => Pengaduan::where('id_user', $user->id_user)
                ->where('status', 'Diajukan')
                ->count(),
            'pengaduan_disetujui' => Pengaduan::where('id_user', $user->id_user)
                ->where('status', 'Disetujui')
                ->count(),
            'pengaduan_selesai' => Pengaduan::where('id_user', $user->id_user)
                ->where('status', 'Selesai')
                ->count(),
        ];

        return view('user.dashboard', compact('user', 'stats', 'pengaduan_terbaru'));
    }
}
