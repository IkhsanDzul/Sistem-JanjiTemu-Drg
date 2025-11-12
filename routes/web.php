<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
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
                Auth::logout();
                return redirect('/login');
        }
    }
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Route dashboard umum yang redirect ke dashboard sesuai role
    Route::get('/dashboard', function () {
        $role = Auth::user()->role_id;
        
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'dokter' => redirect()->route('dokter.dashboard'),
            'pasien' => redirect()->route('pasien.dashboard'),
            default => redirect('/'),
        };
    })->name('dashboard');

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });

    // Dokter routes
    Route::middleware('role:dokter')->group(function () {
        Route::get('/dokter/dashboard', [DokterController::class, 'index'])->name('dokter.dashboard');
        Route::get('/dokter/resep-obat', function () {
            return view('dokter.resepobat');
        })->name('dokter.resepobat');

        // Route::get('/dokter/rekam-medis', [RekamMedisController::class, 'index'])->name('dokter.rekam-medis');
        // Route::get('/dokter/rekam-medis/create', [RekamMedisController::class, 'create'])->name('dokter.rekam-medis.create');
        // Route::post('/dokter/rekam-medis', [RekamMedisController::class, 'store'])->name('dokter.rekam-medis.store');
        // Route::get('/dokter/rekam-medis/{id}', [RekamMedisController::class, 'show'])->name('dokter.rekam-medis.show');
    });

    // Pasien routes
    Route::middleware('role:pasien')->group(function () {
        Route::get('/pasien/dashboard', [PasienController::class, 'index'])->name('pasien.dashboard');
    });
});


require __DIR__ . '/auth.php';
