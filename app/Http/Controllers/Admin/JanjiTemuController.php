<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JanjiTemu;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JanjiTemuController extends Controller
{
    use LogsActivity;
    /**
     * Menampilkan daftar semua janji temu
     */
    public function index(Request $request)
    {
        $query = JanjiTemu::with(['pasien.user', 'dokter.user']);

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->has('tanggal') && $request->tanggal != '') {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Filter berdasarkan bulan
        if ($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('tanggal', $request->bulan)
                  ->whereYear('tanggal', Carbon::now()->year);
        }

        // Search berdasarkan nama pasien atau dokter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('pasien.user', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%");
            })->orWhereHas('dokter.user', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $janjiTemu = $query->paginate(15);

        // Statistik untuk filter
        $totalPending = JanjiTemu::where('status', 'pending')->count();
        $totalConfirmed = JanjiTemu::where('status', 'confirmed')->count();
        $totalCompleted = JanjiTemu::where('status', 'completed')->count();
        $totalCanceled = JanjiTemu::where('status', 'canceled')->count();

        return view('admin.janji-temu.index', compact(
            'janjiTemu',
            'totalPending',
            'totalConfirmed',
            'totalCompleted',
            'totalCanceled'
        ))->with('title', 'Kelola Janji Temu');
    }

    /**
     * Menampilkan detail janji temu
     */
    public function show($id)
    {
        $janjiTemu = JanjiTemu::with(['pasien.user', 'dokter.user', 'rekamMedis.resepObat'])
            ->findOrFail($id);

        return view('admin.janji-temu.show', compact('janjiTemu'))
            ->with('title', 'Detail Janji Temu');
    }

    /**
     * Update status janji temu
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,canceled'
        ]);

        $janjiTemu = JanjiTemu::findOrFail($id);
        $janjiTemu->status = $request->status;
        $janjiTemu->save();

        // Log aktivitas
        $this->logActivity('edit');

        return redirect()->route('admin.janji-temu.show', $id)
            ->with('success', 'Status janji temu berhasil diperbarui.');
    }
}

