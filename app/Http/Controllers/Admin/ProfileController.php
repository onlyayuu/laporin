<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Log;
use App\Models\User;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        // Cek jika user belum login, redirect ke login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        $data = [
            'user' => $user,
        ];

        if($user->role === 'petugas') {
            $data['petugas'] = Petugas::where('id_petugas', $user->id_user)->first();
        }

        return view('admin.profile', $data);
    }

    public function updateProfile(Request $request)
    {
        // Cek jika user belum login
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi telah berakhir. Silakan login kembali.'
            ], 401);
        }

        $user = Auth::user();

        // Validasi data
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:200|unique:users,username,' . $user->id_user . ',id_user',
            'email' => 'nullable|email|max:200',
            'telp' => 'nullable|string|max:30'
        ], [
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'email.email' => 'Format email tidak valid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan validasi',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Update user data
            $updateData = [
                'username' => $request->username,
                'email' => $request->email ?? $user->email,
            ];

            $affected = User::where('id_user', $user->id_user)->update($updateData);

            if ($affected === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data yang diubah'
                ], 400);
            }

            // Jika petugas, update telepon
            if($user->role === 'petugas' && $request->has('telp')) {
                Petugas::where('id_petugas', $user->id_user)->update([
                    'telp' => $request->telp,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Profile berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ], 500);
        }
    }

    public function updatePassword(Request $request)
    {
        // Cek jika user belum login
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi telah berakhir. Silakan login kembali.'
            ], 401);
        }

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password minimal 8 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan validasi',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Cek password saat ini
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password saat ini salah'
                ], 422);
            }

            // Update password
            $affected = User::where('id_user', $user->id_user)->update([
                'password' => Hash::make($request->new_password)
            ]);

            if ($affected === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengubah password'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diubah!'
            ]);

        } catch (\Exception $e) {
            Log::error('Password update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ], 500);
        }
    }
}
