<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Petugas; // TAMBAH INI!
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // User Admin
        User::create([
            'username' => 'admin',
            'nama_pengguna' => 'Administrator',
            'email' => 'admin@smkn1bantul.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // User Petugas + Data Petugas
        $userPetugas = User::create([
            'username' => 'petugas',
            'nama_pengguna' => 'Budi Santoso', // Nama harus sama dengan di table petugas
            'email' => 'petugas@smkn1bantul.sch.id',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);

        // Data di table petugas
        Petugas::create([
            'nama' => 'Budi Santoso', // Harus sama dengan nama_pengguna di user
            'gender' => 'L',
            'telp' => '081234567890',
        ]);

        // User Guru contoh
        User::create([
            'username' => 'guru1',
            'nama_pengguna' => 'Guru Contoh',
            'email' => 'guru@smkn1bantul.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        // User Siswa contoh
        User::create([
            'username' => 'siswa1',
            'nama_pengguna' => 'Siswa Contoh',
            'email' => 'siswa@smkn1bantul.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);

        echo "User admin, petugas, guru, dan siswa berhasil dibuat!\n";
        echo "Login Admin: admin@smkn1bantul.sch.id / password\n";
        echo "Login Petugas: petugas@smkn1bantul.sch.id / password\n";
        echo "Login Guru: guru@smkn1bantul.sch.id / password\n";
        echo "Login Siswa: siswa@smkn1bantul.sch.id / password\n";
    }
}
