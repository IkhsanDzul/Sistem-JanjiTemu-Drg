<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\JanjiTemu;
use App\Models\ResepObat;
use App\Models\MasterObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RekamMedisController extends Controller
{
    /**
     * Menampilkan halaman daftar rekam medis pasien
     */
    public function index(Request $request)
    {
        // Ambil dokter yang sedang login
        $user = Auth::user();
        $dokter = $user->dokter ?? \App\Models\Dokter::where('user_id', $user->id)->first();
        
        if (!$dokter) {
            return view('dokter.rekam-medis.index', [
                'pasiens' => collect([])->paginate(10),
                'totalRekamMedis' => 0,
                'rekamMedisBulanIni' => 0,
                'rekamMedisHariIni' => 0,
                'totalPasien' => 0
            ]);
        }

        // Query dasar untuk pasien yang pernah membuat janji temu dengan dokter ini
        // Hanya pasien yang memiliki rekam medis
        $janjiTemuIds = JanjiTemu::where('dokter_id', $dokter->id)->pluck('id');
        $rekamMedisJanjiTemuIds = RekamMedis::whereIn('janji_temu_id', $janjiTemuIds)->pluck('janji_temu_id');
        $pasienIdsDariRekamMedis = JanjiTemu::whereIn('id', $rekamMedisJanjiTemuIds)->pluck('pasien_id')->unique();
        
        $query = Pasien::with([
            'user', // Relasi ke tabel users
            'janjiTemu' => function($q) use ($dokter) {
                $q->where('dokter_id', $dokter->id)
                  ->with(['dokter.user', 'rekamMedis'])
                  ->orderBy('tanggal', 'desc')
                  ->orderBy('jam_mulai', 'desc');
            }
        ])
        ->whereIn('id', $pasienIdsDariRekamMedis);

        // Filter pencarian berdasarkan nama atau NIK
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan tanggal kunjungan
        if ($request->filled('tanggal')) {
            $tanggal = $request->tanggal;
            $query->whereHas('janjiTemu', function($q) use ($tanggal, $dokter) {
                $q->where('tanggal', $tanggal)
                  ->where('dokter_id', $dokter->id);
            });
        }

        // Ambil data pasien dengan pagination
        $pasiens = $query->distinct()->paginate(10);

        // Tambahkan kunjungan terakhir dan jumlah rekam medis untuk setiap pasien
        $pasiens->getCollection()->transform(function ($pasien) use ($dokter, $rekamMedisJanjiTemuIds) {
            // Hitung jumlah rekam medis per pasien
            $pasienJanjiTemuIds = $pasien->janjiTemu()
                ->where('dokter_id', $dokter->id)
                ->pluck('id');
            $pasien->rekam_medis_count = RekamMedis::whereIn('janji_temu_id', $pasienJanjiTemuIds)
                ->whereIn('janji_temu_id', $rekamMedisJanjiTemuIds)
                ->count();
            
            // Kunjungan terakhir yang memiliki rekam medis
            $pasien->kunjungan_terakhir = $pasien->janjiTemu()
                ->where('dokter_id', $dokter->id)
                ->whereIn('id', $rekamMedisJanjiTemuIds)
                ->where('status', 'completed')
                ->orderBy('tanggal', 'desc')
                ->orderBy('jam_mulai', 'desc')
                ->first();
            return $pasien;
        });

        // Statistik hanya untuk dokter ini
        // Ambil ID janji temu dokter ini
        $janjiTemuIds = JanjiTemu::where('dokter_id', $dokter->id)->pluck('id');
        
        $totalRekamMedis = RekamMedis::whereIn('janji_temu_id', $janjiTemuIds)->count();
        
        $rekamMedisBulanIni = RekamMedis::whereIn('janji_temu_id', $janjiTemuIds)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        $rekamMedisHariIni = RekamMedis::whereIn('janji_temu_id', $janjiTemuIds)
            ->whereDate('created_at', Carbon::today())
            ->count();
        
        // Total pasien yang memiliki rekam medis
        $totalPasien = Pasien::whereIn('id', $pasienIdsDariRekamMedis)->distinct()->count();

        return view('dokter.rekam-medis.index', compact(
            'pasiens',
            'totalRekamMedis',
            'rekamMedisBulanIni',
            'rekamMedisHariIni',
            'totalPasien'
        ));
    }

    /**
     * Menampilkan detail pasien dan rekam medisnya
     */
    public function show($id)
    {
        // Ambil dokter yang sedang login
        $user = Auth::user();
        $dokter = $user->dokter ?? \App\Models\Dokter::where('user_id', $user->id)->first();
        
        if (!$dokter) {
            return redirect()->route('dokter.rekam-medis')
                ->with('error', 'Data dokter tidak ditemukan.');
        }

        // Pastikan pasien pernah membuat janji temu dengan dokter ini
        $pasien = Pasien::whereHas('janjiTemu', function($query) use ($dokter) {
                $query->where('dokter_id', $dokter->id);
            })
            ->with([
                'user',
                'janjiTemu' => function($q) use ($dokter) {
                    $q->where('dokter_id', $dokter->id)
                      ->with(['dokter.user', 'rekamMedis'])
                      ->orderBy('tanggal', 'desc')
                      ->orderBy('jam_mulai', 'desc');
                }
            ])
            ->findOrFail($id);

        // Ambil janji temu yang belum memiliki rekam medis (hanya untuk dokter ini)
        $janjiTemuTersedia = JanjiTemu::where('pasien_id', $id)
            ->where('dokter_id', $dokter->id)
            ->whereIn('status', ['confirmed', 'completed'])
            ->whereDoesntHave('rekamMedis')
            ->with('dokter.user')
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->get();

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

        return view('dokter.rekam-medis.show', compact('pasien', 'janjiTemuTersedia', 'obatTersedia'));
    }

    /**
     * Menyimpan rekam medis baru
     * Sesuai dengan struktur database: janji_temu_id, diagnosa, tindakan, catatan, biaya
     * Juga menangani penyimpanan resep obat jika ada
     */
    public function store(Request $request)
    {
        // Ambil dokter yang sedang login terlebih dahulu
        $user = Auth::user();
        $dokter = $user->dokter ?? \App\Models\Dokter::where('user_id', $user->id)->first();
        
        if (!$dokter) {
            return redirect()
                ->back()
                ->with('error', 'Data dokter tidak ditemukan.');
        }

        // Validasi rekam medis
        $validated = $request->validate([
            'janji_temu_id' => [
                'required',
                'exists:janji_temu,id',
                function ($attribute, $value, $fail) use ($dokter) {
                    // Pastikan janji temu ini milik dokter yang login
                    $janjiTemu = JanjiTemu::find($value);
                    if ($janjiTemu && $janjiTemu->dokter_id !== $dokter->id) {
                        $fail('Janji temu yang dipilih tidak valid untuk dokter Anda.');
                    }
                },
            ],
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
            'catatan' => 'nullable|string',
            'biaya' => 'required|numeric|min:0',
            'resep_obat' => 'nullable|array',
            'resep_obat.*.nama_obat' => 'required_with:resep_obat|string|max:255',
            'resep_obat.*.jumlah' => 'required_with:resep_obat|integer|min:1',
            'resep_obat.*.dosis' => 'required_with:resep_obat|integer|min:0',
            'resep_obat.*.aturan_pakai' => 'required_with:resep_obat|string',
        ]);

        DB::beginTransaction();
        try {
            // Simpan rekam medis sesuai struktur database
            $rekamMedis = RekamMedis::create([
                'janji_temu_id' => $validated['janji_temu_id'],
                'diagnosa' => $validated['diagnosa'],
                'tindakan' => $validated['tindakan'],
                'catatan' => $validated['catatan'],
                'biaya' => $validated['biaya']
            ]);

            // Update status janji temu menjadi completed
            JanjiTemu::where('id', $validated['janji_temu_id'])
                ->update(['status' => 'completed']);

            // Simpan resep obat jika ada
            if (!empty($validated['resep_obat'])) {
                foreach ($validated['resep_obat'] as $resep) {
                    // Skip jika data tidak lengkap
                    if (empty($resep['nama_obat']) || empty($resep['jumlah']) || empty($resep['aturan_pakai'])) {
                        continue;
                    }

                    ResepObat::create([
                        'rekam_medis_id' => $rekamMedis->id,
                        'dokter_id' => $dokter->id,
                        'tanggal_resep' => now()->toDateString(),
                        'nama_obat' => $resep['nama_obat'],
                        'jumlah' => $resep['jumlah'],
                        'dosis' => $resep['dosis'] ?? 0,
                        'aturan_pakai' => $resep['aturan_pakai'],
                    ]);
                }
            }

            DB::commit();

            $message = 'Rekam medis berhasil disimpan';
            if (!empty($validated['resep_obat'])) {
                $count = count(array_filter($validated['resep_obat'], function($r) {
                    return !empty($r['nama_obat']) && !empty($r['jumlah']) && !empty($r['aturan_pakai']);
                }));
                if ($count > 0) {
                    $message .= ' beserta ' . $count . ' resep obat';
                }
            }

            return redirect()
                ->back()
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->with('error', 'Gagal menyimpan rekam medis: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form edit rekam medis
     */
    public function edit($id)
    {
        // Ambil dokter yang sedang login
        $user = Auth::user();
        $dokter = $user->dokter ?? \App\Models\Dokter::where('user_id', $user->id)->first();
        
        if (!$dokter) {
            return redirect()->route('dokter.rekam-medis')
                ->with('error', 'Data dokter tidak ditemukan.');
        }

        // Pastikan rekam medis ini milik dokter yang login
        $rekamMedis = RekamMedis::with(['janjiTemu.pasien.user', 'janjiTemu.dokter.user'])
            ->whereHas('janjiTemu', function($q) use ($dokter) {
                $q->where('dokter_id', $dokter->id);
            })
            ->findOrFail($id);

        return view('dokter.rekam-medis.edit', compact('rekamMedis'));
    }

    /**
     * Update rekam medis
     */
    public function update(Request $request, $id)
    {
        // Ambil dokter yang sedang login
        $user = Auth::user();
        $dokter = $user->dokter ?? \App\Models\Dokter::where('user_id', $user->id)->first();
        
        if (!$dokter) {
            return redirect()->route('dokter.rekam-medis')
                ->with('error', 'Data dokter tidak ditemukan.');
        }

        $validated = $request->validate([
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
            'catatan' => 'nullable|string',
            'biaya' => 'required|numeric|min:0'
        ]);

        try {
            // Pastikan rekam medis ini milik dokter yang login
            $rekamMedis = RekamMedis::whereHas('janjiTemu', function($q) use ($dokter) {
                    $q->where('dokter_id', $dokter->id);
                })
                ->findOrFail($id);
            
            $rekamMedis->update($validated);

            return redirect()
                ->back()
                ->with('success', 'Rekam medis berhasil diperbarui');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui rekam medis: ' . $e->getMessage());
        }
    }

    /**
     * Hapus rekam medis
     */
    public function destroy($id)
    {
        // Ambil dokter yang sedang login
        $user = Auth::user();
        $dokter = $user->dokter ?? \App\Models\Dokter::where('user_id', $user->id)->first();
        
        if (!$dokter) {
            return redirect()->route('dokter.rekam-medis')
                ->with('error', 'Data dokter tidak ditemukan.');
        }

        try {
            // Pastikan rekam medis ini milik dokter yang login
            $rekamMedis = RekamMedis::whereHas('janjiTemu', function($q) use ($dokter) {
                    $q->where('dokter_id', $dokter->id);
                })
                ->findOrFail($id);
            
            $rekamMedis->delete();

            return redirect()
                ->back()
                ->with('success', 'Rekam medis berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus rekam medis: ' . $e->getMessage());
        }
    }

    /**
     * Export rekam medis ke PDF
     */
    public function exportPdf($pasienId)
    {
        $pasien = Pasien::with([
            'user',
            'janjiTemu' => function($q) {
                $q->with(['dokter.user', 'rekamMedis'])
                  ->where('status', 'completed')
                  ->orderBy('tanggal', 'desc');
            }
        ])->findOrFail($pasienId);

        // Generate PDF menggunakan package seperti DomPDF atau TCPDF
        // Contoh dengan DomPDF:
        // $pdf = PDF::loadView('dokter.rekam-medis.pdf', compact('pasien'));
        // return $pdf->download('rekam-medis-'.$pasien->user->nama_lengkap.'.pdf');

        return view('dokter.rekam-medis.pdf', compact('pasien'));
    }
}