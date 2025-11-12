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

        $belumVerifikasi = !$User->nomor_telp || !$User->alamat;

        return view('pasien.dashboard', compact('dokter', 'user', 'belumVerifikasi'));
    }

}
