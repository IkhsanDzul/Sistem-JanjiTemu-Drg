<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\JadwalPraktek;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JadwalPraktekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua dokter
        $dokters = Dokter::with('user')->get();

        if ($dokters->isEmpty()) {
            $this->command->warn('Tidak ada dokter yang ditemukan. Pastikan DokterSeeder sudah dijalankan.');
            return;
        }

        foreach ($dokters as $dokter) {
            // Jadwal untuk dokter pertama (Dr. Ahmad Wijaya)
            if ($dokter->user->email === 'dokter@gmail.com') {
                $now = date('Y-m-d');
                $jadwalDokter1 = [
                    ['tanggal' => $now, 'jam_mulai' => '08:00', 'jam_selesai' => '12:00', 'status' => 'available'],
                    ['tanggal' => date('Y-m-d', strtotime('+1 days')), 'jam_mulai' => '08:00', 'jam_selesai' => '12:00', 'status' => 'available'],
                    ['tanggal' => date('Y-m-d', strtotime('+2 days')), 'jam_mulai' => '13:00', 'jam_selesai' => '17:00', 'status' => 'available'],
                    ['tanggal' => date('Y-m-d', strtotime('+3 days')), 'jam_mulai' => '13:00', 'jam_selesai' => '17:00', 'status' => 'available'],
                    ['tanggal' => date('Y-m-d', strtotime('+4 days')), 'jam_mulai' => '08:00', 'jam_selesai' => '12:00', 'status' => 'available'],
                    ['tanggal' => date('Y-m-d', strtotime('+5 days')), 'jam_mulai' => '09:00', 'jam_selesai' => '13:00', 'status' => 'available'],
                ];

                foreach ($jadwalDokter1 as $jadwal) {
                    JadwalPraktek::firstOrCreate(
                        [
                            'dokter_id' => $dokter->id,
                            'tanggal' => $jadwal['tanggal'],
                        ],
                        [
                            'id' => Str::uuid(),
                            'jam_mulai' => $jadwal['jam_mulai'],
                            'jam_selesai' => $jadwal['jam_selesai'],
                            'status' => $jadwal['status'],
                        ]
                    );
                }
            }

            // Jadwal untuk dokter kedua (Dr. Siti Nurhaliza)
            if ($dokter->user->email === 'dokter2@gmail.com') {
                $now = date('Y-m-d');
                $jadwalDokter2 = [
                    ['tanggal' => $now, 'jam_mulai' => '08:00', 'jam_selesai' => '12:00', 'status' => 'available'],
                    ['tanggal' => date('Y-m-d', strtotime('+1 days')), 'jam_mulai' => '13:00', 'jam_selesai' => '17:00', 'status' => 'available'],
                    ['tanggal' => date('Y-m-d', strtotime('+2 days')), 'jam_mulai' => '13:00', 'jam_selesai' => '17:00', 'status' => 'available'],
                    ['tanggal' => date('Y-m-d', strtotime('+3 days')), 'jam_mulai' => '08:00', 'jam_selesai' => '12:00', 'status' => 'available'],
                    ['tanggal' => date('Y-m-d', strtotime('+4 days')), 'jam_mulai' => '08:00', 'jam_selesai' => '12:00', 'status' => 'available'],
                    ['tanggal' => date('Y-m-d', strtotime('+5 days')), 'jam_mulai' => '09:00', 'jam_selesai' => '13:00', 'status' => 'available'],
                ];

                foreach ($jadwalDokter2 as $jadwal) {
                    JadwalPraktek::firstOrCreate(
                        [
                            'dokter_id' => $dokter->id,
                            'tanggal' => $jadwal['tanggal'],
                        ],
                        [
                            'id' => Str::uuid(),
                            'jam_mulai' => $jadwal['jam_mulai'],
                            'jam_selesai' => $jadwal['jam_selesai'],
                            'status' => $jadwal['status'],
                        ]
                    );
                }
            }
        }
    }
}

