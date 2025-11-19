<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ResepObat;

class ResepObatController extends Controller
{
    /**
     * Tampilkan daftar obat yang tersedia untuk digunakan pada rekam medis
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $dokter = $user->dokter;
        
        if (!$dokter) {
            $dokter = \App\Models\Dokter::where('user_id', $user->id)->first();
        }
        
        if (!$dokter) {
            return redirect()->route('dokter.dashboard')
                ->with('error', 'Data dokter tidak ditemukan.');
        }

        // Ambil semua resep obat dari semua dokter (obat yang tersedia di sistem)
        $resepObat = ResepObat::orderBy('nama_obat', 'asc')
            ->orderBy('tanggal_resep', 'desc')
            ->get();

        // Kelompokkan berdasarkan nama_obat dan hitung statistik
        $obatTersedia = $resepObat->groupBy('nama_obat')->map(function ($items) {
            $dosis = $items->pluck('dosis')->filter();
            $aturanPakai = $items->pluck('aturan_pakai')->unique()->values();
            
            return [
                'nama_obat' => $items->first()->nama_obat,
                'dosis_min' => $dosis->min(),
                'dosis_max' => $dosis->max(),
                'dosis_avg' => $dosis->avg(),
                'aturan_pakai_umum' => $aturanPakai->toArray(),
                'jumlah_penggunaan' => $items->count(),
                'terakhir_digunakan' => $items->max('tanggal_resep'),
            ];
        })->sortByDesc('jumlah_penggunaan')->values();

        // Hitung statistik
        $totalObat = $obatTersedia->count();
        $totalResep = ResepObat::count(); // Total semua resep di sistem

        return view('dokter.resep-obat.index', compact('obatTersedia', 'totalObat', 'totalResep'));
    }

    /**
     * Simpan resep ke database.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $dokter = $user->dokter ?? \App\Models\Dokter::where('user_id', $user->id)->first();
        
        if (!$dokter) {
            return redirect()->back()->with('error', 'Data dokter tidak ditemukan.');
        }

        // Validasi input
        $validated = $request->validate([
            'rekam_medis_id' => 'required|exists:rekam_medis,id',
            'nama_obat'      => 'required|string|max:255',
            'jumlah'         => 'required|integer|min:1',
            'dosis'          => 'required|integer|min:0',
            'aturan_pakai'   => 'required|string',
        ]);

        // Tambahkan dokter_id dan tanggal_resep
        $validated['dokter_id'] = $dokter->id;
        $validated['tanggal_resep'] = now()->toDateString();

        // Simpan resep
        ResepObat::create($validated);

        return redirect()
            ->route('dokter.resep-obat.index')
            ->with('success', 'Resep obat berhasil ditambahkan.');
    }

    /**
     * Hapus resep obat.
     */
    public function destroy($id)
    {
        $resep = ResepObat::findOrFail($id);
        $resep->delete();

        return redirect()
            ->route('dokter.resep-obat.index')
            ->with('success', 'Resep obat berhasil dihapus.');
    }
}