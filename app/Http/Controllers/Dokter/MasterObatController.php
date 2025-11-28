<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\MasterObat;
use Illuminate\Http\Request;

class MasterObatController extends Controller
{
    /**
     * Display a listing of master obat
     */
    public function index(Request $request)
    {
        $query = MasterObat::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_obat', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
        }

        // Filter only active medicines
        $query->where('aktif', true);

        $obatList = $query->orderBy('nama_obat', 'asc')->paginate(15);

        return view('dokter.tambah-obat.index', compact('obatList'));
    }

    /**
     * Show the form for creating a new master obat
     */
    public function create()
    {
        return view('dokter.tambah-obat.create');
    }

    /**
     * Store a newly created master obat
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'satuan' => 'nullable|string|max:50',
            'dosis_default' => 'nullable|integer|min:0',
            'aturan_pakai_default' => 'nullable|string|max:500',
            'deskripsi' => 'nullable|string|max:1000',
        ], [
            'nama_obat.required' => 'Nama obat wajib diisi',
            'nama_obat.max' => 'Nama obat maksimal 255 karakter',
            'dosis_default.integer' => 'Dosis harus berupa angka',
            'dosis_default.min' => 'Dosis tidak boleh negatif',
        ]);

        // Set aktif to true by default
        $validated['aktif'] = true;

        try {
            MasterObat::create($validated);

            return redirect()->route('dokter.tambah-obat.index')
                ->with('success', 'Master obat berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan master obat: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified master obat
     */
    public function edit($id)
    {
        $obat = MasterObat::findOrFail($id);
        return view('dokter.tambah-obat.edit', compact('obat'));
    }

    /**
     * Update the specified master obat
     */
    public function update(Request $request, $id)
    {
        $obat = MasterObat::findOrFail($id);

        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'satuan' => 'nullable|string|max:50',
            'dosis_default' => 'nullable|integer|min:0',
            'aturan_pakai_default' => 'nullable|string|max:500',
            'deskripsi' => 'nullable|string|max:1000',
        ], [
            'nama_obat.required' => 'Nama obat wajib diisi',
            'nama_obat.max' => 'Nama obat maksimal 255 karakter',
            'dosis_default.integer' => 'Dosis harus berupa angka',
            'dosis_default.min' => 'Dosis tidak boleh negatif',
        ]);

        try {
            $obat->update($validated);

            return redirect()->route('dokter.tambah-obat.index')
                ->with('success', 'Master obat berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui master obat: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified master obat (soft delete with aktif flag)
     */
    public function destroy($id)
    {
        try {
            $obat = MasterObat::findOrFail($id);
            
            // Check if medicine is being used in any prescription
            $usageCount = $obat->resepObat()->count();
            
            if ($usageCount > 0) {
                // Soft delete by setting aktif to false
                $obat->update(['aktif' => false]);
                return redirect()->route('dokter.tambah-obat.index')
                    ->with('success', 'Master obat berhasil dinonaktifkan (digunakan di ' . $usageCount . ' resep)');
            } else {
                // Hard delete if not used
                $obat->delete();
                return redirect()->route('dokter.tambah-obat.index')
                    ->with('success', 'Master obat berhasil dihapus!');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus master obat: ' . $e->getMessage());
        }
    }
}