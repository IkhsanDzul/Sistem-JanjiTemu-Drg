<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\JadwalPraktek;
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

        $belumVerifikasi = !$User->nik || !$User->nomor_telp || !$User->tanggal_lahir;

        return view('pasien.dashboard', compact('dokter', 'user', 'Dokter', 'belumVerifikasi'));
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
        $jadwalHari = JadwalPraktek::where('dokter_id', $id)->get();
         $jadwalFormatted = collect(range(0, 6))->map(function ($i) {
            return now()->addDays($i)->locale('id')->isoFormat('ddd, DD MMM');
        });

        $dokter = Dokter::with('user')->findOrFail($id);
        return view('pasien.detail-dokter.index', compact('dokter', 'jadwalHari', 'jadwalFormatted'));
    }

    public function buatJanji(Request $request) {
        $request->validate([
            'dokter_id' => 'required|exists:dokters,id',
            'tanggal_praktek' => 'required|date',
            'waktu_praktek' => 'required|string',
        ]);
        $user = Auth::user();
        $dokter = Dokter::findOrFail($request->dokter_id);
        $tanggalPraktek = Carbon::parse($request->tanggal_praktek);
        $waktuPraktek = $request->waktu_praktek;

        JadwalPraktek::create([
            'dokter_id' => $dokter->id,
            'user_id' => $user->id,
            'tanggal_praktek' => $tanggalPraktek,
            'waktu_praktek' => $waktuPraktek,
        ]);

        return redirect()->route('pasien.dashboard')->with('success', 'Jadwal praktek berhasil dibuat');
    }
}
