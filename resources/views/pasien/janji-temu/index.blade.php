@extends('layouts.pasien')

@section('title', 'Janji Temu Saya')

@section('content')

<div class="px-6 py-4">

    <h2 class="text-2xl font-semibold mb-4">Janji Temu Saya</h2>

    {{-- Jika belum verifikasi --}}
    @if($belumVerifikasi ?? false)
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded">
        <p>Anda harus melengkapi data diri terlebih dahulu sebelum dapat membuat janji temu.</p>
        <a href="{{ route('profile.edit') }}" class="text-yellow-800 font-semibold underline">
            Lengkapi Data Sekarang
        </a>
    </div>
    @endif

    {{-- Tab Navigasi --}}
    <div class="flex gap-4 mb-6 border-b pb-2">
        <a href="?status=pending" class="font-semibold {{ request('status')=='pending' ? 'text-green-600' : 'text-gray-600' }}">
            Menunggu Konfirmasi
        </a>
        <a href="?status=confirmed" class="font-semibold {{ request('status')=='confirmed' ? 'text-green-600' : 'text-gray-600' }}">
            Disetujui
        </a>
        <a href="?status=canceled" class="font-semibold {{ request('status')=='canceled' ? 'text-green-600' : 'text-gray-600' }}">
            Dibatalkan
        </a>
        <a href="?status=completed" class="font-semibold {{ request('status')=='completed' ? 'text-green-600' : 'text-gray-600' }}">
            Selesai
        </a>
    </div>

    {{-- Daftar Janji Temu --}}
    @forelse ($janjiTemu as $j)
    <div class="bg-white shadow rounded-lg p-4 mb-4 flex justify-between items-center">
        <div class="flex items-center gap-4">

            <img src="{{ asset('storage/' . $j->dokter->foto) }}"
                class="w-16 h-16 rounded-full object-cover border">

            <div>
                <h3 class="text-lg font-semibold">{{ $j->dokter->user->name }}</h3>
                <p class="text-gray-500 text-sm">{{ $j->dokter->spesialis }}</p>

                <p class="mt-1 text-sm text-gray-600">
                    <strong>Tanggal:</strong>
                    {{ \Carbon\Carbon::parse($j->tanggal)->locale('id')->isoFormat('dddd, DD MMM YYYY') }}
                </p>

                <p class="text-sm text-gray-600">
                    <strong>Jam:</strong> {{ $j->jam_mulai }}
                </p>
            </div>
        </div>

        {{-- Status --}}
        <div class="text-right">
            @if($j->status == 'pending')
            <span class="px-3 py-1 text-yellow-700 bg-yellow-100 rounded-full text-sm">Menunggu</span>
            @elseif($j->status == 'confirmed')
            <span class="px-3 py-1 text-green-700 bg-green-100 rounded-full text-sm">Disetujui</span>
            @elseif($j->status == 'canceled')
            <span class="px-3 py-1 text-red-700 bg-red-100 rounded-full text-sm">Dibatalkan</span>
            @elseif($j->status == 'completed')
            <span class="px-3 py-1 text-green-700 bg-green-100 rounded-full text-sm">Selesai</span>
            @endif

            {{-- Tombol Aksi --}}
            <div class="mt-3 flex gap-2 justify-end">
                @if($j->status == 'pending')
                <form action="{{ route('pasien.cancel-janji-temu', $j->id) }}" method="POST">
                    @csrf
                    <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                        Batalkan
                    </button>
                </form>
                @endif

                @if($j->status == 'confirmed' || $j->status == 'completed')
                <a href="{{ route('pasien.detail-janji-temu', $j->id) }}"
                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                    Detail
                </a>
                @endif
            </div>
        </div>
    </div>

    @empty
    <div class="text-center text-gray-500 py-10">
        Tidak ada janji temu untuk status ini.
    </div>
    @endforelse

    {{-- Pagination --}}
    @if ($janjiTemu->hasPages())
    <div class="mt-4">
        {{ $janjiTemu->render('pagination') }}
    </div>
    @endif
</div>

@endsection