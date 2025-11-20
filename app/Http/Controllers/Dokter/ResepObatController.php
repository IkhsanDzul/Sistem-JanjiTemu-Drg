<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ResepObat;
use App\Models\MasterObat;
use App\Models\RekamMedis;

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

        // Ambil master obat yang aktif
        $masterObat = MasterObat::where('aktif', true)
            ->orderBy('nama_obat', 'asc')
            ->get();

        // Ambil semua resep obat dari semua dokter (untuk statistik)
        $resepObat = ResepObat::orderBy('nama_obat', 'asc')
            ->orderBy('tanggal_resep', 'desc')
            ->get();

        // Kelompokkan berdasarkan nama_obat dan hitung statistik (untuk card statistik)
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

        // Ambil semua resep obat individual (tidak dikelompokkan) untuk ditampilkan
        $semuaResepObat = ResepObat::with(['rekamMedis.janjiTemu.pasien.user', 'dokter.user'])
            ->orderBy('tanggal_resep', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung statistik
        $totalObat = MasterObat::where('aktif', true)->count();
        $totalResep = ResepObat::count(); // Total semua resep di sistem

        return view('dokter.resep-obat.index', compact('obatTersedia', 'totalObat', 'totalResep', 'masterObat', 'semuaResepObat'));
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
     * Tampilkan form untuk menambahkan master obat baru
     */
    public function create()
    {
        return view('dokter.resep-obat.create');
    }

    /**
     * Simpan master obat baru
     */
    public function storeMasterObat(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255|unique:master_obat,nama_obat',
            'satuan' => 'nullable|string|max:50',
            'dosis_default' => 'nullable|integer|min:0',
            'aturan_pakai_default' => 'nullable|string',
            'deskripsi' => 'nullable|string',
        ]);

        $validated['aktif'] = true;

        MasterObat::create($validated);

        return redirect()
            ->route('dokter.resep-obat.index')
            ->with('success', 'Master obat berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit resep obat
     */
    public function edit($id)
    {
        $resep = ResepObat::with(['rekamMedis.janjiTemu.pasien.user', 'dokter.user'])
            ->findOrFail($id);

        // Pastikan hanya dokter yang membuat resep yang bisa edit
        $user = Auth::user();
        $dokter = $user->dokter ?? \App\Models\Dokter::where('user_id', $user->id)->first();

        if (!$dokter || $resep->dokter_id !== $dokter->id) {
            return redirect()
                ->route('dokter.resep-obat.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit resep ini.');
        }

        // Ambil master obat untuk dropdown
        $masterObat = MasterObat::where('aktif', true)
            ->orderBy('nama_obat', 'asc')
            ->get();

        return view('dokter.resep-obat.edit', compact('resep', 'masterObat'));
    }

    /**
     * Update resep obat
     */
    public function update(Request $request, $id)
    {
        $resep = ResepObat::findOrFail($id);

        // Pastikan hanya dokter yang membuat resep yang bisa update
        $user = Auth::user();
        $dokter = $user->dokter ?? \App\Models\Dokter::where('user_id', $user->id)->first();

        if (!$dokter || $resep->dokter_id !== $dokter->id) {
            return redirect()
                ->route('dokter.resep-obat.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengupdate resep ini.');
        }

        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'dosis' => 'required|integer|min:0',
            'aturan_pakai' => 'required|string',
        ]);

        $resep->update($validated);

        return redirect()
            ->route('dokter.resep-obat.index')
            ->with('success', 'Resep obat berhasil diperbarui.');
    }

    /**
     * Hapus resep obat.
     */
    public function destroy($id)
    {
        $resep = ResepObat::findOrFail($id);
        
        // Pastikan hanya dokter yang membuat resep yang bisa hapus
        $user = Auth::user();
        $dokter = $user->dokter ?? \App\Models\Dokter::where('user_id', $user->id)->first();

        if (!$dokter || $resep->dokter_id !== $dokter->id) {
            return redirect()
                ->route('dokter.resep-obat.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus resep ini.');
        }

        $resep->delete();

        return redirect()
            ->route('dokter.resep-obat.index')
            ->with('success', 'Resep obat berhasil dihapus.');
    }
}