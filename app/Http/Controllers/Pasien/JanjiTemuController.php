<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\JanjiTemu;
use App\Models\RekamMedis;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class JanjiTemuController extends Controller
{
    public function detailJanjiTemu($id)
    {
        $user = Auth::user();
        $pasien = $user->pasien;

        if (!$pasien) {
            return redirect()->route('pasien.dashboard')
                ->with('error', 'Data pasien tidak ditemukan.');
        }

        $janjiTemu = JanjiTemu::with(['dokter.user', 'pasien.user', 'rekamMedis'])
            ->where('pasien_id', $pasien->id)
            ->findOrFail($id);

        $tanggalFormat = Carbon::parse($janjiTemu->tanggal)
            ->locale('id')
            ->isoFormat('dddd, DD MMMM YYYY');

        // Ambil ID rekam medis jika ada
        $rekamMedisId = $janjiTemu->rekamMedis ? $janjiTemu->rekamMedis->id : null;

        return view('pasien.janji-temu.detail', compact('janjiTemu', 'tanggalFormat', 'rekamMedisId'));
    }

    /**
     * Menampilkan daftar janji temu pasien
     */
    public function janjiTemuSaya(Request $request)
    {
        $user = Auth::user();
        $pasien = $user->pasien;

        // Buat paginator kosong jika pasien belum ada
        if (!$pasien) {
            $janjiTemu = new LengthAwarePaginator(
                [],
                0,
                10,
                1,
                ['path' => request()->url()]
            );
        } else {
            $status = $request->get('status', 'pending');

            $janjiTemu = JanjiTemu::where('pasien_id', $pasien->id)
                ->where('status', $status)
                ->with(['dokter.user'])
                ->orderBy('tanggal', 'desc')
                ->orderBy('jam_mulai', 'desc')
                ->paginate(10);
        }

        $belumVerifikasi = !$user->nik || !$user->nomor_telp || !$user->tanggal_lahir;

        return view('pasien.janji-temu.index', compact('janjiTemu', 'belumVerifikasi'));
    }

    /**
     * Membatalkan janji temu
     */
    public function cancelJanjiTemu(Request $request, $id)
    {
        $user = Auth::user();
        $pasien = $user->pasien;

        if (!$pasien) {
            return redirect()->route('pasien.janji-temu')
                ->with('error', 'Data pasien tidak ditemukan.');
        }

        $janjiTemu = JanjiTemu::where('pasien_id', $pasien->id)
            ->findOrFail($id);

        // Hanya bisa dibatalkan jika status masih pending atau confirmed
        if (!in_array($janjiTemu->status, ['pending', 'confirmed'])) {
            return redirect()->route('pasien.janji-temu')
                ->with('error', 'Janji temu ini tidak dapat dibatalkan.');
        }

        $janjiTemu->update(['status' => 'canceled']);

        // Catatan: Tidak perlu mengupdate status jadwal praktek
        // Karena jadwal praktek tetap 'available' dan ketersediaan dicek berdasarkan janji temu
        // Dengan mengubah status menjadi 'canceled', jam tersebut otomatis tersedia lagi

        return redirect()
            ->route('pasien.janji-temu')
            ->with('success', 'Janji temu berhasil dibatalkan.');
    }
}
