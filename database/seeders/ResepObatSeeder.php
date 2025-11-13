<?php

namespace Database\Seeders;

use App\Models\RekamMedis;
use App\Models\ResepObat;
use App\Models\Dokter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ResepObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua rekam medis dengan relasi dokter
        $rekamMedis = RekamMedis::with('janjiTemu.dokter.user')->get();

        if ($rekamMedis->isEmpty()) {
            $this->command->warn('Tidak ada rekam medis yang ditemukan. Pastikan RekamMedisSeeder sudah dijalankan.');
            return;
        }

        // Data resep obat
        $resepObatData = [
            [
                [
                    'nama_obat' => 'Amoxicillin 500mg',
                    'jumlah' => 10,
                    'dosis' => 500,
                    'aturan_pakai' => '3x1 sehari setelah makan',
                ],
                [
                    'nama_obat' => 'Paracetamol 500mg',
                    'jumlah' => 10,
                    'dosis' => 500,
                    'aturan_pakai' => '3x1 sehari jika sakit',
                ],
            ],
            [
                [
                    'nama_obat' => 'Chlorhexidine Mouthwash 0.2%',
                    'jumlah' => 1,
                    'dosis' => 200,
                    'aturan_pakai' => 'Kumur 2x sehari setelah sikat gigi',
                ],
            ],
            [
                [
                    'nama_obat' => 'Ibuprofen 400mg',
                    'jumlah' => 10,
                    'dosis' => 400,
                    'aturan_pakai' => '3x1 sehari setelah makan',
                ],
            ],
            [
                [
                    'nama_obat' => 'Fluoride Gel',
                    'jumlah' => 1,
                    'dosis' => 0,
                    'aturan_pakai' => 'Oleskan pada gigi sebelum tidur',
                ],
            ],
        ];

        foreach ($rekamMedis as $index => $rekam) {
            $resepData = $resepObatData[$index % count($resepObatData)];
            $dokter = $rekam->janjiTemu->dokter;

            foreach ($resepData as $obat) {
                // Tabel resep_obats tidak punya rekam_medis_id, hanya user_id
                ResepObat::firstOrCreate(
                    [
                        'user_id' => $dokter->user_id,
                        'nama_obat' => $obat['nama_obat'],
                        'tanggal_resep' => Carbon::parse($rekam->created_at)->format('Y-m-d'),
                    ],
                    [
                        'id' => Str::uuid(),
                        'jumlah' => $obat['jumlah'],
                        'dosis' => $obat['dosis'],
                        'aturan_pakai' => $obat['aturan_pakai'],
                    ]
                );
            }
        }
    }
}

