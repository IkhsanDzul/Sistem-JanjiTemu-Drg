<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRekamMedisRequest;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\JanjiTemu;
use App\Models\ResepObat;
use App\Models\MasterObat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

class RekamMedisController extends Controller
{
    /**
     * Menampilkan halaman daftar rekam medis pasien
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $dokter = $user->dokter ?? Dokter::where('user_id', $user->id)->first();

        if (!$dokter) {
            return view('dokter.rekam-medis.index', [
                'rekamMedis' => collect()->paginate(10),
                'totalRekamMedis' => 0,
                'rekamMedisBulanIni' => 0,
                'rekamMedisHariIni' => 0,
                'totalPasien' => 0
            ]);
        }

        // Ambil ID janji temu milik dokter ini
        $janjiTemuIds = JanjiTemu::where('dokter_id', $dokter->id)->pluck('id');

        // Query utama: Rekam Medis
        $query = RekamMedis::with([
            'janjiTemu.pasien.user',
            'janjiTemu.dokter.user'
        ])->whereIn('janji_temu_id', $janjiTemuIds);

        // Filter pencarian: berdasarkan nama pasien
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('janjiTemu.pasien.user', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan tanggal janji temu
        if ($request->filled('tanggal')) {
            $tanggal = $request->tanggal;
            $query->whereHas('janjiTemu', function ($q) use ($tanggal) {
                $q->whereDate('tanggal', $tanggal);
            });
        }

        // Urutkan: terbaru dulu
        $query->orderBy('created_at', 'desc');

        // Pagination
        $rekamMedis = $query->paginate(10);

        // === STATISTIK ===
        // Total rekam medis dokter ini
        $totalRekamMedis = RekamMedis::whereIn('janji_temu_id', $janjiTemuIds)->count();

        // Rekam medis hari ini
        $rekamMedisHariIni = RekamMedis::whereIn('janji_temu_id', $janjiTemuIds)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Rekam medis bulan ini
        $rekamMedisBulanIni = RekamMedis::whereIn('janji_temu_id', $janjiTemuIds)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Total pasien unik yang punya rekam medis
        $totalPasien = RekamMedis::whereIn('janji_temu_id', $janjiTemuIds)
            ->join('janji_temu', 'rekam_medis.janji_temu_id', '=', 'janji_temu.id')
            ->distinct('janji_temu.pasien_id')
            ->count('janji_temu.pasien_id');

        return view('dokter.rekam-medis.index', compact(
            'rekamMedis',
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

        $rekamMedis = RekamMedis::with([
            'janjiTemu.pasien.user',
            'janjiTemu.dokter.user',
            'resepObat'
        ])->findOrFail($id);

        // $fotoGigiPath = $rekamMedis->janjiTemu->foto_gigi ?? null;

        // $fotoGigiUrl = $fotoGigiPath ? asset('storage/' . $fotoGigiPath) : null;

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

        return view('dokter.rekam-medis.show', compact('rekamMedis' ))
            ->with('title', 'Detail Rekam Medis');
    }

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

        return view('dokter.rekam-medis.create', compact('janjiTemu', 'selectedJanjiTemuId', 'obatTersedia'))
            ->with('title', 'Tambah Rekam Medis');
    }

    /**
     * Menyimpan rekam medis baru
     * Sesuai dengan struktur database: janji_temu_id, diagnosa, tindakan, catatan, biaya
     * Juga menangani penyimpanan resep obat jika ada
     */
    public function store(Request $request)
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

            // Simpan resep obat jika ada
            if ($request->filled('resep_obat_nama') && $request->filled('resep_obat_jumlah')) {
                // Ambil dokter dari janji temu
                $dokter = $janjiTemu->dokter;

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

            DB::commit();

            $message = 'Rekam medis berhasil ditambahkan.';
            if ($request->filled('resep_obat_nama') && $request->filled('resep_obat_jumlah')) {
                $message .= ' beserta resep obat';
            }

            return redirect()->route('dokter.rekam-medis.show', $rekamMedis->id)
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
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
    public function export($id)
    {
        $rekam = RekamMedis::with([
            'janjiTemu.dokter.user',
            'janjiTemu.pasien.user'
        ])->findOrFail($id);

        // Generate PDF using the same template as pasien
        $pdf = Pdf::loadView('admin.rekam-medis.pdf', compact('rekam'))
            ->setPaper('A4', 'portrait');

        return $pdf->download("Rekam_Medis_{$rekam->id}.pdf");
    }
}