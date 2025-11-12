<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Kalau user sudah login, langsung arahkan ke dashboard masing-masing role
    if (Auth::check()) {
        $role = Auth::user()->role_id;

        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'dokter' => redirect()->route('dokter.dashboard'),
            default => redirect()->route('dashboard'),
        };
    }

    return view('welcome');
})->name('home');

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

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });

    Route::middleware('role:dokter')->group(function () {
        Route::get('/dokter/dashboard', [DokterController::class, 'index'])->name('dokter.dashboard');
    });

    Route::middleware('role:pasien')->group(function () {
        Route::get('/pasien/dashboard', [PasienController::class, 'index'])->name('pasien.dashboard');
    });
});

require __DIR__ . '/auth.php';
