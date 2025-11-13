<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Log;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil admin user (foreign key reference ke users.id, bukan admin.id)
        $adminUser = User::where('role_id', 'admin')->first();

        if (!$adminUser) {
            $this->command->warn('Tidak ada admin yang ditemukan. Pastikan AdminSeeder sudah dijalankan.');
            return;
        }

        // Data log aktivitas
        $logsData = [
            [
                'action' => 'buat',
            ],
            [
                'action' => 'edit',
            ],
            [
                'action' => 'buat',
            ],
            [
                'action' => 'edit',
            ],
            [
                'action' => 'buat',
            ],
            [
                'action' => 'edit',
            ],
            [
                'action' => 'hapus',
            ],
            [
                'action' => 'buat',
            ],
            [
                'action' => 'edit',
            ],
            [
                'action' => 'buat',
            ],
        ];

        // Buat log untuk 30 hari terakhir
        foreach ($logsData as $index => $logData) {
            $createdAt = now()->subDays(rand(0, 30))->subHours(rand(0, 23));

            Log::create([
                'id' => Str::uuid(),
                'admin_id' => $adminUser->id, // ID dari users, karena foreign key reference ke users.id
                'action' => $logData['action'],
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}

