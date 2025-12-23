<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        // VALIDASI DASAR UNTUK SEMUA ROLE
        $request->validate([
            'username' => 'required|string|max:200|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'nama_pengguna' => 'required|string|max:200',
            'role' => 'required|in:admin,petugas,guru,siswa'
        ]);

        // VALIDASI TAMBAHAN JIKA ROLE = PETUGAS
        if ($request->role === 'petugas') {
            $request->validate([
                'gender' => 'required|in:P,L',
                'telp' => 'required|string|max:30'
            ]);
        }

        try {
            // STEP 1: CREATE USER (UNTUK SEMUA ROLE)
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'nama_pengguna' => $request->nama_pengguna,
                'role' => $request->role,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // STEP 2: JIKA PETUGAS, CREATE DI TABEL PETUGAS JUGA
            if ($request->role === 'petugas') {
                Petugas::create([
                    'nama' => $request->nama_pengguna,
                    'gender' => $request->gender,
                    'telp' => $request->telp,
                ]);
            }

            return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan user: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        $user = User::findOrFail($id);

        // AMBIL DATA PETUGAS JIKA ROLE PETUGAS
        $petugas = null;
        if ($user->role === 'petugas') {
            $petugas = Petugas::where('nama', $user->nama_pengguna)->first();
        }

        return view('admin.users.edit', compact('user', 'petugas'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        $user = User::findOrFail($id);

        // VALIDASI DASAR
        $request->validate([
            'username' => 'required|string|max:200|unique:users,username,' . $id . ',id_user',
            'password' => 'nullable|string|min:6|confirmed',
            'nama_pengguna' => 'required|string|max:200',
            'role' => 'required|in:admin,petugas,guru,siswa'
        ]);

        // VALIDASI TAMBAHAN JIKA ROLE = PETUGAS
        if ($request->role === 'petugas') {
            $request->validate([
                'gender' => 'required|in:P,L',
                'telp' => 'required|string|max:30'
            ]);
        }

        try {
            // UPDATE USER DATA
            $data = [
                'username' => $request->username,
                'nama_pengguna' => $request->nama_pengguna,
                'role' => $request->role
            ];

            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            // UPDATE DATA PETUGAS JIKA ROLE PETUGAS
            if ($request->role === 'petugas') {
                $petugas = Petugas::where('nama', $user->getOriginal('nama_pengguna'))->first();

                if ($petugas) {
                    $petugas->update([
                        'nama' => $request->nama_pengguna,
                        'gender' => $request->gender,
                        'telp' => $request->telp,
                    ]);
                } else {
                    // JIKA BELUM ADA, BUAT BARU
                    Petugas::create([
                        'nama' => $request->nama_pengguna,
                        'gender' => $request->gender,
                        'telp' => $request->telp,
                    ]);
                }
            } else {
                // JIKA ROLE BERUBAH DARI PETUGAS KE ROLE LAIN, HAPUS DATA PETUGAS
                $petugas = Petugas::where('nama', $user->getOriginal('nama_pengguna'))->first();
                if ($petugas) {
                    $petugas->delete();
                }
            }

            return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupdate user: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id) // 🔴 PASTIKAN INI ADA PARAMETER $id
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak!');
        }

        try {
            $user = User::findOrFail($id);

            if ($user->id_user == Auth::user()->id_user) {
                return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri!');
            }

            // HAPUS DATA PETUGAS JIKA ADA
            if ($user->role === 'petugas') {
                $petugas = Petugas::where('nama', $user->nama_pengguna)->first();
                if ($petugas) {
                    $petugas->delete();
                }
            }

            $user->delete();

            return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}
