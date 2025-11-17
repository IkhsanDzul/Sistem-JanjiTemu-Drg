@extends('layouts.admin')

@section('title', 'Detail Pasien')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Detail Pasien</h2>
            <p class="text-sm text-gray-600 mt-1">Informasi lengkap tentang pasien</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.pasien.edit', $pasien->id) }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.pasien.index') }}" 
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Informasi Pribadi -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#005248]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Informasi Pribadi
            </h3>
            <div class="space-y-4">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        @if($pasien->user->foto_profil)
                            <img src="{{ asset('storage/' . $pasien->user->foto_profil) }}" 
                                 alt="Foto" 
                                 class="h-20 w-20 rounded-full object-cover">
                        @else
                            <div class="h-20 w-20 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-bold text-2xl">
                                    {{ strtoupper(substr($pasien->user->nama_lengkap ?? 'P', 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 space-y-3">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Nama Lengkap</p>
                            <p class="text-base text-gray-900">{{ $pasien->user->nama_lengkap ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Email</p>
                            <p class="text-base text-gray-900">{{ $pasien->user->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                    <div>
                        <p class="text-sm font-medium text-gray-600">NIK</p>
                        <p class="text-base text-gray-900">{{ $pasien->user->nik ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Jenis Kelamin</p>
                        <p class="text-base text-gray-900">{{ $pasien->user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Tanggal Lahir</p>
                        <p class="text-base text-gray-900">
                            {{ $pasien->user->tanggal_lahir ? \Carbon\Carbon::parse($pasien->user->tanggal_lahir)->format('d/m/Y') : 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Nomor Telepon</p>
                        <p class="text-base text-gray-900">{{ $pasien->user->nomor_telp ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <p class="text-sm font-medium text-gray-600">Alamat</p>
                    <p class="text-base text-gray-900">{{ $pasien->user->alamat ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Informasi Medis -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Informasi Medis
            </h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-600">Golongan Darah</p>
                    <p class="text-base text-gray-900 font-semibold">{{ $pasien->golongan_darah ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Alergi</p>
                    <p class="text-base text-gray-900">{{ $pasien->alergi ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Riwayat Penyakit</p>
                    <p class="text-base text-gray-900">{{ $pasien->riwayat_penyakit ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Statistik Pasien -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Statistik
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-sm font-medium text-blue-700">Total Janji Temu</p>
                    <p class="text-2xl font-bold text-blue-800 mt-1">{{ $totalJanjiTemu }}</p>
                </div>
                <div class="bg-green-50 rounded-lg p-4">
                    <p class="text-sm font-medium text-green-700">Janji Temu Bulan Ini</p>
                    <p class="text-2xl font-bold text-green-800 mt-1">{{ $janjiTemuBulanIni }}</p>
                </div>
            </div>
        </div>

        <!-- Riwayat Janji Temu -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6 lg:col-span-2">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Riwayat Janji Temu
            </h3>
            @if($pasien->janjiTemu && $pasien->janjiTemu->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Dokter</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Keluhan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pasien->janjiTemu->take(10) as $janji)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($janji->tanggal)->format('d/m/Y') }} 
                                        {{ \Carbon\Carbon::parse($janji->jam_mulai)->format('H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $janji->dokter->user->nama_lengkap ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ strlen($janji->keluhan) > 50 ? substr($janji->keluhan, 0, 50) . '...' : $janji->keluhan }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'confirmed' => 'bg-blue-100 text-blue-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                                'canceled' => 'bg-red-100 text-red-800',
                                            ];
                                            $statusColor = $statusColors[$janji->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                                            {{ ucfirst($janji->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="mt-2 text-sm">Belum ada riwayat janji temu</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

