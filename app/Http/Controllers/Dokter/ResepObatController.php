<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResepObatController extends Controller
{
    /**
     * Tampilkan daftar resep obat atau pilih pasien
     */
    public function index(Request $request)
    {
        $pasienId = $request->query('pasien_id');
        
        // Jika tidak ada pasien_id, tampilkan daftar pasien untuk dipilih
        if (!$pasienId) {
            return redirect()->route('dokter.dashboard')
                ->with('error', 'Silakan pilih pasien terlebih dahulu.');
        }
        

        // Jika ada pasien_id, tampilkan form resep obat
        $pasien = \App\Models\Pasien::findOrFail($pasienId);
        $obat = \App\Models\Obat::all();
        $listResep = \App\Models\ResepObat::where('pasien_id', $pasienId)
            ->with('obat')
            ->get();

        return view('dokter.resep-obat.index', compact('pasien', 'obat', 'listResep'));
    }

    /**
     * Simpan resep ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'pasien_id'    => 'required|exists:pasien,id',
            'obat_id'      => 'required|exists:obat,id',
            'dosis'        => 'required|string',
            'aturan_pakai' => 'required|string',
            'jumlah'       => 'required|integer|min:1',
            'keterangan'   => 'nullable|string',
        ]);

        // Cek stok obat
        $obat = \App\Models\Obat::findOrFail($validated['obat_id']);
        if ($obat->stok < $validated['jumlah']) {
            return redirect()
                ->back()
                ->with('error', 'Stok obat tidak mencukupi.')
                ->withInput();
        }

        // Simpan resep
        \App\Models\ResepObat::create($validated);

        // Kurangi stok obat
        $obat->decrement('stok', $validated['jumlah']);

        return redirect()
            ->route('dokter.resep-obat.index', ['pasien_id' => $validated['pasien_id']])
            ->with('success', 'Resep obat berhasil ditambahkan.');
    }

    /**
     * Hapus resep obat.
     */
    public function destroy($id)
    {
        $resep = \App\Models\ResepObat::findOrFail($id);
        
        // Kembalikan stok obat
        $obat = \App\Models\Obat::find($resep->obat_id);
        if ($obat) {
            $obat->increment('stok', $resep->jumlah);
        }
        
        // Hapus resep
        $pasienId = $resep->pasien_id;
        $resep->delete();

        return redirect()
            ->route('dokter.resep-obat.index', ['pasien_id' => $pasienId])
            ->with('success', 'Resep obat berhasil dihapus.');
    }
}