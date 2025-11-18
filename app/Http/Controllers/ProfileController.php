<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        $user = $request->user();
        $pasien = Pasien::firstOrNew(['user_id' => $user->id]);

        return view('profile.edit', compact('user', 'pasien'));
    }

    public function update(Request $request)
    {
        // VALIDASI
        $request->validate([
            'nama_lengkap'      => 'required|string|max:255',
            'alamat'            => 'nullable|string',
            'nomor_telp'        => 'nullable|string|max:15',
            'tanggal_lahir'     => 'nullable|date',
            'jenis_kelamin'     => 'nullable|string',
            'foto_profil'       => 'nullable|image|max:2048',

            'alergi'            => 'nullable|string',
            'riwayat_penyakit'  => 'nullable|string',
            'golongan_darah'    => 'nullable|string|max:3',
        ]);

        $user = $request->user();

        // UPDATE USER
        $user->update([
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
            'nik'          => $request->nik,
            'alamat'       => $request->alamat,
            'nomor_telp'   => $request->nomor_telp,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        // Upload foto
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            
            // Simpan foto baru
            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $user->update(['foto_profil' => $path]);
        }

        // UPDATE / CREATE PASIEN
        Pasien::updateOrCreate(
            ['user_id' => $user->id],
            [
                'alergi'            => $request->alergi,
                'riwayat_penyakit'  => $request->riwayat_penyakit,
                'golongan_darah'    => $request->golongan_darah,
            ]
        );

        return back()->with('status', 'Profile updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
