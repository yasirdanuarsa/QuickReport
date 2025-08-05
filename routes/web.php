<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\MonevController;
use App\Http\Controllers\Petugas\PetugasDashboardController;

// ===================
// Halaman Utama Publik
// ===================
Route::get('/', fn () => view('home', ['title' => 'Dashboard']));
Route::get('/reports', [MonevController::class, 'reports'])->name('monev.reports');

// ===================
// Autentikasi
// ===================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===================
// Route untuk Admin & Petugas (Butuh Auth)
// ===================
Route::middleware(['auth'])->group(function () {

    // ========== ADMIN & GENERAL ==========
    Route::get('/dashboard', [MonevController::class, 'index'])->name('monev.index');
    Route::get('/report', [MonevController::class, 'report'])->name('monev.create');
    Route::post('/report', [MonevController::class, 'store'])->name('monev.store');

    Route::get('/monev/{id}', [MonevController::class, 'show'])->name('monev.show');
    Route::get('/monev/{id}/edit', [MonevController::class, 'edit'])->name('monev.edit');
    Route::put('/monev/{id}', [MonevController::class, 'update'])->name('monev.update');
    Route::delete('/monev/{id}', [MonevController::class, 'destroy'])->name('monev.destroy');

    Route::get('/dashboard/print', [MonevController::class, 'print'])->name('monev.print');
    Route::get('/export-csv', [MonevController::class, 'exportCsv'])->name('monev.export.csv');

    Route::get('/laporan/{id}/extend', [MonevController::class, 'extendForm'])->name('monev.extend');
    Route::post('/laporan/{id}/extend', [MonevController::class, 'extendDeadline'])->name('monev.extendDeadline');
    Route::post('/laporan/{id}/extend/update', [MonevController::class, 'extendDeadline'])->name('monev.extend.update');

    Route::get('/setting-profile', [MonevController::class, 'settingProfile'])->name('profile.setting');

    // ========== VIEW TESTING (Optional) ==========
    Route::view('/admin/dashboard', 'admin.admin');
    Route::view('/petugas/layouts', 'petugas.layouts');
    Route::view('/petugas/dashboard-old', 'petugas.dashboard')->name('petugas.dashboard');
});

// ===================
// Route Khusus Petugas
// ===================
Route::middleware(['auth'])->prefix('petugas')->group(function () {
    Route::get('/dashboard', [MonevController::class, 'index'])->name('monev.index');
    Route::get('/laporan/{id}', [MonevController::class, 'show'])->name('monev.show');
    Route::get('/laporan/{id}/edit', [MonevController::class, 'edit'])->name('monev.edit');
    Route::put('/laporan/{id}', [MonevController::class, 'update'])->name('monev.update');
});

