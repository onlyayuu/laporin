<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Item;
use App\Models\User;
use App\Models\Petugas;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // CEK ROLE ADMIN
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        // Data statistik sederhana
        $total_pengaduan = Pengaduan::count();
        $pengaduan_diajukan = Pengaduan::where('status', 'Diajukan')->count();
        $pengaduan_diproses = Pengaduan::where('status', 'Diproses')->count();
        $pengaduan_selesai = Pengaduan::where('status', 'Selesai')->count();
        $pengaduan_disetujui = Pengaduan::where('status', 'Disetujui')->count();
        $pengaduan_ditolak = Pengaduan::where('status', 'Ditolak')->count();

        // Data overview sistem
        $total_users = User::count();
        $total_petugas = Petugas::count();
        $total_items = Item::count();
        $total_lokasi = Lokasi::count();

        // Data pengaduan menunggu
        $pengaduan_menunggu = Pengaduan::with('user')
            ->where('status', 'Diajukan')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Query untuk pengaduan terbaru dengan filter
        $pengaduanQuery = Pengaduan::with(['user', 'item'])
            ->orderBy('created_at', 'desc')
            ->take(5);

        // Filter berdasarkan status jika ada
        if (request()->has('status') && request('status') != '') {
            $pengaduanQuery->where('status', request('status'));
        }

        $pengaduan_terbaru = $pengaduanQuery->get();

        return view('admin.dashboard', compact(
            'total_pengaduan',
            'pengaduan_diajukan',
            'pengaduan_diproses',
            'pengaduan_selesai',
            'pengaduan_disetujui',
            'pengaduan_ditolak',
            'total_users',
            'total_petugas',
            'total_items',
            'total_lokasi',
            'pengaduan_menunggu',
            'pengaduan_terbaru'
        ));
    }
}
