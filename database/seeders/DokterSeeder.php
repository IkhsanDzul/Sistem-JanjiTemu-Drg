<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Dokter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data dokter untuk seeding
        $dokterData = [
            [
                'email' => 'dokter1@gmail.com',
                'nama_lengkap' => 'Dr. Ahmad Wijaya, Sp.KG',
                'nik' => '3301010101010001',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1985-05-15',
                'nomor_telp' => '081234567890',
                'alamat' => 'Jl. Kesehatan No. 123, Jakarta',
                'no_str' => 'STR-2024-001234',
                'pendidikan' => 'S1 Kedokteran Gigi',
                'pengalaman_tahun' => '10',
                'spesialisasi_gigi' => 'Konservasi Gigi',
            ],
            [
                'email' => 'dokter2@gmail.com',
                'nama_lengkap' => 'Dr. Siti Nurhaliza, Sp.BM',
                'nik' => '3301010101010002',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1990-08-20',
                'nomor_telp' => '081234567891',
                'alamat' => 'Jl. Dokter Soetomo No. 456, Bandung',
                'no_str' => 'STR-2024-001235',
                'pendidikan' => 'S1 Kedokteran Gigi Universitas Indonesia',
                'pengalaman_tahun' => '5',
                'spesialisasi_gigi' => 'Bedah Mulut',
            ],
            [
                'email' => 'dokter3@gmail.com',
                'nama_lengkap' => 'Dr. Budi Santoso, Sp.Orth',
                'nik' => '3301010101010003',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1988-11-25',
                'nomor_telp' => '081234567892',
                'alamat' => 'Jl. Gajah Mada No. 789, Surabaya',
                'no_str' => 'STR-2024-001236',
                'pendidikan' => 'S1 Kedokteran Gigi Airlangga',
                'pengalaman_tahun' => '7',
                'spesialisasi_gigi' => 'Ortodonsia',
            ],
            [
                'email' => 'dokter4@gmail.com',
                'nama_lengkap' => 'Dr. Rina Kusuma, Sp.Ped',
                'nik' => '3301010101010004',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1987-03-10',
                'nomor_telp' => '081234567893',
                'alamat' => 'Jl. Diponegoro No. 321, Medan',
                'no_str' => 'STR-2024-001237',
                'pendidikan' => 'S1 Kedokteran Gigi Padjadjaran',
                'pengalaman_tahun' => '8',
                'spesialisasi_gigi' => 'Pedodontia',
            ],
            [
                'email' => 'dokter5@gmail.com',
                'nama_lengkap' => 'Dr. Joko Prasetyo, Sp.Perio',
                'nik' => '3301010101010005',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1986-07-18',
                'nomor_telp' => '081234567894',
                'alamat' => 'Jl. Ahmad Yani No. 654, Semarang',
                'no_str' => 'STR-2024-001238',
                'pendidikan' => 'S1 Kedokteran Gigi UGM',
                'pengalaman_tahun' => '9',
                'spesialisasi_gigi' => 'Periodonsia',
            ],
            [
                'email' => 'dokter6@gmail.com',
                'nama_lengkap' => 'Dr. Dewi Lestari, Sp.Prostho',
                'nik' => '3301010101010006',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1989-12-05',
                'nomor_telp' => '081234567895',
                'alamat' => 'Jl. Sultan Hasanuddin No. 987, Makassar',
                'no_str' => 'STR-2024-001239',
                'pendidikan' => 'S1 Kedokteran Gigi UNAIR',
                'pengalaman_tahun' => '6',
                'spesialisasi_gigi' => 'Prostodonsia',
            ],
            [
                'email' => 'dokter7@gmail.com',
                'nama_lengkap' => 'Dr. Andi Pratama, Sp.Rad',
                'nik' => '3301010101010007',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1984-09-30',
                'nomor_telp' => '081234567896',
                'alamat' => 'Jl. Imam Bonjol No. 246, Yogyakarta',
                'no_str' => 'STR-2024-001240',
                'pendidikan' => 'S1 Kedokteran Gigi Atma Jaya',
                'pengalaman_tahun' => '11',
                'spesialisasi_gigi' => 'Radiologi',
            ],
            [
                'email' => 'dokter8@gmail.com',
                'nama_lengkap' => 'Dr. Maya Sari, Sp.Endo',
                'nik' => '3301010101010008',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1991-02-14',
                'nomor_telp' => '081234567897',
                'alamat' => 'Jl. Pattimura No. 135, Denpasar',
                'no_str' => 'STR-2024-001241',
                'pendidikan' => 'S1 Kedokteran Gigi Trisakti',
                'pengalaman_tahun' => '4',
                'spesialisasi_gigi' => 'Endodontia',
            ],
            [
                'email' => 'dokter9@gmail.com',
                'nama_lengkap' => 'Dr. Fajar Nugroho, Sp.KG',
                'nik' => '3301010101010009',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1983-06-22',
                'nomor_telp' => '081234567898',
                'alamat' => 'Jl. Veteran No. 369, Palembang',
                'no_str' => 'STR-2024-001242',
                'pendidikan' => 'S1 Kedokteran Gigi Hasanuddin',
                'pengalaman_tahun' => '12',
                'spesialisasi_gigi' => 'Konservasi Gigi',
            ],
            [
                'email' => 'dokter10@gmail.com',
                'nama_lengkap' => 'Dr. Lina Kartika, Sp.BM',
                'nik' => '3301010101010010',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1992-01-08',
                'nomor_telp' => '081234567899',
                'alamat' => 'Jl. Basuki Rahmat No. 147, Malang',
                'no_str' => 'STR-2024-001243',
                'pendidikan' => 'S1 Kedokteran Gigi Brawijaya',
                'pengalaman_tahun' => '3',
                'spesialisasi_gigi' => 'Bedah Mulut',
            ],
            [
                'email' => 'dokter11@gmail.com',
                'nama_lengkap' => 'Dr. Agus Salim, Sp.Orth',
                'nik' => '3301010101010011',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1982-10-17',
                'nomor_telp' => '081234567900',
                'alamat' => 'Jl. Yos Sudarso No. 258, Banjarmasin',
                'no_str' => 'STR-2024-001244',
                'pendidikan' => 'S1 Kedokteran Gigi Udayana',
                'pengalaman_tahun' => '13',
                'spesialisasi_gigi' => 'Ortodonsia',
            ],
            [
                'email' => 'dokter12@gmail.com',
                'nama_lengkap' => 'Dr. Yuni Astuti, Sp.Ped',
                'nik' => '3301010101010012',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1987-04-12',
                'nomor_telp' => '081234567901',
                'alamat' => 'Jl. MT Haryono No. 159, Pontianak',
                'no_str' => 'STR-2024-001245',
                'pendidikan' => 'S1 Kedokteran Gigi Sriwijaya',
                'pengalaman_tahun' => '8',
                'spesialisasi_gigi' => 'Pedodontia',
            ],
            [
                'email' => 'dokter13@gmail.com',
                'nama_lengkap' => 'Dr. Rizki Pratama, Sp.Perio',
                'nik' => '3301010101010013',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1989-07-29',
                'nomor_telp' => '081234567902',
                'alamat' => 'Jl. Merdeka No. 357, Manado',
                'no_str' => 'STR-2024-001246',
                'pendidikan' => 'S1 Kedokteran Gigi Diponegoro',
                'pengalaman_tahun' => '6',
                'spesialisasi_gigi' => 'Periodonsia',
            ],
            [
                'email' => 'dokter14@gmail.com',
                'nama_lengkap' => 'Dr. Tuti Indriani, Sp.Prostho',
                'nik' => '3301010101010014',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1986-11-03',
                'nomor_telp' => '081234567903',
                'alamat' => 'Jl. Diponegoro No. 147, Jayapura',
                'no_str' => 'STR-2024-001247',
                'pendidikan' => 'S1 Kedokteran Gigi Lambung Mangkurat',
                'pengalaman_tahun' => '9',
                'spesialisasi_gigi' => 'Prostodonsia',
            ],
            [
                'email' => 'dokter15@gmail.com',
                'nama_lengkap' => 'Dr. Hadi Prasetya, Sp.Rad',
                'nik' => '3301010101010015',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1985-12-25',
                'nomor_telp' => '081234567904',
                'alamat' => 'Jl. Ahmad Dahlan No. 258, Ambon',
                'no_str' => 'STR-2024-001248',
                'pendidikan' => 'S1 Kedokteran Gigi Kristen Indonesia',
                'pengalaman_tahun' => '10',
                'spesialisasi_gigi' => 'Radiologi',
            ],
        ];

        // Loop untuk membuat 15 dokter
        foreach ($dokterData as $dokter) {
            $user = User::firstOrCreate(
                ['email' => $dokter['email']],
                [
                    'id' => Str::uuid(),
                    'role_id' => 'dokter',
                    'nama_lengkap' => $dokter['nama_lengkap'],
                    'password' => Hash::make('password'),
                    'nik' => $dokter['nik'],
                    'jenis_kelamin' => $dokter['jenis_kelamin'],
                    'tanggal_lahir' => $dokter['tanggal_lahir'],
                    'nomor_telp' => $dokter['nomor_telp'],
                    'alamat' => $dokter['alamat'],
                ]
            );

            // Update role_id jika user sudah ada tapi belum punya role dokter
            if ($user->role_id !== 'dokter') {
                $user->update(['role_id' => 'dokter']);
            }

            Dokter::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'id' => Str::uuid(),
                    'no_str' => $dokter['no_str'],
                    'pendidikan' => $dokter['pendidikan'],
                    'pengalaman_tahun' => $dokter['pengalaman_tahun'],
                    'spesialisasi_gigi' => $dokter['spesialisasi_gigi'],
                    'status' => 'tersedia',
                ]
            );
        }
    }
}

