<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPraktek;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JadwalPraktekController extends Controller
{
    /**
     * Menampilkan daftar jadwal praktek dokter yang sedang login
     */
    public function index()
    {
        $dokter = Auth::user()->dokter;
        
        if (!$dokter) {
            return redirect()->route('dokter.dashboard')
                ->with('error', 'Data dokter tidak ditemukan.');
        }

        // Ambil jadwal praktek yang akan datang (tanggal >= hari ini)
        $jadwalPraktek = JadwalPraktek::where('dokter_id', $dokter->id)
            ->where('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // Group by hari dalam seminggu (Senin, Selasa, dll) dan jam
        // Struktur: [hari => [jam_mulai-jam_selesai => [tanggal1, tanggal2, ...]]]
        $jadwalGroupedByHari = [];
        
        foreach ($jadwalPraktek as $jadwal) {
            $hari = Carbon::parse($jadwal->tanggal)->locale('id')->isoFormat('dddd'); // Senin, Selasa, dll
            $jamKey = date('H:i', strtotime($jadwal->jam_mulai)) . '-' . date('H:i', strtotime($jadwal->jam_selesai));
            
            if (!isset($jadwalGroupedByHari[$hari])) {
                $jadwalGroupedByHari[$hari] = [];
            }
            
            if (!isset($jadwalGroupedByHari[$hari][$jamKey])) {
                $jadwalGroupedByHari[$hari][$jamKey] = [
                    'jam_mulai' => $jadwal->jam_mulai,
                    'jam_selesai' => $jadwal->jam_selesai,
                    'status' => $jadwal->status,
                    'tanggal' => [],
                    'jadwal_ids' => []
                ];
            }
            
            $jadwalGroupedByHari[$hari][$jamKey]['tanggal'][] = $jadwal->tanggal;
            $jadwalGroupedByHari[$hari][$jamKey]['jadwal_ids'][] = $jadwal->id;
        }

        // Urutkan hari sesuai urutan seminggu
        $urutanHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $jadwalGroupedSorted = [];
        foreach ($urutanHari as $hari) {
            if (isset($jadwalGroupedByHari[$hari])) {
                $jadwalGroupedSorted[$hari] = $jadwalGroupedByHari[$hari];
            }
        }

        return view('dokter.jadwal-praktek.index', compact('jadwalPraktek', 'jadwalGroupedSorted'));
    }
}

