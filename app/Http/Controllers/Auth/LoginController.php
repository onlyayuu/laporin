<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user by username
        $user = User::where('username', $request->username)->first();

        // Check jika user exists dan password match
        if ($user && Hash::check($request->password, $user->password)) {
            // Login user
            Auth::login($user, $request->has('remember'));

            // Redirect berdasarkan role
            return $this->redirectToRole($user->role);
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput();
    }

    protected function redirectToRole($role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil sebagai Admin!');
            case 'petugas':
                return redirect()->route('petugas.dashboard')->with('success', 'Login berhasil sebagai Petugas!');
            case 'guru':
            case 'siswa':
                return redirect()->route('user.dashboard')->with('success', 'Login berhasil!');
            default:
                return redirect('/')->with('success', 'Login berhasil!');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logout berhasil!');
    }
}
