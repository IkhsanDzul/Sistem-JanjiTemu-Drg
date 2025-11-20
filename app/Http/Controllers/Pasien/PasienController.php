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
            // Ambil jam praktek berdasarkan tanggal (hanya yang available)
            $jadwalPraktek = JadwalPraktek::where('dokter_id', $id)
                ->where('status', 'available')
                ->where('tanggal', $tanggalDipilih)
                ->get();

            // Ambil janji temu yang sudah pending/confirmed/completed untuk tanggal tersebut
            // Catatan: Pending juga dianggap terpakai untuk mencegah double booking
            $janjiTemuTerpakai = JanjiTemu::where('dokter_id', $id)
                ->where('tanggal', $tanggalDipilih)
                ->whereIn('status', ['pending', 'confirmed', 'completed'])
                ->pluck('jam_mulai')
                ->map(function ($jam) {
                    return date('H:i', strtotime($jam));
                })
                ->toArray();

            // Generate jam-jam yang tersedia dari semua jadwal praktek
            $jamTersedia = [];
            foreach ($jadwalPraktek as $jadwal) {
                $jamMulai = \Carbon\Carbon::parse($jadwal->jam_mulai);
                $jamSelesai = \Carbon\Carbon::parse($jadwal->jam_selesai);

                while ($jamMulai->lt($jamSelesai)) {
                    $jamFormat = $jamMulai->format('H:i');
                    // Hanya tambahkan jika jam belum terpakai
                    if (!in_array($jamFormat, $janjiTemuTerpakai)) {
                        $jamTersedia[] = $jamFormat;
                    }
                    $jamMulai->addHour(); // Tambah 1 jam
                }
            }

            // Remove duplicate dan sort
            $jamPraktek = array_values(array_unique($jamTersedia));
            sort($jamPraktek);
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
    public function store(Request $request)
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
        $jamBooking = Carbon::parse($request->jam_mulai)->format('H:i');
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

        // Upload foto gigi (setelah validasi berhasil)
        $fotoPath = $request->file('foto_gigi')->store('foto_gigi', 'public');

        // Buat janji temu (setelah semua validasi berhasil)
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

        // Catatan: Jadwal praktek TIDAK diupdate menjadi 'booked'
        // Status jadwal tetap 'available' karena masih ada slot lain yang tersedia
        // Sistem akan cek ketersediaan berdasarkan janji temu yang sudah ada

        return redirect()
            ->route('pasien.dashboard')
            ->with('success', 'Janji temu berhasil dibuat.');
    }
}
