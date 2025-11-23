<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\Dokter\JanjiTemuController; 
use App\Http\Controllers\Admin\JanjiTemuController as AdminJanjiTemuController;
use App\Http\Controllers\Admin\DokterController as AdminDokterController;
use App\Http\Controllers\Admin\PasienController as AdminPasienController;
use App\Http\Controllers\Admin\RekamMedisController as AdminRekamMedisController;
use App\Http\Controllers\Admin\JadwalPraktekController as AdminJadwalPraktekController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\ResepObatController as AdminResepObatController;
use App\Http\Controllers\Dokter\DaftarPasienController;
use App\Http\Controllers\Pasien\JanjiTemuController as PasienJanjiTemuController;
use App\Http\Controllers\Pasien\PasienController;
use App\Http\Controllers\Pasien\RekamMedisController as PasienRekamMedisController;
use App\Http\Controllers\Pasien\ResepObatController;
use App\Http\Controllers\ProfileController;
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
        
        // Pasien Routes (CRUD)
        Route::prefix('admin/pasien')->name('admin.pasien.')->group(function () {
            Route::get('/', [AdminPasienController::class, 'index'])->name('index');
            Route::get('/create', [AdminPasienController::class, 'create'])->name('create');
            Route::post('/', [AdminPasienController::class, 'store'])->name('store');
            Route::get('/{id}', [AdminPasienController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AdminPasienController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminPasienController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminPasienController::class, 'destroy'])->name('destroy');
        });
        
        // Rekam Medis Routes (CRUD)
        Route::prefix('admin/rekam-medis')->name('admin.rekam-medis.')->group(function () {
            Route::get('/', [AdminRekamMedisController::class, 'index'])->name('index');
            Route::get('/create', [AdminRekamMedisController::class, 'create'])->name('create');
            Route::post('/', [AdminRekamMedisController::class, 'store'])->name('store');
            Route::get('/{id}', [AdminRekamMedisController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AdminRekamMedisController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminRekamMedisController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminRekamMedisController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/pdf', [AdminRekamMedisController::class, 'export'])->name('pdf');
        });
        
        // Laporan Routes
        Route::prefix('admin/laporan')->name('admin.laporan.')->group(function () {
            Route::get('/', [AdminLaporanController::class, 'index'])->name('index');
            Route::get('/pasien', [AdminLaporanController::class, 'pasien'])->name('pasien');
            Route::get('/jadwal-kunjungan', [AdminLaporanController::class, 'jadwalKunjungan'])->name('jadwal-kunjungan');
            Route::get('/dokter-aktif', [AdminLaporanController::class, 'dokterAktif'])->name('dokter-aktif');
        });
        
        // Resep Obat Routes (View Only)
        Route::prefix('admin/resep-obat')->name('admin.resep-obat.')->group(function () {
            Route::get('/', [AdminResepObatController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminResepObatController::class, 'show'])->name('show');
        });
    });

    // Dokter routes
    Route::middleware('role:dokter')->group(function () {
        Route::get('/dokter/dashboard', [DokterController::class, 'index'])->name('dokter.dashboard');
        Route::get('/dokter/resep-obat', function () {
            return view('dokter.resepobat');
        })->name('dokter.resepobat');
    });

    // Pasien routes
    Route::middleware('role:pasien')->group(function () {
        Route::get('/pasien/dashboard', [PasienController::class, 'index'])->name('pasien.dashboard');
    });  


// Dokter Routes
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
      // Dashboard - menggunakan controller yang sudah ada
      Route::get('/dashboard', [DokterController::class, 'index'])->name('dashboard');

      Route::get('/daftar-pasien', 
      [DaftarPasienController::class, 'index']
)->name('daftar-pasien');

