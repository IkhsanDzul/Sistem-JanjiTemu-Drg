@extends('layouts.pasien')

@section('title', 'Dashboard Pasien')


@section('content')
<div x-data="{ showModal: {{ $belumVerifikasi ? 'true' : 'false' }}, 
              showModalClick: false }"
    class="flex flex-col lg:flex-row h-screen bg-gray-50 overflow-hidden">
    {{-- Popup verifikasi --}}
    <div
        x-show="showModal || showModalClick"
        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
        x-cloak>
        <div class="bg-white w-96 rounded-xl p-6 shadow-lg text-center">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Verifikasi Data Diri</h2>
            <p class="text-sm text-gray-500 mb-4">Silakan lengkapi nomor telepon dan upload foto KTP untuk melanjutkan.</p>
            <div class="flex space-x-4 justify-center">
            <a href="{{route ('profile.edit')}}">
                <button class="mt-4 px-4 py-2 bg-gray-300 rounded hover:bg-green-400">Profil</button>
            </a>    
                <button @click="showModal = false; showModalClick = false" class="mt-4 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Close</button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        <main class="flex-1 p-6 grid grid-cols-1 lg:grid-cols-3 gap-6 h-full overflow-hidden">

            {{-- Kolom kiri: daftar dokter --}}
            <div class="lg:col-span-2 flex flex-col space-y-4 overflow-y-auto pr-4 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent">
                <div class="w-full sticky top-0 bg-gray-50 pb-2 z-10">
                    <input type="text" placeholder="Cari Dokter"
                        class="w-full rounded-full border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent">
                </div>

                {{-- List dokter dari database --}}
                @forelse ($dokter as $d)
                <div
                    class="bg-white rounded-xl shadow-sm p-4 flex justify-between items-center hover:shadow-md transition cursor-pointer"
                    @click="{{ $belumVerifikasi ? 'showModalClick = true' : "window.location.href='/pasien/janji-temu/$d->id'" }}">

                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gray-200 rounded-md flex items-center justify-center text-gray-400 text-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14v7m0-7a9 9 0 110-18 9 9 0 010 18z" />
                            </svg>
                        </div>
                        <div>
                            @php
                            $userDokter = $d->user;
                            @endphp
                            <h2 class="text-lg font-semibold text-gray-800">{{ $userDokter->nama_lengkap ?? 'Nama Dokter' }}</h2>
                            <p class="text-sm text-gray-500">{{ $d->spesialis ?? 'Spesialis Gigi Umum' }}</p>
                            <p class="text-sm text-gray-500">Pengalaman: {{ $d->pengalaman_tahun ?? '-' }} tahun</p>

                        </div>
                    </div>
                    <p class="text-sm text-gray-600 font-medium">
                        <span class="{{ $d->status == 'tersedia' ? 'text-green-600' : 'text-red-600' }}">
                            {{ ucfirst($d->status ?? 'tidak tersedia') }}
                        </span>
                    </p>
                </div>
                @empty
                <p class="text-gray-500 text-center mt-10">Belum ada data dokter.</p>
                @endforelse

                {{-- Pagination --}}
                <div class="sticky bottom-0 bg-white py-3 flex justify-center items-center border-t border-gray-200">
                    {{ $dokter->links() }}
                </div>
            </div>

            {{-- Kolom kanan: sticky --}}
            <div class="space-y-4 lg:col-span-1 sticky top-6 self-start h-fit">
                <div class="bg-white rounded-xl shadow-sm p-4 h-40 flex flex-col justify-center items-center text-center">
                    <h3 class="text-sm font-semibold text-gray-800 mb-2">Janji Temu Mendatang</h3>
                    <p class="text-gray-500 text-sm">Belum ada janji temu</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-4 h-40 flex flex-col justify-center items-center text-center">
                    <h3 class="text-sm font-semibold text-gray-800 mb-2">Pengingat</h3>
                    <p class="text-gray-500 text-sm">Tidak ada pengingat hari ini</p>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection