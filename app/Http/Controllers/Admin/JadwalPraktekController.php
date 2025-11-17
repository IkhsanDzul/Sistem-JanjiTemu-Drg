<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\JadwalPraktek;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class JadwalPraktekController extends Controller
{
    /**
     * Menampilkan daftar jadwal praktek dokter
     */
    public function index($dokterId)
    {
        $dokter = Dokter::with('user')->findOrFail($dokterId);
        
        $jadwalPraktek = JadwalPraktek::where('dokter_id', $dokterId)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->get();

        return view('admin.jadwal-praktek.index', compact('dokter', 'jadwalPraktek'))
            ->with('title', 'Jadwal Praktek Dokter');
    }

    /**
     * Menampilkan form tambah jadwal praktek
     */
    public function create($dokterId)
    {
        $dokter = Dokter::with('user')->findOrFail($dokterId);
        
        // Ambil hari yang sudah ada jadwal
        $hariTerpakai = JadwalPraktek::where('dokter_id', $dokterId)
            ->where('status', 'aktif')
            ->pluck('hari')
            ->toArray();

        return view('admin.jadwal-praktek.create', compact('dokter', 'hariTerpakai'))
            ->with('title', 'Tambah Jadwal Praktek');
    }

    /**
     * Menyimpan jadwal praktek baru
     */
    public function store(Request $request, $dokterId)
    {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'hari.required' => 'Hari wajib dipilih.',
            'hari.in' => 'Hari tidak valid.',
            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid.',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ]);

        // Cek apakah hari sudah ada
        $jadwalExist = JadwalPraktek::where('dokter_id', $dokterId)
            ->where('hari', $request->hari)
            ->first();

        if ($jadwalExist) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal untuk hari ' . $request->hari . ' sudah ada. Silakan edit jadwal yang sudah ada.');
        }

        // Cek konflik waktu dengan jadwal lain
        $konflik = JadwalPraktek::where('dokter_id', $dokterId)
            ->where('hari', $request->hari)
            ->where('status', 'aktif')
            ->where(function($q) use ($request) {
                $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhere(function($q2) use ($request) {
                      $q2->where('jam_mulai', '<=', $request->jam_mulai)
                         ->where('jam_selesai', '>=', $request->jam_selesai);
                  });
            })
            ->exists();

        if ($konflik) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal bertabrakan dengan jadwal yang sudah ada.');
        }

        JadwalPraktek::create([
            'id' => Str::uuid(),
            'dokter_id' => $dokterId,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.dokter.jadwal-praktek.index', $dokterId)
            ->with('success', 'Jadwal praktek berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit jadwal praktek
     */
    public function edit($dokterId, $id)
    {
        $dokter = Dokter::with('user')->findOrFail($dokterId);
        $jadwal = JadwalPraktek::where('dokter_id', $dokterId)
            ->findOrFail($id);

        return view('admin.jadwal-praktek.edit', compact('dokter', 'jadwal'))
            ->with('title', 'Edit Jadwal Praktek');
    }

    /**
     * Update jadwal praktek
     */
    public function update(Request $request, $dokterId, $id)
    {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'hari.required' => 'Hari wajib dipilih.',
            'hari.in' => 'Hari tidak valid.',
            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid.',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ]);

        $jadwal = JadwalPraktek::where('dokter_id', $dokterId)
            ->findOrFail($id);

        // Cek apakah hari sudah ada (kecuali jadwal yang sedang diedit)
        $jadwalExist = JadwalPraktek::where('dokter_id', $dokterId)
            ->where('hari', $request->hari)
            ->where('id', '!=', $id)
            ->first();

        if ($jadwalExist) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal untuk hari ' . $request->hari . ' sudah ada.');
        }

        // Cek konflik waktu
        $konflik = JadwalPraktek::where('dokter_id', $dokterId)
            ->where('hari', $request->hari)
            ->where('id', '!=', $id)
            ->where('status', 'aktif')
            ->where(function($q) use ($request) {
                $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhere(function($q2) use ($request) {
                      $q2->where('jam_mulai', '<=', $request->jam_mulai)
                         ->where('jam_selesai', '>=', $request->jam_selesai);
                  });
            })
            ->exists();

        if ($konflik) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal bertabrakan dengan jadwal yang sudah ada.');
        }

        $jadwal->update([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.dokter.jadwal-praktek.index', $dokterId)
            ->with('success', 'Jadwal praktek berhasil diperbarui.');
    }

    /**
     * Hapus jadwal praktek
     */
    public function destroy($dokterId, $id)
    {
        $jadwal = JadwalPraktek::where('dokter_id', $dokterId)
            ->findOrFail($id);

        $jadwal->delete();

        return redirect()->route('admin.dokter.jadwal-praktek.index', $dokterId)
            ->with('success', 'Jadwal praktek berhasil dihapus.');
    }
}

