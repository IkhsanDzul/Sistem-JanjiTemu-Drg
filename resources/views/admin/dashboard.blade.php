@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="space-y-6">
        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Total Pasien -->
                <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Pasien</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalPasien }}</p>
                            </div>
                            <div class="p-3 bg-blue-50 rounded-full">
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Dokter -->
                <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Dokter</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalDokter }}</p>
                            </div>
                            <div class="p-3 bg-green-50 rounded-full">
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Janji Temu Bulan Ini -->
                <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Janji Temu Bulan Ini</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $janjiTemuBulanIni }}</p>
                                <p class="text-xs text-gray-500 mt-1">Hari ini: {{ $janjiTemuHariIni }}</p>
                            </div>
                            <div class="p-3 bg-orange-50 rounded-full">
                                <svg class="w-8 h-8 text-[#FFA700]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pendapatan Bulan Ini -->
                <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Pendapatan Bulan Ini</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500 mt-1">Hari ini: Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</p>
                            </div>
                            <div class="p-3 bg-teal-50 rounded-full">
                                <svg class="w-8 h-8 text-[#005248]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Statistik Status Janji Temu -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-yellow-700">Pending</p>
                            <p class="text-2xl font-bold text-yellow-800 mt-1">{{ $janjiPending }}</p>
                        </div>
                        <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-700">Confirmed</p>
                            <p class="text-2xl font-bold text-blue-800 mt-1">{{ $janjiConfirmed }}</p>
                        </div>
                        <div class="w-3 h-3 bg-blue-400 rounded-full"></div>
                    </div>
                </div>

                <div class="bg-green-50 border border-green-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-700">Completed</p>
                            <p class="text-2xl font-bold text-green-800 mt-1">{{ $janjiCompleted }}</p>
                        </div>
                        <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                    </div>
                </div>

                <div class="bg-red-50 border border-red-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-red-700">Canceled</p>
                            <p class="text-2xl font-bold text-red-800 mt-1">{{ $janjiCanceled }}</p>
                        </div>
                        <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                    </div>
                </div>
            </div>

        <!-- Grid Layout untuk Tabel -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Janji Temu Terbaru -->
                <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-100">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Janji Temu Terbaru</h3>
                            <a href="{{ route('admin.janji-temu.index') }}" class="text-sm text-[#005248] hover:text-[#FFA700] font-medium transition-colors">Lihat Semua</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Pasien</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Dokter</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($janjiTemuTerbaru as $janji)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                {{ $janji->pasien->user->nama_lengkap ?? 'N/A' }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                {{ $janji->dokter->user->nama_lengkap ?? 'N/A' }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                                {{ \Carbon\Carbon::parse($janji->tanggal)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'confirmed' => 'bg-blue-100 text-blue-800',
                                                        'completed' => 'bg-green-100 text-green-800',
                                                        'canceled' => 'bg-red-100 text-red-800',
                                                    ];
                                                    $statusColor = $statusColors[$janji->status] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                                                    {{ ucfirst($janji->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-4 text-center text-sm text-gray-500">
                                                Belum ada janji temu
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- User Terbaru -->
                <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-100">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">User Terbaru</h3>
                            <a href="#" class="text-sm text-[#005248] hover:text-[#FFA700] font-medium transition-colors">Lihat Semua</a>
                        </div>
                        <div class="space-y-3">
                            @forelse($userTerbaru as $user)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-[#005248] rounded-full flex items-center justify-center">
                                            <span class="text-white font-semibold text-sm">
                                                {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $user->nama_lengkap }}</p>
                                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($user->role_id == 'admin') bg-purple-100 text-purple-700
                                        @elseif($user->role_id == 'dokter') bg-green-100 text-green-700
                                        @else bg-blue-100 text-blue-700
                                        @endif">
                                        {{ ucfirst($user->role_id) }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-center text-sm text-gray-500 py-4">Belum ada user</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dokter Aktif dan Logs -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Dokter Aktif -->
                <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-100">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Dokter Aktif</h3>
                            <a href="#" class="text-sm text-[#005248] hover:text-[#FFA700] font-medium transition-colors">Lihat Semua</a>
                        </div>
                        <div class="space-y-3">
                            @forelse($dokterAktif as $dokter)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-green-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-semibold text-sm">
                                                {{ strtoupper(substr($dokter->user->nama_lengkap ?? 'D', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $dokter->user->nama_lengkap ?? 'N/A' }}</p>
                                            <p class="text-xs text-gray-500">{{ $dokter->spesialisasi_gigi ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                        {{ ucfirst($dokter->status) }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-center text-sm text-gray-500 py-4">Belum ada dokter aktif</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Log Aktivitas -->
                <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-100">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Log Aktivitas</h3>
                            <a href="#" class="text-sm text-[#005248] hover:text-[#FFA700] font-medium transition-colors">Lihat Semua</a>
                        </div>
                        <div class="space-y-3">
                            @forelse($logsTerbaru as $log)
                                <div class="flex items-start p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex-shrink-0">
                                        @php
                                            $actionColors = [
                                                'buat' => 'bg-green-500',
                                                'edit' => 'bg-blue-500',
                                                'hapus' => 'bg-red-500',
                                            ];
                                            $actionColor = $actionColors[$log->action] ?? 'bg-gray-500';
                                        @endphp
                                        <div class="h-8 w-8 {{ $actionColor }} rounded-full flex items-center justify-center">
                                            <span class="text-white text-xs font-semibold">{{ strtoupper(substr($log->action, 0, 1)) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <p class="text-sm text-gray-900">
                                            <span class="font-medium">{{ $log->admin->nama_lengkap ?? 'Admin' }}</span> 
                                            melakukan aksi <span class="font-semibold">{{ $log->action }}</span>
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-sm text-gray-500 py-4">Belum ada log aktivitas</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
