<?php

use App\Http\Controllers\Admin\MonevController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Route halaman utama
Route::get('/', function () {
    return view('home', ['title' => 'Dashboard']);
});
Route::get('/reports', [MonevController::class, 'reports'])->name('monev.reports');


// Route autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
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
    
});
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [MonevController::class, 'index'])->name('monev.index');
    Route::get('/export-csv', [MonevController::class, 'exportCsv'])->name('monev.export.csv');
    Route::get('/dashboard/print', [MonevController::class, 'print'])->name('monev.print'); 
    Route::post('/report', [MonevController::class, 'store'])->name('monev.store'); 
    Route::get('/monev/{id}', [MonevController::class, 'show'])->name('monev.show');
    Route::get('/monev/{id}/edit', [MonevController::class, 'edit'])->name('monev.edit');
    Route::put('/monev/{id}', [MonevController::class, 'update'])->name('monev.update');
    Route::delete('/monev/{id}', [MonevController::class, 'destroy'])->name('monev.destroy');

});

// Route::get('/reports', [MonevController::class, 'reports'])->name('monev.reports');
// Route tambahan tanpa middleware spesifik
// Route::get('/dashboard', [ProductController::class, 'index']);
// Report route dengan controller
// Route::get('/reports', [MonevController::class, 'reports'])->name('reports');