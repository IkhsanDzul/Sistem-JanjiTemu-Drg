<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\JadwalPraktek;
use App\Models\JanjiTemu;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class PasienController extends Controller
{
    /**
     * Menampilkan dashboard pasien
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $pasien = $user->pasien;

        $belumVerifikasi = !$user->nik || !$user->nomor_telp || !$user->tanggal_lahir;

        $query = Dokter::where('status', 'tersedia')->with('user');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($sub) use ($search) {
                    $sub->where('nama_lengkap', 'LIKE', "%{$search}%");
                })
                    ->orWhere('spesialisasi_gigi', 'LIKE', "%{$search}%");
            });
        }

        $dokter = $query->paginate(6)->appends($request->query());

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
        // Ambil tanggal hari ini sampai 7 hari ke depan (sebagai batas)
        $tanggal7Hari = collect(range(0, 6))->map(function ($i) {
            return now()->addDays($i)->format('Y-m-d');
        });

        // Ambil semua jadwal praktek dokter dalam 7 hari ke depan yang status 'available' atau 'aktif'
        $jadwalPraktek = JadwalPraktek::where('dokter_id', $id)
            ->whereIn('status', ['available', 'aktif'])
            ->whereIn('tanggal', $tanggal7Hari)
            ->get();

        // Ambil hanya tanggal unik yang benar-benar punya jadwal
        $jadwalFormat = $jadwalPraktek->pluck('tanggal')->unique()->values()->sort();

        // Ambil hanya tanggal yang memiliki slot waktu yang tersedia
        $jadwalFormatDenganSlotTersedia = $jadwalFormat->filter(function ($tanggal) use ($id, $jadwalPraktek) {
            // Ambil jadwal praktek untuk tanggal yang dipilih
            $jadwalDiTanggal = $jadwalPraktek->where('tanggal', $tanggal);

            // Ambil jam yang sudah terpakai (oleh janji temu aktif)
            $janjiTemuTerpakai = JanjiTemu::where('dokter_id', $id)
                ->where('tanggal', $tanggal)
                ->whereIn('status', ['pending', 'confirmed', 'completed'])
                ->pluck('jam_mulai')
                ->map(fn($jam) => date('H:i', strtotime($jam)))
                ->toArray();

            // Periksa apakah ada slot waktu yang masih tersedia
            foreach ($jadwalDiTanggal as $jadwal) {
                $jamMulai = \Carbon\Carbon::parse($jadwal->jam_mulai);
                $jamSelesai = \Carbon\Carbon::parse($jadwal->jam_selesai);

                // Periksa setiap jam dalam jadwal praktek apakah ada yang masih tersedia
                while ($jamMulai->lt($jamSelesai)) {
                    $jamFormat = $jamMulai->format('H:i');
                    if (!in_array($jamFormat, $janjiTemuTerpakai)) {
                        // Jika ada satu jam yang tersedia, tanggal ini masih bisa dipilih
                        return true;
                    }
                    $jamMulai->addHour(); // Slot per jam
                }
            }
            // Jika semua slot sudah terisi, tanggal ini tidak boleh ditampilkan
            return false;
        });

        // Ambil jam praktek jika tanggal sudah dipilih
        $jamPraktek = [];
        $tanggalDipilih = $request->input('tanggal');

        if ($tanggalDipilih && $jadwalFormatDenganSlotTersedia->contains($tanggalDipilih)) {
            // Ambil jadwal praktek untuk tanggal yang dipilih
            $jadwalDiTanggal = $jadwalPraktek->where('tanggal', $tanggalDipilih);

            // Ambil jam yang sudah terpakai (oleh janji temu aktif)
            $janjiTemuTerpakai = JanjiTemu::where('dokter_id', $id)
                ->where('tanggal', $tanggalDipilih)
                ->whereIn('status', ['pending', 'confirmed', 'completed'])
                ->pluck('jam_mulai')
                ->map(fn($jam) => date('H:i', strtotime($jam)))
                ->toArray();

            // Bangun daftar jam tersedia berdasarkan slot jadwal praktek
            $jamTersedia = [];
            foreach ($jadwalDiTanggal as $jadwal) {
                $jamMulai = \Carbon\Carbon::parse($jadwal->jam_mulai);
                $jamSelesai = \Carbon\Carbon::parse($jadwal->jam_selesai);

                while ($jamMulai->lt($jamSelesai)) {
                    $jamFormat = $jamMulai->format('H:i');
                    if (!in_array($jamFormat, $janjiTemuTerpakai)) {
                        $jamTersedia[] = $jamFormat;
                    }
                    $jamMulai->addHour(); // Slot per jam
                }
            }

            $jamPraktek = array_values(array_unique($jamTersedia));
            sort($jamPraktek);
        }

        $dokter = Dokter::with('user')->findOrFail($id);

        return view('pasien.detail-dokter.index', compact(
            'dokter',
            'jamPraktek',
            'jadwalFormatDenganSlotTersedia',
            'tanggalDipilih'
        ));
    }

    /**
     * Membuat janji temu baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokter,id',
            'pasien_id' => 'required|exists:pasien,id',
            'jam_mulai' => 'required|date_format:H:i',
            'keluhan' => 'required|string|max:500',
            'tanggal' => 'required|date',
            'status' => 'required|in:pending,confirmed',
        ]);

        // Validasi: Cek apakah jam yang dipilih masih tersedia
        // (tidak ada janji temu lain yang sudah confirmed/completed/pending di jam tersebut)
        // Catatan: Pending juga dicek untuk mencegah double booking sebelum dokter approve
        $janjiTemuKonflik = JanjiTemu::where('dokter_id', $request->dokter_id)
            ->where('tanggal', $request->tanggal)
            ->where('jam_mulai', $request->jam_mulai)
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->exists();

        if ($janjiTemuKonflik) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jam yang dipilih sudah tidak tersedia. Silakan pilih jam lain.');
        }

        // Cek apakah jam yang dipilih ada dalam jadwal praktek yang available
        $jamBooking = Carbon::parse($request->jam_mulai);
        $jadwalTersedia = JadwalPraktek::where('dokter_id', $request->dokter_id)
            ->where('tanggal', $request->tanggal)
            ->where('status', 'available')
            ->where('jam_mulai', '<=', $jamBooking)
            ->where('jam_selesai', '>', $jamBooking)
            ->exists();

        if (!$jadwalTersedia) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jam yang dipilih tidak tersedia dalam jadwal praktek dokter.');
        }

        // Buat janji temu (setelah semua validasi berhasil)
        JanjiTemu::create([
            'dokter_id' => $request->dokter_id,
            'pasien_id' => $request->pasien_id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'keluhan' => $request->keluhan,
            'status' => $request->status,
        ]);

        return redirect()->route('pasien.dashboard')
            ->with('success', 'Janji temu berhasil dibuat.');
    } 
}