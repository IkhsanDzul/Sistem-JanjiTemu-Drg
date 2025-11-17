@extends('layouts.pasien')

@section('title', 'Dashboard Pasien')

@section('content')
<div class="flex flex-col lg:flex h-screen bg-gray-50 overflow-hidden">
    {{-- Jika belum verifikasi --}}
    @if($belumVerifikasi ?? false)
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded">
        <p>Anda harus melengkapi data diri terlebih dahulu sebelum dapat membuat janji temu.</p>
        <a href="{{ route('profile.edit') }}" class="text-yellow-800 font-semibold underline">
            Lengkapi Data Sekarang
        </a>
    </div>
    @endif

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        <main class="flex-1 p-6 grid grid-cols-1 lg:grid-cols-3 gap-6 h-full overflow-hidden">

            {{-- Daftar dokter --}}
            <div class="lg:col-span-2 flex flex-col space-y-4 overflow-y-auto pr-4 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent">
                <!-- Filter Section -->
                <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
                    <form method="GET" action="{{ route('pasien.cariDokter') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Search -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Dokter</label>
                                <input type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Cari nama dokter..."
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent">
                            </div>
                        </div>
                    </form>
                </div>

                {{-- List dokter dari database --}}
                @forelse ($dokter as $d)
                <div
                    class="bg-white rounded-xl shadow-sm p-4 flex justify-between items-center hover:shadow-md transition cursor-pointer"
                    @click="{{$belumVerifikasi ? '' : "window.location='".route('pasien.detail-dokter', $d->id)."' "}}">

                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gray-200 rounded-md flex items-center justify-center text-gray-400 text-xl">
                            <img src="{{ asset('storage/' . $d->user->foto_profil) }}" alt="Foto Dokter" class="w-full h-full object-cover rounded-md">
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

                <!-- Pagination -->
                <div class="sticky bottom-0 bg-white py-3 flex justify-center items-center border-t border-gray-200">
                    {{ $dokter->links() }}
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="space-y-4 lg:col-span-1 sticky top-6 self-start h-fit">
                <div class="bg-white rounded-xl shadow-sm p-4 h-fit flex flex-col justify-start">
                    <h3 class="text-sm font-semibold text-gray-800 mb-2">Janji Temu Mendatang</h3>
                    <ul class="list-disc list-inside text-gray-600 text-sm">
                        @forelse ($janjiTemuMendatang as $janji)
                        <a href="{{ route('pasien.detail-janji-temu', $janji->id) }}">
                            <div class="mb-4 shadow-sm p-4 flex flex-col hover:bg-[#005248] hover:text-white transition rounded-lg">
                                <p class=" text-sm font-semibold">{{ $janji->dokter->user->nama_lengkap ?? 'Dokter' }}</p>
                                <p class=" text-sm"> {{ $tanggal = \Carbon\Carbon::parse($janji->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY')  }} | {{ $janji->jam_mulai = \Carbon\Carbon::parse($janji->jam_mulai)->format('H:i') }}</p>
                            </div>
                        </a>
                        @empty
                        <p class="text-gray-500 text-center mt-10">Belum ada janji temu mendatang</p>
                        @endforelse
                    </ul>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-4 h-fit flex flex-col justify-start">
                    <h3 class="text-sm font-semibold text-gray-800 mb-2">Janji Temu Di Setujui</h3>
                    @forelse ($janjiTemuConfirmed as $janji)
                    <a href="{{ route('pasien.detail-janji-temu', $janji->id) }}">
                        <div class="mb-4 shadow-sm p-4 flex flex-col hover:bg-[#005248] hover:text-white transition rounded-lg">
                            <p class=" text-sm font-semibold">{{ $janji->dokter->user->nama_lengkap ?? 'Dokter' }}</p>
                            <p class=" text-sm"> {{ $tanggal = \Carbon\Carbon::parse($janji->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY')  }} | {{ $janji->jam_mulai = \Carbon\Carbon::parse($janji->jam_mulai)->format('H:i') }}</p>
                        </div>
                    </a>
                    @empty
                    <p class="text-gray-500 text-center mt-5 text-sm">Belum ada janji temu.</p>
                    @endforelse
                </div>
            </div>
    </div>
    </main>
</div>
</div>
@endsection