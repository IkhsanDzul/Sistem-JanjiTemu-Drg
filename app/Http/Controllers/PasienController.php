<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\JadwalPraktek;
use App\Models\JanjiTemu;
use App\Models\RekamMedis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class PasienController extends Controller
{
    /**
     * Menampilkan dashboard pasien
     */
    public function index()
    {
        $user = Auth::user();
        $pasien = $user->pasien;

        // Ambil dokter yang tersedia
        $dokter = Dokter::where('status', 'tersedia')
            ->with('user')
            ->paginate(6);

        // Inisialisasi variabel janji temu
        $janjiTemuMendatang = collect();
        $janjiTemuConfirmed = collect();

        // Ambil janji temu jika pasien sudah ada
        if ($pasien) {
            $janjiTemuMendatang = JanjiTemu::where('pasien_id', $pasien->id)
                ->where('status', 'pending')
                ->with('dokter.user')
                ->orderBy('tanggal', 'asc')
                ->get();

            $janjiTemuConfirmed = JanjiTemu::where('pasien_id', $pasien->id)
                ->where('status', 'confirmed')
                ->with('dokter.user')
                ->orderBy('tanggal', 'asc')
                ->get();
        }

        // Cek data verifikasi
        $belumVerifikasi = !$user->nik || !$user->nomor_telp || !$user->tanggal_lahir;

        return view('pasien.dashboard', compact(
            'dokter',
            'belumVerifikasi',
            'janjiTemuMendatang',
            'janjiTemuConfirmed'
        ));
    }

    /**
     * Mencari dokter berdasarkan keyword
     */
    public function cariDokter(Request $request)
    {
        $user = Auth::user();
        $query = Dokter::where('status', 'tersedia')->with('user');

        // Search berdasarkan nama dokter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $dokter = $query->paginate(6);
        $belumVerifikasi = !$user->nik || !$user->nomor_telp || !$user->tanggal_lahir;

        // Ambil janji temu untuk sidebar
        $pasien = $user->pasien;
        $janjiTemuMendatang = collect();
        $janjiTemuConfirmed = collect();

        if ($pasien) {
            $janjiTemuMendatang = JanjiTemu::where('pasien_id', $pasien->id)
                ->where('status', 'pending')
                ->with('dokter.user')
                ->orderBy('tanggal', 'asc')
                ->get();

            $janjiTemuConfirmed = JanjiTemu::where('pasien_id', $pasien->id)
                ->where('status', 'confirmed')
                ->with('dokter.user')
                ->orderBy('tanggal', 'asc')
                ->get();
        }

        return view('pasien.dashboard', compact(
            'dokter',
            'belumVerifikasi',
            'janjiTemuMendatang',
            'janjiTemuConfirmed'
        ));
    }

    /**
     * Menampilkan detail dokter
     */
    public function detailDokter(Request $request, $id)
    {
        $tanggalDipilih = $request->input('tanggal');

        // Generate jadwal format untuk 7 hari ke depan
        $jadwalFormat = collect(range(0, 6))->map(function ($i) {
            return now()->addDays($i)->format('Y-m-d');
        });

        // Ambil semua jadwal praktek dokter berdasarkan tanggal
        $jadwalHari = JadwalPraktek::where('dokter_id', $id)
            ->whereIn('status', ['available', 'aktif'])
            ->whereIn('tanggal', $jadwalFormat)
            ->get();

        // Ambil jam praktek jika tanggal sudah dipilih
        $jamPraktek = [];
        if ($tanggalDipilih) {
            // Ambil jam praktek berdasarkan tanggal
            $jamPraktek = JadwalPraktek::where('dokter_id', $id)
                ->whereIn('status', ['available', 'aktif'])
                ->where('tanggal', $tanggalDipilih)
                ->get()
                ->map(function ($jadwal) {
                    // Generate jam-jam yang tersedia dari jam_mulai sampai jam_selesai
                    $jamMulai = \Carbon\Carbon::parse($jadwal->jam_mulai);
                    $jamSelesai = \Carbon\Carbon::parse($jadwal->jam_selesai);
                    $jamTersedia = [];
                    
                    while ($jamMulai->lt($jamSelesai)) {
                        $jamTersedia[] = $jamMulai->format('H:i');
                        $jamMulai->addHour(); // Tambah 1 jam
                    }
                    
                    return $jamTersedia;
                })
                ->flatten()
                ->unique()
                ->sort()
                ->values()
                ->toArray();
        }

        $dokter = Dokter::with('user')->findOrFail($id);

        return view('pasien.detail-dokter.index', compact(
            'dokter',
            'jadwalHari',
            'jamPraktek',
            'jadwalFormat',
            'tanggalDipilih'
        ));
    }

    /**
     * Membuat janji temu baru
     */
    public function buatJanjiTemu(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokter,id',
            'pasien_id' => 'required|exists:pasien,id',
            'jam_mulai' => 'required',
            'keluhan' => 'required|string|max:500',
            'foto_gigi' => 'required|image|max:2048',
            'tanggal' => 'required|date',
            'status' => 'required|in:pending,confirmed',
        ]);

        // Upload foto gigi
        $fotoPath = $request->file('foto_gigi')->store('foto_gigi', 'public');

        // Buat janji temu
        $janjiTemu = JanjiTemu::create([
            'dokter_id' => $request->dokter_id,
            'pasien_id' => $request->pasien_id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => Carbon::parse($request->jam_mulai)->addHour()->format('H:i:s'),
            'foto_gigi' => $fotoPath,
            'keluhan' => $request->keluhan,
            'status' => $request->status,
        ]);

        // Update status jadwal praktek menjadi booked
        $jadwalDokter = JadwalPraktek::where('dokter_id', $request->dokter_id)
            ->where('jam_mulai', $request->jam_mulai)
            ->where('tanggal', $request->tanggal)
            ->first();

        if ($jadwalDokter) {
            $jadwalDokter->update(['status' => 'booked']);
        }

        return redirect()
            ->route('pasien.dashboard')
            ->with('success', 'Janji temu berhasil dibuat.');
    }

    /**
     * Menampilkan detail janji temu
     */
    public function detailJanjiTemu($id)
    {
        $user = Auth::user();
        $pasien = $user->pasien;

        if (!$pasien) {
            return redirect()->route('pasien.dashboard')
                ->with('error', 'Data pasien tidak ditemukan.');
        }

        $janjiTemu = JanjiTemu::with(['dokter.user', 'pasien.user'])
            ->where('pasien_id', $pasien->id)
            ->findOrFail($id);

        $tanggalFormat = Carbon::parse($janjiTemu->tanggal)
            ->locale('id')
            ->isoFormat('dddd, DD MMMM YYYY');

        return view('pasien.janji-temu.detail', compact('janjiTemu', 'tanggalFormat'));
    }

    /**
     * Menampilkan daftar janji temu pasien
     */
    public function janjiTemuSaya(Request $request)
    {
        $user = Auth::user();
        $pasien = $user->pasien;

        // Buat paginator kosong jika pasien belum ada
        if (!$pasien) {
            $janjiTemu = new LengthAwarePaginator(
                [],
                0,
                10,
                1,
                ['path' => request()->url()]
            );
        } else {
            $status = $request->get('status', 'pending');

            $janjiTemu = JanjiTemu::where('pasien_id', $pasien->id)
                ->where('status', $status)
                ->with(['dokter.user'])
                ->orderBy('tanggal', 'desc')
                ->orderBy('jam_mulai', 'desc')
                ->paginate(10);
        }

        $belumVerifikasi = !$user->nik || !$user->nomor_telp || !$user->tanggal_lahir;

        return view('pasien.janji-temu.index', compact('janjiTemu', 'belumVerifikasi'));
    }

    /**
     * Membatalkan janji temu
     */
    public function cancelJanjiTemu(Request $request, $id)
    {
        $user = Auth::user();
        $pasien = $user->pasien;

        if (!$pasien) {
            return redirect()->route('pasien.janji-temu')
                ->with('error', 'Data pasien tidak ditemukan.');
        }

        $janjiTemu = JanjiTemu::where('pasien_id', $pasien->id)
            ->findOrFail($id);

        // Hanya bisa dibatalkan jika status masih pending
        if ($janjiTemu->status !== 'pending') {
            return redirect()->route('pasien.janji-temu')
                ->with('error', 'Janji temu ini tidak dapat dibatalkan.');
        }

        $janjiTemu->update(['status' => 'canceled']);

        // Update status jadwal praktek kembali menjadi available
        $jadwalDokter = JadwalPraktek::where('dokter_id', $janjiTemu->dokter_id)
            ->where('jam_mulai', $janjiTemu->jam_mulai)
            ->where('tanggal', $janjiTemu->tanggal)
            ->first();

        if ($jadwalDokter) {
            $jadwalDokter->update(['status' => 'available']);
        }

        return redirect()
            ->route('pasien.janji-temu')
            ->with('success', 'Janji temu berhasil dibatalkan.');
    }

    /**
     * Menampilkan daftar rekam medis pasien
     */
    public function rekamMedis()
    {
        $user = Auth::user();
        $pasien = $user->pasien;

        // Buat paginator kosong jika pasien belum ada
        if (!$pasien) {
            $rekamMedis = new LengthAwarePaginator(
                [],
                0,
                10,
                1,
                ['path' => request()->url()]
            );
        } else {
            // Ambil ID janji temu pasien
            $janjiTemuIds = JanjiTemu::where('pasien_id', $pasien->id)
                ->pluck('id');

            // Ambil rekam medis berdasarkan janji temu
            $rekamMedis = RekamMedis::whereIn('janji_temu_id', $janjiTemuIds)
                ->with(['janjiTemu.dokter.user'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        $belumVerifikasi = !$user->nik || !$user->nomor_telp || !$user->tanggal_lahir;

        return view('pasien.rekam-medis.index', compact('rekamMedis', 'belumVerifikasi'));
    }

    /**
     * Menampilkan detail rekam medis
     */
    public function rekamMedisDetail($id)
    {
        $user = Auth::user();
        $pasien = $user->pasien;

        if (!$pasien) {
            return redirect()->route('pasien.rekam-medis')
                ->with('error', 'Data pasien tidak ditemukan.');
        }

        // Ambil ID janji temu pasien
        $janjiTemuIds = JanjiTemu::where('pasien_id', $pasien->id)
            ->pluck('id');

        // Pastikan rekam medis milik pasien ini
        $rekam = RekamMedis::whereIn('janji_temu_id', $janjiTemuIds)
            ->with(['janjiTemu.dokter.user', 'janjiTemu.pasien.user'])
            ->findOrFail($id);

        return view('pasien.rekam-medis.detail', compact('rekam'));
    }
}
