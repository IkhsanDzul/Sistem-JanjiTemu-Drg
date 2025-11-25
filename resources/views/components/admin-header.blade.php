@props(['title' => 'Dashboard', 'subtitle' => null])

@php
    // Determine subtitle based on route if not provided
    if ($subtitle === null) {
        $routeName = request()->route()->getName();
        
        $subtitleMap = [
            'admin.dashboard' => 'Halaman Utama',
            'admin.pasien.index' => 'Kelola data pasien yang terdaftar di sistem',
            'admin.pasien.create' => 'Tambah data pasien baru ke dalam sistem',
            'admin.pasien.show' => 'Detail informasi pasien',
            'admin.pasien.edit' => 'Edit data pasien yang terdaftar',
            'admin.dokter.index' => 'Kelola data dokter yang terdaftar di sistem',
            'admin.dokter.create' => 'Tambah data dokter baru ke dalam sistem',
            'admin.dokter.show' => 'Detail informasi dokter',
            'admin.dokter.edit' => 'Edit data dokter yang terdaftar',
            'admin.janji-temu.index' => 'Kelola janji temu pasien dengan dokter',
            'admin.janji-temu.show' => 'Detail informasi janji temu',
            'admin.rekam-medis.index' => 'Kelola rekam medis pasien',
            'admin.rekam-medis.show' => 'Detail rekam medis pasien',
            'admin.rekam-medis.edit' => 'Edit rekam medis pasien',
            'admin.resep-obat.index' => 'Kelola resep obat pasien',
            'admin.resep-obat.show' => 'Detail resep obat pasien',
            'admin.jadwal-praktek.index' => 'Kelola jadwal praktek dokter',
            'admin.jadwal-praktek.create' => 'Tambah jadwal praktek baru',
            'admin.jadwal-praktek.edit' => 'Edit jadwal praktek dokter',
            'admin.laporan.index' => 'Laporan dan rekapitulasi data sistem',
            'admin.laporan.pasien' => 'Laporan jumlah pasien terdaftar',
            'admin.laporan.dokter-aktif' => 'Laporan daftar dokter aktif',
            'admin.laporan.jadwal-kunjungan' => 'Laporan jadwal kunjungan pasien',
        ];
        
        $subtitle = $subtitleMap[$routeName] ?? 'Halaman Utama';
    }
@endphp

<header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-40">
    <div class="px-6 py-4 flex items-center justify-between">
        <!-- Mobile Menu Button -->
        <button @click="$dispatch('toggle-sidebar')" class="lg:hidden p-2 text-gray-600 hover:text-[#005248] hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Page Title -->
        <div class="flex-1 ml-4 lg:ml-0">
            <h1 class="text-2xl font-bold text-gray-900">{{ $title }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $subtitle }}</p>
        </div>

        <!-- Right Side - Notifications, Profile, Date/Time -->
        <div class="flex items-center gap-4">
            <!-- Profile/User Menu -->
            <div x-data="{ open: false }" class="flex items-center gap-2 p-2 text-gray-600 rounded-lg transition-colors">
                <div class="w-8 h-8 bg-[#005248] rounded-full flex items-center justify-center">
                    <span class="text-white font-semibold text-sm">
                        {{ strtoupper(substr(Auth::user()->nama_lengkap ?? 'A', 0, 1)) }}
                    </span>
                </div>
            </div>

            <!-- Date and Time -->
            <div class="hidden md:block text-right border-l border-gray-200 pl-4">
                <p class="text-sm font-medium text-gray-900" id="current-date">{{ now()->format('d F Y') }}</p>
                <p class="text-xs text-gray-500" id="current-time">{{ now()->format('H:i') }}</p>
            </div>
        </div>
    </div>
</header>

<script>
    // Update time every minute
    function updateTime() {
        const now = new Date();
        const dateOptions = {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        };
        const timeOptions = {
            hour: '2-digit',
            minute: '2-digit'
        };

        document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', dateOptions);
        document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', timeOptions);
    }

    // Update immediately and then every minute
    updateTime();
    setInterval(updateTime, 60000);
</script>