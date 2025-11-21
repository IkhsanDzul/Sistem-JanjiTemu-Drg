<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDokterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $dokterId = $this->route('id');
        $dokter = \App\Models\Dokter::findOrFail($dokterId);
        $userId = $dokter->user_id;

        return [
            // Data User
            'nik' => [
                'required',
                'string',
                'size:16',
                Rule::unique('users', 'nik')->ignore($userId),
            ],
            'nama_lengkap' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:50',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date|before:today',
            'nomor_telp' => 'required|string|max:20',
            'alamat' => 'required|string',
            
            // Data Dokter
            'no_str' => [
                'required',
                'string',
                'max:50',
                Rule::unique('dokter', 'no_str')->ignore($dokterId),
            ],
            'pendidikan' => 'required|string|max:255',
            'pengalaman_tahun' => 'required|string|max:100',
            'spesialisasi_gigi' => 'required|string|max:100',
            'status' => 'required|in:tersedia,tidak tersedia',
            
            // Foto Profil
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus terdiri dari 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.max' => 'Nama lengkap maksimal 100 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin harus Laki-laki atau Perempuan.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'nomor_telp.required' => 'Nomor telepon wajib diisi.',
            'nomor_telp.max' => 'Nomor telepon maksimal 20 karakter.',
            'alamat.required' => 'Alamat wajib diisi.',
            'no_str.required' => 'Nomor STR wajib diisi.',
            'no_str.unique' => 'Nomor STR sudah terdaftar.',
            'pendidikan.required' => 'Pendidikan wajib diisi.',
            'pendidikan.max' => 'Pendidikan maksimal 255 karakter.',
            'pengalaman_tahun.required' => 'Pengalaman tahun wajib diisi.',
            'spesialisasi_gigi.required' => 'Spesialisasi gigi wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus Tersedia atau Tidak Tersedia.',
            'foto_profil.image' => 'File foto profil harus berupa gambar.',
            'foto_profil.mimes' => 'Foto profil harus berformat: jpeg, png, jpg, atau gif.',
            'foto_profil.max' => 'Ukuran foto profil maksimal 2MB.',
        ];
    }
}

