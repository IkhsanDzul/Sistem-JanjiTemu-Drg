<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\JanjiTemu;
use App\Models\Pasien;
use Carbon\Carbon;

class DokterController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Pastikan relasi dokter dimuat
        $dokter = $user->dokter;
        
        // Jika tidak ada relasi dokter, coba cari berdasarkan user_id
        if (!$dokter) {
            $dokter = \App\Models\Dokter::where('user_id', $user->id)->first();
        }
        
        if (!$dokter) {
            return view('dokter.dashboard', [
                'totalPasien' => 0,
                'janjiTemuHariIni' => 0,
                'statusPending' => 0,
                'statusSelesai' => 0,
                'janjiTemuTerbaru' => collect(),
                'jadwalPraktekTerdekat' => collect(),
            ]);
        }

        // Total pasien unik yang pernah berjanji temu dengan dokter ini
        // Menggunakan DB raw untuk mendapatkan pasien unik
        $totalPasien = DB::table('janji_temu')
            ->where('dokter_id', $dokter->id)
            ->distinct()
            ->count('pasien_id');

        // Janji temu hari ini - menggunakan Carbon untuk perbandingan tanggal
        $janjiTemuHariIni = JanjiTemu::where('dokter_id', $dokter->id)
            ->whereDate('tanggal', Carbon::today())
            ->count();

        // Status pending
        $statusPending = JanjiTemu::where('dokter_id', $dokter->id)
            ->where('status', 'pending')
            ->count();

        // Status selesai (completed)
        $statusSelesai = JanjiTemu::where('dokter_id', $dokter->id)
            ->where('status', 'completed')
            ->count();

        // Janji temu terbaru (5 terakhir) dengan relasi lengkap
        $janjiTemuTerbaru = JanjiTemu::where('dokter_id', $dokter->id)
            ->with(['pasien.user', 'dokter.user'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Jadwal praktek terdekat (5 terdekat yang akan datang)
        $jadwalPraktekTerdekat = \App\Models\JadwalPraktek::where('dokter_id', $dokter->id)
            ->where('tanggal', '>=', Carbon::today())
            ->where('status', 'available')
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->limit(5)
            ->get();

        return view('dokter.dashboard', compact(
            'totalPasien',
            'janjiTemuHariIni',
            'statusPending',
            'statusSelesai',
            'janjiTemuTerbaru',
            'jadwalPraktekTerdekat'
        ));
    }
}
