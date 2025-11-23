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
        <p>Klinik Gigi Sehat – {{ $rekam->janjiTemu && $rekam->janjiTemu->tanggal ? \Carbon\Carbon::parse($rekam->janjiTemu->tanggal)->format('d M Y') : now()->format('d M Y') }}</p>
    </div>

    <!-- Informasi Pasien -->
    <div class="section">
        <div class="label">Informasi Pasien</div>
        <div class="value">
            Nama: {{ $rekam->janjiTemu->pasien->user->nama_lengkap ?? 'N/A' }}<br>
            No. Telepon: {{ $rekam->janjiTemu->pasien->user->nomor_telp ?? 'N/A' }}<br>
            Tanggal Lahir: {{ $rekam->janjiTemu->pasien->tanggal_lahir ? \Carbon\Carbon::parse($rekam->janjiTemu->pasien->tanggal_lahir)->format('d M Y') : 'N/A' }}
        </div>
    </div>

    <!-- Informasi Dokter -->
    <div class="section">
        <div class="label">Dokter Penanggung Jawab</div>
        <div class="value">
            Nama: {{ $rekam->janjiTemu->dokter->user->nama_lengkap ?? 'N/A' }}<br>
            Spesialisasi: {{ $rekam->janjiTemu->dokter->spesialisasi_gigi ?? 'N/A' }}
        </div>
    </div>

    <!-- Informasi Pemeriksaan -->
    <div class="section">
        <div class="label">Detail Pemeriksaan</div>
        <div class="value">
            Tanggal: {{ $rekam->janjiTemu && $rekam->janjiTemu->tanggal ? \Carbon\Carbon::parse($rekam->janjiTemu->tanggal)->format('d M Y') : 'N/A' }}<br>
            Diagnosa: {{ $rekam->diagnosa }}<br>
            Tindakan: {{ $rekam->tindakan }}
        </div>
    </div>

    <!-- Catatan & Resep -->
    <div class="section">
        <div class="label">Catatan Dokter</div>
        <div class="value">{{ $rekam->catatan ?? '-' }}</div>

        @if($rekam->resep)
        <div class="label" style="margin-top: 10px;">Resep Obat</div>
        <div class="value">{{ $rekam->resep }}</div>
        @endif
    </div>

    <div class="footer">
        Dokumen ini dicetak secara elektronik dan tidak memerlukan tanda tangan basah.
    </div>

</body>

</html>

