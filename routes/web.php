<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\JanjiTemuController as AdminJanjiTemuController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role_id;
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'dokter':
                return redirect()->route('dokter.dashboard');
            case 'pasien':
                return redirect()->route('pasien.dashboard');
            default:
                return redirect()->route('login');
        }
    }
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    //Manajemen Dokter
    Route::get('/kelola-dokter', [AdminController::class, 'kelolaDokter'])->name('kelola-dokter');
    Route::get('/edit-dokter/{id}', [AdminController::class, 'editDokter'])->name('edit-dokter');
    Route::patch('/update-dokter/{id}', [AdminController::class, 'updateDokter'])->name('update-dokter');
    
    //Janji Temu
    Route::get('/janji-temu', [AdminJanjiTemuController::class, 'index'])->name('janji-temu.index');
    Route::get('/janji-temu/{id}', [AdminJanjiTemuController::class, 'show'])->name('janji-temu.show');
    Route::post('/janji-temu/{id}/update-status', [AdminJanjiTemuController::class, 'updateStatus'])->name('janji-temu.update-status');
});

// Dokter Routes
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dokter.dashboard');
    })->name('dashboard');

    // Rekam Medis - Simple Route
    Route::get('/rekam-medis', function () {
        return view('dokter.rekam-medis');
    })->name('rekam-medis');

    // Resep Obat
    Route::get('/resep-obat', function () {
        return view('dokter.resep-obat');
    })->name('resep-obat');
});

// Pasien Routes
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/dashboard', [PasienController::class, 'index'])->name('dashboard');

    //cari dokter
    Route::get('/cari-dokter', [PasienController::class, 'cariDokter'])->name('cariDokter');
});

require __DIR__.'/auth.php';