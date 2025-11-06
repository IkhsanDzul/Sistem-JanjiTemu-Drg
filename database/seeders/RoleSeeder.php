<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['id' => 'admin', 'nama_role' => 'Admin'],
            ['id' => 'dokter', 'nama_role' => 'Dokter'],
            ['id' => 'pasien', 'nama_role' => 'Pasien'],
        ]);
    }
}
