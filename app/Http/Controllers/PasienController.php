<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasienController extends Controller
{
    public function index() {
        $dokter = Dokter::paginate(6);
        $user = User::paginate(6);
        $User = Auth::user();

        $belumVerifikasi = !$User->nik || !$User->nomor_telp || !$User->tanggal_lahir;

        return view('pasien.dashboard', compact('dokter', 'user', 'belumVerifikasi'));
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
}
