@extends('layouts.pasien')

@section('title', 'Dashboard Pasien')

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

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Daftar Dokter -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Search Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
                <form method="GET" action="{{ route('pasien.dashboard') }}">
                    <div class="flex gap-2">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama dokter atau spesialisasi..."
                            class="flex-1 rounded-lg border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#005248]"
                            autocomplete="off">
                        <button type="submit" class="px-6 py-2.5 bg-[#005248] text-white rounded-lg hover:bg-[#003d35]">
                            Cari
                        </button>
                    </div>
                </form> 
            </div>

            <!-- List Dokter -->
            @forelse ($dokter as $d)
            @php
            $routeUrl = !$belumVerifikasi ? route('pasien.detail-dokter', $d->id) : '#';
            $cursorClass = !$belumVerifikasi ? 'cursor-pointer hover:shadow-md hover:border-[#005248]' : 'cursor-not-allowed opacity-60';
            @endphp
            <a href="{{ $routeUrl }}"
                class="block bg-white rounded-xl shadow-sm border border-gray-100 p-5 transition-all group {{ $cursorClass }}"
                @if($belumVerifikasi) onclick="return false;" @endif>
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0">
                        @if($d->user && $d->user->foto_profil)
                        <img src="{{ asset('storage/' . $d->user->foto_profil) }}"
                            alt="Foto Dokter"
                            class="w-16 h-16 rounded-lg object-cover border"
                            onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');">
                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center hidden">
                            <span class="text-gray-400 font-bold text-xl">
                                {{ strtoupper(substr($d->user->nama_lengkap ?? 'D', 0, 1)) }}
                            </span>
                        </div>
                        @else
                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                            <span class="text-gray-400 font-bold text-xl">
                                {{ strtoupper(substr($d->user->nama_lengkap ?? 'D', 0, 1)) }}
                            </span>
                        </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-semibold text-gray-900 group-hover:text-[#005248] transition-colors truncate">
                            {{ $d->user->nama_lengkap ?? 'Nama Dokter' }}
                        </h3>
                        <p class="text-sm text-gray-600 mt-1 truncate">{{ $d->spesialisasi_gigi ?? 'Spesialis Gigi Umum' }}</p>
                        <div class="flex items-center gap-3 mt-2">
                            <p class="text-xs text-gray-500">Pengalaman: {{ $d->pengalaman_tahun ?? '-' }} tahun</p>
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $d->status == 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($d->status ?? 'tidak tersedia') }}
                            </span>
                        </div>
                    </div>
                    @unless($belumVerifikasi)
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-[#005248] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    @endunless
                </div>
            </a>
            @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada dokter ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if(request('search'))
                    Tidak ada dokter yang cocok dengan "{{ request('search') }}".
                    @else
                    Belum ada data dokter yang tersedia.
                    @endif
                </p>
            </div>
            @endforelse

            <!-- Pagination -->
            @if($dokter->hasPages())
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 px-6 py-4">
                {{ $dokter->appends(request()->query())->links() }}
            </div>
            @endif
        </div>

        <!-- Sidebar - Janji Temu -->
        <div class="space-y-4 lg:sticky lg:top-6 self-start">
            <!-- Janji Temu Mendatang -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Menunggu Konfirmasi
                    </h3>
                    @if($janjiTemuMendatang->count() > 0)
                    <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">
                        {{ $janjiTemuMendatang->count() }}
                    </span>
                    @endif
                </div>
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @forelse ($janjiTemuMendatang as $janji)
                    <a href="{{ route('pasien.detail-janji-temu', $janji->id) }}"
                        class="block p-4 bg-yellow-50 border border-yellow-200 rounded-lg hover:bg-yellow-100 hover:border-yellow-300 transition-all group">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-[#005248] transition-colors">
                                    {{ $janji->dokter->user->nama_lengkap ?? 'Dokter' }}
                                </p>
                                <p class="text-xs text-gray-600 mt-1">
                                    {{ \Carbon\Carbon::parse($janji->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                </p>
                                <p class="text-xs text-gray-600">
                                    {{ \Carbon\Carbon::parse($janji->jam_mulai)->format('H:i') }} WIB
                                </p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-[#005248] transition-colors flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </a>
                    @empty
                    <div class="text-center py-8">
                        <svg class="mx-auto h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-gray-500 mt-2">Belum ada janji temu</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Janji Temu Disetujui -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Disetujui
                    </h3>
                    @if($janjiTemuConfirmed->count() > 0)
                    <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                        {{ $janjiTemuConfirmed->count() }}
                    </span>
                    @endif
                </div>
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @forelse ($janjiTemuConfirmed as $janji)
                    <a href="{{ route('pasien.detail-janji-temu', $janji->id) }}"
                        class="block p-4 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 hover:border-green-300 transition-all group">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-[#005248] transition-colors">
                                    {{ $janji->dokter->user->nama_lengkap ?? 'Dokter' }}
                                </p>
                                <p class="text-xs text-gray-600 mt-1">
                                    {{ \Carbon\Carbon::parse($janji->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                </p>
                                <p class="text-xs text-gray-600">
                                    {{ \Carbon\Carbon::parse($janji->jam_mulai)->format('H:i') }} WIB
                                </p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-[#005248] transition-colors flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </a>
                    @empty
                    <div class="text-center py-8">
                        <svg class="mx-auto h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-gray-500 mt-2">Belum ada janji temu</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection