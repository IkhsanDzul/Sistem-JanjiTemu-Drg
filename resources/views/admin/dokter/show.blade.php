@extends('layouts.admin')

@section('title', 'Detail Dokter')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Detail Dokter</h2>
            <p class="text-sm text-gray-600 mt-1">Informasi lengkap tentang dokter</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.dokter.edit', $dokter->id) }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.dokter.index') }}" 
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
                        @if($dokter->user->foto_profil)
                            <img src="{{ asset('storage/' . $dokter->user->foto_profil) }}" 
                                 alt="Foto Profil" 
                                 class="w-20 h-20 object-cover rounded-full">
                        @else
                        <div class="h-20 w-20 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-green-600 font-bold text-2xl">
                                {{ strtoupper(substr($dokter->user->nama_lengkap ?? 'D', 0, 1)) }}
                            </span>
                        </div>
                        @endif
                    </div>
                    <div class="flex-1 space-y-3">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Nama Lengkap</p>
                            <p class="text-base text-gray-900">{{ $dokter->user->nama_lengkap ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Email</p>
                            <p class="text-base text-gray-900">{{ $dokter->user->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                    <div>
                        <p class="text-sm font-medium text-gray-600">NIK</p>
                        <p class="text-base text-gray-900">{{ $dokter->user->nik ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Jenis Kelamin</p>
                        <p class="text-base text-gray-900">{{ $dokter->user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Tanggal Lahir</p>
                        <p class="text-base text-gray-900">
                            {{ $dokter->user->tanggal_lahir ? \Carbon\Carbon::parse($dokter->user->tanggal_lahir)->format('d/m/Y') : 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Nomor Telepon</p>
                        <p class="text-base text-gray-900">{{ $dokter->user->nomor_telp ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <p class="text-sm font-medium text-gray-600">Alamat</p>
                    <p class="text-base text-gray-900">{{ $dokter->user->alamat ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Informasi Dokter -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Informasi Dokter
            </h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-600">Nomor STR</p>
                    <p class="text-base text-gray-900 font-semibold">{{ $dokter->no_str ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Spesialisasi</p>
                    <p class="text-base text-gray-900">{{ $dokter->spesialisasi_gigi ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Pengalaman</p>
                    <p class="text-base text-gray-900">{{ $dokter->pengalaman_tahun ?? 'N/A' }} tahun</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Status</p>
                    @php
                        $statusColor = $dokter->status == 'tersedia' 
                            ? 'bg-green-100 text-green-800 border-green-300' 
                            : 'bg-red-100 text-red-800 border-red-300';
                        $statusLabel = $dokter->status == 'tersedia' ? 'Tersedia' : 'Tidak Tersedia';
                    @endphp
                    <span class="inline-block mt-2 px-4 py-2 text-sm font-semibold rounded-lg border-2 {{ $statusColor }}">
                        {{ $statusLabel }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Statistik Dokter -->
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

        <!-- Jadwal Praktek -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Jadwal Praktek
                </h3>
                <a href="{{ route('admin.dokter.jadwal-praktek.index', $dokter->id) }}" 
                   class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors text-sm font-medium flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Kelola Jadwal
                </a>
            </div>
            @if($dokter->jadwalPraktek && $dokter->jadwalPraktek->count() > 0)
                <div class="space-y-2">
                    @foreach($dokter->jadwalPraktek as $jadwal)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ $jadwal->hari }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }} WIB
                                </p>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $jadwal->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($jadwal->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="mt-2 text-sm">Belum ada jadwal praktek</p>
                    <a href="{{ route('admin.dokter.jadwal-praktek.create', $dokter->id) }}" 
                       class="mt-4 inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Jadwal
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

