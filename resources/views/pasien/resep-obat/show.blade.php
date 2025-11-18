@extends('layouts.pasien')

@section('title', 'Resep Obat')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 px-4 sm:px-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Resep Obat</h1>
        <a href="{{ route('pasien.rekam-medis.detail', $rekam->id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Rekam Medis
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Daftar Obat</h2>

        @if($rekam->resepObat->isEmpty())
        <p class="text-gray-600">Tidak ada obat yang diresepkan.</p>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Obat</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosis</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aturan Pakai</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($rekam->resepObat as $resep)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $resep->nama_obat }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $resep->jumlah }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $resep->dosis }}mg</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $resep->aturan_pakai }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <!-- Tombol Download PDF -->
    <div class="flex justify-end">
        <a href="{{ route('pasien.resep-obat.pdf', $rekam->id) }}"
            class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium flex items-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 13h14m-4 8H6a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2z" />
            </svg>
            Unduh PDF Resep
        </a>
    </div>
</div>
@endsection