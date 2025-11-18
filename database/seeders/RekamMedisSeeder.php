<?php

namespace Database\Seeders;

use App\Models\JanjiTemu;
use App\Models\RekamMedis;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RekamMedisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil janji temu yang sudah completed dan belum punya rekam medis
        $janjiTemuCompleted = JanjiTemu::where('status', 'completed')
            ->whereDoesntHave('rekamMedis')
            ->get();

        if ($janjiTemuCompleted->isEmpty()) {
            // Cek apakah ada janji temu completed yang sudah punya rekam medis
            $totalCompleted = JanjiTemu::where('status', 'completed')->count();
            if ($totalCompleted > 0) {
                $this->command->info('Semua janji temu completed sudah memiliki rekam medis.');
            } else {
                $this->command->warn('Tidak ada janji temu yang completed. Pastikan JanjiTemuSeeder sudah dijalankan.');
            }
            return;
        }

        $rekamMedisData = [
            [
                'diagnosa' => 'Karies dentis pada gigi 16 (geraham kiri atas)',
                'tindakan' => 'Pembersihan karies, penambalan dengan komposit resin',
                'catatan' => 'Pasien dianjurkan untuk kontrol 6 bulan sekali dan menjaga kebersihan gigi',
                'biaya' => 500000,
            ],
            [
                'diagnosa' => 'Gingivitis kronis dengan akumulasi plak dan karang gigi',
                'tindakan' => 'Scaling dan root planing, pembersihan karang gigi',
                'catatan' => 'Pasien perlu melakukan perawatan rutin setiap 6 bulan',
                'biaya' => 300000,
            ],
            [
                'diagnosa' => 'Maloklusi kelas II dengan crowding ringan',
                'tindakan' => 'Konsultasi ortodontik, pencetakan model studi',
                'catatan' => 'Pasien akan melakukan perawatan ortodontik dengan behel',
                'biaya' => 750000,
            ],
            [
                'diagnosa' => 'Gigi sehat, hanya perlu pembersihan rutin',
                'tindakan' => 'Pembersihan karang gigi dan polishing',
                'catatan' => 'Pasien dianjurkan kontrol 6 bulan sekali',
                'biaya' => 250000,
            ],
        ];

        foreach ($janjiTemuCompleted as $index => $janjiTemu) {
            $data = $rekamMedisData[$index % count($rekamMedisData)];

            RekamMedis::firstOrCreate(
                ['janji_temu_id' => $janjiTemu->id],
                [
                    'id' => Str::uuid(),
                    'diagnosa' => $data['diagnosa'],
                    'tindakan' => $data['tindakan'],
                    'catatan' => $data['catatan'],
                    'biaya' => $data['biaya'],
                ]
            );
        }
    }
}

