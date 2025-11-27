@extends('layouts.pasien')

@section('title', 'Rimayat Pemeriksaan')

@php
$title = 'Riwayat Pemeriksaan';
$subtitle = 'Daftar Pemeriksaan saya';
@endphp

@section('content')
<div class="space-y-6">

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
        <!-- Hanya tampilkan info dasar -->
        <div class="p-4 bg-white rounded-lg shadow mb-4">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="font-semibold text-gray-800">{{ $rm->janjiTemu->dokter->user->nama_lengkap }}</h3>
                    <p class="text-sm text-gray-600">Spesialisasi: {{ $rm->janjiTemu->dokter->spesialisasi_gigi }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($rm->janjiTemu->tanggal)->locale('id_ID')->isoFormat('dddd, D MMMM YYYY') }}</p>
                    <p class="font-medium text-green-600">Biaya: Rp {{ number_format($rm->biaya, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Tombol Lihat Detail (opsional) -->
            <div class="mt-3 flex justify-end">
                <a href="{{ route('pasien.rekam-medis.detail', $rm->id) }}"
                    class="px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 text-sm">
                    Lihat Detail
                </a>
            </div>
        </div>
        @empty
        <!-- Tidak ada data -->
        <div class="bg-gray-100 text-center py-10 rounded-lg text-gray-600">
            Tidak ada rekam medis ditemukan.
        </div>
        @endforelse

        <!-- Pagination -->
        @if (method_exists($rekamMedis, 'hasPages') && $rekamMedis->hasPages())
        <div class="mt-5">
            {{ $rekamMedis->links() }}
        </div>
        @endif
    </div>
</div>
@endsection