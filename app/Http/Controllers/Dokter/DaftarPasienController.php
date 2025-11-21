<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\JanjiTemu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarPasienController extends Controller
{
    public function index(Request $request)
    {
        // Ambil dokter yang sedang login
        $user = Auth::user();
        $dokter = $user->dokter ?? \App\Models\Dokter::where('user_id', $user->id)->first();
        
        if (!$dokter) {
            return view('dokter.daftar-pasien.index', [
                'patients' => collect([])->paginate(5),
                'search' => $request->input('search')
            ]);
        }

        // Fitur pencarian (optional)
        $search = $request->input('search');

        // Hanya tampilkan pasien yang pernah membuat janji temu dengan dokter ini
        $patients = Pasien::query()
            ->join('users', 'users.id', '=', 'pasien.user_id')
            ->whereHas('janjiTemu', function($query) use ($dokter) {
                $query->where('dokter_id', $dokter->id);
            })
            ->when($search, function ($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('users.nama_lengkap', 'like', "%$search%")
                      ->orWhere('users.nomor_telp', 'like', "%$search%")
                      ->orWhere('pasien.id', 'like', "%$search%");
                });
            })
            ->select('pasien.*', 'users.nama_lengkap as nama', 'users.nomor_telp')
            ->distinct()
            ->orderBy('users.nama_lengkap', 'asc')
            ->paginate(5)
            ->withQueryString();
    
        return view('dokter.daftar-pasien.index', compact('patients', 'search'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Ambil dokter yang sedang login
        $user = Auth::user();
        $dokter = $user->dokter ?? \App\Models\Dokter::where('user_id', $user->id)->first();
        
        if (!$dokter) {
            return redirect()->route('dokter.daftar-pasien')
                ->with('error', 'Data dokter tidak ditemukan.');
        }

        // Pastikan pasien pernah membuat janji temu dengan dokter ini
        $pasien = Pasien::whereHas('janjiTemu', function($query) use ($dokter) {
                $query->where('dokter_id', $dokter->id);
            })
            ->with(['user', 'rekamMedis'])
            ->findOrFail($id);

        return view('dokter.daftar-pasien.show', compact('pasien'));
        
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
