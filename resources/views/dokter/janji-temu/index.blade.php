<x-app-layout title="Janji Temu">
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Header dengan Gradient -->
        <div class="bg-gradient-to-r from-[#005248] to-[#007a6a] rounded-lg shadow-md p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-semibold">Daftar Janji Temu</h2>
                    <p class="text-sm text-white/90 mt-1">Kelola semua janji temu pasien dalam sistem</p>
                </div>
                <div class="hidden md:flex items-center gap-2 bg-white/10 px-4 py-2 rounded-lg backdrop-blur-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="text-sm font-medium">Total: {{ $appointments->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Filter dan Search -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <!-- Search -->
                <div class="w-full md:w-96">
                    <div class="relative">
                        <input type="text" 
                               id="searchInput"
                               placeholder="Cari nama pasien atau layanan..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005248] focus:border-transparent">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- Filter Status -->
                <div class="flex gap-2 flex-wrap">
                    <button onclick="filterStatus('all')" class="filter-btn active px-4 py-2 rounded-lg text-sm font-medium bg-[#005248] text-white">
                        Semua
                    </button>
                    <button onclick="filterStatus('pending')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Pending
                    </button>
                    <button onclick="filterStatus('approved')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Approved
                    </button>
                    <button onclick="filterStatus('completed')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Completed
                    </button>
                </div>
            </div>
        </div>

        <!-- Card Grid View untuk Janji Temu -->
        <div id="appointmentGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($appointments as $item)
            <div id="{{ Str::slug($item->nama_pasien) }}" 
                 class="appointment-card bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200" 
                 data-status="{{ $item->status }}" 
                 data-name="{{ strtolower($item->nama_pasien) }}" 
                 data-service="{{ strtolower($item->layanan) }}">

                <!-- Header Card -->
                <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-[#005248]/5 to-[#007a6a]/5">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-[#005248] rounded-full flex items-center justify-center text-white font-semibold text-lg">
                                {{ substr($item->nama_pasien, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $item->nama_pasien }}</h3>
                                <p class="text-xs text-gray-500">ID: #{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            @if($item->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($item->status == 'approved') bg-green-100 text-green-800
                            @elseif($item->status == 'completed') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>
                </div>

                <!-- Body Card -->
                <div class="p-4 space-y-3">
                    <!-- Layanan -->
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#005248]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500">Layanan</p>
                            <p class="text-sm font-medium text-gray-800">{{ $item->layanan }}</p>
                        </div>
                    </div>

                    <!-- Tanggal -->
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#005248]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500">Tanggal & Waktu</p>
                            <p class="text-sm font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }} - {{ $item->waktu }}
                            </p>
                        </div>
                    </div>

                    <!-- Keluhan (jika ada) -->
                    @if($item->keluhan)
                    <div class="pt-2 border-t border-gray-100">
                        <p class="text-xs text-gray-500 mb-1">Keluhan</p>
                        <p class="text-sm text-gray-700 line-clamp-2">{{ $item->keluhan }}</p>
                    </div>
                    @endif
                </div>

                <!-- Footer Card -->
                <div class="p-4 border-t border-gray-100 bg-gray-50">
                    <a href="{{ route('dokter.janji-temu.show', $item->id) }}" 
                       class="block w-full text-center px-4 py-2 bg-[#005248] text-white rounded-lg hover:bg-[#007a6a] transition-colors font-medium text-sm">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum Ada Janji Temu</h3>
                    <p class="text-gray-500 text-sm">Janji temu dari pasien akan muncul di sini</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- No Results Message -->
        <div id="noResults" class="hidden bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Tidak Ada Hasil</h3>
            <p class="text-gray-500 text-sm">Coba gunakan kata kunci atau filter yang berbeda</p>
        </div>

    </div>

    <!-- JavaScript for Search and Filter -->
    <script>
        let currentFilter = 'all';

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            filterAppointments(searchTerm, currentFilter);
        });

        // Filter status functionality
        function filterStatus(status) {
            currentFilter = status;
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            
            // Update button styles
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active', 'bg-[#005248]', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            });
            event.target.classList.add('active', 'bg-[#005248]', 'text-white');
            event.target.classList.remove('bg-gray-100', 'text-gray-700');
            
            filterAppointments(searchTerm, status);
        }

        function filterAppointments(searchTerm, status) {
            const cards = document.querySelectorAll('.appointment-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const name = card.dataset.name;
                const service = card.dataset.service;
                const cardStatus = card.dataset.status;

                const matchesSearch = name.includes(searchTerm) || service.includes(searchTerm);
                const matchesStatus = status === 'all' || cardStatus === status;

                if (matchesSearch && matchesStatus) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide no results message
            const noResults = document.getElementById('noResults');
            const grid = document.getElementById('appointmentGrid');
            
            if (visibleCount === 0) {
                noResults.classList.remove('hidden');
                grid.classList.add('hidden');
            } else {
                noResults.classList.add('hidden');
                grid.classList.remove('hidden');
            }
        }
    </script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-app-layout>
