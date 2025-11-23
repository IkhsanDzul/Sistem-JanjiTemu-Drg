<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rekam Medis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #005248;
        }

        .header h1 {
            color: #005248;
            font-size: 20px;
            margin: 0;
        }

        .section {
            margin-bottom: 20px;
        }

        .label {
            font-weight: bold;
            color: #005248;
            margin-bottom: 4px;
        }

        .value {
            margin-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>REKAM MEDIS PASIEN</h1>
        <p>Klinik Gigi Sehat – {{ now()->format('d M Y') }}</p>
    </div>

    <!-- Informasi Pasien -->
    <div class="section">
        <div class="label">Informasi Pasien</div>
        <div class="value">
            Nama: {{ $rekam->janjiTemu->pasien->user->nama_lengkap ?? 'N/A' }}<br>
            NIK: {{ $rekam->janjiTemu->pasien->user->nik ?? 'N/A' }}<br>
            No. Telepon: {{ $rekam->janjiTemu->pasien->user->nomor_telp ?? 'N/A' }}<br>
            Alamat: {{ $rekam->janjiTemu->pasien->user->alamat ?? 'N/A' }}
        </div>
    </div>

    <!-- Informasi Dokter -->
    <div class="section">
        <div class="label">Dokter Penanggung Jawab</div>
        <div class="value">
            Nama: {{ $rekam->janjiTemu->dokter->user->nama_lengkap ?? 'N/A' }}<br>
            Spesialisasi: {{ $rekam->janjiTemu->dokter->spesialisasi_gigi ?? 'N/A' }}<br>
            No. STR: {{ $rekam->janjiTemu->dokter->no_str ?? 'N/A' }}
        </div>
    </div>

    <!-- Informasi Pemeriksaan -->
    <div class="section">
        <div class="label">Detail Pemeriksaan</div>
        <div class="value">
            Tanggal: {{ $rekam->janjiTemu->tanggal ? \Carbon\Carbon::parse($rekam->janjiTemu->tanggal)->format('d M Y') : 'N/A' }}<br>
            Waktu: {{ $rekam->janjiTemu->jam_mulai ? \Carbon\Carbon::parse($rekam->janjiTemu->jam_mulai)->format('H:i') : 'N/A' }} - 
                   {{ $rekam->janjiTemu->jam_selesai ? \Carbon\Carbon::parse($rekam->janjiTemu->jam_selesai)->format('H:i') : 'N/A' }} WIB<br>
            Keluhan: {{ $rekam->janjiTemu->keluhan ?? '-' }}<br>
            Diagnosa: {{ $rekam->diagnosa ?? '-' }}<br>
            Tindakan: {{ $rekam->tindakan ?? '-' }}<br>
            Catatan: {{ $rekam->catatan ?? '-' }}<br>
            Biaya: Rp {{ number_format($rekam->biaya, 0, ',', '.') }}
        </div>
    </div>

    <!-- Resep Obat -->
    @if($rekam->resepObat && $rekam->resepObat->count() > 0)
    <div class="section">
        <div class="label">Resep Obat</div>
        <table>
            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Dosis</th>
                    <th>Aturan Pakai</th>
                    <th>Tanggal Resep</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rekam->resepObat as $resep)
                <tr>
                    <td>{{ $resep->nama_obat }}</td>
                    <td>{{ $resep->jumlah }} unit</td>
                    <td>{{ number_format($resep->dosis, 0, ',', '.') }} mg</td>
                    <td>{{ $resep->aturan_pakai }}</td>
                    <td>{{ $resep->tanggal_resep ? \Carbon\Carbon::parse($resep->tanggal_resep)->format('d/m/Y') : 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        Dokumen ini dicetak secara elektronik dan tidak memerlukan tanda tangan basah.
    </div>

</body>

</html>

