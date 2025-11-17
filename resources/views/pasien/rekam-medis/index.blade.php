@extends('layouts.pasien')

@section('title', 'Rekam Medis Saya')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Rekam Medis Saya</h2>
            <p class="text-sm text-gray-600 mt-1">Riwayat rekam medis Anda</p>
        </div>
    </div>

    <!-- Alert Verifikasi -->
    @if($belumVerifikasi ?? false)
    <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-800 px-4 py-3 rounded-lg">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div>
                <p class="font-semibold">Lengkapi Data Diri Anda</p>
                <p class="text-sm">Anda harus melengkapi data diri terlebih dahulu.</p>
                <a href="{{ route('profile.edit') }}" class="text-yellow-900 font-semibold underline mt-1 inline-block">
                    Lengkapi Data Sekarang →
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- List Rekam Medis -->
    <div class="space-y-4">
        @forelse ($rekamMedis as $rm)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-4 flex-1">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Informasi -->
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ $rm->janjiTemu->dokter->user->nama_lengkap ?? 'Dokter Tidak Ditemukan' }}
                        </h3>
                        <div class="flex flex-wrap gap-4 mt-2">
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Tanggal:</span>
                                {{ $rm->janjiTemu->tanggal ? \Carbon\Carbon::parse($rm->janjiTemu->tanggal)->locale('id')->isoFormat('dddd, DD MMMM YYYY') : 'N/A' }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Dokter:</span>
                                {{ $rm->janjiTemu->dokter->spesialisasi_gigi ?? 'N/A' }}
                            </p>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">
                            <span class="font-medium">Diagnosa:</span>
                            {{ Str::limit($rm->diagnosa, 60, '...') }}
                        </p>
                        @if($rm->biaya)
                        <p class="text-sm font-semibold text-green-600 mt-2">
                            Biaya: Rp {{ number_format($rm->biaya, 0, ',', '.') }}
                        </p>
                        @endif
                    </div>
                </div>

                <!-- Action Button -->
                <div class="flex-shrink-0">
                    <a href="{{ route('pasien.rekam-medis.detail', $rm->id) }}" 
                       class="px-6 py-2 bg-[#005248] text-white rounded-lg hover:bg-[#003d35] transition-colors font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada rekam medis</h3>
            <p class="mt-1 text-sm text-gray-500">Belum ada data rekam medis yang tersedia.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(method_exists($rekamMedis, 'hasPages') && $rekamMedis->hasPages())
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 px-6 py-4">
        {{ $rekamMedis->links() }}
    </div>
    @endif
</div>
@endsection
