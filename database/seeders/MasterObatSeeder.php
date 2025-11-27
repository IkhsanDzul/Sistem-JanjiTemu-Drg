<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterObat;
use Illuminate\Support\Str;

class MasterObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obat = [
            [
                'id' => Str::uuid()->toString(),
                'nama_obat' => 'Paracetamol 500mg',
                'satuan' => 'mg',
                'dosis_default' => 500,
                'aturan_pakai_default' => '3x1 sehari jika sakit',
                'deskripsi' => 'Obat pereda nyeri dan demam',
                'aktif' => true,
            ],
            [
                'id' => Str::uuid()->toString(),
                'nama_obat' => 'Amoxicillin 500mg',
                'satuan' => 'mg',
                'dosis_default' => 500,
                'aturan_pakai_default' => '3x1 sehari setelah makan',
                'deskripsi' => 'Antibiotik untuk infeksi bakteri',
                'aktif' => true,
            ],
            [
                'id' => Str::uuid()->toString(),
                'nama_obat' => 'Chlorhexidine Mouthwash 0.2%',
                'satuan' => 'ml',
                'dosis_default' => 200,
                'aturan_pakai_default' => 'Kumur 2x sehari setelah sikat gigi',
                'deskripsi' => 'Obat kumur antiseptik untuk kesehatan mulut',
                'aktif' => true,
            ],
            [
                'id' => Str::uuid()->toString(),
                'nama_obat' => 'Ibuprofen 400mg',
                'satuan' => 'mg',
                'dosis_default' => 400,
                'aturan_pakai_default' => '3x1 sehari setelah makan',
                'deskripsi' => 'Obat antiinflamasi nonsteroid untuk nyeri dan peradangan',
                'aktif' => true,
            ],
            [
                'id' => Str::uuid()->toString(),
                'nama_obat' => 'Metronidazole 500mg',
                'satuan' => 'mg',
                'dosis_default' => 500,
                'aturan_pakai_default' => '3x1 sehari setelah makan',
                'deskripsi' => 'Antibiotik untuk infeksi anaerob',
                'aktif' => true,
            ],
            [
                'id' => Str::uuid()->toString(),
                'nama_obat' => 'Diclofenac Sodium 50mg',
                'satuan' => 'mg',
                'dosis_default' => 50,
                'aturan_pakai_default' => '2x1 sehari setelah makan',
                'deskripsi' => 'Obat antiinflamasi untuk nyeri dan peradangan',
                'aktif' => true,
            ],
            [
                'id' => Str::uuid()->toString(),
                'nama_obat' => 'Cefadroxil 500mg',
                'satuan' => 'mg',
                'dosis_default' => 500,
                'aturan_pakai_default' => '2x1 sehari setelah makan',
                'deskripsi' => 'Antibiotik sefalosporin untuk infeksi bakteri',
                'aktif' => true,
            ],
            [
                'id' => Str::uuid()->toString(),
                'nama_obat' => 'Povidone Iodine 10%',
                'satuan' => 'ml',
                'dosis_default' => 10,
                'aturan_pakai_default' => 'Oleskan pada area yang terinfeksi 2x sehari',
                'deskripsi' => 'Antiseptik topikal untuk luka dan infeksi kulit',
                'aktif' => true,
            ],
        ];

        foreach ($obat as $data) {
            MasterObat::create($data);
        }
    }
}

