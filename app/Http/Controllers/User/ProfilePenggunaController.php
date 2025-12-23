<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ProfilePenggunaController extends Controller
{
    public function index()
    {
        // Get user initials
        $user = Auth::user();
        $userInitials = $this->getInitials($user->nama_pengguna);

        return view('user.profile', compact('userInitials'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi data profile
        $validated = $request->validate([
            'nama_pengguna' => 'required|string|max:200',
            'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'current_password' => 'nullable',
            'new_password' => 'nullable|min:8|confirmed',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hapus_foto' => 'nullable'
        ]);

        try {
            // Update data profile
            $updateData = [
                'nama_pengguna' => $validated['nama_pengguna'],
                'email' => $validated['email'],
                'updated_at' => now(),
            ];

            // Handle upload foto profil
            if ($request->hasFile('foto_profil')) {
                // Hapus foto lama jika ada
                if ($user->foto_profil && Storage::exists('public/' . $user->foto_profil)) {
                    Storage::delete('public/' . $user->foto_profil);
                }

                // Simpan foto baru
                $path = $request->file('foto_profil')->store('profile-photos', 'public');
                $updateData['foto_profil'] = $path;
            }

            // Handle hapus foto
            if ($request->has('hapus_foto') && $request->hapus_foto == '1') {
                if ($user->foto_profil && Storage::exists('public/' . $user->foto_profil)) {
                    Storage::delete('public/' . $user->foto_profil);
                }
                $updateData['foto_profil'] = null;
            }

            // Update password jika diisi
            if (!empty($validated['current_password']) && !empty($validated['new_password'])) {
                if (!Hash::check($validated['current_password'], $user->password)) {
                    return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
                }
                $updateData['password'] = Hash::make($validated['new_password']);
            }

            // Update ke database
            DB::table('users')
                ->where('id_user', $user->id_user)
                ->update($updateData);

            return redirect()->route('user.profile')->with('success', 'Profile berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Function to get user initials
    private function getInitials($name)
    {
        $words = explode(' ', $name);
        $initials = '';

        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }

        return substr($initials, 0, 2);
    }
}
