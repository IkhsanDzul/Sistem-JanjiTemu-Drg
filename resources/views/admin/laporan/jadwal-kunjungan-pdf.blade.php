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
        .stats {
            width: 100%;
            margin-bottom: 25px;
        }
        .stats table {
            width: 100%;
            border-collapse: collapse;
        }
        .stats td {
            width: 20%;
            padding: 12px;
            text-align: center;
            vertical-align: middle;
            border: 2px solid #e0e0e0;
        }
        .stat-box {
            text-align: center;
        }
        .stat-box.total {
            background-color: #005248;
            color: white;
            border-color: #005248;
        }
        .stat-box.pending {
            background-color: #f59e0b;
            color: white;
            border-color: #f59e0b;
        }
        .stat-box.confirmed {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }
        .stat-box.completed {
            background-color: #10b981;
            color: white;
            border-color: #10b981;
        }
        .stat-box.canceled {
            background-color: #ef4444;
            color: white;
            border-color: #ef4444;
        }
        .stat-box h3 {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stat-box.total h3,
        .stat-box.pending h3,
        .stat-box.confirmed h3,
        .stat-box.completed h3,
        .stat-box.canceled h3 {
            color: white;
        }
        .stat-box p {
            font-size: 24px;
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
        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        .status-confirmed {
            background: #dbeafe;
            color: #1e40af;
        }
        .status-completed {
            background: #d1fae5;
            color: #065f46;
        }
        .status-canceled {
            background: #fee2e2;
            color: #991b1b;
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
            <p class="subtitle">Tanggal: {{ $tanggalLaporan }}</p>
            <p class="brand">DentaTime - Sistem Manajemen Klinik Gigi</p>
        </div>

        <div class="stats">
            <table>
                <tr>
                    <td class="stat-box total">
                        <h3>Total Kunjungan</h3>
                        <p>{{ $totalKunjungan }}</p>
                    </td>
                    <td class="stat-box pending">
                        <h3>Pending</h3>
                        <p>{{ $statusCount['pending'] }}</p>
                    </td>
                    <td class="stat-box confirmed">
                        <h3>Confirmed</h3>
                        <p>{{ $statusCount['confirmed'] }}</p>
                    </td>
                    <td class="stat-box completed">
                        <h3>Completed</h3>
                        <p>{{ $statusCount['completed'] }}</p>
                    </td>
                    <td class="stat-box canceled">
                        <h3>Canceled</h3>
                        <p>{{ $statusCount['canceled'] }}</p>
                    </td>
                </tr>
            </table>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pasien</th>
                    <th>Dokter</th>
                    <th>Tanggal</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($janjiTemu as $index => $jt)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $jt->pasien->user->nama_lengkap ?? '-' }}</td>
                    <td>{{ $jt->dokter->user->nama_lengkap ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($jt->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($jt->jam_mulai)->format('H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($jt->jam_selesai)->format('H:i') }}</td>
                    <td>
                        <span class="status-badge status-{{ $jt->status }}">
                            {{ ucfirst($jt->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #999;">Tidak ada jadwal kunjungan untuk tanggal ini</td>
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

