@extends('layouts.admin')
@section('title', 'Kelola Dokter')

@section('content')
{{-- Main Content --}}
{{-- Main Content --}}
<div class="flex-1 flex flex-col transition-all duration-300 ml-0">

    {{-- Content --}}
    <main class="p-4 sm:p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Daftar Dokter --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- Search Bar --}}
            <div class="w-full">
                <input type="text" placeholder="Cari Dokter..."
                    class="w-full rounded-full border border-gray-300 px-4 py-2 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent">
            </div>

            {{-- List Dokter --}}
            @foreach ($dokter as $d)
            <div
                class="bg-white rounded-xl shadow-sm p-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 hover:shadow-md border border-transparent hover:border-[#005248] transition">
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <div
                        class="w-20 h-20 sm:w-16 sm:h-16 bg-gray-200 rounded-md flex items-center justify-center text-gray-400">
                        <img src="{{ asset('storage/' . $d->user->foto_profil) }}" alt="Foto Dokter"
                            class="w-full h-full rounded-md object-cover">
                    </div>
                    <div class="text-center sm:text-left">
                        <p class="font-semibold text-gray-800 text-base sm:text-lg">
                            {{ $d->user->nama_lengkap ?? 'Nama Dokter' }}
                        </p>
                        <p class="text-sm text-gray-500">{{ $d->spesialisasi_gigi ?? 'Spesialisasi' }}</p>
                        <p class="text-sm text-gray-500">{{ $d->pengalaman_tahun ?? '-' }} tahun pengalaman</p>
                    </div>
                </div>

                <div class="flex flex-col items-center gap-2 sm:gap-3">
                    <p class="text-sm text-gray-600 font-medium text-center sm:text-left">
                        Status:
                        <span
                            class="font-semibold {{ $d->status == 'Aktif' ? 'text-green-600' : 'text-gray-500' }}">
                            {{ $d->status ?? '-' }}
                        </span>
                    </p>
                    <a href="{{route('admin.edit-dokter', $d->id)}}">
                        <button
                            class="flex items-center gap-1 text-white bg-[#00534A] text-[#005248] hover:text-[#FFA700] transition p-2 rounded-lg hover:bg-gray-100 w-full justify-center">
                            Edit
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </button>
                    </a>
                        
                </div>
            </div>
            @endforeach
        </div>

        {{-- Info Dokter --}}
        <div class="space-y-4 lg:sticky lg:top-6 self-start">

            {{-- Total Dokter --}}
            <div class="bg-white rounded-xl shadow-sm p-4 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-semibold text-gray-800">Total Dokter</h3>
                    <p class="text-2xl font-bold text-gray-800 mt-2">{{ $totalDokter }}</p>
                </div>
                <div class="p-3 bg-green-50 rounded-full">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </div>

            {{-- Dokter Aktif --}}
            <div class="bg-white rounded-xl shadow-sm p-4 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-2">Dokter Aktif</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $dokterAktif->count() }}</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-full">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
            </div>

            {{-- Button Daftar Dokter --}}
            <button
                class="w-full bg-[#FFA700] hover:bg-[#e89500] text-white font-semibold py-3 rounded-lg flex items-center justify-center gap-2 transition text-sm sm:text-base">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4" />
                </svg>
                Daftarkan Dokter
            </button>
        </div>

    </main>
</div>
@endsection