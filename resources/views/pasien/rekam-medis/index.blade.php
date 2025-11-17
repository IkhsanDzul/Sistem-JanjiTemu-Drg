@extends('layouts.pasien')

@section('title', 'Rekam Medis Saya')

@section('content')

<div class="px-6 py-4">

    <h2 class="text-2xl font-semibold mb-5">Rekam Medis Saya</h2>

    {{-- Alert verifikasi data --}}
    @if ($belumVerifikasi)
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded">
        <p><strong>Lengkapi Data Diri:</strong> Anda harus melengkapi data diri terlebih dahulu.</p>
    </div>
    @endif


    {{-- Daftar Rekam Medis --}}
    @forelse ($rekamMedis as $rm)
    <div class="bg-white shadow-md rounded-xl p-5 mb-4 flex flex-col md:flex-row items-start md:items-center justify-between transition hover:shadow-lg">

        <div class="flex-1">
            {{-- Nama Dokter --}}
            <h3 class="text-lg font-semibold text-gray-800">
                {{ $rm->janjiTemu->dokter->user->name ?? 'Dokter Tidak Ditemukan' }}
            </h3>

            {{-- Tanggal --}}
            <p class="text-gray-600 text-sm mt-1 flex items-center gap-1">
                <span class="font-medium">Tanggal:</span>
                {{ \Carbon\Carbon::parse($rm->tanggal)->format('d M Y') }}
            </p>

            {{-- Diagnosa singkat --}}
            <p class="text-gray-600 text-sm mt-1 flex items-center gap-1">
                <span class="font-medium">Diagnosa:</span>
                {{ Str::limit($rm->diagnosa, 40, '...') }}
            </p>
        </div>

        {{-- Tombol Detail --}}
        <div class="mt-4 md:mt-0">
            <a href="{{ route('pasien.rekam-medis.detail', $rm->id) }}"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                Lihat Detail
            </a>
        </div>

    </div>
    @empty

    {{-- Tidak ada data --}}
    <div class="bg-gray-100 text-center py-10 rounded-lg text-gray-600">
        Tidak ada rekam medis ditemukan.
    </div>

    @endforelse


    {{-- Pagination --}}
    @if (method_exists($rekamMedis, 'hasPages') && $rekamMedis->hasPages())
    <div class="mt-5">
        {{ $rekamMedis->links() }}
    </div>
    @endif

</div>

@endsection