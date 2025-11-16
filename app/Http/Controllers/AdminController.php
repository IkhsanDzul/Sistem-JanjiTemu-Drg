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

    //Manajemen Dokter
    public function kelolaDokter()
    {
        $dokterAktif = Dokter::with('user')
            ->where('status', 'tersedia')
            ->get();
        
        $totalDokter = Dokter::count();
        $dokter = Dokter::all();

        $user = User::all();

        return view('admin.manajemen-dokter.kelola-dokter', compact('dokterAktif', 'totalDokter', 'dokter', 'user'))->with('title', 'Kelola Dokter');
    }

    public function editDokter($id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);
        return view('admin.manajemen-dokter.edit-dokter', compact('dokter'))->with('title', 'Edit Dokter');
    }

    public function updateDokter(Request $request, $id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);

        $validatedData = $request->validate([
            'no_str' => ['required', Rule::unique(Dokter::class, 'no_str')->ignore($dokter->id)],
            'pendidikan' => 'required|string|max:255',
            'pengalaman_tahun' => 'required|string|max:100',
            'spesialisasi_gigi' => 'required|string|max:100',
            'status' => 'required|in:tersedia,tidak tersedia',
        ]);

        $dokter->update($validatedData);

        return redirect()->route('admin.kelola-dokter')->with('success', 'Data dokter berhasil diperbarui.');
    }    

    public function deleteDokter($id)
    {
        $dokter = Dokter::findOrFail($id);
        $user = User::findOrFail($dokter->user_id);
        $dokter->delete();
        $user->delete();

        return redirect()->route('admin.kelola-dokter')->with('success', 'Data dokter berhasil dihapus.');
    }

    public function tambahDokter() {
        return view('admin.manajemen-dokter.tambah-dokter')->with('title', 'Tambah Dokter');
    }

    public function daftarkanDokter() {

        User::create([
            'nama_lengkap' => request('nama_lengkap'),
            'nik' => request('nik'),
            'role_id' => 'dokter',
            'email' => request('email'),
            'password' => bcrypt(request('email') . '123'),
            'nomor_telp' => request('nomor_telp'),
            'alamat' => request('alamat'),
            'tanggal_lahir' => request('tanggal_lahir'),
            'jenis_kelamin' => request('jenis_kelamin'),
        ]);

       Dokter::create([
            'user_id' => User::latest()->first()->id,
            'no_str' => request('no_str'),
            'pendidikan' => request('pendidikan'),
            'pengalaman_tahun' => request('pengalaman_tahun'),
            'spesialisasi_gigi' => request('spesialisasi_gigi'),
            'status' => 'tidak tersedia',
        ]);


        return redirect()->route('admin.kelola-dokter')->with('success', 'Data dokter berhasil ditambahkan.');
    }
}