<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Dokter;
use App\Http\Requests\Admin\StoreDokterRequest;
use App\Http\Requests\Admin\UpdateDokterRequest;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DokterController extends Controller
{
    /**
     * Menampilkan daftar semua dokter
     */
    public function index(Request $request)
    {
        $query = Dokter::with(['user', 'jadwalPraktek']);

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan spesialisasi
        if ($request->has('spesialisasi') && $request->spesialisasi != '') {
            $query->where('spesialisasi_gigi', 'like', "%{$request->spesialisasi}%");
        }

        // Search berdasarkan nama atau email
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // Sorting - default by created_at dari user
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        // Sorting berdasarkan field
        if (in_array($sortBy, ['no_str', 'spesialisasi_gigi', 'pengalaman_tahun', 'status'])) {
            // Sort dari tabel dokter
            $query->orderBy('dokter.' . $sortBy, $sortOrder);
        } elseif (in_array($sortBy, ['nama_lengkap', 'email'])) {
            // Sort dari tabel users menggunakan join
            $query->join('users', 'dokter.user_id', '=', 'users.id')
                  ->select('dokter.*')
                  ->orderBy('users.' . $sortBy, $sortOrder);
        } else {
            // Default: sort by user created_at menggunakan join
            $query->join('users', 'dokter.user_id', '=', 'users.id')
                  ->select('dokter.*')
                  ->orderBy('users.created_at', $sortOrder);
        }

        $dokter = $query->paginate(15);

        // Statistik
        $totalDokter = Dokter::count();
        $dokterTersedia = Dokter::where('status', 'tersedia')->count();
        $dokterTidakTersedia = Dokter::where('status', 'tidak tersedia')->count();

        return view('admin.dokter.index', compact(
            'dokter',
            'totalDokter',
            'dokterTersedia',
            'dokterTidakTersedia'
        ))->with('title', 'Manajemen Dokter');
    }

    /**
     * Menampilkan form tambah dokter
     */
    public function create()
    {
        return view('admin.dokter.create')->with('title', 'Tambah Dokter');
    }

    /**
     * Menyimpan data dokter baru
     */
    public function store(StoreDokterRequest $request)
    {
        DB::beginTransaction();
        
        try {
            // Handle upload foto profil
            $fotoProfilPath = null;
            if ($request->hasFile('foto_profil')) {
                $fotoProfilPath = $request->file('foto_profil')->store('foto_profil', 'public');
            }

            // Buat user baru
            $user = User::create([
                'id' => Str::uuid(),
                'role_id' => 'dokter',
                'nik' => $request->nik,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'nomor_telp' => $request->nomor_telp,
                'alamat' => $request->alamat,
                'foto_profil' => $fotoProfilPath,
            ]);

            // Buat data dokter
            $dokter = Dokter::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'no_str' => $request->no_str,
                'pendidikan' => $request->pendidikan,
                'pengalaman_tahun' => $request->pengalaman_tahun,
                'spesialisasi_gigi' => $request->spesialisasi_gigi,
                'status' => $request->status ?? 'tersedia',
            ]);

            DB::commit();

            return redirect()->route('admin.dokter.index')
                ->with('success', 'Data dokter berhasil ditambahkan.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            // Validation exception akan otomatis redirect back dengan errors
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log error untuk debugging
            Log::error('Error saat menyimpan data dokter: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail dokter
     */
    public function show($id)
    {
        $dokter = Dokter::with(['user', 'jadwalPraktek', 'janjiTemu'])
            ->findOrFail($id);

        // Statistik dokter
        $totalJanjiTemu = $dokter->janjiTemu()->count();
        $janjiTemuBulanIni = $dokter->janjiTemu()
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        return view('admin.dokter.show', compact('dokter', 'totalJanjiTemu', 'janjiTemuBulanIni'))
            ->with('title', 'Detail Dokter');
    }

    /**
     * Menampilkan form edit dokter
     */
    public function edit($id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);
        
        return view('admin.dokter.edit', compact('dokter'))
            ->with('title', 'Edit Dokter');
    }

    /**
     * Update data dokter
     */
    public function update(UpdateDokterRequest $request, $id)
    {
        DB::beginTransaction();
        
        try {
            $dokter = Dokter::with('user')->findOrFail($id);
            $user = $dokter->user;

            // Handle upload foto profil
            if ($request->hasFile('foto_profil')) {
                // Hapus foto lama jika ada
                if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                    Storage::disk('public')->delete($user->foto_profil);
                }
                
                // Simpan foto baru
                $fotoProfilPath = $request->file('foto_profil')->store('foto_profil', 'public');
            }

            // Update data user
            $userData = [
                'nik' => $request->nik,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'nomor_telp' => $request->nomor_telp,
                'alamat' => $request->alamat,
            ];

            // Update password jika diisi
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            // Update foto profil jika ada
            if (isset($fotoProfilPath)) {
                $userData['foto_profil'] = $fotoProfilPath;
            }

            $user->update($userData);

            // Update data dokter
            $dokter->update([
                'no_str' => $request->no_str,
                'pendidikan' => $request->pendidikan,
                'pengalaman_tahun' => $request->pengalaman_tahun,
                'spesialisasi_gigi' => $request->spesialisasi_gigi,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('admin.dokter.show', $id)
                ->with('success', 'Data dokter berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Hapus data dokter
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        
        try {
            $dokter = Dokter::with('user')->findOrFail($id);
            
            // Cek apakah dokter memiliki janji temu yang belum selesai
            $janjiTemuAktif = $dokter->janjiTemu()
                ->whereIn('status', ['pending', 'confirmed'])
                ->count();

            if ($janjiTemuAktif > 0) {
                return redirect()->back()
                    ->with('error', 'Tidak dapat menghapus dokter yang masih memiliki janji temu aktif.');
            }

            // Hapus user (akan cascade ke dokter karena foreign key)
            $dokter->user->delete();

            DB::commit();

            return redirect()->route('admin.dokter.index')
                ->with('success', 'Data dokter berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}

