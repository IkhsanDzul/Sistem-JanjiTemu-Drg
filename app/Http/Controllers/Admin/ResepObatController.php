<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResepObat;
use App\Models\MasterObat;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ResepObatController extends Controller
{
    /**
     * Menampilkan daftar semua resep obat
     */
    public function index(Request $request)
    {
        $query = ResepObat::with([
            'rekamMedis.janjiTemu.pasien.user',
            'rekamMedis.janjiTemu.dokter.user',
            'dokter.user'
        ]);

        // Search berdasarkan nama obat, nama pasien, atau nama dokter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_obat', 'like', "%{$search}%")
                  ->orWhereHas('rekamMedis.janjiTemu.pasien.user', function($q) use ($search) {
                      $q->where('nama_lengkap', 'like', "%{$search}%");
                  })
                  ->orWhereHas('rekamMedis.janjiTemu.dokter.user', function($q) use ($search) {
                      $q->where('nama_lengkap', 'like', "%{$search}%");
                  });
            });
        }

        // Filter berdasarkan tanggal resep
        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('tanggal_resep', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('tanggal_resep', '<=', $request->tanggal_sampai);
        }

        // Filter berdasarkan dokter
        if ($request->has('dokter_id') && $request->dokter_id != '') {
            $query->where('dokter_id', $request->dokter_id);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'tanggal_resep');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $resepObat = $query->paginate(15);

        // Statistik
        $totalResepObat = ResepObat::count();
        $totalObatUnik = ResepObat::distinct('nama_obat')->count('nama_obat');
        $resepObatBulanIni = ResepObat::whereMonth('tanggal_resep', now()->month)
            ->whereYear('tanggal_resep', now()->year)
            ->count();

        // Ambil daftar dokter untuk filter
        $dokterList = \App\Models\Dokter::with('user')
            ->whereHas('user')
            ->get()
            ->map(function($d) {
                return [
                    'id' => $d->id,
                    'nama' => $d->user->nama_lengkap ?? 'N/A'
                ];
            });

        return view('admin.resep-obat.index', compact(
            'resepObat',
            'totalResepObat',
            'totalObatUnik',
            'resepObatBulanIni',
            'dokterList'
        ))->with('title', 'Resep Obat');
    }

    /**
     * Menampilkan detail resep obat
     */
    public function show($id)
    {
        $resepObat = ResepObat::with([
            'rekamMedis.janjiTemu.pasien.user',
            'rekamMedis.janjiTemu.dokter.user',
            'dokter.user'
        ])->findOrFail($id);

        return view('admin.resep-obat.show', compact('resepObat'))
            ->with('title', 'Detail Resep Obat');
    }
}

