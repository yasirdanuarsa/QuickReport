<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\MonevController;
use App\Http\Controllers\Petugas\PetugasDashboardController;

// Route halaman utama
Route::get('/', function () {
    return view('home', ['title' => 'Dashboard']);
});
Route::get('/reports', [MonevController::class, 'reports'])->name('monev.reports');


// Route autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route CRUD Laporan dan fungsi tambahan
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [MonevController::class, 'index'])->name('monev.index');
    Route::get('/report', [MonevController::class, 'report'])->name('monev.create');
    Route::post('/report', [MonevController::class, 'store'])->name('monev.store');
    Route::get('/dashboard/print', [MonevController::class, 'print'])->name('monev.print'); // Route cetak laporan
    Route::get('/laporan/{id}/edit', [MonevController::class, 'edit'])->name('monev.edit');
    Route::put('/laporan/{id}', [MonevController::class, 'update'])->name('monev.update');
    Route::get('/laporan/{id}', [MonevController::class, 'show'])->name('laporan.show');
    Route::get('/admin/dashboard', function () {return view('admin.admin');})->middleware(['auth']);
    Route::get('/petugas/layouts', function () {return view('petugas.layouts');})->middleware(['auth']);
    Route::get('/petugas/dashboard', function () {return view('petugas.dashboard');})->name('petugas.dashboard')->middleware(['auth']);

    
// });
// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [MonevController::class, 'index'])->name('monev.index');
//     Route::get('/export-csv', [MonevController::class, 'exportCsv'])->name('monev.export.csv');
//     Route::get('/dashboard/print', [MonevController::class, 'print'])->name('monev.print'); 
//     Route::post('/report', [MonevController::class, 'store'])->name('monev.store'); 
    

});
Route::middleware(['auth'])->group(function () {

    // Dashboard untuk semua (admin & petugas bisa diarahkan ke view berbeda)
    Route::get('/dashboard', [MonevController::class, 'index'])->name('monev.index');
    Route::get('/monev/{id}', [MonevController::class, 'show'])->name('monev.show');
    Route::get('/monev/{id}/edit', [MonevController::class, 'edit'])->name('monev.edit');
    Route::put('/monev/{id}', [MonevController::class, 'update'])->name('monev.update');
    Route::delete('/monev/{id}', [MonevController::class, 'destroy'])->name('monev.destroy');
    Route::get('/export-csv', [MonevController::class, 'exportCsv'])->name('monev.export.csv');
    Route::post('/laporan/{id}/extend', [MonevController::class, 'extendDeadline'])->name('monev.extendDeadline');
    Route::get('/laporan/{id}/extend', [MonevController::class, 'extendForm'])->name('monev.extend');
    Route::post('/laporan/{id}/extend/update', [MonevController::class, 'extendDeadline'])->name('monev.extend.update');


    // Setting profile
    Route::get('/setting-profile', [MonevController::class, 'settingProfile'])->name('profile.setting');

    // Logout (misalnya di AuthController)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ADMIN routes
    // Route::middleware(['role:admin'])->group(function () {
    //     Route::get('/report', [MonevController::class, 'report'])->name('report.index');
    //     Route::get('/register-petugas', [MonevController::class, 'registerPetugas'])->name('register.petugas');
    //     Route::post('/register-petugas', [MonevController::class, 'savePetugas']);
    // });
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->group(function () {
    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('petugas.dashboard');
    Route::get('/laporan/{id}', [PetugasDashboardController::class, 'show'])->name('petugas.laporan.show');
    Route::get('/laporan/{id}/edit', [PetugasDashboardController::class, 'edit'])->name('petugas.laporan.edit');
    Route::put('/laporan/{id}', [PetugasDashboardController::class, 'update'])->name('petugas.laporan.update');
});

    // PETUGAS routes
    Route::middleware(['role:petugas'])->group(function () {
        Route::get('/form-input', [MonevController::class, 'inputForm'])->name('form.input');
        Route::post('/form-input', [MonevController::class, 'store']);
    });
});
// Route::get('/reports', [MonevController::class, 'reports'])->name('monev.reports');
// Route tambahan tanpa middleware spesifik
// Route::get('/dashboard', [ProductController::class, 'index']);
// Report route dengan controller
// Route::get('/reports', [MonevController::class, 'reports'])->name('reports');