<?php

namespace App\Traits;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait LogsActivity
{
    /**
     * Membuat log aktivitas
     * 
     * @param string $action Action yang dilakukan: 'buat', 'edit', 'hapus'
     * @return void
     */
    protected function logActivity(string $action)
    {
        // Pastikan user sudah login dan adalah admin
        if (!Auth::check() || Auth::user()->role_id !== 'admin') {
            return;
        }

        $user = Auth::user();
        
        // Ambil admin record dari user
        $admin = $user->admin;
        
        if (!$admin) {
            return;
        }

        // Buat log
        try {
            Log::create([
                'id' => Str::uuid(),
                'admin_id' => $admin->id,
                'action' => $action,
            ]);
        } catch (\Exception $e) {
            // Jika terjadi error, jangan ganggu proses utama
            // Log error untuk debugging
            \Log::error('Gagal membuat log aktivitas: ' . $e->getMessage());
        }
    }
}


