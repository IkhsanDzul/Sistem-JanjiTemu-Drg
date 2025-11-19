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
                           placeholder="Cari nama obat..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005248] focus:border-transparent">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Obat -->
    @if(isset($obatTersedia) && $obatTersedia->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="obatGrid">
            @foreach($obatTersedia as $obat)
            <div class="obat-card bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200" 
                 data-name="{{ strtolower($obat['nama_obat']) }}">
                
                <!-- Header Card -->
                <div class="p-4 border-b-2 border-[#005248]/20 bg-gradient-to-r from-[#005248]/5 to-[#007a6a]/5">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3 flex-1">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#005248] to-[#007a6a] rounded-lg flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-gray-900 text-base truncate">{{ $obat['nama_obat'] }}</h3>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    Digunakan {{ $obat['jumlah_penggunaan'] }} kali
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Body Card -->
                <div class="p-4 space-y-3 bg-white">
                    <!-- Dosis -->
                    @if($obat['dosis_min'] !== null)
                    <div class="flex items-center gap-3 p-2 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 font-medium">Dosis</p>
                            <p class="text-sm font-semibold text-gray-900">
                                @if($obat['dosis_min'] == $obat['dosis_max'])
                                    {{ number_format($obat['dosis_min']) }} mg
                                @else
                                    {{ number_format($obat['dosis_min']) }} - {{ number_format($obat['dosis_max']) }} mg
                                @endif
                            </p>
                        </div>
                    </div>
                    @endif

                    <!-- Aturan Pakai -->
                    @if(!empty($obat['aturan_pakai_umum']))
                    <div class="pt-2 border-t-2 border-gray-200">
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-[#005248] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500 font-medium mb-1">Aturan Pakai Umum</p>
                                <div class="space-y-1">
                                    @foreach(array_slice($obat['aturan_pakai_umum'], 0, 2) as $aturan)
                                        <p class="text-sm text-gray-700 bg-[#005248]/5 p-2 rounded border border-[#005248]/10">{{ $aturan }}</p>
                                    @endforeach
                                    @if(count($obat['aturan_pakai_umum']) > 2)
                                        <p class="text-xs text-gray-500 italic">+{{ count($obat['aturan_pakai_umum']) - 2 }} aturan lainnya</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Terakhir Digunakan -->
                    @if($obat['terakhir_digunakan'])
                    <div class="flex items-center gap-3 p-2 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500 font-medium">Terakhir Digunakan</p>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($obat['terakhir_digunakan'])->locale('id')->isoFormat('D MMMM YYYY') }}
                            </p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Footer Card -->
                <div class="p-4 border-t-2 border-gray-200 bg-gradient-to-r from-[#005248]/5 to-[#007a6a]/5">
                    <div class="flex items-center justify-between">
                        <span class="px-3 py-1 bg-[#005248] text-white rounded-full text-xs font-semibold">
                            Tersedia
                        </span>
                        <span class="text-xs text-gray-500">
                            {{ $obat['jumlah_penggunaan'] }}x digunakan
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- No Results Message -->
        <div id="noResults" class="hidden bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Tidak Ada Hasil</h3>
            <p class="text-gray-500 text-sm">Coba gunakan kata kunci yang berbeda</p>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum Ada Obat Tersedia</h3>
            <p class="text-gray-500 text-sm mb-6">Obat yang digunakan pada resep akan muncul di sini</p>
        </div>
    @endif
</div>

<!-- JavaScript for Search -->
@if(isset($obatTersedia) && $obatTersedia->count() > 0)
<script>
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            filterObat(searchTerm);
        });
    }

    function filterObat(searchTerm) {
        const cards = document.querySelectorAll('.obat-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const name = card.dataset.name || '';
            const matchesSearch = name.includes(searchTerm);

            if (matchesSearch) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide no results message
        const noResults = document.getElementById('noResults');
        const grid = document.getElementById('obatGrid');
        
        if (visibleCount === 0 && cards.length > 0) {
            if (noResults) noResults.classList.remove('hidden');
            if (grid) grid.classList.add('hidden');
        } else {
            if (noResults) noResults.classList.add('hidden');
            if (grid) grid.classList.remove('hidden');
        }
    }
</script>
@endif
@endsection
