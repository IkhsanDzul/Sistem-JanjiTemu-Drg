<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => Str::uuid(),
                'role_id' => 'admin',
                'nama_lengkap' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
            ],
            [
                'id' => Str::uuid(),
                'role_id' => 'dokter',
                'nama_lengkap' => 'Dokter',
                'email' => 'dokter@gmail.com',
                'password' => Hash::make('password'),
            ],
            [
                'id' => Str::uuid(),
                'role_id' => 'pasien',
                'nama_lengkap' => 'Pasien',
                'email' => 'pasien@gmail.com',
                'password' => Hash::make('password'),
            ],            
        ]);
    }
}
