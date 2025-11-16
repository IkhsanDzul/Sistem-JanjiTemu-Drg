<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\JadwalPraktek;
use App\Models\JanjiTemu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PasienController extends Controller
{
    public function index() {
        $dokter = Dokter::where('status', 'tersedia')->with('user')->paginate(6);
        $Dokter = Dokter::with('user')->paginate(6);
        $user = User::paginate(6);
        $User = Auth::user();
        $janjiTemuMendatang = JanjiTemu::where('pasien_id', $User->pasien->id)->where('status', 'pending')->get();

        $janjiTemuConfirmed = JanjiTemu::where('pasien_id', $User->pasien->id)->where('status', 'confirmed')->get();

        $belumVerifikasi = !$User->nik || !$User->nomor_telp || !$User->tanggal_lahir;

        return view('pasien.dashboard', compact('dokter', 'user', 'Dokter', 'belumVerifikasi', 'janjiTemuMendatang', 'janjiTemuConfirmed'));
    }

    public function cariDokter(Request $request) {
        $query = Dokter::with('user');
        $User = Auth::user();

        $belumVerifikasi = !$User->nik || !$User->nomor_telp || !$User->tanggal_lahir;

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%");
            });
        }

        return view('pasien.dashboard', [
            'dokter' => $query->paginate(6),
            'belumVerifikasi' => $belumVerifikasi,
        ]);
    }

    public function detailDokter($id) {
        $jamPraktek = JadwalPraktek::where('dokter_id', $id)->pluck('jam_mulai')->unique();

        $jadwalHari = JadwalPraktek::where('dokter_id', $id)->where('status', 'available')->get();

        $jadwalFormat = collect(range(0, 6))->map(function ($i) {
            return now()->addDays($i)->locale('id')->isoFormat('ddd, DD MMM');  
        });

        $dokter = Dokter::with('user')->findOrFail($id);
        return view('pasien.detail-dokter.index', compact('dokter', 'jadwalHari', 'jamPraktek', 'jadwalFormat'));
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
}
