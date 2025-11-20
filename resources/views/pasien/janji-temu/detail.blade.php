@extends('layouts.pasien')

@section('title', 'Detail Janji Temu')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Detail Janji Temu</h2>
            <p class="text-sm text-gray-600 mt-1">Informasi lengkap tentang janji temu Anda</p>
        </div>
        <a href="{{ route('pasien.janji-temu') }}"
            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="flex flex-col justify-between gap-4">
            <!-- Informasi Dokter -->
            <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6 h-full">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#005248]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Informasi Dokter
                </h3>
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        @if($janjiTemu->dokter && $janjiTemu->dokter->user && $janjiTemu->dokter->user->foto_profil)
                        <img src="{{ asset('storage/' . $janjiTemu->dokter->user->foto_profil) }}"
                            alt="Foto Dokter"
                            class="w-24 h-24 rounded-lg object-cover"
                            onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center hidden">
                            <span class="text-gray-400 font-bold text-3xl">
                                {{ strtoupper(substr($janjiTemu->dokter->user->nama_lengkap ?? 'D', 0, 1)) }}
                            </span>
                        </div>
                        @else
                        <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                            <span class="text-gray-400 font-bold text-3xl">
                                {{ strtoupper(substr($janjiTemu->dokter->user->nama_lengkap ?? 'D', 0, 1)) }}
                            </span>
                        </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-gray-900">{{ $janjiTemu->dokter->user->nama_lengkap ?? 'N/A' }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ $janjiTemu->dokter->spesialisasi_gigi ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500 mt-1">Pengalaman: {{ $janjiTemu->dokter->pengalaman_tahun ?? '-' }} tahun</p>
                    </div>
                </div>
            </div>
            <div class="flex gap-4 items-center space-x-2">
                @if($rekamMedisId)
                <a href="{{ route('pasien.rekam-medis.detail', $rekamMedisId) }}"
                    class="w-full flex items-center space-x-2 px-4 py-2 bg-[#005248] text-white rounded-lg hover:bg-[#003d35] transition-colors font-medium">
                    <span class="flex-1">Rekam Medis Saya</span>
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </a>
                @else
                <div class="w-full flex items-center space-x-2 px-4 py-2 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed font-medium">
                    <span class="flex-1">Rekam Medis Belum Tersedia</span>
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                @endif
            </div>
        </div>

        <!-- Informasi Janji Temu -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Detail Janji Temu
            </h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tanggal</p>
                    <p class="text-base text-gray-900 mt-1">{{ $tanggalFormat }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Waktu</p>
                    <p class="text-base text-gray-900 mt-1">
                        {{ \Carbon\Carbon::parse($janjiTemu->jam_mulai)->format('H:i') }} -
                        {{ $janjiTemu->jam_selesai ? \Carbon\Carbon::parse($janjiTemu->jam_selesai)->format('H:i') : 'N/A' }} WIB
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Status</p>
                    @php
                    $statusConfig = [
                    'pending' => ['bg-yellow-100', 'text-yellow-800', 'Menunggu Konfirmasi'],
                    'confirmed' => ['bg-green-100', 'text-green-800', 'Disetujui'],
                    'completed' => ['bg-blue-100', 'text-blue-800', 'Selesai'],
                    'canceled' => ['bg-red-100', 'text-red-800', 'Dibatalkan'],
                    ];
                    $status = $statusConfig[$janjiTemu->status] ?? $statusConfig['pending'];
                    @endphp
                    <span class="inline-block mt-2 px-4 py-2 text-sm font-semibold rounded-lg {{ $status[0] }} {{ $status[1] }}">
                        {{ $status[2] }}
                    </span>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Keluhan</p>
                    <p class="text-base text-gray-900 mt-1">{{ $janjiTemu->keluhan ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Foto Kondisi Gigi -->
        @if($janjiTemu->foto_gigi)
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6 lg:col-span-2">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Foto Kondisi Gigi
            </h3>
            <div class="flex justify-center">
                <img src="{{ asset('storage/' . $janjiTemu->foto_gigi) }}"
                    alt="Foto Kondisi Gigi"
                    class="max-w-full h-auto rounded-lg shadow-md max-h-96">
            </div>
        </div>
        @endif

        <!-- Catatan Penting -->
        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-6 lg:col-span-2">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="text-lg font-semibold text-blue-900 mb-2">Catatan Penting</h4>
                    <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                        <li>Pastikan datang 15-20 menit sebelum waktu yang telah ditentukan</li>
                        <li>Bawa kartu identitas (KTP/SIM) untuk verifikasi</li>
                        <li>Jika perlu membatalkan, lakukan minimal 24 jam sebelum jadwal</li>
                        <li>Gunakan masker dan ikuti protokol kesehatan yang berlaku</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection