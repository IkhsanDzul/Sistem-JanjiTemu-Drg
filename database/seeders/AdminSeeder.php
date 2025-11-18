<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat atau update user admin
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'id' => Str::uuid(),
                'role_id' => 'admin',
                'nama_lengkap' => 'Administrator',
                'password' => Hash::make('password'),
                'nik' => '3201010101010000',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1990-01-01',
                'nomor_telp' => '081234567800',
                'alamat' => 'Jl. Admin No. 1, Jakarta',
            ]
        );

        // Update role_id jika user sudah ada
        if ($adminUser->role_id !== 'admin') {
            $adminUser->update(['role_id' => 'admin']);
        }

        // Buat data admin
        Admin::firstOrCreate(
            ['user_id' => $adminUser->id],
            [
                'id' => Str::uuid(),
            ]
        );
    }
}

