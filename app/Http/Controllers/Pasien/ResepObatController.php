<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use Barryvdh\DomPDF\Facade\Pdf;

class ResepObatController extends Controller
{
    public function show($rekam_id)
    {
        $user = auth()->user();
        $pasien = $user->pasien;

        if (!$pasien) {
            abort(403, 'Akses ditolak.');
        }

        // Pastikan rekam medis milik pasien ini
        $janjiTemuIds = \App\Models\JanjiTemu::where('pasien_id', $pasien->id)->pluck('id');

        $rekam = RekamMedis::whereIn('janji_temu_id', $janjiTemuIds)
            ->with(['resepObat'])
            ->findOrFail($rekam_id);

        return view('pasien.resep-obat.show', compact('rekam'));
    }

    public function downloadPdf($rekam_id)
    {
        $user = auth()->user();
        $pasien = $user->pasien;

        if (!$pasien) {
            abort(403, 'Akses ditolak.');
        }

        $janjiTemuIds = \App\Models\JanjiTemu::where('pasien_id', $pasien->id)->pluck('id');

        $rekam = RekamMedis::whereIn('janji_temu_id', $janjiTemuIds)
            ->with(['resepObat'])
            ->findOrFail($rekam_id);

        $pdf = Pdf::loadView('pasien.resep-obat.pdf', compact('rekam'))
            ->setPaper('A4', 'portrait');

        return $pdf->download("Resep_Obat_{$rekam->id}.pdf");
    }
}
