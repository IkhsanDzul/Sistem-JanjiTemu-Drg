<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use Illuminate\Http\Request;

class DaftarPasienController extends Controller
{
    public function index(Request $request)
    {
        // Fitur pencarian (optional)
        $search = $request->input('search');

        $patients = Pasien::query()
        ->join('users', 'users.id', '=', 'pasien.user_id')
        ->when($search, function ($query, $search) {
            $query->where('users.nama_lengkap', 'like', "%$search%")
                  ->orWhere('users.nomor_telp', 'like', "%$search%");
        })
        ->select('pasien.*', 'users.nama_lengkap as nama', 'users.nomor_telp')
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
        $pasien = Pasien::with(['user', 'rekamMedis'])->findOrFail($id);

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
