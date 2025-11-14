<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dokter.rekam-medis');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dokter.rekam-medis-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Logic untuk menyimpan rekam medis
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Logic untuk menampilkan detail rekam medis
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Logic untuk edit rekam medis
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Logic untuk update rekam medis
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Logic untuk hapus rekam medis
    }
}