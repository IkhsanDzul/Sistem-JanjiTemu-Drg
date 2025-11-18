<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * 
     * Urutan seeding penting karena ada relasi foreign key:
     * 1. Roles (harus pertama)
     * 2. Admin (karena bisa membuat data lain)
     * 3. Dokter
     * 4. Pasien
     * 5. Jadwal Praktek (butuh dokter)
     * 6. Janji Temu (butuh pasien & dokter)
     * 7. Rekam Medis (butuh janji temu)
     * 8. Resep Obat (butuh rekam medis)
     * 9. Logs (butuh admin)
     */
    public function run(): void
    {
        $this->command->info('🚀 Memulai seeding database...');
        
        // 1. Seed roles first (required for users)
        $this->command->info('📋 Seeding Roles...');
        $this->call(RoleSeeder::class);

        // 2. Seed admin
        $this->command->info('👤 Seeding Admin...');
        $this->call(AdminSeeder::class);

        // 3. Seed dokter
        $this->command->info('👨‍⚕️ Seeding Dokter...');
        $this->call(DokterSeeder::class);

        // 4. Seed pasien
        $this->command->info('👥 Seeding Pasien...');
        $this->call(PasienSeeder::class);

        // 5. Seed jadwal praktek
        $this->command->info('📅 Seeding Jadwal Praktek...');
        $this->call(JadwalPraktekSeeder::class);

        // 6. Seed janji temu
        $this->command->info('📝 Seeding Janji Temu...');
        $this->call(JanjiTemuSeeder::class);

        // 7. Seed rekam medis
        $this->command->info('🏥 Seeding Rekam Medis...');
        $this->call(RekamMedisSeeder::class);

        // 8. Seed resep obat
        $this->command->info('💊 Seeding Resep Obat...');
        $this->call(ResepObatSeeder::class);

        // 9. Seed logs
        $this->command->info('📊 Seeding Logs...');
        $this->call(LogSeeder::class);

        $this->command->info('✅ Seeding database selesai!');
        $this->command->info('');
        $this->command->info('📌 Kredensial Login:');
        $this->command->info('   Admin: admin@gmail.com / password');
        $this->command->info('   Dokter: dokter@gmail.com / password');
        $this->command->info('   Pasien: budi@gmail.com / password');
    }
}
