<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\Dokter\JanjiTemuController; 
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\JanjiTemuController as AdminJanjiTemuController;
use App\Http\Controllers\Admin\DokterController as AdminDokterController;
use App\Http\Controllers\Admin\JadwalPraktekController as AdminJadwalPraktekController;
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
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        
        // Dokter Routes (CRUD)
        Route::prefix('admin/dokter')->name('admin.dokter.')->group(function () {
            Route::get('/', [AdminDokterController::class, 'index'])->name('index');
            Route::get('/create', [AdminDokterController::class, 'create'])->name('create');
            Route::post('/', [AdminDokterController::class, 'store'])->name('store');
            Route::get('/{id}', [AdminDokterController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AdminDokterController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminDokterController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminDokterController::class, 'destroy'])->name('destroy');
            
        });
        
        // Jadwal Praktek Routes (harus di luar prefix dokter untuk menghindari konflik)
        Route::prefix('admin/dokter/{dokterId}/jadwal-praktek')->name('admin.dokter.jadwal-praktek.')->group(function () {
            Route::get('/', [AdminJadwalPraktekController::class, 'index'])->name('index');
            Route::get('/create', [AdminJadwalPraktekController::class, 'create'])->name('create');
            Route::post('/', [AdminJadwalPraktekController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminJadwalPraktekController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminJadwalPraktekController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminJadwalPraktekController::class, 'destroy'])->name('destroy');
        });
        
        // Janji Temu Routes
        Route::prefix('admin/janji-temu')->name('admin.janji-temu.')->group(function () {
            Route::get('/', [AdminJanjiTemuController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminJanjiTemuController::class, 'show'])->name('show');
            Route::patch('/{id}/status', [AdminJanjiTemuController::class, 'updateStatus'])->name('update-status');
        });
    });

    // Dokter routes
    Route::middleware('role:dokter')->group(function () {
        Route::get('/dokter/dashboard', [DokterController::class, 'index'])->name('dokter.dashboard');
        Route::get('/dokter/resep-obat', function () {
            return view('dokter.resepobat');
        })->name('dokter.resepobat');
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

     Route::get('/janji-temu', [JanjiTemuController::class, 'index'])->name('janji-temu.index');
     Route::get('/janji-temu/{id}', [JanjiTemuController::class, 'show'])->name('janji-temu.show');
     Route::patch('/janji-temu/{id}/approve', [JanjiTemuController::class, 'approve'])->name('janji-temu.approve');
     Route::patch('/janji-temu/{id}/reject', [JanjiTemuController::class, 'reject'])->name('janji-temu.reject');
     
    // Resep Obat
    Route::get('/resep-obat', [\App\Http\Controllers\Dokter\ResepObatController::class, 'index'])->name('resep-obat.index');
    Route::post('/resep-obat', [\App\Http\Controllers\Dokter\ResepObatController::class, 'store'])->name('resep-obat.store');
    Route::delete('/resep-obat/{id}', [\App\Http\Controllers\Dokter\ResepObatController::class, 'destroy'])->name('resep-obat.destroy');
});

// Pasien Routes
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/dashboard', [PasienController::class, 'index'])->name('dashboard');

    //cari dokter
    Route::get('/cari-dokter', [PasienController::class, 'index'])->name('cariDokter');

    //Detail Dokter
    Route::get('/detail-dokter/{id}', [PasienController::class, 'detailDokter'])->name('detail-dokter');

    // Janji Temu
    Route::get('janji-temu', [PasienController::class, 'janjiTemuSaya'])->name('janji-temu');
    Route::post('buat-janji', [PasienController::class, 'buatJanjiTemu'])->name('buat-janji');
    Route::get('janji-temu/{id}', [PasienController::class, 'detailJanjiTemu'])->name('detail-janji-temu');
    Route::post('janji-temu/{id}/cancel', [PasienController::class, 'cancelJanjiTemu'])->name('cancel-janji-temu');
    
    //Rekam Medis
    Route::get('/rekam-medis', [PasienController::class, 'rekamMedis'])->name('rekam-medis');
    Route::get('/rekam-medis/{id}', [PasienController::class, 'rekamMedisDetail'])->name('rekam-medis.detail');
});

require __DIR__.'/auth.php';