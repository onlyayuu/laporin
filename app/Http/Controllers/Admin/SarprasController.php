<?php
// app/Http/Controllers/Admin/SarprasController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Lokasi;
use App\Models\ListLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SarprasController extends Controller
{
    /**
     * DASHBOARD SARPRAS - MENAMPILKAN LOKASI DAN ITEM DALAM SATU HALAMAN
     */
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        // Ambil data untuk kedua section
        $lokasis = Lokasi::withCount('items')->orderBy('nama_lokasi', 'asc')->get();
        $items = Item::with('lokasis')->orderBy('created_at', 'desc')->paginate(10);

        $totalItems = Item::count();
        $totalLokasi = Lokasi::count();
        $allLokasis = Lokasi::all(); // Untuk form select

        return view('admin.items.index', compact('lokasis', 'items', 'totalItems', 'totalLokasi', 'allLokasis'));
    }

    /**
     * FORM CREATE - UNTUK TAMBAH ITEM ATAU TAMBAH LOKASI
     */
    public function create()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        $lokasis = Lokasi::all();
        $allItems = Item::with('lokasis')->get(); // Ambil semua item dengan lokasinya
        $totalItems = Item::count();
        $itemsWithLocation = Item::has('lokasis')->count(); // Hitung item yang sudah punya lokasi

        return view('admin.items.create', compact('lokasis', 'allItems', 'totalItems', 'itemsWithLocation'));
    }

    /**
     * STORE LOKASI - DENGAN ITEM YANG DIPILIH
     */
    public function storeLokasi(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }
        //validasi BERDASARKAN struktur DATAAAA//
        $request->validate([
            'nama_lokasi' => 'required|string|max:200|unique:lokasi,nama_lokasi',
            'items' => 'nullable|array',
            'items.*' => 'exists:items,id_item'
        ]);

        try {
            DB::beginTransaction();

            // 1. Buat lokasi baru
            $lokasi = Lokasi::create([
                'nama_lokasi' => $request->nama_lokasi,
            ]);

            // 2. Jika ada items yang dipilih, buat relasi many-to-many
            if ($request->has('items') && !empty($request->items)) {
                foreach ($request->items as $id_item) {
                    ListLokasi::create([
                        'id_lokasi' => $lokasi->id_lokasi,
                        'id_item' => $id_item
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.items.index')->with('success', 'Lokasi berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan lokasi: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * UPDATE LOKASI
     */
    public function updateLokasi(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'nama_lokasi' => 'required|string|max:200|unique:lokasi,nama_lokasi,' . $id . ',id_lokasi',
        ]);

        try {
            $lokasi = Lokasi::findOrFail($id);
            $lokasi->update([
                'nama_lokasi' => $request->nama_lokasi,
            ]);

            return redirect()->route('admin.items.index')->with('success', 'Lokasi berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->route('admin.items.index')->with('error', 'Gagal mengupdate lokasi: ' . $e->getMessage());
        }
    }

    /**
     * HAPUS LOKASI
     */
    public function destroyLokasi($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        try {
            $lokasi = Lokasi::findOrFail($id);

            // CEK APAKAH LOKASI MEMILIKI ITEM
            if ($lokasi->items()->count() > 0) {
                return redirect()->route('admin.items.index')->with('error', 'Tidak dapat menghapus lokasi karena masih memiliki item terkait.');
            }

            $lokasi->delete();

            return redirect()->route('admin.items.index')->with('success', 'Lokasi berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->route('admin.items.index')->with('error', 'Gagal menghapus lokasi: ' . $e->getMessage());
        }
    }

    /**
     * STORE ITEM
     */
    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'nama_item' => 'required|string|max:200',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lokasi' => 'required|array|min:1',
            'lokasi.*' => 'exists:lokasi,id_lokasi'
        ]);

        try {
            DB::beginTransaction();

            $item = Item::create([
                'nama_item' => $request->nama_item,
                'deskripsi' => $request->deskripsi,
                'foto' => $request->hasFile('foto') ? $request->file('foto')->store('items', 'public') : null
            ]);

            foreach ($request->lokasi as $id_lokasi) {
                ListLokasi::create([
                    'id_item' => $item->id_item,
                    'id_lokasi' => $id_lokasi
                ]);
            }

            DB::commit();

            return redirect()->route('admin.items.index')->with('success', 'Item berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan item: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * EDIT ITEM
     */
    /**
 * EDIT ITEM
 */
/**
 * EDIT ITEM
 */
public function edit($id)
{
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return redirect('/login')->with('error', 'Akses ditolak!');
    }

    $item = Item::with('lokasis')->findOrFail($id);
    $lokasis = Lokasi::withCount('items')->orderBy('nama_lokasi', 'asc')->get();

    return view('admin.items.edit', compact('item', 'lokasis'));
}

    /**
     * UPDATE ITEM
     */
    public function update(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'nama_item' => 'required|string|max:200',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lokasi' => 'required|array|min:1',
            'lokasi.*' => 'exists:lokasi,id_lokasi'
        ]);

        $item = Item::findOrFail($id);

        try {
            DB::beginTransaction();

            $data = [
                'nama_item' => $request->nama_item,
                'deskripsi' => $request->deskripsi,
            ];

            if ($request->hasFile('foto')) {
                if ($item->foto) {
                    Storage::disk('public')->delete($item->foto);
                }
                $data['foto'] = $request->file('foto')->store('items', 'public');
            }

            $item->update($data);

            ListLokasi::where('id_item', $item->id_item)->delete();

            foreach ($request->lokasi as $id_lokasi) {
                ListLokasi::create([
                    'id_item' => $item->id_item,
                    'id_lokasi' => $id_lokasi
                ]);
            }

            DB::commit();

            return redirect()->route('admin.items.index')->with('success', 'Item berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengupdate item: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * DESTROY ITEM
     */
    public function destroy($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        try {
            $item = Item::findOrFail($id);

            if ($item->pengaduan()->count() > 0) {
                return redirect()->back()->with('error', 'Tidak dapat menghapus item karena sudah digunakan dalam pengaduan.');
            }

            DB::beginTransaction();

            ListLokasi::where('id_item', $item->id_item)->delete();

            if ($item->foto) {
                Storage::disk('public')->delete($item->foto);
            }

            $item->delete();

            DB::commit();

            return redirect()->route('admin.items.index')->with('success', 'Item berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus item: ' . $e->getMessage());
        }
    }

    /**
     * SHOW ITEM
     */
    public function show($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        $item = Item::with('lokasis')->findOrFail($id);
        return view('admin.items.show', compact('item'));
    }
}
