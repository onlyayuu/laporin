<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Petugas;
use App\Models\User;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        // DAPATKAN SEMUA DATA DULU
        $allPengaduans = Pengaduan::with(['user', 'petugas', 'item'])
            ->when($request->status, function($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('nama_pengaduan', 'like', "%{$search}%")
                      ->orWhere('lokasi', 'like', "%{$search}%")
                      ->orWhereHas('user', function($userQuery) use ($search) {
                          $userQuery->where('nama_pengguna', 'like', "%{$search}%");
                      });
                });
            })
            ->orderBy('tgl_pengajuan', 'desc')
            ->get();

        // FILTER MANUAL UNTUK JENIS PENGADUAN
        if ($request->jenis_pengaduan == 'temporary') {
            $filteredPengaduans = $allPengaduans->filter(function($pengaduan) {
                return self::isTemporaryItem($pengaduan->id_pengaduan);
            });
        } elseif ($request->jenis_pengaduan == 'biasa') {
            $filteredPengaduans = $allPengaduans->filter(function($pengaduan) {
                return !self::isTemporaryItem($pengaduan->id_pengaduan);
            });
        } else {
            $filteredPengaduans = $allPengaduans;
        }

        // PAGINATION MANUAL
        $page = $request->get('page', 1);
        $perPage = 10;
        $currentPageItems = $filteredPengaduans->slice(($page - 1) * $perPage, $perPage)->values();

        $pengaduans = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            $filteredPengaduans->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // HITUNG STATISTIK
        $totalPengaduan = Pengaduan::count();
        $totalTemporary = $allPengaduans->filter(function($pengaduan) {
            return self::isTemporaryItem($pengaduan->id_pengaduan);
        })->count();
        $totalBiasa = $totalPengaduan - $totalTemporary;

        $statusCounts = [
            'Diajukan' => Pengaduan::where('status', 'Diajukan')->count(),
            'Disetujui' => Pengaduan::where('status', 'Disetujui')->count(),
            'Diproses' => Pengaduan::where('status', 'Diproses')->count(),
            'Selesai' => Pengaduan::where('status', 'Selesai')->count(),
            'Ditolak' => Pengaduan::where('status', 'Ditolak')->count(),
        ];

        return view('admin.pengaduan.index', compact(
            'pengaduans',
            'totalPengaduan',
            'totalTemporary',
            'totalBiasa',
            'statusCounts'
        ));
    }

    public function show($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        $pengaduan = Pengaduan::with(['user', 'petugas', 'item'])->findOrFail($id);
        $petugas = Petugas::all();

        // ✅ PASTIKAN nama tabel 'temporary_item'
        if ($pengaduan->id_item) {
            $temporaryData = DB::table('temporary_item')  // ✅ NAMA TABEL BENAR
                ->where('id_item', $pengaduan->id_item)
                ->whereNotNull('nama_barang_baru')
                ->first();

            if ($temporaryData) {
                return view('admin.pengaduan.show', compact('pengaduan', 'petugas', 'temporaryData'));
            }
        }

        return view('admin.pengaduan.show', compact('pengaduan', 'petugas'));
    }

    public function updateStatus(Request $request, $id)
{
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return redirect('/login')->with('error', 'Akses ditolak!');
    }

    $request->validate([
        'status' => 'required|in:Diajukan,Disetujui,Ditolak,Diproses,Selesai',
        'saran_petugas' => 'nullable|string'
        // HAPUS: 'id_petugas' => 'nullable|exists:petugas,id_petugas'
    ]);

    $pengaduan = Pengaduan::findOrFail($id);

    $updateData = [
        'status' => $request->status,
        'saran_petugas' => $request->saran_petugas
    ];

    // HAPUS LOGIC PEMILIHAN PETUGAS
    // if (in_array($request->status, ['Diproses', 'Selesai'])) {
    //     $updateData['id_petugas'] = $request->id_petugas;
    // } else {
    //     $updateData['id_petugas'] = null;
    // }

    // Set tanggal selesai jika status Selesai
    if ($request->status == 'Selesai') {
        $updateData['tgl_selesai'] = now()->format('Y-m-d');
    }

    $pengaduan->update($updateData);

    return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui.');
}

    public function destroy($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->delete();

        return redirect()->route('admin.pengaduan.index')
                       ->with('success', 'Pengaduan berhasil dihapus.');
    }

    /**
     * Method untuk menerima temporary item dan memindahkan ke tabel items
     */
    public function acceptTemporary($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        $pengaduan = Pengaduan::findOrFail($id);

        // Ambil data temporary
        $temporaryData = DB::table('temporary_item')
            ->where('id_item', $pengaduan->id_item)
            ->first();

        if ($temporaryData) {
            // Insert ke tabel items
            DB::table('items')->insert([
                'nama_item' => $temporaryData->nama_barang_baru,
                'lokasi' => $temporaryData->lokasi_barang_baru,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Hapus dari temporary
            DB::table('temporary_item')->where('id_item', $pengaduan->id_item)->delete();

            // Update status pengaduan menjadi Disetujui
            $pengaduan->update([
                'status' => 'Disetujui',
                'saran_petugas' => 'Item temporary telah diterima dan ditambahkan ke daftar items'
            ]);

            return redirect()->back()->with('success', 'Item temporary berhasil ditambahkan ke daftar items!');
        }

        return redirect()->back()->with('error', 'Data temporary tidak ditemukan!');
    }

    /**
     * Method untuk menolak temporary item
     */
    public function rejectTemporary($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        $pengaduan = Pengaduan::findOrFail($id);

        // Hapus dari temporary
        $deleted = DB::table('temporary_item')
            ->where('id_item', $pengaduan->id_item)
            ->delete();

        if ($deleted) {
            // Update status pengaduan menjadi Ditolak
            $pengaduan->update([
                'status' => 'Ditolak',
                'saran_petugas' => 'Item temporary telah ditolak dan dihapus dari sistem'
            ]);

            return redirect()->back()->with('success', 'Temporary item berhasil ditolak dan dihapus!');
        }

        return redirect()->back()->with('error', 'Gagal menolak temporary item!');
    }

    /**
     * Method sederhana untuk cek temporary item
     */
    public static function isTemporaryItem($id_pengaduan)
    {
        $pengaduan = Pengaduan::find($id_pengaduan);

        if (!$pengaduan) {
            return false;
        }

        // CARA 1: Cek berdasarkan nama barang dan lokasi (bukan id_item)
        return DB::table('temporary_item')
            ->where(function($query) use ($pengaduan) {
                // Cek match berdasarkan nama pengaduan dengan nama barang baru
                if ($pengaduan->nama_pengaduan) {
                    $query->where('nama_barang_baru', 'like', '%' . $pengaduan->nama_pengaduan . '%');
                }
                // ATAU cek match berdasarkan lokasi
                if ($pengaduan->lokasi) {
                    $query->orWhere('lokasi_barang_baru', 'like', '%' . $pengaduan->lokasi . '%');
                }
            })
            ->whereNotNull('nama_barang_baru')
            ->exists();
    }
}
