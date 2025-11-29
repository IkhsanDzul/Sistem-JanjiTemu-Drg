@extends('layouts.admin')

@section('title', 'Laporan Jadwal Kunjungan')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $title }}</h2>
                <p class="text-sm text-gray-600 mt-1">Periode: {{ $tanggalLaporan }}</p>
            </div>
            <div class="flex gap-2">
                <form method="GET" action="{{ route('admin.laporan.jadwal-kunjungan') }}" class="flex gap-2">
                    <input type="month" 
                           name="bulan" 
                           value="{{ $bulan }}" 
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#005248]">
                    <button type="submit" 
                            class="px-4 py-2 bg-[#005248] text-white rounded-lg hover:bg-[#003d35] transition-colors font-medium">
                        Filter
                    </button>
                </form>
                <a href="{{ route('admin.laporan.jadwal-kunjungan', ['format' => 'pdf', 'bulan' => $bulan]) }}" 
                   class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    PDF
                </a>
                <a href="{{ route('admin.laporan.jadwal-kunjungan', ['format' => 'excel', 'bulan' => $bulan]) }}" 
                   class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Excel
                </a>
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
            <p class="text-sm font-medium text-gray-600">Total Kunjungan</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalKunjungan }}</p>
        </div>
        <div class="bg-yellow-50 rounded-lg shadow-sm border border-yellow-200 p-4">
            <p class="text-sm font-medium text-yellow-700">Pending</p>
            <p class="text-2xl font-bold text-yellow-800 mt-1">{{ $statusCount['pending'] }}</p>
        </div>
        <div class="bg-blue-50 rounded-lg shadow-sm border border-blue-200 p-4">
            <p class="text-sm font-medium text-blue-700">Confirmed</p>
            <p class="text-2xl font-bold text-blue-800 mt-1">{{ $statusCount['confirmed'] }}</p>
        </div>
        <div class="bg-green-50 rounded-lg shadow-sm border border-green-200 p-4">
            <p class="text-sm font-medium text-green-700">Completed</p>
            <p class="text-2xl font-bold text-green-800 mt-1">{{ $statusCount['completed'] }}</p>
        </div>
        <div class="bg-red-50 rounded-lg shadow-sm border border-red-200 p-4">
            <p class="text-sm font-medium text-red-700">Canceled</p>
            <p class="text-2xl font-bold text-red-800 mt-1">{{ $statusCount['canceled'] }}</p>
        </div>
    </div>

    <!-- Tabel Jadwal Kunjungan -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Jadwal Kunjungan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Mulai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Selesai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($janjiTemu as $index => $jt)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $jt->pasien->user->nama_lengkap ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $jt->dokter->user->nama_lengkap ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($jt->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($jt->jam_mulai)->format('H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($jt->jam_selesai)->format('H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'confirmed' => 'bg-blue-100 text-blue-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'canceled' => 'bg-red-100 text-red-800',
                                ];
                                $color = $statusColors[$jt->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $color }}">
                                {{ ucfirst($jt->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada jadwal kunjungan untuk bulan ini</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

