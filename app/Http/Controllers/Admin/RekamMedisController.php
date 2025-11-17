<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\JanjiTemu;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Http\Requests\Admin\StoreRekamMedisRequest;
use App\Http\Requests\Admin\UpdateRekamMedisRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        $janjiTemu = JanjiTemu::with(['pasien.user', 'dokter.user'])
            ->whereDoesntHave('rekamMedis')
            ->where('status', 'completed')
            ->orderBy('tanggal', 'desc')
            ->get();

        // Jika ada parameter janji_temu_id, set sebagai selected
        $selectedJanjiTemuId = $request->get('janji_temu_id');

        return view('admin.rekam-medis.create', compact('janjiTemu', 'selectedJanjiTemuId'))
            ->with('title', 'Tambah Rekam Medis');
    }

    /**
     * Menyimpan data rekam medis baru
     */
    public function store(StoreRekamMedisRequest $request)
    {
        DB::beginTransaction();
        
        try {
            // Validasi janji temu
            $janjiTemu = JanjiTemu::findOrFail($request->janji_temu_id);
            
            // Cek apakah janji temu sudah memiliki rekam medis
            if ($janjiTemu->rekamMedis) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Janji temu ini sudah memiliki rekam medis.');
            }

            // Buat rekam medis
            $rekamMedis = RekamMedis::create([
                'id' => Str::uuid(),
                'janji_temu_id' => $request->janji_temu_id,
                'diagnosa' => $request->diagnosa,
                'tindakan' => $request->tindakan,
                'catatan' => $request->catatan,
                'biaya' => $request->biaya ?? 0,
            ]);

            DB::commit();

            return redirect()->route('admin.rekam-medis.show', $rekamMedis->id)
                ->with('success', 'Rekam medis berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail rekam medis
     */
    public function show($id)
    {
        $rekamMedis = RekamMedis::with([
            'janjiTemu.pasien.user',
            'janjiTemu.dokter.user'
        ])->findOrFail($id);

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
            'janjiTemu.dokter.user'
        ])->findOrFail($id);
        
        return view('admin.rekam-medis.edit', compact('rekamMedis'))
            ->with('title', 'Edit Rekam Medis');
    }

    /**
     * Update data rekam medis
     */
    public function update(UpdateRekamMedisRequest $request, $id)
    {
        DB::beginTransaction();
        
        try {
            $rekamMedis = RekamMedis::findOrFail($id);

            // Update data rekam medis
            $rekamMedis->update([
                'diagnosa' => $request->diagnosa,
                'tindakan' => $request->tindakan,
                'catatan' => $request->catatan,
                'biaya' => $request->biaya ?? 0,
            ]);

            DB::commit();

            return redirect()->route('admin.rekam-medis.show', $id)
                ->with('success', 'Rekam medis berhasil diperbarui.');

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