Route::get('/daftar-pasien/{id}', [DaftarPasienController::class, 'show'])
->name('daftar-pasien.show');


    // Rekam Medis Routes
    Route::get('/rekam-medis', [\App\Http\Controllers\Dokter\RekamMedisController::class, 'index'])->name('rekam-medis');
    Route::get('/rekam-medis/{id}', [\App\Http\Controllers\Dokter\RekamMedisController::class, 'show'])->name('rekam-medis.show');
    Route::post('/rekam-medis', [\App\Http\Controllers\Dokter\RekamMedisController::class, 'store'])->name('rekam-medis.store');
    Route::get('/rekam-medis/{id}/edit', [\App\Http\Controllers\Dokter\RekamMedisController::class, 'edit'])->name('rekam-medis.edit');
    Route::put('/rekam-medis/{id}', [\App\Http\Controllers\Dokter\RekamMedisController::class, 'update'])->name('rekam-medis.update');
    Route::delete('/rekam-medis/{id}', [\App\Http\Controllers\Dokter\RekamMedisController::class, 'destroy'])->name('rekam-medis.destroy');

     Route::get('/janji-temu', [JanjiTemuController::class, 'index'])->name('janji-temu.index');
     Route::get('/janji-temu/{id}', [JanjiTemuController::class, 'show'])->name('janji-temu.show');
     Route::patch('/janji-temu/{id}/approve', [JanjiTemuController::class, 'approve'])->name('janji-temu.approve');
     Route::patch('/janji-temu/{id}/reject', [JanjiTemuController::class, 'reject'])->name('janji-temu.reject');
     Route::patch('/janji-temu/{id}/complete', [JanjiTemuController::class, 'complete'])->name('janji-temu.complete');
     
    // Jadwal Praktek
    Route::get('/jadwal-praktek', [\App\Http\Controllers\Dokter\JadwalPraktekController::class, 'index'])->name('jadwal-praktek.index');
    Route::get('/jadwal-praktek/create', [\App\Http\Controllers\Dokter\JadwalPraktekController::class, 'create'])->name('jadwal-praktek.create');
    Route::post('/jadwal-praktek', [\App\Http\Controllers\Dokter\JadwalPraktekController::class, 'store'])->name('jadwal-praktek.store');
    Route::get('/jadwal-praktek/{id}/edit', [\App\Http\Controllers\Dokter\JadwalPraktekController::class, 'edit'])->name('jadwal-praktek.edit');
    Route::put('/jadwal-praktek/{id}', [\App\Http\Controllers\Dokter\JadwalPraktekController::class, 'update'])->name('jadwal-praktek.update');
    Route::delete('/jadwal-praktek/{id}', [\App\Http\Controllers\Dokter\JadwalPraktekController::class, 'destroy'])->name('jadwal-praktek.destroy');
     
    // Resep Obat
    Route::get('/resep-obat', [\App\Http\Controllers\Dokter\ResepObatController::class, 'index'])->name('resep-obat.index');
    Route::get('/resep-obat/create', [\App\Http\Controllers\Dokter\ResepObatController::class, 'create'])->name('resep-obat.create');
    Route::post('/resep-obat/master', [\App\Http\Controllers\Dokter\ResepObatController::class, 'storeMasterObat'])->name('resep-obat.store-master');
    Route::post('/resep-obat', [\App\Http\Controllers\Dokter\ResepObatController::class, 'store'])->name('resep-obat.store');
    Route::get('/resep-obat/{id}/edit', [\App\Http\Controllers\Dokter\ResepObatController::class, 'edit'])->name('resep-obat.edit');
    Route::put('/resep-obat/{id}', [\App\Http\Controllers\Dokter\ResepObatController::class, 'update'])->name('resep-obat.update');
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
    Route::post('buat-janji', [PasienController::class, 'store'])->name('buat-janji');
    Route::get('janji-temu', [PasienJanjiTemuController::class, 'show'])->name('janji-temu');
    Route::get('janji-temu/{id}', [PasienJanjiTemuController::class, 'index'])->name('detail-janji-temu');
    Route::post('janji-temu/{id}/cancel', [PasienJanjiTemuController::class, 'cancel'])->name('cancel-janji-temu');
    
    //Rekam Medis
    Route::get('/rekam-medis', [PasienRekamMedisController::class, 'index'])->name('rekam-medis');
    Route::get('/rekam-medis/{id}', [PasienRekamMedisController::class, 'detail'])->name('rekam-medis.detail');
    Route::get('/rekam-medis/{id}/pdf', [PasienRekamMedisController::class, 'export'])->name('rekam-medis.pdf');

    //Resep Obat
    Route::get('/resep-obat/{rekam_id}', [ResepObatController::class, 'show'])->name('resep-obat.show');
    Route::get('/resep-obat/{rekam_id}/pdf', [ResepObatController::class, 'export'])->name('resep-obat.pdf');
});

require __DIR__.'/auth.php';