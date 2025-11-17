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

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $Dokter = Dokter::with('user')->paginate(6);
        $user = User::paginate(6);
        $User = Auth::user();

        $dokter = Dokter::where('status', 'tersedia')
            ->with('user')
            ->when($request->has('search') && $request->search != '', function ($query) use ($request) {
                return $query->where(function ($q) use ($request) {
                    $q->whereHas('user', function ($q) use ($request) {
                        $q->where('nama_lengkap', 'LIKE', '%' . $request->search . '%');
                    });
                    $q->orWhere('spesialisasi_gigi', 'LIKE', '%' . $request->search . '%');
                });
            })
            ->paginate(6);

        // Aman, tidak error meskipun pasien belum ada
        if (optional($User->pasien)->id) {
            $janjiTemuMendatang = JanjiTemu::where('pasien_id', $User->pasien->id)
                ->where('status', 'pending')
                ->get();

            $janjiTemuConfirmed = JanjiTemu::where('pasien_id', $User->pasien->id)
                ->where('status', 'confirmed')
                ->get();
        } else {
            $janjiTemuMendatang = [];
            $janjiTemuConfirmed = [];
        }

        // Cek data verifikasi
        $belumVerifikasi = !$User->nik || !$User->nomor_telp || !$User->tanggal_lahir;

        return view(
            'pasien.dashboard',
            compact(
                'dokter',
                'user',
                'Dokter',
                'belumVerifikasi',
                'janjiTemuMendatang',
                'janjiTemuConfirmed'
            )
        );
    }

    public function detailDokter(Request $request, $id)
    {
        $tanggalDipilih = $request->input('tanggal');

        $jadwalFormat = collect(range(0, 6))->map(function ($i) {
            return now()->addDays($i)->locale('id')->isoFormat('YYYY-MM-DD');
        });

        $jadwalHari = JadwalPraktek::where('dokter_id', $id)
            ->where('status', 'available')
            ->whereIn('tanggal', $jadwalFormat)
            ->get();

        $jamPraktek = [];
        if ($tanggalDipilih) {
            $jamPraktek = JadwalPraktek::where('dokter_id', $id)
                ->where('status', 'available')
                ->where('tanggal', $tanggalDipilih)
                ->pluck('jam_mulai');
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


    public function buatJanjiTemu(Request $request)
    {

        $request->validate([
            'dokter_id' => 'required',
            'pasien_id' => 'required',
            'jam_mulai' => 'required',
            'keluhan' => 'required',
            'foto_gigi' => 'required|image',
            'tanggal' => 'required',
            'status' => 'required',
        ]);

        $fotoPath = $request->file('foto_gigi')->store('foto_gigi', 'public');

        JanjiTemu::create([
            'dokter_id' => $request->dokter_id,
            'pasien_id' => $request->pasien_id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'foto_gigi' => $fotoPath,
            'keluhan' => $request->keluhan,
            'status' => $request->status,
        ]);

        $jadwalDokter = JadwalPraktek::where('dokter_id', $request->dokter_id)->where('jam_mulai', $request->jam_mulai)->first();
        $jadwalDokter->status = 'booked';
        $jadwalDokter->save();

        return redirect()->route('pasien.dashboard')->with('success', 'Janji temu berhasil dibuat.');
    }

    public function detailJanjiTemu() {
        $user = Auth::user();

        $janjiTemuIncoming = JanjiTemu::with('dokter.user')
            ->where('pasien_id', $user->pasien->id)
            ->where('status', 'pending')
            ->first();

        $janjiTemuConfirmed = JanjiTemu::with('dokter.user')
            ->where('pasien_id', $user->pasien->id)
            ->where('status', 'confirmed')
            ->first();

        $janjiTemu = $janjiTemuIncoming ?? $janjiTemuConfirmed;

        $tanggalFormat = Carbon::parse($janjiTemu->tanggal)->locale('id')->isoFormat('dddd, DD MMMM YYYY');
        
        return view('pasien.janji-temu.detail', compact('janjiTemu', 'tanggalFormat'));
    }

    public function janjiTemuSaya()
    {
        $user = Auth::user();

        $pasienId = optional($user->pasien)->id;

        if (!$pasienId) {
            // paginator kosong
            $janjiTemu = new \Illuminate\Pagination\LengthAwarePaginator(
                [],
                0,
                10,
                1,
                ['path' => request()->url()]
            );
        } else {
            $status = request('status') ?? 'pending';

            $janjiTemu = JanjiTemu::where('pasien_id', $pasienId)
                ->where('status', $status)
                ->with(['dokter.user'])
                ->paginate(6);
                
        }

        $belumVerifikasi = !$user->nik || !$user->nomor_telp || !$user->tanggal_lahir;

        return view('pasien.janji-temu.index', compact('janjiTemu', 'belumVerifikasi'));
    }

    public function cancelJanjiTemu() {
        $janjiTemu = JanjiTemu::findOrFail(request('id'));
        $janjiTemu->status = 'canceled';
        $janjiTemu->save();

        return redirect()->route('pasien.janji-temu.index')->with('success', 'Janji temu berhasil dibatalkan');
    }

    //Rekam Medis
    public function rekamMedis()
    {
        $user = Auth::user();
        $pasien = $user->pasien; // relasi pasien dari user

        if (!$pasien) {
            $rekamMedis = new \Illuminate\Pagination\LengthAwarePaginator(
                [],
                0,
                10,
                1,
                ['path' => request()->url()]
            );
        } else {
            $janjiTemuIds = JanjiTemu::where('pasien_id', $pasien->id)->pluck('id');
            $tanggalJanji = JanjiTemu::where('pasien_id', $pasien->id)->pluck('tanggal');

            $rekamMedis = RekamMedis::whereIn('janji_temu_id', $janjiTemuIds)
                ->with(['janjiTemu.dokter.user'])
                ->orderBy('created_at', 'desc')
                ->paginate(6);
        }

        $belumVerifikasi = !$user->nik || !$user->nomor_telp || !$user->tanggal_lahir;

        return view('pasien.rekam-medis.index', compact('rekamMedis', 'belumVerifikasi'));
    }

    public function rekamMedisDetail($id)
    {
        $rekam = RekamMedis::with(['janjiTemu.dokter.user'])
            ->findOrFail($id);

        return view('pasien.rekam-medis.detail', compact('rekam'));
    }
}
