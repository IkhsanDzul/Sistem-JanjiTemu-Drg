@extends('layouts.pasien')

@section('title', 'Detail Rekam Medis')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Detail Rekam Medis</h2>
            <p class="text-sm text-gray-600 mt-1">Informasi lengkap tentang rekam medis Anda</p>
        </div>
        <a href="{{ route('pasien.rekam-medis') }}" 
           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Informasi Dokter -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#005248]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Dokter Penanggung Jawab
            </h3>
            <div class="space-y-4">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        @if($rekam->janjiTemu && $rekam->janjiTemu->dokter && $rekam->janjiTemu->dokter->user && $rekam->janjiTemu->dokter->user->foto_profil)
                            <img src="{{ asset('storage/' . $rekam->janjiTemu->dokter->user->foto_profil) }}" 
                                 alt="Foto Dokter" 
                                 class="w-20 h-20 rounded-lg object-cover"
                                 onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center hidden">
                                <span class="text-gray-400 font-bold text-2xl">
                                    {{ strtoupper(substr($rekam->janjiTemu->dokter->user->nama_lengkap ?? 'D', 0, 1)) }}
                                </span>
                            </div>
                        @else
                            <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                <span class="text-gray-400 font-bold text-2xl">
                                    {{ strtoupper(substr($rekam->janjiTemu->dokter->user->nama_lengkap ?? 'D', 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900">
                            {{ $rekam->janjiTemu->dokter->user->nama_lengkap ?? 'Dokter Tidak Ditemukan' }}
                        </h4>
                        <p class="text-sm text-gray-600 mt-1">{{ $rekam->janjiTemu->dokter->spesialisasi_gigi ?? 'N/A' }}</p>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Tanggal Pemeriksaan</p>
                    <p class="text-base text-gray-900 mt-1">
                        {{ $rekam->janjiTemu->tanggal ? \Carbon\Carbon::parse($rekam->janjiTemu->tanggal)->locale('id')->isoFormat('dddd, DD MMMM YYYY') : 'N/A' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Informasi Rekam Medis -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Informasi Rekam Medis
            </h3>
            <div class="space-y-4">
                @if($rekam->biaya)
                <div>
                    <p class="text-sm font-medium text-gray-600">Biaya</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">
                        Rp {{ number_format($rekam->biaya, 0, ',', '.') }}
                    </p>
                </div>
                @endif
                <div>
                    <p class="text-sm font-medium text-gray-600">Tanggal Dibuat</p>
                    <p class="text-base text-gray-900 mt-1">
                        {{ $rekam->created_at->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm') }} WIB
                    </p>
                </div>
            </div>
        </div>

        <!-- Diagnosa -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Diagnosa
            </h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-base text-gray-900 whitespace-pre-line">{{ $rekam->diagnosa ?? '-' }}</p>
            </div>
        </div>

        <!-- Tindakan -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Tindakan
            </h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-base text-gray-900 whitespace-pre-line">{{ $rekam->tindakan ?? '-' }}</p>
            </div>
        </div>

        <!-- Catatan -->
        @if($rekam->catatan)
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6 lg:col-span-2">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Catatan Dokter
            </h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-base text-gray-900 whitespace-pre-line">{{ $rekam->catatan }}</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
