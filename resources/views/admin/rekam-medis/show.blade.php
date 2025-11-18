@extends('layouts.admin')

@section('title', 'Detail Rekam Medis')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Detail Rekam Medis</h2>
            <p class="text-sm text-gray-600 mt-1">Informasi lengkap tentang rekam medis</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.rekam-medis.edit', $rekamMedis->id) }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.rekam-medis.index') }}" 
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
        <!-- Informasi Janji Temu -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#005248]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Informasi Janji Temu
            </h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tanggal</p>
                    <p class="text-base text-gray-900">
                        {{ $rekamMedis->janjiTemu->tanggal ? \Carbon\Carbon::parse($rekamMedis->janjiTemu->tanggal)->format('d/m/Y') : 'N/A' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Waktu</p>
                    <p class="text-base text-gray-900">
                        {{ $rekamMedis->janjiTemu->jam_mulai ? \Carbon\Carbon::parse($rekamMedis->janjiTemu->jam_mulai)->format('H:i') : 'N/A' }} - 
                        {{ $rekamMedis->janjiTemu->jam_selesai ? \Carbon\Carbon::parse($rekamMedis->janjiTemu->jam_selesai)->format('H:i') : 'N/A' }} WIB
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Pasien</p>
                    <p class="text-base text-gray-900 font-semibold">{{ $rekamMedis->janjiTemu->pasien->user->nama_lengkap ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-500">{{ $rekamMedis->janjiTemu->pasien->user->nik ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Dokter</p>
                    <p class="text-base text-gray-900 font-semibold">{{ $rekamMedis->janjiTemu->dokter->user->nama_lengkap ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-500">{{ $rekamMedis->janjiTemu->dokter->spesialisasi_gigi ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Keluhan</p>
                    <p class="text-base text-gray-900">{{ $rekamMedis->janjiTemu->keluhan ?? '-' }}</p>
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
                <div>
                    <p class="text-sm font-medium text-gray-600">Diagnosa</p>
                    <p class="text-base text-gray-900 mt-1">{{ $rekamMedis->diagnosa ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Tindakan</p>
                    <p class="text-base text-gray-900 mt-1">{{ $rekamMedis->tindakan ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Catatan</p>
                    <p class="text-base text-gray-900 mt-1">{{ $rekamMedis->catatan ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Biaya</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">
                        Rp {{ number_format($rekamMedis->biaya, 0, ',', '.') }}
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Tanggal Dibuat</p>
                    <p class="text-base text-gray-900">
                        {{ $rekamMedis->created_at->format('d/m/Y H:i') }} WIB
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Terakhir Diupdate</p>
                    <p class="text-base text-gray-900">
                        {{ $rekamMedis->updated_at->format('d/m/Y H:i') }} WIB
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

