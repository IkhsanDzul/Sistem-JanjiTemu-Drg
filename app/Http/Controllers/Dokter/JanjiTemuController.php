<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JanjiTemu;

class JanjiTemuController extends Controller
{
    // Tampilkan daftar janji temu
    public function index()
    {
        $appointments = JanjiTemu::all();
        return view('dokter.janji-temu.index', compact('appointments'));
    }

    // Tampilkan detail janji temu
    public function show($id)
    {
        $appointment = JanjiTemu::findOrFail($id);
        return view('dokter.janji-temu.show', compact('appointment'));
    }

    public function approve($id)
{
    $appointment = JanjiTemu::findOrFail($id);
    $appointment->status = 'confirmed'; // Bukan 'approved'
    $appointment->save();

    return redirect()->route('dokter.janji-temu.show', $id)
                     ->with('success', 'Janji temu disetujui.');
}

public function reject($id)
{
    $appointment = JanjiTemu::findOrFail($id);
    $appointment->status = 'canceled'; // Bukan 'rejected'
    $appointment->save();

    return redirect()->route('dokter.janji-temu.show', $id)
                     ->with('success', 'Janji temu ditolak.');
}

public function complete($id)
{
    $appointment = JanjiTemu::findOrFail($id);
    $appointment->status = 'completed';
    $appointment->save();

    return redirect()->route('dokter.janji-temu.show', $id)
                     ->with('success', 'Janji temu selesai.');
}
}