<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Dokter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat atau update user dokter pertama
        $userDokter = User::firstOrCreate(
            ['email' => 'dokter@gmail.com'],
            [
                'id' => Str::uuid(),
                'role_id' => 'dokter',
                'nama_lengkap' => 'Dr. Ahmad Wijaya, Sp.KG',
                'password' => Hash::make('password'),
                'nik' => '3201010101010001',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1985-05-15',
                'nomor_telp' => '081234567890',
                'alamat' => 'Jl. Kesehatan No. 123, Jakarta',
            ]
        );

        // Update role_id jika user sudah ada tapi belum punya role dokter
        if ($userDokter->role_id !== 'dokter') {
            $userDokter->update(['role_id' => 'dokter']);
        }

        // Membuat atau update data dokter terkait
        Dokter::firstOrCreate(
            ['user_id' => $userDokter->id],
            [
                'id' => Str::uuid(),
                'no_str' => 'STR-2024-001234',
                'pengalaman_tahun' => '10',
                'spesialisasi_gigi' => 'Konservasi Gigi',
                'status' => 'tersedia',
            ]
        );

        // Membuat dokter kedua untuk variasi
        $userDokter2 = User::firstOrCreate(
            ['email' => 'dokter2@gmail.com'],
            [
                'id' => Str::uuid(),
                'role_id' => 'dokter',
                'nama_lengkap' => 'Dr. Siti Nurhaliza, Sp.BM',
                'password' => Hash::make('password'),
                'nik' => '3201010101010002',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1990-08-20',
                'nomor_telp' => '081234567891',
                'alamat' => 'Jl. Dokter Soetomo No. 456, Bandung',
            ]
        );

        // Update role_id jika user sudah ada tapi belum punya role dokter
        if ($userDokter2->role_id !== 'dokter') {
            $userDokter2->update(['role_id' => 'dokter']);
        }

        Dokter::firstOrCreate(
            ['user_id' => $userDokter2->id],
            [
                'id' => Str::uuid(),
                'no_str' => 'STR-2024-001235',
                'pengalaman_tahun' => '5',
                'spesialisasi_gigi' => 'Bedah Mulut',
                'status' => 'tersedia',
            ]
        );
    }
}

