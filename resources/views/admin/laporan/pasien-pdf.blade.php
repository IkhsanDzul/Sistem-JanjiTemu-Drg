<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
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
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #005248;
        }
        .header h1 {
            color: #005248;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .header .subtitle {
            color: #666;
            font-size: 12px;
            margin: 3px 0;
        }
        .header .brand {
            color: #005248;
            font-size: 14px;
            font-weight: bold;
            margin-top: 8px;
        }
        .stats {
            width: 100%;
            margin-bottom: 25px;
        }
        .stats table {
            width: 100%;
            border-collapse: collapse;
        }
        .stats td {
            width: 33.33%;
            padding: 15px;
            text-align: center;
            vertical-align: middle;
            border: 2px solid #e0e0e0;
        }
        .stat-box.total {
            background-color: #005248;
            color: white;
            border-color: #005248;
        }
        .stat-box.laki {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }
        .stat-box.perempuan {
            background-color: #ec4899;
            color: white;
            border-color: #ec4899;
        }
        .stat-box h3 {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stat-box.total h3,
        .stat-box.laki h3,
        .stat-box.perempuan h3 {
            color: white;
        }
        .stat-box p {
            font-size: 28px;
            font-weight: bold;
            margin: 0;
        }
        .table-container {
            margin-top: 20px;
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
            padding: 12px 10px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            border: 1px solid #003d35;
        }
        th:first-child {
            text-align: center;
            width: 40px;
        }
        td {
            padding: 10px;
            border: 1px solid #e0e0e0;
            font-size: 11px;
            color: #333;
        }
        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        td:first-child {
            text-align: center;
            font-weight: bold;
            color: #005248;
        }
        .footer {
            margin-top: 25px;
            text-align: center;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
            color: #666;
            font-size: 10px;
        }
        @page {
            margin: 1cm;
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

        <div class="stats">
            <table>
                <tr>
                    <td class="stat-box total">
                        <h3>Total Pasien</h3>
                        <p>{{ $totalPasien }}</p>
                    </td>
                    <td class="stat-box laki">
                        <h3>Pasien Laki-laki</h3>
                        <p>{{ $pasienLaki }}</p>
                    </td>
                    <td class="stat-box perempuan">
                        <h3>Pasien Perempuan</h3>
                        <p>{{ $pasienPerempuan }}</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pasien as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $p->user->nama_lengkap ?? '-' }}</td>
                        <td>{{ $p->user->email ?? '-' }}</td>
                        <td>{{ $p->user->nomor_telp ?? '-' }}</td>
                        <td>
                            @if($p->user && $p->user->jenis_kelamin)
                                {{ $p->user->jenis_kelamin === 'L' ? 'Laki-laki' : ($p->user->jenis_kelamin === 'P' ? 'Perempuan' : $p->user->jenis_kelamin) }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $p->user->created_at ? \Carbon\Carbon::parse($p->user->created_at)->format('d/m/Y') : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px; color: #999;">Tidak ada data pasien</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>Dicetak pada: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY [pukul] HH:mm') }}</p>
        </div>
    </div>
</body>
</html>
