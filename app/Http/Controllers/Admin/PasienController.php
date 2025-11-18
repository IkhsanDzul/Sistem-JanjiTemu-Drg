<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pasien;
use App\Http\Requests\Admin\StorePasienRequest;
use App\Http\Requests\Admin\UpdatePasienRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PasienController extends Controller
{
    /**
     * Menampilkan daftar semua pasien
     */
    public function index(Request $request)
    {
        $query = Pasien::with('user');

        // Search berdasarkan nama, email, atau NIK
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan jenis kelamin
        if ($request->has('jenis_kelamin') && $request->jenis_kelamin != '') {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('jenis_kelamin', $request->jenis_kelamin);
            });
        }

        // Sorting - default by created_at dari user
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        // Sorting berdasarkan field
        if (in_array($sortBy, ['nama_lengkap', 'email', 'nik'])) {
            // Sort dari tabel users menggunakan join
            $query->join('users', 'pasien.user_id', '=', 'users.id')
                  ->select('pasien.*')
                  ->orderBy('users.' . $sortBy, $sortOrder);
        } else {
            // Default: sort by user created_at menggunakan join
            $query->join('users', 'pasien.user_id', '=', 'users.id')
                  ->select('pasien.*')
                  ->orderBy('users.created_at', $sortOrder);
        }

        $pasien = $query->paginate(15);

        // Statistik
        $totalPasien = Pasien::count();
        $pasienLakiLaki = Pasien::whereHas('user', function($q) {
            $q->where('jenis_kelamin', 'L');
        })->count();
        $pasienPerempuan = Pasien::whereHas('user', function($q) {
            $q->where('jenis_kelamin', 'P');
        })->count();

        return view('admin.manajemen-pasien.index', compact(
            'pasien',
            'totalPasien',
            'pasienLakiLaki',
            'pasienPerempuan'
        ))->with('title', 'Manajemen Pasien');
    }

    /**
     * Menampilkan form tambah pasien
     */
    public function create()
    {
        return view('admin.manajemen-pasien.create')->with('title', 'Tambah Pasien');
    }

    /**
     * Menyimpan data pasien baru
     */
    public function store(StorePasienRequest $request)
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
                'role_id' => 'pasien',
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

            // Buat data pasien
            $pasien = Pasien::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'alergi' => $request->alergi,
                'golongan_darah' => $request->golongan_darah,
                'riwayat_penyakit' => $request->riwayat_penyakit,
            ]);

            DB::commit();

            return redirect()->route('admin.pasien.index')
                ->with('success', 'Data pasien berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail pasien
     */
    public function show($id)
    {
        $pasien = Pasien::with(['user', 'janjiTemu.dokter.user'])
            ->findOrFail($id);

        // Statistik pasien
        $totalJanjiTemu = $pasien->janjiTemu()->count();
        $janjiTemuBulanIni = $pasien->janjiTemu()
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        return view('admin.manajemen-pasien.show', compact('pasien', 'totalJanjiTemu', 'janjiTemuBulanIni'))
            ->with('title', 'Detail Pasien');
    }

    /**
     * Menampilkan form edit pasien
     */
    public function edit($id)
    {
        $pasien = Pasien::with('user')->findOrFail($id);
        
        return view('admin.manajemen-pasien.edit', compact('pasien'))
            ->with('title', 'Edit Pasien');
    }

    /**
     * Update data pasien
     */
    public function update(UpdatePasienRequest $request, $id)
    {
        DB::beginTransaction();
        
        try {
            $pasien = Pasien::with('user')->findOrFail($id);
            $user = $pasien->user;

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

            // Update data pasien
            $pasien->update([
                'alergi' => $request->alergi,
                'golongan_darah' => $request->golongan_darah,
                'riwayat_penyakit' => $request->riwayat_penyakit,
            ]);

            DB::commit();

            return redirect()->route('admin.pasien.show', $id)
                ->with('success', 'Data pasien berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Hapus data pasien
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        
        try {
            $pasien = Pasien::with('user')->findOrFail($id);
            
            // Cek apakah pasien memiliki janji temu yang belum selesai
            $janjiTemuAktif = $pasien->janjiTemu()
                ->whereIn('status', ['pending', 'confirmed'])
                ->count();

            if ($janjiTemuAktif > 0) {
                return redirect()->back()
                    ->with('error', 'Tidak dapat menghapus pasien yang masih memiliki janji temu aktif.');
            }

            // Hapus user (akan cascade ke pasien karena foreign key)
            $pasien->user->delete();

            DB::commit();

            return redirect()->route('admin.pasien.index')
                ->with('success', 'Data pasien berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}

