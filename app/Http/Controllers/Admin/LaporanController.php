<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\JanjiTemu;
use App\Exports\PasienExport;
use App\Exports\JadwalKunjunganExport;
use App\Exports\DokterAktifExport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman pilihan laporan
     */
    public function index()
    {
        return view('admin.laporan.index')
            ->with('title', 'Laporan dan Rekapitulasi Data');
    }

    /**
     * Laporan Jumlah Pasien Terdaftar
     */
    public function pasien(Request $request)
    {
        $format = $request->get('format', 'view'); // view, pdf, excel

        // Query data pasien
        $pasien = Pasien::with('user')
            ->get()
            ->sortByDesc(function($p) {
                return $p->user->created_at ?? now();
            })
            ->values();

        $totalPasien = $pasien->count();
        $pasienLaki = $pasien->filter(function($p) {
            return $p->user && ($p->user->jenis_kelamin === 'Laki-laki' || $p->user->jenis_kelamin === 'L');
        })->count();
        $pasienPerempuan = $pasien->filter(function($p) {
            return $p->user && ($p->user->jenis_kelamin === 'Perempuan' || $p->user->jenis_kelamin === 'P');
        })->count();

        $data = [
            'title' => 'Laporan Jumlah Pasien Terdaftar',
            'totalPasien' => $totalPasien,
            'pasienLaki' => $pasienLaki,
            'pasienPerempuan' => $pasienPerempuan,
            'pasien' => $pasien,
            'tanggalLaporan' => Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY'),
        ];

        if ($format === 'pdf') {
            return $this->exportPDF('admin.laporan.pasien-pdf', $data, 'laporan-pasien.pdf');
        } elseif ($format === 'excel') {
            return Excel::download(
                new PasienExport($pasien, $totalPasien, $pasienLaki, $pasienPerempuan),
                'laporan-pasien-' . date('Y-m-d') . '.xlsx'
            );
        }

        return view('admin.laporan.pasien', $data);
    }

    /**
     * Laporan Jadwal Kunjungan Per Bulan
     */
    public function jadwalKunjungan(Request $request)
    {
        $format = $request->get('format', 'view');
        $bulan = $request->get('bulan', today()->format('Y-m'));
        $carbonBulan = Carbon::parse($bulan . '-01');
        $tahun = $carbonBulan->year;
        $bulanAngka = $carbonBulan->month;
        $janjiTemu = JanjiTemu::with(['pasien.user', 'dokter.user'])
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulanAngka)
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get();
        $totalKunjungan = $janjiTemu->count();
        $statusCount = [
            'pending' => $janjiTemu->where('status', 'pending')->count(),
            'confirmed' => $janjiTemu->where('status', 'confirmed')->count(),
            'completed' => $janjiTemu->where('status', 'completed')->count(),
            'canceled' => $janjiTemu->where('status', 'canceled')->count(),
        ];
        $data = [
            'title' => 'Laporan Jadwal Kunjungan',
            'bulan' => $bulan,
            'totalKunjungan' => $totalKunjungan,
            'statusCount' => $statusCount,
            'janjiTemu' => $janjiTemu,
            'tanggalLaporan' => $carbonBulan->locale('id')->isoFormat('MMMM YYYY'),
        ];
        if ($format === 'pdf') {
            return $this->exportPDF('admin.laporan.jadwal-kunjungan-pdf', $data, 'laporan-jadwal-kunjungan-' . $bulan . '.pdf');
        } elseif ($format === 'excel') {
            return Excel::download(
                new JadwalKunjunganExport($janjiTemu, $bulan, $totalKunjungan, $statusCount),
                'laporan-jadwal-kunjungan-' . $bulan . '.xlsx'
            );
        }
        return view('admin.laporan.jadwal-kunjungan', $data);
    }

    /**
     * Laporan Daftar Dokter Aktif
     */
    public function dokterAktif(Request $request)
    {
        $format = $request->get('format', 'view');

        // Query dokter aktif (status tersedia)
        $dokter = Dokter::with('user')
            ->where('status', 'tersedia')
            ->get()
            ->sortByDesc(function($d) {
                return $d->user->created_at ?? now();
            })
            ->values();

        $totalDokter = $dokter->count();

        // Hitung statistik per dokter
        $dokterWithStats = $dokter->map(function($d) {
            $totalJanjiTemu = JanjiTemu::where('dokter_id', $d->id)->count();
            $janjiTemuBulanIni = JanjiTemu::where('dokter_id', $d->id)
                ->whereMonth('tanggal', Carbon::now()->month)
                ->whereYear('tanggal', Carbon::now()->year)
                ->count();
            
            return [
                'dokter' => $d,
                'total_janji_temu' => $totalJanjiTemu,
                'janji_temu_bulan_ini' => $janjiTemuBulanIni,
            ];
        });

        $data = [
            'title' => 'Laporan Daftar Dokter Aktif',
            'totalDokter' => $totalDokter,
            'dokter' => $dokterWithStats,
            'tanggalLaporan' => Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY'),
        ];

        if ($format === 'pdf') {
            return $this->exportPDF('admin.laporan.dokter-aktif-pdf', $data, 'laporan-dokter-aktif.pdf');
        } elseif ($format === 'excel') {
            return Excel::download(
                new DokterAktifExport($dokterWithStats, $totalDokter),
                'laporan-dokter-aktif-' . date('Y-m-d') . '.xlsx'
            );
        }

        return view('admin.laporan.dokter-aktif', $data);
    }

    /**
     * Export ke PDF menggunakan DomPDF
     */
    private function exportPDF($view, $data, $filename)
    {
        $pdf = Pdf::loadView($view, $data);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('enable-local-file-access', true);
        return $pdf->download($filename);
    }

}
