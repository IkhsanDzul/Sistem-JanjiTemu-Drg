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
    Route::delete('/delete-dokter/{id}', [AdminController::class, 'deleteDokter'])->name('delete-dokter');
    Route::get('/tambah-dokter', [AdminController::class, 'tambahDokter'])->name('tambah-dokter');
    Route::post('/tambah-dokter', [AdminController::class, 'daftarkanDokter'])->name('daftarkan-dokter');
    
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

    Route::get('/daftar-pasien', function () {
        return view('dokter.daftar-pasien.index');
    })->name('daftar-pasien');

    // Rekam Medis - Simple Route
    Route::get('/rekam-medis', function () {
        return view('dokter.rekam-medis.index');
    })->name('rekam-medis');

     // Detail rekam medis
    Route::get('/rekam-medis/{id}', [RekamMedisController::class, 'show'])
     ->name('rekam-medis.show');
    Route::get('/rekam-medis/{id}/edit', [RekamMedisController::class, 'edit'])
     ->name('rekam-medis.edit');
    Route::put('/rekam-medis/{id}', [RekamMedisController::class, 'update'])
     ->name('rekam-medis.update');
     Route::delete('/rekam-medis/{id}', [RekamMedisController::class, 'destroy'])
     ->name('rekam-medis.destroy');

       // Halaman daftar & kelola janji temu
    Route::get('/janji-temu', [\App\Http\Controllers\Dokter\JanjiTemuController::class, 'index'])
    ->name('janji-temu.index');

// Detail janji temu (opsional)
Route::get('/janji-temu/{id}', [\App\Http\Controllers\Dokter\JanjiTemuController::class, 'show'])
    ->name('janji-temu.show');

    // Resep Obat
    Route::get('/resep-obat', [\App\Http\Controllers\Dokter\ResepObatController::class, 'index'])->name('resep-obat.index');
    Route::post('/resep-obat', [\App\Http\Controllers\Dokter\ResepObatController::class, 'store'])->name('resep-obat.store');
    Route::delete('/resep-obat/{id}', [\App\Http\Controllers\Dokter\ResepObatController::class, 'destroy'])->name('resep-obat.destroy');
});

// Pasien Routes
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/dashboard', [PasienController::class, 'index'])->name('dashboard');

    //cari dokter
    Route::get('/cari-dokter', [PasienController::class, 'cariDokter'])->name('cariDokter');

    //Detail Dokter
    Route::get('/detail-dokter/{id}', [PasienController::class, 'detailDokter'])->name('detail-dokter');

    // Janji Temu
    Route::get('janji-temu', [PasienController::class, 'janjiTemu'])->name('janji-temu');
    Route::post('buat-janji', [PasienController::class, 'buatJanjiTemu'])->name('buat-janji');
    Route::get('janji-temu/{id}', [PasienController::class, 'detailJanjiTemu'])->name('detail-janji-temu');
});

require __DIR__.'/auth.php';