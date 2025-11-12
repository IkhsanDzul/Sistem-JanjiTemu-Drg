<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles first (required for users)
        $this->call([
            RoleSeeder::class,
        ]);

        // User::factory(10)->create();


        User::factory()->create([
            'id' => Str::uuid(),
            'role_id' => 'admin',
            'nama_lengkap' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

    // User::factory(10)->create();


    // User::factory()->create([
    //     'id' => (string) Str::uuid(),
    //     'role_id' => 'admin',
    //     'nama_lengkap' => 'Admin',
    //     'email' => 'admin@gmail.com',
    //     'password' => Hash::make('password'),
    // ]);

    // User::factory()->create([
    //     'id' => (string) Str::uuid(),
    //     'role_id' => 'dokter',
    //     'nama_lengkap' => 'Dokter',
    //     'email' => 'dokter@gmail.com',
    //     'password' => Hash::make('password'),
    // ]);

    // User::factory()->create([
    //     'id' => (string) Str::uuid(),
    //     'role_id' => 'pasien',
    //     'nama_lengkap' => 'Pasien',
    //     'email' => 'pasien@gmail.com',
    //     'password' => Hash::make('password'),
    // ]);
        
    }
}
