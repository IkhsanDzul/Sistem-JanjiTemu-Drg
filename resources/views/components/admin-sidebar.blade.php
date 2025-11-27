@props([])

<div x-data="{ open: false }"
    @toggle-sidebar.window="open = !open"
    x-init="
       $watch('open', value => {
         try {
           const body = $el.ownerDocument.body;
           if (value) {
             body.style.overflow = 'hidden';
           } else {
             body.style.overflow = '';
           }
         } catch(e) {
           console.error('Error setting body overflow:', e);
         }
       });
     ">
    <aside :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="w-64 bg-[#005248] flex flex-col h-screen fixed left-0 top-0 z-50 transition-transform duration-300 ease-in-out">
        <!-- Logo Section -->
        <div class="p-6 border-b border-[#005248]/50">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center">
                        <img src="{{ asset('images/gigi.png') }}" alt="Logo DentaTime" class="w-12 h-12 object-contain" />
                    </div>
                    <span class="text-white text-xl font-semibold">DentaTime</span>
                </div>
                <!-- Close button for mobile -->
                <button @click="open = false" class="lg:hidden text-white hover:text-[#FFA700]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto py-4">
            <ul class="space-y-1 px-3">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-[#005248]/80 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#FFA700] text-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>
                </li>

                <!-- Janji Temu -->
                <li>
                    <a href="{{ route('admin.janji-temu.index') }}"
                        class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-[#005248]/80 transition-colors {{ request()->routeIs('admin.janji-temu.*') ? 'bg-[#FFA700] text-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-medium">Janji Temu</span>
                    </a>
                </li>

                <!-- Manajemen Pasien -->
                <li>
                    <a href="{{ route('admin.pasien.index') }}"
                        class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-[#005248]/80 transition-colors {{ request()->routeIs('admin.pasien.*') ? 'bg-[#FFA700] text-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="font-medium">Manajemen Pasien</span>
                    </a>
                </li>

                <!-- Manajemen Dokter -->
                <li>
                    <a href="{{ route('admin.dokter.index') }}"
                        class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-[#005248]/80 transition-colors {{ request()->routeIs('admin.dokter.*') ? 'bg-[#FFA700] text-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-medium">Manajemen Dokter</span>
                    </a>
                </li>

                <!-- Rekam Medis -->
                <li>
                    <a href="{{ route('admin.rekam-medis.index') }}"
                        class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-[#005248]/80 transition-colors {{ request()->routeIs('admin.rekam-medis.*') ? 'bg-[#FFA700] text-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="font-medium">Rekam Medis</span>
                    </a>
                </li>

                <!-- Resep Obat -->
                <li>
                    <a href="{{ route('admin.resep-obat.index') }}"
                        class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-[#005248]/80 transition-colors {{ request()->routeIs('admin.resep-obat.*') ? 'bg-[#FFA700] text-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                        <span class="font-medium">Resep Obat</span>
                    </a>
                </li>

                <!-- Laporan -->
                <li>
                    <a href="{{ route('admin.laporan.index') }}"
                        class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-[#005248]/80 transition-colors {{ request()->routeIs('admin.laporan.*') ? 'bg-[#FFA700] text-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="font-medium">Laporan</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Bottom Section -->
        <div class="border-t border-[#005248]/50 p-4">
            <a href="{{ route('profile.edit') }}"
                class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-[#005248]/80 transition-colors mb-2 {{ request()->routeIs('profile.edit') ? 'bg-[#FFA700] text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="font-medium">Profile</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center px-4 py-3 text-white rounded-lg hover:bg-red-600/20 transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span class="font-medium">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div x-show="open"
        x-cloak
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="open = false"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 lg:hidden"></div>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>