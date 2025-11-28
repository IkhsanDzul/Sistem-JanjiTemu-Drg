@extends('layouts.dokter')

@section('title', 'Resep Obat')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <p class="text-red-700 font-medium">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Header dengan Gradient -->
    <div class="bg-gradient-to-r from-[#005248] to-[#007a6a] rounded-lg shadow-md p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold">Daftar Obat Tersedia</h2>
                <p class="text-sm text-white/90 mt-1">Lihat obat yang dapat digunakan pada rekam medis</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden md:flex items-center gap-4 bg-white/10 px-4 py-2 rounded-lg backdrop-blur-sm">
                    <div class="text-center">
                        <p class="text-xs text-white/80">Total Obat</p>
                        <p class="text-lg font-bold">{{ $totalObat ?? 0 }}</p>
                    </div>
                    <div class="w-px h-8 bg-white/30"></div>
                    <div class="text-center">
                        <p class="text-xs text-white/80">Total Resep</p>
                        <p class="text-lg font-bold">{{ $totalResep ?? 0 }}</p>
                    </div>
                </div>
                <a href="{{ route('dokter.resep-obat.create') }}" 
                   class="px-4 py-2 bg-white text-[#005248] rounded-lg hover:bg-gray-100 transition-colors font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Obat
                </a>
            </div>
        </div>
    </div>


    <!-- Search dan Filter -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <!-- Search -->
            <div class="w-full md:w-96">
                <div class="relative">
                    <input type="text" 
                           id="searchInput"
                           placeholder="Cari nama obat atau pasien..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005248] focus:border-transparent">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Resep Obat Individual -->
    @if(isset($semuaResepObat) && $semuaResepObat->count() > 0)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Semua Resep Obat ({{ $semuaResepObat->count() }})
            </h3>
            <p class="text-sm text-gray-600 mt-1">Daftar lengkap semua resep obat yang telah dibuat</p>
        </div>
        <div class="divide-y divide-gray-200">
            @foreach($semuaResepObat as $resep)
            <div class="resep-item p-6 hover:bg-gray-50 transition-colors" 
                 data-nama-obat="{{ strtolower($resep->nama_obat) }}"
                 data-pasien="{{ strtolower($resep->rekamMedis?->janjiTemu?->pasien?->user?->nama_lengkap ?? '') }}">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="px-3 py-1 bg-[#005248] text-white rounded-full text-xs font-semibold">
                                {{ $resep->nama_obat }}
                            </div>
                            <div class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                {{ \Carbon\Carbon::parse($resep->tanggal_resep)->locale('id')->isoFormat('DD MMM YYYY') }}
                            </div>
                            @if($resep->rekamMedis && $resep->rekamMedis->janjiTemu && $resep->rekamMedis->janjiTemu->pasien)
                            <div class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                {{ $resep->rekamMedis->janjiTemu->pasien->user->nama_lengkap ?? 'N/A' }}
                            </div>
                            @endif
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Jumlah</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $resep->jumlah }} unit</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Dosis</p>
                                <p class="text-sm font-semibold text-gray-900">{{ number_format($resep->dosis) }} mg</p>
                            </div>
                            <div class="md:col-span-1">
                                <p class="text-xs text-gray-500 mb-1">Aturan Pakai</p>
                                <p class="text-sm text-gray-800">{{ $resep->aturan_pakai }}</p>
                            </div>
                        </div>
                        @if($resep->dokter)
                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <p class="text-xs text-gray-500">Diresepkan oleh: <span class="font-medium text-gray-700">Dr. {{ $resep->dokter->user->nama_lengkap ?? 'N/A' }}</span></p>
                        </div>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 ml-4">
                        @php
                            $user = auth()->user();
                            $dokter = $user->dokter ?? \App\Models\Dokter::where('user_id', $user->id)->first();
                            $canEdit = $dokter && $resep->dokter_id === $dokter->id;
                        @endphp
                        @if($canEdit)
                        <a href="{{ route('dokter.resep-obat.edit', $resep->id) }}" 
                           class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                            Edit
                        </a>
                        <form action="{{ route('dokter.resep-obat.destroy', $resep->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Hapus resep obat ini?');"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                                Hapus
                            </button>
                        </form>
                        @else
                        <span class="text-xs text-gray-500">Hanya dokter yang membuat resep dapat mengedit</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <!-- Empty State untuk Resep Obat -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum Ada Resep Obat</h3>
        <p class="text-gray-500 text-sm mb-6">Resep obat yang dibuat akan muncul di sini</p>
    </div>
    @endif
</div>

<!-- JavaScript for Search -->
<script>
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            filterResep(searchTerm);
        });
    }

    function filterResep(searchTerm) {
        const items = document.querySelectorAll('.resep-item');
        let visibleCount = 0;

        items.forEach(item => {
            const namaObat = item.dataset.namaObat || '';
            const pasien = item.dataset.pasien || '';
            const matchesSearch = namaObat.includes(searchTerm) || pasien.includes(searchTerm);

            if (matchesSearch || searchTerm === '') {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>
@endsection