<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\JanjiTemu;
use App\Models\RekamMedis;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        // Statistik Umum
        $totalPasien = Pasien::count();
        $totalDokter = Dokter::count();
        $totalAdmin = User::where('role_id', 'admin')->count();
        
        // Statistik Janji Temu
        $janjiTemuHariIni = JanjiTemu::whereDate('tanggal', today())->count();
        $janjiTemuMingguIni = JanjiTemu::whereBetween('tanggal', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        $janjiTemuBulanIni = JanjiTemu::whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();
        
        // Statistik Status Janji Temu
        $janjiPending = JanjiTemu::where('status', 'pending')->count();
        $janjiConfirmed = JanjiTemu::where('status', 'confirmed')->count();
        $janjiCompleted = JanjiTemu::where('status', 'completed')->count();
        $janjiCanceled = JanjiTemu::where('status', 'canceled')->count();
        
        // Statistik Pendapatan
        $pendapatanBulanIni = RekamMedis::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('biaya') ?? 0;
        
        $pendapatanHariIni = RekamMedis::whereDate('created_at', today())
            ->sum('biaya') ?? 0;
        
        // Data Terbaru
        $janjiTemuTerbaru = JanjiTemu::with(['pasien.user', 'dokter.user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $userTerbaru = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        $dokterAktif = Dokter::with('user')
            ->where('status', 'aktif')
            ->limit(5)
            ->get();
        
        $logsTerbaru = Log::with('admin')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Statistik Janji Temu per Bulan (untuk chart)
        $janjiTemuPerBulan = JanjiTemu::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('tanggal', Carbon::now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return view('admin.dashboard', compact(
            'totalPasien',
            'totalDokter',
            'totalAdmin',
            'janjiTemuHariIni',
            'janjiTemuMingguIni',
            'janjiTemuBulanIni',
            'janjiPending',
            'janjiConfirmed',
            'janjiCompleted',
            'janjiCanceled',
            'pendapatanBulanIni',
            'pendapatanHariIni',
            'janjiTemuTerbaru',
            'userTerbaru',
            'dokterAktif',
            'logsTerbaru',
            'janjiTemuPerBulan'
        ))->with('title', 'Dashboard Admin');
    }
};