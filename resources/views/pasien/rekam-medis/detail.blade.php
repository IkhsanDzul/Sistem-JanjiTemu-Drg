@extends('layouts.pasien')

@section('title', 'Detail Rekam Medis')

@section('content')

<div class="px-6 py-4">

    {{-- Back Button --}}
    <a href="{{ route('pasien.rekam-medis') }}"
        class="inline-block mb-4 text-green-700 hover:text-green-900">
        ← Kembali ke Rekam Medis
    </a>

    <div class="bg-white shadow-md rounded-xl p-6">

        <h2 class="text-2xl font-semibold mb-6 text-gray-800">
            Detail Rekam Medis
        </h2>

        {{-- Nama Dokter --}}
        <div class="mb-4">
            <p class="text-gray-600 text-sm">Dokter Penanggung Jawab</p>
            <p class="text-lg font-semibold text-gray-800">
                {{ $rekam->janjiTemu->dokter->user->name ?? 'Tidak Ditemukan' }}
            </p>
        </div>

        {{-- Tanggal --}}
        <div class="mb-4">
            <p class="text-gray-600 text-sm">Tanggal Pemeriksaan</p>
            <p class="text-lg text-gray-800">
                {{ \Carbon\Carbon::parse($rekam->tanggal)->format('d M Y') }}
            </p>
        </div>

        {{-- Diagnosa --}}
        <div class="mb-4">
            <p class="text-gray-600 text-sm">Diagnosa</p>
            <p class="text-gray-800">
                {{ $rekam->diagnosa }}
            </p>
        </div>

        {{-- Tindakan --}}
        <div class="mb-4">
            <p class="text-gray-600 text-sm">Tindakan</p>
            <p class="text-gray-800">
                {{ $rekam->tindakan }}
            </p>
        </div>

        {{-- Catatan Dokter --}}
        <div class="mb-4">
            <p class="text-gray-600 text-sm">Catatan Dokter</p>
            <div class="text-gray-800 whitespace-pre-line bg-gray-50 border p-3 rounded">
                {{ $rekam->catatan }}
            </div>
        </div>

        {{-- Optional: Resep Obat --}}
        @if (!empty($rekam->resep))
        <div class="mb-4">
            <p class="text-gray-600 text-sm">Resep Obat</p>
            <div class="text-gray-800 whitespace-pre-line bg-gray-50 border p-3 rounded">
                {{ $rekam->resep }}
            </div>
        </div>
        @endif

        {{-- Tombol Aksi --}}
        <div class="mt-6 flex gap-3">

            {{-- Back --}}
            <a href="{{ route('pasien.rekam-medis') }}"
                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                Kembali
            </a>

            {{-- Button PDF (Optional → tinggal diaktifkan jika PDF ready) --}}
            {{--
            <a href="{{ route('pasien.rekam-medis.pdf', $rekam->id) }}"
            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            Download PDF
            </a>
            --}}
        </div>

    </div>

</div>

@endsection