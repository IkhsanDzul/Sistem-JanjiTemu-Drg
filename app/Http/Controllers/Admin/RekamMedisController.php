<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\JanjiTemu;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\MasterObat;
use App\Models\ResepObat;
use App\Http\Requests\Admin\StoreRekamMedisRequest;
use App\Http\Requests\Admin\UpdateRekamMedisRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class RekamMedisController extends Controller
{
    /**
     * Menampilkan daftar semua rekam medis
     */
    public function index(Request $request)
    {
        $query = RekamMedis::with(['janjiTemu.pasien.user', 'janjiTemu.dokter.user']);

        // Search berdasarkan nama pasien, dokter, atau diagnosa
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('diagnosa', 'like', "%{$search}%")
                  ->orWhere('tindakan', 'like', "%{$search}%")
                  ->orWhereHas('janjiTemu.pasien.user', function($q) use ($search) {
                      $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%");
                  })
                  ->orWhereHas('janjiTemu.dokter.user', function($q) use ($search) {
                      $q->where('nama_lengkap', 'like', "%{$search}%");
                  });
            });
        }

        // Filter berdasarkan tanggal
        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereHas('janjiTemu', function($q) use ($request) {
                $q->whereDate('tanggal', '>=', $request->tanggal_dari);
            });
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereHas('janjiTemu', function($q) use ($request) {
                $q->whereDate('tanggal', '<=', $request->tanggal_sampai);
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if ($sortBy === 'tanggal') {
            $query->join('janji_temu', 'rekam_medis.janji_temu_id', '=', 'janji_temu.id')
                  ->select('rekam_medis.*')
                  ->orderBy('janji_temu.tanggal', $sortOrder);
        } else {
            $query->orderBy('rekam_medis.' . $sortBy, $sortOrder);
        }

        $rekamMedis = $query->paginate(15);

        // Statistik
        $totalRekamMedis = RekamMedis::count();
        $totalBiaya = RekamMedis::sum('biaya') ?? 0;
        $rekamMedisBulanIni = RekamMedis::whereHas('janjiTemu', function($q) {
            $q->whereMonth('tanggal', now()->month)
              ->whereYear('tanggal', now()->year);
        })->count();

        return view('admin.rekam-medis.index', compact(
            'rekamMedis',
            'totalRekamMedis',
            'totalBiaya',
            'rekamMedisBulanIni'
        ))->with('title', 'Rekam Medis');
    }

    /**
     * Menampilkan form tambah rekam medis
     */
    public function create(Request $request)
    {
        // Ambil janji temu yang belum memiliki rekam medis
        // Bisa untuk janji temu dengan status 'confirmed' atau 'completed'
        // Saat membuat rekam medis, status akan otomatis menjadi 'completed'
        $janjiTemu = JanjiTemu::with(['pasien.user', 'dokter.user'])
            ->whereDoesntHave('rekamMedis')
            ->whereIn('status', ['confirmed', 'completed'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->get();

        // Jika ada parameter janji_temu_id, set sebagai selected
        $selectedJanjiTemuId = $request->get('janji_temu_id');

        // Ambil master obat yang aktif untuk dropdown
        $obatTersedia = MasterObat::where('aktif', true)
            ->orderBy('nama_obat', 'asc')
            ->get()
            ->map(function ($obat) {
                return [
                    'nama_obat' => $obat->nama_obat,
                    'dosis' => $obat->dosis_default ?? 0,
                    'aturan_pakai' => $obat->aturan_pakai_default ?? '',
                ];
            });

        return view('admin.rekam-medis.create', compact('janjiTemu', 'selectedJanjiTemuId', 'obatTersedia'))
            ->with('title', 'Tambah Rekam Medis');
    }

    /**
     * Menyimpan data rekam medis baru
     */

    /**
     * Menampilkan detail rekam medis
     */
    public function show($id)
    {
        $rekamMedis = RekamMedis::with([
            'janjiTemu.pasien.user',
            'janjiTemu.dokter.user',
            'resepObat'
        ])->findOrFail($id);

        // Jika resep obat ada tapi aturan pakai kosong, ambil dari master obat
        if ($rekamMedis->resepObat && $rekamMedis->resepObat->count() > 0) {
            foreach ($rekamMedis->resepObat as $resep) {
                if (empty($resep->aturan_pakai) || $resep->dosis == 0) {
                    $masterObat = MasterObat::where('nama_obat', $resep->nama_obat)
                        ->where('aktif', true)
                        ->first();
                    
                    if ($masterObat) {
                        if (empty($resep->aturan_pakai)) {
                            $resep->aturan_pakai = $masterObat->aturan_pakai_default ?? '';
                        }
                        if ($resep->dosis == 0) {
                            $resep->dosis = $masterObat->dosis_default ?? 0;
                        }
                    }
                }
            }
        }

        return view('admin.rekam-medis.show', compact('rekamMedis'))
            ->with('title', 'Detail Rekam Medis');
    }

    /**
     * Menampilkan form edit rekam medis
     */
    public function edit($id)
    {
        $rekamMedis = RekamMedis::with([
            'janjiTemu.pasien.user',
            'janjiTemu.dokter.user',
            'resepObat'
        ])->findOrFail($id);
        
        // Ambil master obat yang aktif untuk dropdown
        $obatTersedia = MasterObat::where('aktif', true)
            ->orderBy('nama_obat', 'asc')
            ->get()
            ->map(function ($obat) {
                return [
                    'nama_obat' => $obat->nama_obat,
                    'dosis' => $obat->dosis_default ?? 0,
                    'aturan_pakai' => $obat->aturan_pakai_default ?? '',
                ];
            });
        
        return view('admin.rekam-medis.edit', compact('rekamMedis', 'obatTersedia'))
            ->with('title', 'Edit Rekam Medis');
    }

    /**
     * Update data rekam medis
     */
    public function update(UpdateRekamMedisRequest $request, $id)
    {
        DB::beginTransaction();
        
        try {
            $rekamMedis = RekamMedis::with('janjiTemu.dokter')->findOrFail($id);

            // Update data rekam medis
            $rekamMedis->update([
                'diagnosa' => $request->diagnosa,
                'tindakan' => $request->tindakan,
                'catatan' => $request->catatan,
                'biaya' => $request->biaya ?? 0,
            ]);

            // Handle resep obat
            // Jika ada parameter untuk hapus resep obat
            if ($request->has('hapus_resep_obat') && $request->hapus_resep_obat) {
                // Hapus semua resep obat yang ada
                $rekamMedis->resepObat()->delete();
            }
            // Jika ada resep obat baru yang diisi (dan tidak ada checkbox hapus)
            elseif ($request->filled('resep_obat_nama') && $request->filled('resep_obat_jumlah')) {
                // Hapus resep obat lama jika ada
                $rekamMedis->resepObat()->delete();
                
                // Ambil dokter dari janji temu
                $dokter = $rekamMedis->janjiTemu->dokter;
                
                // Ambil aturan pakai dari master obat jika field kosong
                $aturanPakai = $request->resep_obat_aturan_pakai;
                $dosis = $request->resep_obat_dosis ?? 0;
                
                // Jika aturan pakai atau dosis kosong, ambil dari master obat
                if (empty($aturanPakai) || $dosis == 0) {
                    $masterObat = MasterObat::where('nama_obat', $request->resep_obat_nama)
                        ->where('aktif', true)
                        ->first();
                    
                    if ($masterObat) {
                        if (empty($aturanPakai)) {
                            $aturanPakai = $masterObat->aturan_pakai_default ?? '';
                        }
                        if ($dosis == 0) {
                            $dosis = $masterObat->dosis_default ?? 0;
                        }
                    }
                }
                
                // Buat resep obat baru
                ResepObat::create([
                    'rekam_medis_id' => $rekamMedis->id,
                    'dokter_id' => $dokter->id ?? null,
                    'tanggal_resep' => now()->toDateString(),
                    'nama_obat' => $request->resep_obat_nama,
                    'jumlah' => $request->resep_obat_jumlah,
                    'dosis' => $dosis,
                    'aturan_pakai' => $aturanPakai,
                ]);
            }
            // Jika tidak ada perubahan resep obat, biarkan tetap seperti semula

            DB::commit();

            $message = 'Rekam medis berhasil diperbarui.';
            if ($request->has('hapus_resep_obat') && $request->hapus_resep_obat) {
                $message .= ' Resep obat telah dihapus.';
            } elseif ($request->filled('resep_obat_nama') && $request->filled('resep_obat_jumlah')) {
                $message .= ' Resep obat telah diperbarui.';
            }

            return redirect()->route('admin.rekam-medis.show', $id)
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Hapus data rekam medis
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        
        try {
            $rekamMedis = RekamMedis::findOrFail($id);
            $rekamMedis->delete();

            DB::commit();

            return redirect()->route('admin.rekam-medis.index')
                ->with('success', 'Rekam medis berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

}

