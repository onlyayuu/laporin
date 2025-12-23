<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PengaduanController;
use App\Http\Controllers\Admin\SarprasController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Petugas\ProfilePetugasController;
use App\Http\Controllers\Petugas\DashboardPetugasController;
use App\Http\Controllers\Petugas\PengaduanPetugasController;
use App\Http\Controllers\User\ProfilePenggunaController;
use App\Http\Controllers\User\PengaduUserController;
use App\Http\Controllers\User\PengaduanUserController;
use Illuminate\Support\Facades\Route;

// Routes Authentication Manual - SIMPLE
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Admin Routes Group
Route::prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Profile Routes - accessible by all roles
    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('admin.profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('admin.profile.password');

    // Pengaduan Management
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('admin.pengaduan.index');
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('admin.pengaduan.show');
    Route::put('/pengaduan/{id}/status', [PengaduanController::class, 'updateStatus'])->name('admin.pengaduan.updateStatus');
    Route::delete('/pengaduan/{id}', [PengaduanController::class, 'destroy'])->name('admin.pengaduan.destroy');
    Route::post('/pengaduan/{id}/accept-temporary', [PengaduanController::class, 'acceptTemporary'])->name('admin.pengaduan.acceptTemporary');
    Route::delete('/pengaduan/{id}/reject-temporary', [PengaduanController::class, 'rejectTemporary'])->name('admin.pengaduan.rejectTemporary');

    // 🔴 SARPRAS/ITEMS ROUTES - DIPINDAH KE DALAM PREFIX ADMIN
    Route::prefix('items')->name('admin.items.')->group(function () {
        // HALAMAN UTAMA (LOKASI + ITEMS)
        Route::get('/', [SarprasController::class, 'index'])->name('index');

        // LOKASI ACTIONS (HANDLE FORM DI HALAMAN YANG SAMA)
        Route::post('/lokasi/store', [SarprasController::class, 'storeLokasi'])->name('lokasi.store');
        Route::put('/lokasi/{id}/update', [SarprasController::class, 'updateLokasi'])->name('lokasi.update');
        Route::delete('/lokasi/{id}/destroy', [SarprasController::class, 'destroyLokasi'])->name('lokasi.destroy');

        // ITEMS MANAGEMENT
        Route::get('/create', [SarprasController::class, 'create'])->name('create');
        Route::post('/store', [SarprasController::class, 'store'])->name('store');
        Route::get('/{id}/show', [SarprasController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [SarprasController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [SarprasController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [SarprasController::class, 'destroy'])->name('destroy');
    });

    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // Laporan Routes
    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
    Route::get('/laporan/{id}', [LaporanController::class, 'show'])->name('admin.laporan.show');
    Route::get('/laporan/{id}/pdf', [LaporanController::class, 'pdfSingle'])->name('admin.laporan.pdfSingle');
    Route::get('/laporan/pdf/all', [LaporanController::class, 'pdfAll'])->name('admin.laporan.pdfAll');
});

// Petugas Routes Group - TAMBAHKAN DI SINI
Route::prefix('petugas')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardPetugasController::class, 'index'])->name('petugas.dashboard');

    // ✅ PROFILE ROUTES UNTUK PETUGAS - TAMBAHKAN DI SINI
    Route::get('/profile', [ProfilePetugasController::class, 'index'])->name('petugas.profile');
    Route::put('/profile/update', [ProfilePetugasController::class, 'update'])->name('petugas.profile.update');
    Route::put('/profile/password', [ProfilePetugasController::class, 'updatePassword'])->name('petugas.profile.password'); 

    // Pengaduan Management
    Route::prefix('pengaduan')->group(function () {
        Route::get('/', [PengaduanPetugasController::class, 'index'])->name('petugas.pengaduan.index');
        Route::get('/task', [PengaduanPetugasController::class, 'task'])->name('petugas.pengaduan.task');
        Route::get('/history', [PengaduanPetugasController::class, 'history'])->name('petugas.pengaduan.history');
        Route::get('/{id}', [PengaduanPetugasController::class, 'show'])->name('petugas.pengaduan.show');
        Route::post('/take/{id}', [PengaduanPetugasController::class, 'take'])->name('petugas.pengaduan.take');
        Route::post('/update-status/{id}', [PengaduanPetugasController::class, 'updateStatus'])->name('petugas.pengaduan.update-status');
    });
});

// User Routes (Guru/Siswa)
Route::prefix('user')->group(function () {
    Route::get('/dashboard', [PengaduUserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/pengaduan', [PengaduanUserController::class, 'index'])->name('user.pengaduan.index');
    Route::get('/pengaduan/create', [PengaduanUserController::class, 'create'])->name('user.pengaduan.create');
    Route::post('/pengaduan', [PengaduanUserController::class, 'store'])->name('user.pengaduan.store');
    Route::get('/pengaduan/{id}', [PengaduanUserController::class, 'show'])->name('user.pengaduan.show');

    // Route AJAX untuk filter items by lokasi
    Route::get('/get-items-by-lokasi/{id_lokasi}', [PengaduanUserController::class, 'getItemsByLokasi']);

    // Route baru untuk edukasi
    Route::get('/edukasi', function () {
        return view('user.edukasi');
    })->name('user.edukasi');

    // Route untuk Profile
    Route::get('/profile', [ProfilePenggunaController::class, 'index'])->name('user.profile');
    Route::put('/profile/update', [ProfilePenggunaController::class, 'update'])->name('user.profile.update');
    Route::post('/profile/update-foto', [ProfilePenggunaController::class, 'updateFoto'])->name('user.profile.updateFoto');
});
