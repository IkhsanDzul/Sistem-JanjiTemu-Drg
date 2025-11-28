<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JanjiTemu;
use App\Models\JadwalPraktek;
use App\Models\RekamMedis;
use Carbon\Carbon;

class JanjiTemuController extends Controller
{
    // Tampilkan daftar janji temu
    public function index(Request $request)
    {
        $dokter = auth()->user()->dokter;
    
        $filter = $request->get('filter');
    
        $appointments = JanjiTemu::where('dokter_id', $dokter->id)
            ->with(['pasien.user', 'dokter.user']); 
    
        // Filter status
        if (in_array($filter, ['pending', 'confirmed', 'completed'])) {
            $appointments->where('status', $filter);
        }
    
        // Filter hari ini
        if ($filter === 'today') {
            $appointments->whereDate('tanggal', now()->toDateString());
        }
    
        // Tambahkan pagination (9 items per halaman untuk grid 3x3)
        $appointments = $appointments->orderBy('tanggal', 'asc')
                                     ->paginate(3)
                                     ->appends(['filter' => $filter]); // Preserve filter di URL
    
        return view('dokter.janji-temu.index', compact('appointments', 'filter'));
    }
    

    // Tampilkan detail janji temu
    public function show($id)
    {
        $dokter = auth()->user()->dokter;
        
        $appointment = JanjiTemu::with(['pasien.user', 'dokter.user'])
            ->where('id', $id)
            ->where('dokter_id', $dokter->id)
            ->firstOrFail();
        
        // Format data untuk view
        $appointmentFormatted = (object)[
            'id' => $appointment->id,
            'nama_pasien' => $appointment->pasien->user->nama_lengkap ?? 'N/A',
            'layanan' => 'Konsultasi Gigi',
            'tanggal' => $appointment->tanggal,
            'waktu' => Carbon::parse($appointment->jam_mulai)->format('H:i'),
            'keluhan' => $appointment->keluhan,
            'status' => $appointment->status,
        ];

        $rekamMedis = RekamMedis::where('janji_temu_id', $id)->first();
        
        return view('dokter.janji-temu.show', ['appointment' => $appointmentFormatted, 'appointmentModel' => $appointment, 'rekamMedis' => $rekamMedis]);
    }

    public function approve($id)
    {
        $dokter = auth()->user()->dokter;
        $appointment = JanjiTemu::where('id', $id)
            ->where('dokter_id', $dokter->id)
            ->firstOrFail();
        
        // Update status janji temu
        $appointment->status = 'confirmed';
        $appointment->save();

        // Catatan: Jadwal praktek TIDAK diupdate menjadi 'booked'
        // Sistem menggunakan logika: jadwal praktek tetap 'available'
        // Ketersediaan jam dicek berdasarkan janji temu yang sudah confirmed/completed
        // Ini memungkinkan multiple booking dalam satu jadwal praktek (contoh: 8-12 bisa di-booking jam 8, 9, 10, 11)

        return redirect()->route('dokter.janji-temu.show', $id)
                         ->with('success', 'Janji temu disetujui.');
    }

    public function reject($id)
    {
        $dokter = auth()->user()->dokter;
        $appointment = JanjiTemu::where('id', $id)
            ->where('dokter_id', $dokter->id)
            ->firstOrFail();
        
        // Update status janji temu
        $appointment->status = 'canceled';
        $appointment->save();

        // Catatan: Tidak perlu mengupdate status jadwal praktek
        // Karena jadwal praktek tetap 'available' dan ketersediaan dicek berdasarkan janji temu
        // Dengan mengubah status menjadi 'canceled', jam tersebut otomatis tersedia lagi

        return redirect()->route('dokter.janji-temu.show', $id)
                         ->with('success', 'Janji temu ditolak.');
    }

    public function complete($id)
    {
        $dokter = auth()->user()->dokter;
        $appointment = JanjiTemu::where('id', $id)
            ->where('dokter_id', $dokter->id)
            ->firstOrFail();
        
        // Update status janji temu
        $appointment->status = 'completed';
        $appointment->save();

        // Setelah janji temu selesai, jadwal praktek tetap booked
        // (tidak dikembalikan ke available karena sudah terpakai)
        // Jika ingin dikembalikan ke available, uncomment baris di bawah:
        /*
        $jadwalPraktek = JadwalPraktek::where('dokter_id', $dokter->id)
            ->where('tanggal', $appointment->tanggal)
            ->where('jam_mulai', $appointment->jam_mulai)
            ->where('status', 'booked')
            ->first();

        if ($jadwalPraktek) {
            $jadwalPraktek->update(['status' => 'available']);
        }
        */

        return redirect()->route('dokter.janji-temu.show', $id)
                         ->with('success', 'Janji temu selesai.');
    }
}