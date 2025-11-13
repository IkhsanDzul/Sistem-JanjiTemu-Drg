<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pasien;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pasienData = [
            [
                'nama_lengkap' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'nik' => '3201010101010003',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1995-03-15',
                'nomor_telp' => '081234567892',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta Pusat',
                'alergi' => 'Penisilin',
                'golongan_darah' => 'A',
                'riwayat_penyakit' => 'Tidak ada',
            ],
            [
                'nama_lengkap' => 'Siti Nurhaliza',
                'email' => 'siti@gmail.com',
                'nik' => '3201010101010004',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1998-07-22',
                'nomor_telp' => '081234567893',
                'alamat' => 'Jl. Sudirman No. 456, Jakarta Selatan',
                'alergi' => 'Tidak ada',
                'golongan_darah' => 'B',
                'riwayat_penyakit' => 'Hipertensi',
            ],
            [
                'nama_lengkap' => 'Ahmad Fauzi',
                'email' => 'ahmad@gmail.com',
                'nik' => '3201010101010005',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1992-11-10',
                'nomor_telp' => '081234567894',
                'alamat' => 'Jl. Gatot Subroto No. 789, Jakarta Selatan',
                'alergi' => 'Aspirin',
                'golongan_darah' => 'O',
                'riwayat_penyakit' => 'Diabetes',
            ],
            [
                'nama_lengkap' => 'Dewi Sartika',
                'email' => 'dewi@gmail.com',
                'nik' => '3201010101010006',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2000-01-05',
                'nomor_telp' => '081234567895',
                'alamat' => 'Jl. Thamrin No. 321, Jakarta Pusat',
                'alergi' => 'Tidak ada',
                'golongan_darah' => 'AB',
                'riwayat_penyakit' => 'Tidak ada',
            ],
            [
                'nama_lengkap' => 'Rizki Pratama',
                'email' => 'rizki@gmail.com',
                'nik' => '3201010101010007',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1997-09-18',
                'nomor_telp' => '081234567896',
                'alamat' => 'Jl. Kebon Jeruk No. 654, Jakarta Barat',
                'alergi' => 'Lateks',
                'golongan_darah' => 'A',
                'riwayat_penyakit' => 'Asma',
            ],
        ];

        foreach ($pasienData as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'id' => Str::uuid(),
                    'role_id' => 'pasien',
                    'nama_lengkap' => $data['nama_lengkap'],
                    'password' => Hash::make('password'),
                    'nik' => $data['nik'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'tanggal_lahir' => $data['tanggal_lahir'],
                    'nomor_telp' => $data['nomor_telp'],
                    'alamat' => $data['alamat'],
                ]
            );

            // Update role_id jika user sudah ada
            if ($user->role_id !== 'pasien') {
                $user->update(['role_id' => 'pasien']);
            }

            // Buat data pasien
            Pasien::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'id' => Str::uuid(),
                    'alergi' => $data['alergi'],
                    'golongan_darah' => $data['golongan_darah'],
                    'riwayat_penyakit' => $data['riwayat_penyakit'],
                ]
            );
        }
    }
}

