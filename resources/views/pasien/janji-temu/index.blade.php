@extends('layouts.pasien')

@section('title', 'Janji Temu Saya')

@php
    $title = 'Janji Temu Saya';
    $subtitle = 'Daftar janji temu saya';
@endphp

@section('content')
<div class="space-y-6">

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

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('error') }}
        </div>
    </div>
    @endif

    <!-- Alert Verifikasi -->
    @if($belumVerifikasi ?? false)
    <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-800 px-4 py-3 rounded-lg">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div>
                <p class="font-semibold">Lengkapi Data Diri Anda</p>
                <p class="text-sm">Anda harus melengkapi data diri terlebih dahulu sebelum dapat membuat janji temu.</p>
                <a href="{{ route('profile.edit') }}" class="text-yellow-900 font-semibold underline mt-1 inline-block">
                    Lengkapi Data Sekarang →
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Tab Navigation (Mobile-Friendly) -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-2">
        <div class="flex gap-2 overflow-x-auto pb-2">
            <a href="{{ route('pasien.janji-temu', ['status' => 'pending']) }}"
                class="px-4 py-2 rounded-lg font-medium text-sm whitespace-nowrap transition-colors {{ request('status') == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'text-gray-600 hover:bg-gray-100' }}">
                Menunggu Konfirmasi
            </a>
            <a href="{{ route('pasien.janji-temu', ['status' => 'confirmed']) }}"
                class="px-4 py-2 rounded-lg font-medium text-sm whitespace-nowrap transition-colors {{ request('status') == 'confirmed' ? 'bg-green-100 text-green-800' : 'text-gray-600 hover:bg-gray-100' }}">
                Disetujui
            </a>
            <a href="{{ route('pasien.janji-temu', ['status' => 'completed']) }}"
                class="px-4 py-2 rounded-lg font-medium text-sm whitespace-nowrap transition-colors {{ request('status') == 'completed' ? 'bg-blue-100 text-blue-800' : 'text-gray-600 hover:bg-gray-100' }}">
                Selesai
            </a>
            <a href="{{ route('pasien.janji-temu', ['status' => 'canceled']) }}"
                class="px-4 py-2 rounded-lg font-medium text-sm whitespace-nowrap transition-colors {{ request('status') == 'canceled' ? 'bg-red-100 text-red-800' : 'text-gray-600 hover:bg-gray-100' }}">
                Dibatalkan
            </a>
        </div>
    </div>

    <!-- List Janji Temu -->
    <div class="space-y-4">
        @forelse ($janjiTemu as $j)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                <!-- Foto Dokter + Info -->
                <div class="flex items-start gap-3 flex-1">
                    <!-- Foto Dokter -->
                    <div class="flex-shrink-0">
                        @if($j->dokter && $j->dokter->user && $j->dokter->user->foto_profil)
                        <img src="{{ asset('storage/' . $j->dokter->user->foto_profil) }}"
                            alt="Foto Dokter"
                            class="w-12 h-12 md:w-16 md:h-16 rounded-lg object-cover"
                            onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-gray-200 rounded-lg flex items-center justify-center hidden">
                            <span class="text-gray-400 font-bold text-lg md:text-xl">
                                {{ strtoupper(substr($j->dokter->user->nama_lengkap ?? 'D', 0, 1)) }}
                            </span>
                        </div>
                        @else
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                            <span class="text-gray-400 font-bold text-lg md:text-xl">
                                {{ strtoupper(substr($j->dokter->user->nama_lengkap ?? 'D', 0, 1)) }}
                            </span>
                        </div>
                        @endif
                    </div>

                    <!-- Informasi -->
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base md:text-lg font-semibold text-gray-900 truncate">{{ $j->dokter->user->nama_lengkap ?? 'Dokter' }}</h3>
                        <p class="text-xs md:text-sm text-gray-600 mt-1 truncate">{{ $j->dokter->spesialisasi_gigi ?? 'Spesialis Gigi' }}</p>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <p class="text-xs text-gray-600">
                                <span class="font-medium">Tanggal:</span>
                                {{ \Carbon\Carbon::parse($j->tanggal)->locale('id')->isoFormat('ddd, DD MMM YYYY') }}
                            </p>
                            <p class="text-xs text-gray-600">
                                <span class="font-medium">Jam:</span>
                                {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} WIB
                            </p>
                        </div>
                        @if($j->keluhan)
                        <p class="text-xs text-gray-500 mt-2 line-clamp-2">
                            <span class="font-medium">Keluhan:</span>
                            {{ $j->keluhan }}
                        </p>
                        @endif
                    </div>
                </div>

                <!-- Status & Actions -->
                <div class="flex flex-col items-end gap-2 mt-4 md:mt-0">
                    <!-- Status Badge -->
                    @php
                    $statusConfig = [
                    'pending' => ['bg-yellow-100', 'text-yellow-800', 'Menunggu'],
                    'confirmed' => ['bg-green-100', 'text-green-800', 'Disetujui'],
                    'completed' => ['bg-blue-100', 'text-blue-800', 'Selesai'],
                    'canceled' => ['bg-red-100', 'text-red-800', 'Dibatalkan'],
                    ];
                    $status = $statusConfig[$j->status] ?? $statusConfig['pending'];
                    @endphp
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $status[0] }} {{ $status[1] }}">
                        {{ $status[2] }}
                    </span>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        @if($j->status == 'pending')
                        <form action="{{ route('pasien.cancel-janji-temu', $j->id) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin membatalkan janji temu ini?');">
                            @csrf
                            <button type="submit"
                                class="px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-xs font-medium">
                                Batalkan
                            </button>
                        </form>
                        @endif

                        @if(in_array($j->status, ['confirmed', 'completed']))
                        <a href="{{ route('pasien.detail-janji-temu', $j->id) }}"
                            class="px-3 py-1.5 bg-[#005248] text-white rounded-lg hover:bg-[#003d35] transition-colors text-xs font-medium">
                            Detail
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada janji temu</h3>
            <p class="mt-1 text-sm text-gray-500">Belum ada janji temu untuk status ini.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($janjiTemu->hasPages())
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 px-6 py-4">
        {{ $janjiTemu->links() }}
    </div>
    @endif
</div>
@endsection
