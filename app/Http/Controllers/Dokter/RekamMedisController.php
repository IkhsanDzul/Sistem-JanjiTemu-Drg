<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    /**
     * Halaman list rekam medis (untuk halaman awal)
     */
    public function index(Request $request)
    {
        // Ambil query pencarian jika ada
        $search = $request->input('search');
        $tanggal = $request->input('tanggal');

        // Query pasien yang memiliki rekam medis
        $pasiens = Pasien::withCount('rekamMedis')
            ->with(['rekamMedis' => function($query) {
                $query->latest()->limit(1);
            }])
            ->when($search, function($query, $search) {
                return $query->where('nama', 'like', "%{$search}%")
                            ->orWhere('no_rm', 'like', "%{$search}%");
            })
            ->when($tanggal, function($query, $tanggal) {
                return $query->whereHas('rekamMedis', function($q) use ($tanggal) {
                    $q->whereDate('tanggal_kunjungan', $tanggal);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Statistik
        $totalRekamMedis = RekamMedis::count();
        $rekamMedisBulanIni = RekamMedis::whereMonth('tanggal_kunjungan', now()->month)
                                       ->whereYear('tanggal_kunjungan', now()->year)
                                       ->count();
        $rekamMedisHariIni = RekamMedis::whereDate('tanggal_kunjungan', today())->count();
        $totalPasien = Pasien::count();

        return view('dokter.rekam-medis', compact(
            'pasiens',
            'totalRekamMedis',
            'rekamMedisBulanIni',
            'rekamMedisHariIni',
            'totalPasien'
        ));
    }

    /**
     * Halaman detail rekam medis pasien (menampilkan riwayat + form input baru)
     * Ini yang akan digunakan untuk halaman yang Anda buat
     */
    public function show($pasien_id)
    {
        // Ambil data pasien
        $pasien = Pasien::with(['rekamMedis' => function($query) {
            $query->latest();
        }])->findOrFail($pasien_id);

        // Hitung umur pasien
        if ($pasien->tanggal_lahir) {
            $tanggalLahir = new \DateTime($pasien->tanggal_lahir);
            $sekarang = new \DateTime();
            $umur = $sekarang->diff($tanggalLahir)->y;
            $pasien->umur = $umur;
        }

        // Ambil riwayat rekam medis
        $riwayatRekamMedis = $pasien->rekamMedis;

        return view('dokter.rekam-medis-detail', compact('pasien', 'riwayatRekamMedis'));
    }

    /**
     * Form create rekam medis baru
     */
    public function create($pasien_id)
    {
        $pasien = Pasien::findOrFail($pasien_id);
        return view('dokter.rekam-medis-create', compact('pasien'));
    }

    /**
     * Simpan rekam medis baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'keluhan_utama' => 'required|string',
            'riwayat_penyakit_sekarang' => 'required|string',
            'riwayat_penyakit_dahulu' => 'nullable|string',
            'tekanan_darah' => 'nullable|string',
            'nadi' => 'nullable|integer',
            'suhu' => 'nullable|numeric',
            'respirasi' => 'nullable|integer',
            'pemeriksaan_gigi' => 'required|string',
            'diagnosa' => 'required|string',
            'tindakan' => 'nullable|array',
            'tindakan_detail' => 'nullable|string',
            'obat_nama.*' => 'nullable|string',
            'obat_dosis.*' => 'nullable|string',
            'obat_aturan.*' => 'nullable|string',
            'obat_durasi.*' => 'nullable|string',
            'catatan_dokter' => 'nullable|string',
            'biaya_total' => 'nullable|numeric',
            'metode_pembayaran' => 'nullable|string',
            'status_pembayaran' => 'nullable|string',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // max 5MB
        ]);

        // Gabungkan checkbox tindakan dengan detail tindakan
        $tindakanList = [];
        if ($request->has('tindakan')) {
            $tindakanList = array_merge($tindakanList, $request->tindakan);
        }
        if ($request->tindakan_detail) {
            $tindakanList[] = $request->tindakan_detail;
        }
        $tindakan = implode(', ', array_filter($tindakanList));

        // Format resep obat
        $resepObat = [];
        if ($request->has('obat_nama')) {
            foreach ($request->obat_nama as $index => $namaObat) {
                if (!empty($namaObat)) {
                    $resepObat[] = [
                        'nama' => $namaObat,
                        'dosis' => $request->obat_dosis[$index] ?? '',
                        'aturan' => $request->obat_aturan[$index] ?? '',
                        'durasi' => $request->obat_durasi[$index] ?? '',
                    ];
                }
            }
        }

        // Gabungkan riwayat penyakit dahulu dengan checkbox
        $riwayatDahulu = [];
        if ($request->hipertensi) $riwayatDahulu[] = 'Hipertensi';
        if ($request->diabetes) $riwayatDahulu[] = 'Diabetes';
        if ($request->jantung) $riwayatDahulu[] = 'Penyakit Jantung';
        if ($request->riwayat_penyakit_dahulu) {
            $riwayatDahulu[] = $request->riwayat_penyakit_dahulu;
        }
        $riwayatPenyakitDahulu = implode(', ', array_filter($riwayatDahulu));

        // Buat rekam medis
        $rekamMedis = RekamMedis::create([
            'pasien_id' => $request->pasien_id,
            'dokter_id' => Auth::id(), // ID dokter yang login
            'tanggal_kunjungan' => now(),
            'keluhan_utama' => $request->keluhan_utama,
            'riwayat_penyakit_sekarang' => $request->riwayat_penyakit_sekarang,
            'riwayat_penyakit_dahulu' => $riwayatPenyakitDahulu,
            'pemeriksaan_fisik' => json_encode([
                'tekanan_darah' => $request->tekanan_darah,
                'nadi' => $request->nadi,
                'suhu' => $request->suhu,
                'respirasi' => $request->respirasi,
            ]),
            'pemeriksaan_gigi' => $request->pemeriksaan_gigi,
            'diagnosa' => $request->diagnosa,
            'tindakan' => $tindakan,
            'resep_obat' => json_encode($resepObat),
            'catatan_dokter' => $request->catatan_dokter,
            'biaya' => $request->biaya_total,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => $request->status_pembayaran ?? 'Belum Lunas',
        ]);

        // Upload files jika ada
        if ($request->hasFile('files')) {
            $filePaths = [];
            foreach ($request->file('files') as $file) {
                $path = $file->store('rekam-medis', 'public');
                $filePaths[] = $path;
            }
            $rekamMedis->update([
                'files' => json_encode($filePaths)
            ]);
        }

        return redirect()
            ->route('dokter.rekam-medis.show', $request->pasien_id)
            ->with('success', 'Rekam medis berhasil disimpan!');
    }

    /**
     * Form edit rekam medis
     */
    public function edit($id)
    {
        $rekamMedis = RekamMedis::with('pasien')->findOrFail($id);
        return view('dokter.rekam-medis-edit', compact('rekamMedis'));
    }

    /**
     * Update rekam medis
     */
    public function update(Request $request, $id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);

        // Validasi
        $validated = $request->validate([
            'keluhan_utama' => 'required|string',
            'riwayat_penyakit_sekarang' => 'required|string',
            'riwayat_penyakit_dahulu' => 'nullable|string',
            'pemeriksaan_gigi' => 'required|string',
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
            'catatan_dokter' => 'nullable|string',
        ]);

        // Update rekam medis
        $rekamMedis->update($validated);

        return redirect()
            ->route('dokter.rekam-medis.show', $rekamMedis->pasien_id)
            ->with('success', 'Rekam medis berhasil diupdate!');
    }

    /**
     * Hapus rekam medis
     */
    public function destroy($id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);
        $pasienId = $rekamMedis->pasien_id;

        // Hapus files jika ada
        if ($rekamMedis->files) {
            $files = json_decode($rekamMedis->files, true);
            foreach ($files as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        $rekamMedis->delete();

        return redirect()
            ->route('dokter.rekam-medis.show', $pasienId)
            ->with('success', 'Rekam medis berhasil dihapus!');
    }
}