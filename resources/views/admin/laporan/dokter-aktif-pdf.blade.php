<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            padding: 20px;
            font-size: 12px;
            color: #333;
        }
        .container {
            background: white;
            padding: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 3px solid #005248;
        }
        .header h1 {
            color: #005248;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .header .subtitle {
            color: #666;
            font-size: 14px;
            margin: 5px 0;
        }
        .header .brand {
            color: #005248;
            font-size: 16px;
            font-weight: 600;
            margin-top: 10px;
        }
        .stat-box {
            text-align: center;
            padding: 20px;
            border: 2px solid #005248;
            background-color: #005248;
            color: white;
            margin-bottom: 25px;
            max-width: 300px;
            margin-left: auto;
            margin-right: auto;
        }
        .stat-box h3 {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: rgba(255,255,255,0.9);
        }
        .stat-box p {
            font-size: 36px;
            font-weight: bold;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        thead {
            background-color: #005248;
            color: white;
        }
        th {
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #003d35;
        }
        th:first-child {
            text-align: center;
            width: 50px;
        }
        td {
            padding: 12px;
            border: 1px solid #e0e0e0;
            font-size: 13px;
            color: #333;
        }
        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        td:first-child {
            text-align: center;
            font-weight: 600;
            color: #005248;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            color: #666;
            font-size: 12px;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .container {
                box-shadow: none;
                padding: 20px;
            }
            .no-print {
                display: none !important;
            }
            @page {
                margin: 1cm;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $title }}</h1>
            <p class="subtitle">Tanggal Laporan: {{ $tanggalLaporan }}</p>
            <p class="brand">DentaTime - Sistem Manajemen Klinik Gigi</p>
        </div>

        <div class="stat-box">
            <h3>Total Dokter Aktif</h3>
            <p>{{ $totalDokter }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Dokter</th>
                    <th>Email</th>
                    <th>Spesialisasi</th>
                    <th>Pengalaman</th>
                    <th>No. STR</th>
                    <th>Total Janji Temu</th>
                    <th>Janji Temu Bulan Ini</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dokter as $index => $item)
                @php $d = $item['dokter']; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $d->user->nama_lengkap ?? '-' }}</td>
                    <td>{{ $d->user->email ?? '-' }}</td>
                    <td>{{ $d->spesialisasi_gigi ?? '-' }}</td>
                    <td>{{ $d->pengalaman_tahun ?? 0 }} tahun</td>
                    <td>{{ $d->no_str ?? '-' }}</td>
                    <td>{{ $item['total_janji_temu'] }}</td>
                    <td>{{ $item['janji_temu_bulan_ini'] }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px; color: #999;">Tidak ada dokter aktif</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            <p>Dicetak pada: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY [pukul] HH:mm') }}</p>
        </div>
    </div>
</body>
</html>

