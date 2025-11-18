<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPraktek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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

    /**
     * Menampilkan form tambah jadwal praktek
     */
    public function create()
    {
        $dokter = Auth::user()->dokter;
        
        if (!$dokter) {
            return redirect()->route('dokter.dashboard')
                ->with('error', 'Data dokter tidak ditemukan.');
        }

        return view('dokter.jadwal-praktek.create');
    }

    /**
     * Menyimpan jadwal praktek baru
     */
    public function store(Request $request)
    {
        $dokter = Auth::user()->dokter;
        
        if (!$dokter) {
            return redirect()->route('dokter.dashboard')
                ->with('error', 'Data dokter tidak ditemukan.');
        }

        $validated = $request->validate([
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'status' => 'required|in:available,booked',
        ], [
            'tanggal.required' => 'Tanggal wajib dipilih.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'tanggal.after_or_equal' => 'Tanggal harus hari ini atau setelahnya.',
            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid.',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ]);

        // Cek apakah jadwal untuk tanggal dan jam yang sama sudah ada
        $jadwalExist = JadwalPraktek::where('dokter_id', $dokter->id)
            ->where('tanggal', $validated['tanggal'])
            ->where('jam_mulai', $validated['jam_mulai'])
            ->first();

        if ($jadwalExist) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal untuk tanggal dan jam tersebut sudah ada.');
        }

        // Cek konflik waktu dengan jadwal lain pada tanggal yang sama
        $konflik = JadwalPraktek::where('dokter_id', $dokter->id)
            ->where('tanggal', $validated['tanggal'])
            ->where('status', 'available')
            ->where(function($q) use ($validated) {
                $q->whereBetween('jam_mulai', [$validated['jam_mulai'], $validated['jam_selesai']])
                  ->orWhereBetween('jam_selesai', [$validated['jam_mulai'], $validated['jam_selesai']])
                  ->orWhere(function($q2) use ($validated) {
                      $q2->where('jam_mulai', '<=', $validated['jam_mulai'])
                         ->where('jam_selesai', '>=', $validated['jam_selesai']);
                  });
            })
            ->exists();

        if ($konflik) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal bertabrakan dengan jadwal yang sudah ada pada tanggal yang sama.');
        }

        JadwalPraktek::create([
            'id' => Str::uuid(),
            'dokter_id' => $dokter->id,
            'tanggal' => $validated['tanggal'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('dokter.jadwal-praktek.index')
            ->with('success', 'Jadwal praktek berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit jadwal praktek
     */
    public function edit($id)
    {
        $dokter = Auth::user()->dokter;
        
        if (!$dokter) {
            return redirect()->route('dokter.dashboard')
                ->with('error', 'Data dokter tidak ditemukan.');
        }

        $jadwal = JadwalPraktek::where('dokter_id', $dokter->id)
            ->findOrFail($id);

        return view('dokter.jadwal-praktek.edit', compact('jadwal'));
    }

    /**
     * Update jadwal praktek
     */
    public function update(Request $request, $id)
    {
        $dokter = Auth::user()->dokter;
        
        if (!$dokter) {
            return redirect()->route('dokter.dashboard')
                ->with('error', 'Data dokter tidak ditemukan.');
        }

        $validated = $request->validate([
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'status' => 'required|in:available,booked',
        ], [
            'tanggal.required' => 'Tanggal wajib dipilih.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'tanggal.after_or_equal' => 'Tanggal harus hari ini atau setelahnya.',
            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid.',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ]);

        $jadwal = JadwalPraktek::where('dokter_id', $dokter->id)
            ->findOrFail($id);

        // Cek apakah jadwal untuk tanggal dan jam yang sama sudah ada (kecuali jadwal yang sedang diedit)
        $jadwalExist = JadwalPraktek::where('dokter_id', $dokter->id)
            ->where('tanggal', $validated['tanggal'])
            ->where('jam_mulai', $validated['jam_mulai'])
            ->where('id', '!=', $id)
            ->first();

        if ($jadwalExist) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal untuk tanggal dan jam tersebut sudah ada.');
        }

        // Cek konflik waktu pada tanggal yang sama
        $konflik = JadwalPraktek::where('dokter_id', $dokter->id)
            ->where('tanggal', $validated['tanggal'])
            ->where('id', '!=', $id)
            ->where('status', 'available')
            ->where(function($q) use ($validated) {
                $q->whereBetween('jam_mulai', [$validated['jam_mulai'], $validated['jam_selesai']])
                  ->orWhereBetween('jam_selesai', [$validated['jam_mulai'], $validated['jam_selesai']])
                  ->orWhere(function($q2) use ($validated) {
                      $q2->where('jam_mulai', '<=', $validated['jam_mulai'])
                         ->where('jam_selesai', '>=', $validated['jam_selesai']);
                  });
            })
            ->exists();

        if ($konflik) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal bertabrakan dengan jadwal yang sudah ada pada tanggal yang sama.');
        }

        $jadwal->update([
            'tanggal' => $validated['tanggal'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('dokter.jadwal-praktek.index')
            ->with('success', 'Jadwal praktek berhasil diperbarui.');
    }

    /**
     * Hapus jadwal praktek
     */
    public function destroy($id)
    {
        $dokter = Auth::user()->dokter;
        
        if (!$dokter) {
            return redirect()->route('dokter.dashboard')
                ->with('error', 'Data dokter tidak ditemukan.');
        }

        $jadwal = JadwalPraktek::where('dokter_id', $dokter->id)
            ->findOrFail($id);

        $jadwal->delete();

        return redirect()->route('dokter.jadwal-praktek.index')
            ->with('success', 'Jadwal praktek berhasil dihapus.');
    }
}

