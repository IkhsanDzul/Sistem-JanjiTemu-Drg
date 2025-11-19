<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\JanjiTemu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RekamMedisController extends Controller
{
    /**
     * Menampilkan halaman daftar rekam medis pasien
     */
    public function index(Request $request)
    {
        // Query dasar untuk pasien dengan relasi
        $query = Pasien::with([
            'user', // Relasi ke tabel users
            'janjiTemu' => function($q) {
                $q->with(['dokter.user', 'rekamMedis'])
                  ->orderBy('tanggal', 'desc')
                  ->orderBy('jam_mulai', 'desc');
            }
        ])
        ->withCount('janjiTemu'); // Hitung total janji temu per pasien

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
            $query->whereHas('janjiTemu', function($q) use ($tanggal) {
                $q->where('tanggal', $tanggal);
            });
        }

        // Ambil data pasien dengan pagination
        $pasiens = $query->paginate(10);

        // Tambahkan kunjungan terakhir untuk setiap pasien
        $pasiens->getCollection()->transform(function ($pasien) {
            $pasien->kunjungan_terakhir = $pasien->janjiTemu()
                ->where('status', 'completed')
                ->orderBy('tanggal', 'desc')
                ->orderBy('jam_mulai', 'desc')
                ->first();
            return $pasien;
        });

        // Statistik berdasarkan struktur database yang sebenarnya
        $totalRekamMedis = RekamMedis::count();
        
        $rekamMedisBulanIni = RekamMedis::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        $rekamMedisHariIni = RekamMedis::whereDate('created_at', Carbon::today())
            ->count();
        
        $totalPasien = Pasien::count();

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
        $pasien = Pasien::with([
            'user',
            'janjiTemu' => function($q) {
                $q->with(['dokter.user', 'rekamMedis'])
                  ->orderBy('tanggal', 'desc')
                  ->orderBy('jam_mulai', 'desc');
            }
        ])->findOrFail($id);

        // Ambil janji temu yang belum memiliki rekam medis
        // Bisa untuk janji temu dengan status 'confirmed' atau 'completed'
        // Saat membuat rekam medis, status akan otomatis menjadi 'completed'
        $janjiTemuTersedia = JanjiTemu::where('pasien_id', $id)
            ->whereIn('status', ['confirmed', 'completed'])
            ->whereDoesntHave('rekamMedis')
            ->with('dokter.user')
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->get();

        return view('dokter.rekam-medis.show', compact('pasien', 'janjiTemuTersedia'));
    }

    /**
     * Menyimpan rekam medis baru
     * Sesuai dengan struktur database: janji_temu_id, diagnosa, tindakan, catatan, biaya
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'janji_temu_id' => 'required|exists:janji_temu,id',
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
            'catatan' => 'nullable|string',
            'biaya' => 'required|numeric|min:0'
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

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Rekam medis berhasil disimpan');

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
        $rekamMedis = RekamMedis::with(['janjiTemu.pasien.user', 'janjiTemu.dokter.user'])
            ->findOrFail($id);

        return view('dokter.rekam-medis.edit', compact('rekamMedis'));
    }

    /**
     * Update rekam medis
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
            'catatan' => 'nullable|string',
            'biaya' => 'required|numeric|min:0'
        ]);

        try {
            $rekamMedis = RekamMedis::findOrFail($id);
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
        try {
            $rekamMedis = RekamMedis::findOrFail($id);
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