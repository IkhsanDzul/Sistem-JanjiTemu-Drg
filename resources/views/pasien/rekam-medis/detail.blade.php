@extends('layouts.pasien')

@section('title', 'Detail Pemeriksaan')

@php
$title = 'Detail Pemeriksaan';
$subtitle = $rekam->pasien->user->nama_lengkap ?? 'Pasien';
@endphp

@section('content')
<div class="max-w-6xl mx-auto space-y-8 px-4 sm:px-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <a href="{{ route('pasien.rekam-medis') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    <!-- Di detail riwayat -->
    <!-- Detail Riwayat Pemeriksaan -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            Detail Pemeriksaan
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Dokter Penanggung Jawab -->
            <div class="space-y-1">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Dokter Penanggung Jawab</p>
                <p class="text-gray-800 font-medium">
                    {{ $rekam->janjiTemu->dokter->user->nama_lengkap ?? 'N/A' }}
                </p>
                <p class="text-sm text-gray-600">
                    {{ $rekam->janjiTemu->dokter->spesialisasi_gigi ?? 'Spesialis Gigi' }}
                </p>
            </div>

            <!-- Tanggal Pemeriksaan -->
            <div class="space-y-1">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Pemeriksaan</p>
                <p class="text-gray-800 font-medium">
                    {{ \Carbon\Carbon::parse($rekam->janjiTemu->tanggal)->locale('id')->isoFormat('dddd, DD MMMM YYYY') }}
                </p>
            </div>

            <!-- Biaya -->
            <div class="space-y-1">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Biaya</p>
                <p class="text-lg font-bold text-green-600">
                    Rp {{ number_format($rekam->biaya ?? 0, 0, ',', '.') }}
                </p>
            </div>

            <!-- Resep Obat (jika ada) -->
            @if($rekam->resepObat && $rekam->resepObat->isNotEmpty())
            <div class="space-y-1">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Resep Obat</p>
                <ul class="space-y-1">
                    @foreach($rekam->resepObat as $resep)
                    <li class="flex items-start gap-2">
                        <span class="text-gray-800">•</span>
                        <span class="text-gray-700">
                            {{ $resep->nama_obat ?? 'Obat' }}
                            <span class="text-sm text-gray-500">(Jumlah: {{ $resep->jumlah ?? 1 }})</span>
                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Tombol Unduh PDF -->
            <div class="sm:col-span-2 pt-2 mt-4 border-t border-gray-100">
                <a href="{{ route('pasien.rekam-medis.pdf', $rekam->id) }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors shadow-sm">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Unduh Ringkasan Pemeriksaan
                </a>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi
    <div class="flex justify-end pt-4">
        <a href="{{ route('pasien.rekam-medis.pdf', $rekam->id) }}"
            class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium flex items-center gap-2 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 13h14m-4 8H6a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2z" />
            </svg>
            Unduh PDF
        </a>
    </div> -->
</div>
@endsection