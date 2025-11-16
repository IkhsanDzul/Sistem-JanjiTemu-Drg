<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JanjiTemu;

class JanjiTemuController extends Controller
{
    public function index()
    {
        $appointments = JanjiTemu::orderBy('tanggal', 'desc')->get();


        return view('dokter.janji-temu.index', compact('appointments'));
    }

    public function show($id)
    {
        $appointment = JanjiTemu::findOrFail($id);

        return view('dokter.janji-temu.show', compact('appointment'));
    }
}
