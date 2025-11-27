<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Ringkasan Pemeriksaan</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #005248;
        }

        .header h1 {
            color: #005248;
            font-size: 22px;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .clinic-name {
            font-weight: 600;
            color: #005248;
        }

        .section {
            margin-bottom: 22px;
        }

        .label {
            font-weight: 700;
            color: #005248;
            margin-bottom: 6px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .value {
            margin-bottom: 14px;
            padding-left: 2px;
            font-size: 12.5px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .info-item {
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: 600;
            color: #555;
            font-size: 11.5px;
        }

        .info-value {
            font-size: 12.5px;
            color: #222;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 9px 12px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #005248;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            padding-top: 15px;
            border-top: 1px dashed #ccc;
        }

        .highlight {
            background-color: #f0f9f4;
            padding: 14px;
            border-radius: 6px;
            border-left: 3px solid #4ade80;
            margin-top: 8px;
        }

        .biaya {
            color: #0d9488;
            font-weight: 700;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>RINGKASAN PEMERIKSAAN PASIEN</h1>
        <p class="clinic-name">Klinik Gigi Sehat – {{ now()->format('d M Y') }}</p>
    </div>

    <!-- Informasi Pasien -->
    <div class="section">
        <div class="label">Informasi Pasien</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Nama Lengkap</div>
                <div class="info-value">{{ $rekam->janjiTemu->pasien->user->nama_lengkap ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">No. Telepon</div>
                <div class="info-value">{{ $rekam->janjiTemu->pasien->user->nomor_telp ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Tanggal Lahir</div>
                <div class="info-value">
                    {{ $rekam->janjiTemu->pasien->user->tanggal_lahir ? \Carbon\Carbon::parse($rekam->janjiTemu->pasien->user->tanggal_lahir)->format('d M Y') : 'N/A' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Kunjungan -->
    <div class="section">
        <div class="label">Informasi Kunjungan</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Dokter</div>
                <div class="info-value">{{ $rekam->janjiTemu->dokter->user->nama_lengkap ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Spesialisasi</div>
                <div class="info-value">{{ $rekam->janjiTemu->dokter->spesialisasi_gigi ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Tanggal</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($rekam->janjiTemu->tanggal)->format('d M Y') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Jam</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($rekam->janjiTemu->jam_mulai)->format('H:i') }} WIB</div>
            </div>
            <div class="info-item">
                <div class="info-label">Keluhan</div>
                <div class="info-value">{{ $rekam->janjiTemu->keluhan ?? '-' }}</div>
            </div>
        </div>
    </div>

    <!-- Biaya -->
    <div class="section">
        <div class="label">Biaya Pemeriksaan</div>
        <div class="highlight">
            <div class="biaya">Rp {{ number_format($rekam->biaya ?? 0, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Resep Obat (jika ada) -->
    @if($rekam->resepObat && $rekam->resepObat->isNotEmpty())
    <div class="section">
        <div class="label">Resep Obat</div>
        <table>
            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rekam->resepObat as $resep)
                <tr>
                    <td>{{ $resep->nama_obat ?? '-' }}</td>
                    <td>{{ $resep->jumlah ?? 1 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        Dokumen ini merupakan ringkasan kunjungan pasien dan dicetak secara elektronik.<br>
        Tidak memerlukan tanda tangan basah.
    </div>

</body>

</html>