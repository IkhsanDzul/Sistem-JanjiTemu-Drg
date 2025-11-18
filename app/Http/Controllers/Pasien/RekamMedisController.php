<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\JanjiTemu;
use App\Models\RekamMedis;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class RekamMedisController extends Controller
{
    /**
     * Menampilkan daftar rekam medis pasien
     */
    public function rekamMedis()
    {
        $user = Auth::user();
        $pasien = $user->pasien;

        // Buat paginator kosong jika pasien belum ada
        if (!$pasien) {
            $rekamMedis = new LengthAwarePaginator(
                [],
                0,
                10,
                1,
                ['path' => request()->url()]
            );
        } else {
            // Ambil ID janji temu pasien
            $janjiTemuIds = JanjiTemu::where('pasien_id', $pasien->id)
                ->pluck('id');

            // Ambil rekam medis berdasarkan janji temu
            $rekamMedis = RekamMedis::whereIn('janji_temu_id', $janjiTemuIds)
                ->with(['janjiTemu.dokter.user'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        $belumVerifikasi = !$user->nik || !$user->nomor_telp || !$user->tanggal_lahir;

        return view('pasien.rekam-medis.index', compact('rekamMedis', 'belumVerifikasi'));
    }

    /**
     * Menampilkan detail rekam medis
     */
    public function rekamMedisDetail($id)
    {
        $user = Auth::user();
        $pasien = $user->pasien;

        if (!$pasien) {
            return redirect()->route('pasien.rekam-medis')
                ->with('error', 'Data pasien tidak ditemukan.');
        }

        $janjiTemuIds = JanjiTemu::where('pasien_id', $pasien->id)->pluck('id');

        $rekam = RekamMedis::whereIn('janji_temu_id', $janjiTemuIds)
            ->with([
                'janjiTemu.dokter.user',
                'janjiTemu.pasien.user',
                'resepObat'
            ])
            ->findOrFail($id);

        return view('pasien.rekam-medis.detail', compact('rekam'));
    }

    public function downloadPdf($id)
    {
        $user = auth()->user();
        $pasien = $user->pasien;

        if (!$pasien) {
            abort(403, 'Akses ditolak.');
        }

        // Pastikan rekam medis milik pasien ini
        $janjiTemuIds = JanjiTemu::where('pasien_id', $pasien->id)->pluck('id');

        $rekam = RekamMedis::whereIn('janji_temu_id', $janjiTemuIds)
            ->with([
                'janjiTemu.dokter.user',
                'janjiTemu.pasien.user'
            ])
            ->findOrFail($id);

        // Generate PDF using the DOMPDF wrapper from the container to avoid facade type issues
        $pdf = Pdf::loadView('pasien.rekam-medis.pdf', compact('rekam'))
            ->setPaper('A4', 'portrait');

        return $pdf->download("Rekam_Medis_{$rekam->id}.pdf");
    }
}
