@extends('layouts.admin')

@section('title', 'Laporan dan Rekapitulasi Data')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <h1 class="text-2xl font-bold text-gray-900">Laporan dan Rekapitulasi Data</h1>
        <p class="text-gray-600 mt-1">Pilih jenis laporan yang ingin Anda lihat atau unduh</p>
    </div>

    <!-- Pilihan Laporan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Laporan Jumlah Pasien Terdaftar -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 rounded-lg">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Jumlah Pasien Terdaftar</h3>
            <p class="text-sm text-gray-600 mb-4">Laporan data pasien yang terdaftar di sistem</p>
            <div class="flex gap-2">
                <a href="{{ route('admin.laporan.pasien') }}" 
                   class="flex-1 px-4 py-2 bg-[#005248] text-white rounded-lg hover:bg-[#003d35] transition-colors text-center text-sm font-medium">
                    Lihat Laporan
                </a>
                <a href="{{ route('admin.laporan.pasien', ['format' => 'pdf']) }}" 
                   class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors text-sm font-medium"
                   target="_blank">
                    PDF
                </a>
                <a href="{{ route('admin.laporan.pasien', ['format' => 'excel']) }}" 
                   class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors text-sm font-medium">
                    Excel
                </a>
            </div>
        </div>

        <!-- Laporan Jadwal Kunjungan Hari Ini -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-50 rounded-lg">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Jadwal Kunjungan</h3>
            <p class="text-sm text-gray-600 mb-4">Laporan jadwal kunjungan pasien hari ini</p>
            <div class="flex gap-2">
                <a href="{{ route('admin.laporan.jadwal-kunjungan') }}" 
                   class="flex-1 px-4 py-2 bg-[#005248] text-white rounded-lg hover:bg-[#003d35] transition-colors text-center text-sm font-medium">
                    Lihat Laporan
                </a>
                <a href="{{ route('admin.laporan.jadwal-kunjungan', ['format' => 'pdf']) }}" 
                   class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors text-sm font-medium"
                   target="_blank">
                    PDF
                </a>
                <a href="{{ route('admin.laporan.jadwal-kunjungan', ['format' => 'excel']) }}" 
                   class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors text-sm font-medium">
                    Excel
                </a>
            </div>
        </div>

        <!-- Laporan Daftar Dokter Aktif -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-50 rounded-lg">
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Daftar Dokter Aktif</h3>
            <p class="text-sm text-gray-600 mb-4">Laporan daftar dokter yang aktif di klinik</p>
            <div class="flex gap-2">
                <a href="{{ route('admin.laporan.dokter-aktif') }}" 
                   class="flex-1 px-4 py-2 bg-[#005248] text-white rounded-lg hover:bg-[#003d35] transition-colors text-center text-sm font-medium">
                    Lihat Laporan
                </a>
                <a href="{{ route('admin.laporan.dokter-aktif', ['format' => 'pdf']) }}" 
                   class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors text-sm font-medium"
                   target="_blank">
                    PDF
                </a>
                <a href="{{ route('admin.laporan.dokter-aktif', ['format' => 'excel']) }}" 
                   class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors text-sm font-medium">
                    Excel
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

