@extends('layouts.admin')

@section('title', 'Detail Resep Obat')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Detail Resep Obat</h2>
            <p class="text-sm text-gray-600 mt-1">Informasi lengkap tentang resep obat</p>
        </div>
        <a href="{{ route('admin.resep-obat.index') }}" 
           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
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
        <!-- Informasi Resep Obat -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#005248]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
                Informasi Resep Obat
            </h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-600">Nama Obat</p>
                    <p class="text-base text-gray-900 font-semibold mt-1">{{ $resepObat->nama_obat }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Jumlah</p>
                    <p class="text-base text-gray-900 mt-1">{{ $resepObat->jumlah }} unit</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Dosis</p>
                    <p class="text-base text-gray-900 mt-1">{{ number_format($resepObat->dosis, 0, ',', '.') }} mg</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Aturan Pakai</p>
                    <p class="text-base text-gray-900 mt-1">{{ $resepObat->aturan_pakai ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Tanggal Resep</p>
                    <p class="text-base text-gray-900 mt-1">
                        {{ $resepObat->tanggal_resep ? \Carbon\Carbon::parse($resepObat->tanggal_resep)->format('d/m/Y') : 'N/A' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Dibuat Pada</p>
                    <p class="text-base text-gray-900 mt-1">
                        {{ $resepObat->created_at->format('d/m/Y H:i') }} WIB
                    </p>
                </div>
            </div>
        </div>

        <!-- Informasi Dokter -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Dokter yang Meresepkan
            </h3>
            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full overflow-hidden bg-green-500 flex items-center justify-center">
                        @if($resepObat->dokter && $resepObat->dokter->user && $resepObat->dokter->user->foto_profil)
                            <img src="{{ asset('storage/' . $resepObat->dokter->user->foto_profil) }}" 
                                 alt="{{ $resepObat->dokter->user->nama_lengkap }}" 
                                 class="h-12 w-12 rounded-full object-cover">
                        @else
                            <span class="text-white font-semibold">
                                {{ strtoupper(substr($resepObat->dokter->user->nama_lengkap ?? 'D', 0, 1)) }}
                            </span>
                        @endif
                    </div>
                    <div class="ml-4">
                        <p class="text-base font-semibold text-gray-900">
                            {{ $resepObat->dokter->user->nama_lengkap ?? 'N/A' }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $resepObat->dokter->spesialisasi_gigi ?? 'N/A' }}
                        </p>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">No. STR</p>
                    <p class="text-base text-gray-900 mt-1">{{ $resepObat->dokter->no_str ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Pasien dan Rekam Medis -->
    @if($resepObat->rekamMedis && $resepObat->rekamMedis->janjiTemu)
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Informasi Pasien -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                Informasi Pasien
            </h3>
            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full overflow-hidden bg-blue-500 flex items-center justify-center">
                        @if($resepObat->rekamMedis->janjiTemu->pasien && $resepObat->rekamMedis->janjiTemu->pasien->user && $resepObat->rekamMedis->janjiTemu->pasien->user->foto_profil)
                            <img src="{{ asset('storage/' . $resepObat->rekamMedis->janjiTemu->pasien->user->foto_profil) }}" 
                                 alt="{{ $resepObat->rekamMedis->janjiTemu->pasien->user->nama_lengkap }}" 
                                 class="h-12 w-12 rounded-full object-cover">
                        @else
                            <span class="text-white font-semibold">
                                {{ strtoupper(substr($resepObat->rekamMedis->janjiTemu->pasien->user->nama_lengkap ?? 'P', 0, 1)) }}
                            </span>
                        @endif
                    </div>
                    <div class="ml-4">
                        <p class="text-base font-semibold text-gray-900">
                            {{ $resepObat->rekamMedis->janjiTemu->pasien->user->nama_lengkap ?? 'N/A' }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $resepObat->rekamMedis->janjiTemu->pasien->user->nik ?? 'N/A' }}
                        </p>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Email</p>
                    <p class="text-base text-gray-900 mt-1">{{ $resepObat->rekamMedis->janjiTemu->pasien->user->email ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Informasi Rekam Medis -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Rekam Medis Terkait
            </h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-600">Diagnosa</p>
                    <p class="text-base text-gray-900 mt-1">{{ $resepObat->rekamMedis->diagnosa ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Tindakan</p>
                    <p class="text-base text-gray-900 mt-1">{{ $resepObat->rekamMedis->tindakan ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Tanggal Janji Temu</p>
                    <p class="text-base text-gray-900 mt-1">
                        {{ $resepObat->rekamMedis->janjiTemu->tanggal ? \Carbon\Carbon::parse($resepObat->rekamMedis->janjiTemu->tanggal)->format('d/m/Y') : 'N/A' }}
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.rekam-medis.show', $resepObat->rekamMedis->id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-[#005248] text-white rounded-lg hover:bg-[#003d35] transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat Rekam Medis
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

