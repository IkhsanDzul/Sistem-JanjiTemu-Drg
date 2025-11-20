@extends('layouts.pasien')

@section('title', 'Detail Rekam Medis')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 px-4 sm:px-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Rekam Medis</h1>
            <p class="text-sm text-gray-600 mt-1">Informasi lengkap tentang kunjungan dan perawatan Anda</p>
        </div>
        <a href="{{ route('pasien.rekam-medis') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Informasi Dokter -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-2 mb-5">
                <svg class="w-5 h-5 text-[#005248]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <h2 class="text-lg font-semibold text-gray-900">Dokter Penanggung Jawab</h2>
            </div>

            <div class="flex items-start gap-5">
                <!-- Foto Dokter -->
                <div class="flex-shrink-0">
                    @if($rekam->janjiTemu?->dokter?->user?->foto_profil)
                    <img src="{{ asset('storage/' . $rekam->janjiTemu->dokter->user->foto_profil) }}"
                        alt="Foto Dokter"
                        class="w-20 h-20 rounded-xl object-cover border border-gray-200"
                        onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');">
                    <div class="w-20 h-20 bg-gray-100 rounded-xl flex items-center justify-center hidden">
                        <span class="text-gray-500 font-bold text-xl">
                            {{ strtoupper(substr($rekam->janjiTemu->dokter->user->nama_lengkap ?? 'D', 0, 1)) }}
                        </span>
                    </div>
                    @else
                    <div class="w-32 h-32 bg-gray-100 rounded-xl flex items-center justify-center">
                        <span class="text-gray-500 font-bold text-xl">
                            {{ strtoupper(substr($rekam->janjiTemu?->dokter?->user?->nama_lengkap ?? 'D', 0, 1)) }}
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Info Dokter -->
                <div class="min-w-0">
                    <h3 class="text-lg font-semibold text-gray-900 truncate">
                        {{ $rekam->janjiTemu?->dokter?->user?->nama_lengkap ?? 'Dokter Tidak Ditemukan' }}
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ $rekam->janjiTemu?->dokter?->spesialisasi_gigi ?? 'Spesialis Gigi' }}
                    </p>
                    <div class="mt-4">
                        <p class="text-xs text-gray-500 font-medium">Tanggal Pemeriksaan</p>
                        <p class="text-base text-gray-900">
                            {{ $rekam->janjiTemu?->tanggal ? \Carbon\Carbon::parse($rekam->janjiTemu->tanggal)->locale('id')->isoFormat('dddd, DD MMMM YYYY') : 'N/A' }}
                        </p>
                    </div>
                    <!-- Biaya Pemeriksaan -->
                    <div class="mt-4">
                        <p class="text-xs text-gray-500 font-medium mb-2">Biaya Pemeriksaan</p>
                        <div class="text-base font-bold text-green-600">
                            Rp{{ number_format($rekam->biaya, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Resep Obat Section -->
            <div class="mt-6">
                <p class="text-xs text-gray-500 font-medium mb-2">Resep Obat</p>

                @if($rekam->resepObat->isNotEmpty())
                <!-- Jika ada resep obat -->
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <p class="text-sm text-gray-700 mb-3">
                        {{ $rekam->resepObat->count() }} obat diresepkan.
                    </p>

                    <!-- Button Lihat Resep -->
                    <a href="{{ route('pasien.resep-obat.show', $rekam->id) }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Lihat Resep Obat
                    </a>

                    <!-- Button Download PDF Resep -->
                    <a href="{{ route('pasien.resep-obat.pdf', $rekam->id) }}"
                        class="ml-2 inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 13h14m-4 8H6a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2z" />
                        </svg>
                        Unduh PDF Resep
                    </a>
                </div>
                @else
                <!-- Jika tidak ada resep obat -->
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <p class="text-sm text-gray-600">Belum ada resep obat untuk kunjungan ini.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Detail Rekam Medis -->
        <div class="space-y-6">
            <!-- Tanggal -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <p class="text-xs text-gray-500 font-medium mb-1">Tanggal Pemeriksaan</p>
                <p class="text-lg text-gray-900">
                    {{ $rekam->janjiTemu?->tanggal ? \Carbon\Carbon::parse($rekam->janjiTemu->tanggal)->locale('id')->isoFormat('dddd, DD MMMM YYYY') : 'N/A' }}
                </p>
            </div>

            <!-- Diagnosa -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <p class="text-xs text-gray-500 font-medium mb-1">Diagnosa</p>
                <p class="text-gray-800 leading-relaxed">{{ $rekam->diagnosa }}</p>
            </div>

            <!-- Tindakan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <p class="text-xs text-gray-500 font-medium mb-1">Tindakan</p>
                <p class="text-gray-800 leading-relaxed">{{ $rekam->tindakan }}</p>
            </div>

            <!-- Catatan Dokter -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <p class="text-xs text-gray-500 font-medium mb-2">Catatan Dokter</p>
                <div class="text-gray-800 bg-gray-50 rounded-lg p-3 whitespace-pre-line leading-relaxed">
                    {{ $rekam->catatan ?? '-' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="flex justify-end pt-4">
        <a href="{{ route('pasien.rekam-medis.pdf', $rekam->id) }}"
            class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium flex items-center gap-2 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 13h14m-4 8H6a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2z" />
            </svg>
            Unduh PDF
        </a>
    </div>
</div>
@endsection