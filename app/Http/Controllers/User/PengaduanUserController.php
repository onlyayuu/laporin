<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Item;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class PengaduanUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['guru', 'siswa'])) {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        $pengaduans = Pengaduan::with(['item', 'petugas'])
            ->where('id_user', Auth::user()->id_user)
            ->orderBy('tgl_pengajuan', 'desc')
            ->paginate(10);

        return view('user.pengaduan.index', compact('pengaduans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['guru', 'siswa'])) {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        $lokasis = Lokasi::with('items')->get();
        $items = Item::with('listLokasi')->get();

        return view('user.pengaduan.create', compact('lokasis', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['guru', 'siswa'])) {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        // DEBUG
        Log::info('=== PENGADUAN STORE DEBUG ===');
        Log::info('Request Data:', $request->all());
        Log::info('Files:', $request->hasFile('foto') ? ['file_exists' => true] : ['file_exists' => false]);

        // VALIDASI
        $validator = Validator::make($request->all(), [
            'nama_pengaduan' => 'required|string|max:200',
            'deskripsi' => 'required|string|min:10',
            'id_lokasi' => 'required|exists:lokasi,id_lokasi',
            'id_item' => 'required_without:nama_barang_baru|exists:items,id_item',
            'nama_barang_baru' => 'required_without:id_item|string|max:200',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'id_item.required_without' => 'Pilih barang atau input barang baru',
            'nama_barang_baru.required_without' => 'Input barang baru atau pilih barang existing',
            'foto.required' => 'Foto pengaduan wajib diunggah',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar yang didukung: JPEG, PNG, JPG, GIF',
            'foto.max' => 'Ukuran gambar maksimal 5MB',
        ]);

        if ($validator->fails()) {
            Log::info('Validation Failed:', $validator->errors()->toArray());
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // DAPATKAN LOKASI
            $lokasi = Lokasi::find($request->id_lokasi);
            if (!$lokasi) {
                return back()->with('error', 'Lokasi tidak ditemukan.')->withInput();
            }

            // DAPATKAN USER ID
            $userId = Auth::id();
            if (!$userId) {
                $userId = Auth::user()->id_user;
            }

            $isTemporaryMode = !empty($request->nama_barang_baru);

            // HANDLE IMAGE UPLOAD
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                try {
                    $foto = $request->file('foto');

                    // Pastikan directory exists
                    if (!Storage::disk('public')->exists('pengaduan_images')) {
                        Storage::disk('public')->makeDirectory('pengaduan_images');
                    }

                    // Generate unique filename
                    $fotoName = 'pengaduan_' . time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();

                    // Store file
                    $fotoPath = $foto->storeAs('pengaduan_images', $fotoName, 'public');

                    Log::info("Foto uploaded successfully: " . $fotoPath);

                    // Verifikasi file tersimpan
                    if (!Storage::disk('public')->exists($fotoPath)) {
                        throw new \Exception('File gagal disimpan di server');
                    }

                } catch (\Exception $e) {
                    Log::error("Error uploading foto: " . $e->getMessage());
                    return back()->with('error', 'Gagal mengunggah gambar: ' . $e->getMessage())->withInput();
                }
            }

            // PREPARE DATA PENGAJUAN
            $pengaduanData = [
                'nama_pengaduan' => $request->nama_pengaduan,
                'deskripsi' => $request->deskripsi,
                'lokasi' => $lokasi->nama_lokasi,
                'foto' => $fotoPath,
                'status' => 'Diajukan',
                'id_user' => (int)$userId,
                'tgl_pengajuan' => now()->format('Y-m-d'),
            ];

            // Handle timestamps dengan try-catch
            try {
                $pengaduanData['created_at'] = now();
                $pengaduanData['updated_at'] = now();
            } catch (\Exception $e) {
                // Jika error, berarti tabel tidak punya timestamps
                Log::info('Table does not have timestamps columns');
            }

            if ($isTemporaryMode) {
                // MODE TEMPORARY ITEM
                $temporaryItemData = [
                    'id_item' => null,
                    'nama_barang_baru' => $request->nama_barang_baru,
                    'lokasi_barang_baru' => $request->lokasi_barang_baru ?: $lokasi->nama_lokasi,
                ];

                // Coba dengan timestamps
                try {
                    $temporaryItemId = DB::table('temporary_item')->insertGetId(array_merge(
                        $temporaryItemData,
                        ['created_at' => now(), 'updated_at' => now()]
                    ));
                } catch (\Exception $e) {
                    $temporaryItemId = DB::table('temporary_item')->insertGetId($temporaryItemData);
                }

                $pengaduanData['id_item'] = null;

            } else {
                // MODE NORMAL
                $itemExists = DB::table('list_lokasi')
                    ->where('id_lokasi', $request->id_lokasi)
                    ->where('id_item', $request->id_item)
                    ->exists();

                if (!$itemExists) {
                    return back()->withErrors([
                        'id_item' => 'Barang tidak tersedia di lokasi yang dipilih.',
                    ])->withInput();
                }

                $pengaduanData['id_item'] = (int) $request->id_item;
            }

            Log::info("Data pengaduan yang akan diinsert:", $pengaduanData);

            // INSERT KE DATABASE
            try {
                $pengaduanId = DB::table('pengaduan')->insertGetId($pengaduanData);
                Log::info("Insert berhasil! ID: " . $pengaduanId);
            } catch (\Exception $e) {
                // Jika error karena unknown column, coba tanpa timestamps
                if (strpos($e->getMessage(), 'Unknown column') !== false) {
                    Log::info('Retrying without timestamps...');
                    unset($pengaduanData['created_at']);
                    unset($pengaduanData['updated_at']);
                    $pengaduanId = DB::table('pengaduan')->insertGetId($pengaduanData);
                } else {
                    throw $e;
                }
            }

            // VERIFIKASI DATA YANG DIMASUKKAN
            $insertedData = DB::table('pengaduan')->where('id_pengaduan', $pengaduanId)->first();
            Log::info("Data setelah insert:", (array)$insertedData);

            DB::commit();

            $message = $isTemporaryMode
                ? 'Pengaduan berhasil diajukan! Barang baru menunggu persetujuan admin.'
                : 'Pengaduan berhasil diajukan! ID: ' . $pengaduanId;

            return redirect()->route('user.pengaduan.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error store pengaduan: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['guru', 'siswa'])) {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        $pengaduan = Pengaduan::with(['item', 'petugas'])
            ->where('id_user', Auth::user()->id_user)
            ->findOrFail($id);

        return view('user.pengaduan.show', compact('pengaduan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Optional: jika tidak butuh edit, bisa dihapus atau return 404
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Optional: jika tidak butuh update, bisa dihapus atau return 404
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Optional: jika tidak butuh delete, bisa dihapus atau return 404
        abort(404);
    }
}
