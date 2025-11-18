<?php

namespace Database\Seeders;

use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\JanjiTemu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class JanjiTemuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pasien = Pasien::with('user')->get();
        $dokters = Dokter::with('user')->get();

        if ($pasien->isEmpty() || $dokters->isEmpty()) {
            $this->command->warn('Tidak ada pasien atau dokter yang ditemukan. Pastikan seeder terkait sudah dijalankan.');
            return;
        }

        // Data janji temu untuk berbagai status
        $janjiTemuData = [
            // Janji temu hari ini - pending
            [
                'pasien_email' => 'budi@gmail.com',
                'dokter_email' => 'dokter@gmail.com',
                'tanggal' => Carbon::today(),
                'jam_mulai' => '09:00',
                'jam_selesai' => '10:00',
                'keluhan' => 'Gigi berlubang pada gigi geraham kiri atas',
                'status' => 'pending',
            ],
            // Janji temu hari ini - confirmed
            [
                'pasien_email' => 'siti@gmail.com',
                'dokter_email' => 'dokter@gmail.com',
                'tanggal' => Carbon::today(),
                'jam_mulai' => '10:00',
                'jam_selesai' => '11:00',
                'keluhan' => 'Perlu pembersihan karang gigi',
                'status' => 'confirmed',
            ],
            // Janji temu besok - confirmed
            [
                'pasien_email' => 'ahmad@gmail.com',
                'dokter_email' => 'dokter2@gmail.com',
                'tanggal' => Carbon::tomorrow(),
                'jam_mulai' => '14:00',
                'jam_selesai' => '15:00',
                'keluhan' => 'Konsultasi untuk perawatan ortodontik',
                'status' => 'confirmed',
            ],
            // Janji temu kemarin - completed
            [
                'pasien_email' => 'dewi@gmail.com',
                'dokter_email' => 'dokter@gmail.com',
                'tanggal' => Carbon::yesterday(),
                'jam_mulai' => '11:00',
                'jam_selesai' => '12:00',
                'keluhan' => 'Pemeriksaan rutin dan pembersihan gigi',
                'status' => 'completed',
            ],
            // Janji temu 2 hari lalu - completed
            [
                'pasien_email' => 'rizki@gmail.com',
                'dokter_email' => 'dokter2@gmail.com',
                'tanggal' => Carbon::yesterday()->subDay(),
                'jam_mulai' => '15:00',
                'jam_selesai' => '16:00',
                'keluhan' => 'Tambal gigi yang copot',
                'status' => 'completed',
            ],
            // Janji temu minggu lalu - canceled
            [
                'pasien_email' => 'budi@gmail.com',
                'dokter_email' => 'dokter2@gmail.com',
                'tanggal' => Carbon::now()->subWeek(),
                'jam_mulai' => '10:00',
                'jam_selesai' => '11:00',
                'keluhan' => 'Konsultasi gigi sensitif',
                'status' => 'canceled',
            ],
            // Janji temu minggu depan - pending
            [
                'pasien_email' => 'siti@gmail.com',
                'dokter_email' => 'dokter2@gmail.com',
                'tanggal' => Carbon::now()->addWeek(),
                'jam_mulai' => '09:00',
                'jam_selesai' => '10:00',
                'keluhan' => 'Kontrol setelah perawatan',
                'status' => 'pending',
            ],
            // Janji temu 3 hari lagi - confirmed
            [
                'pasien_email' => 'ahmad@gmail.com',
                'dokter_email' => 'dokter@gmail.com',
                'tanggal' => Carbon::now()->addDays(3),
                'jam_mulai' => '14:00',
                'jam_selesai' => '15:00',
                'keluhan' => 'Pemeriksaan untuk pemasangan behel',
                'status' => 'confirmed',
            ],
        ];

        foreach ($janjiTemuData as $data) {
            $pasienUser = $pasien->firstWhere('user.email', $data['pasien_email']);
            $dokterUser = $dokters->firstWhere('user.email', $data['dokter_email']);

            if (!$pasienUser || !$dokterUser) {
                continue;
            }

            JanjiTemu::firstOrCreate(
                [
                    'pasien_id' => $pasienUser->id,
                    'dokter_id' => $dokterUser->id,
                    'tanggal' => $data['tanggal'],
                    'jam_mulai' => $data['jam_mulai'],
                ],
                [
                    'id' => Str::uuid(),
                    'jam_selesai' => $data['jam_selesai'],
                    'keluhan' => $data['keluhan'],
                    'status' => $data['status'],
                ]
            );
        }
    }
}

