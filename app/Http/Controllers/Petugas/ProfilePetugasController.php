<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Petugas;

class ProfilePetugasController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data petugas berdasarkan nama yang sama
        $petugas = Petugas::where('nama', $user->nama_pengguna)->first();

        return view('petugas.profile', compact('user', 'petugas'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_pengguna' => 'required|string|max:255|unique:users,nama_pengguna,' . $user->id_user . ',id_user',
            'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'gender' => 'required|in:P,L',
            'telp' => 'nullable|string|max:30',
        ]);

        try {
            DB::beginTransaction();

            // 1. UPDATE USERS (nama_pengguna dan email)
            User::where('id_user', $user->id_user)->update([
                'nama_pengguna' => $request->nama_pengguna,
                'email' => $request->email,
            ]);

            // 2. UPDATE PETUGAS (gender dan telp)
            $petugas = Petugas::where('nama', $user->nama_pengguna)->first();

            if ($petugas) {
                // Update yang sudah ada
                $petugas->update([
                    'gender' => $request->gender,
                    'telp' => $request->telp,
                ]);
            } else {
                // Buat baru jika belum ada
                Petugas::create([
                    'nama' => $request->nama_pengguna, // pakai nama_pengguna sebagai nama
                    'gender' => $request->gender,
                    'telp' => $request->telp,
                ]);
            }

            DB::commit();

            return redirect()->route('petugas.profile')->with('success', 'Profil berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        // Cek password saat ini
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Password saat ini tidak sesuai!');
        }

        // Update password
        User::where('id_user', $user->id_user)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('petugas.profile')->with('success', 'Password berhasil diubah!');
    }
}
