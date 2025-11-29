<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\JadwalPraktek;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class JadwalPraktekController extends Controller
{
    use LogsActivity;
    /**
     * Menampilkan daftar jadwal praktek dokter
     */
    public function index($dokterId)
    {
        $dokter = Dokter::with('user')->findOrFail($dokterId);
        
        $jadwalPraktek = JadwalPraktek::where('dokter_id', $dokterId)
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
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

        return view('admin.jadwal-praktek.create', compact('dokter'))
            ->with('title', 'Tambah Jadwal Praktek');
    }

    /**
     * Menyimpan jadwal praktek baru
     */
    public function store(Request $request, $dokterId)
    {
        $request->validate([
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
        $jadwalExist = JadwalPraktek::where('dokter_id', $dokterId)
            ->where('tanggal', $request->tanggal)
            ->where('jam_mulai', $request->jam_mulai)
            ->first();

        if ($jadwalExist) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal untuk tanggal dan jam tersebut sudah ada. Silakan edit jadwal yang sudah ada.');
        }

        // Cek konflik waktu dengan jadwal lain pada tanggal yang sama
        $konflik = JadwalPraktek::where('dokter_id', $dokterId)
            ->where('tanggal', $request->tanggal)
            ->where('status', 'available')
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
                ->with('error', 'Jadwal bertabrakan dengan jadwal yang sudah ada pada tanggal yang sama.');
        }

        JadwalPraktek::create([
            'id' => Str::uuid(),
            'dokter_id' => $dokterId,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => $request->status,
        ]);

        // Log aktivitas
        $this->logActivity('buat');

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

        $jadwal = JadwalPraktek::where('dokter_id', $dokterId)
            ->findOrFail($id);

        // Cek apakah jadwal untuk tanggal dan jam yang sama sudah ada (kecuali jadwal yang sedang diedit)
        $jadwalExist = JadwalPraktek::where('dokter_id', $dokterId)
            ->where('tanggal', $request->tanggal)
            ->where('jam_mulai', $request->jam_mulai)
            ->where('id', '!=', $id)
            ->first();

        if ($jadwalExist) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal untuk tanggal dan jam tersebut sudah ada.');
        }

        // Cek konflik waktu pada tanggal yang sama
        $konflik = JadwalPraktek::where('dokter_id', $dokterId)
            ->where('tanggal', $request->tanggal)
            ->where('id', '!=', $id)
            ->where('status', 'available')
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
                ->with('error', 'Jadwal bertabrakan dengan jadwal yang sudah ada pada tanggal yang sama.');
        }

        $jadwal->update([
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => $request->status,
        ]);

        // Log aktivitas
        $this->logActivity('edit');

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

        // Log aktivitas
        $this->logActivity('hapus');

        return redirect()->route('admin.dokter.jadwal-praktek.index', $dokterId)
            ->with('success', 'Jadwal praktek berhasil dihapus.');
    }
}

