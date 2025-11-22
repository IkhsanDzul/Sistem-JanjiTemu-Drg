@props([])

<aside x-data="{ open: false }"
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
      "
    class="flex">
    <aside
        :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="w-64 bg-[#005248] flex flex-col h-screen fixed left-0 top-0 z-[60] transition-transform duration-300 ease-in-out">

        <!-- Logo Section -->
        <div class="p-6 border-b border-[#005248]/50">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <span class="text-[#005248] font-bold text-lg">DT</span>
                    </div>
                    <span class="text-white text-xl font-semibold">DentaTime</span>
                </div>
                <!-- Close button for mobile -->
                <button @click="open = false" class="lg:hidden text-white hover:text-[#FFA700]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto py-4">
            <ul class="space-y-1 px-3">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('pasien.dashboard') }}"
                        class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-[#005248]/80 transition-colors {{ request()->routeIs('pasien.dashboard') ? 'bg-[#FFA700] text-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>
                </li>

                <!-- Janji Temu -->
                <li>
                    <a href="{{ route('pasien.janji-temu') }}"
                        class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-[#005248]/80 transition-colors {{ request()->routeIs('pasien.janji-temu') ? 'bg-[#FFA700] text-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-medium">Janji Temu Saya</span>
                    </a>
                </li>

                <!-- Rekam Medis -->
                <li>
                    <a href="{{ route('pasien.rekam-medis') }}"
                        class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-[#005248]/80 transition-colors {{ request()->routeIs('pasien.rekam-medis') ? 'bg-[#FFA700] text-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="font-medium">Rekam Medis Saya</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Bottom Section -->
        <div class="border-t border-[#005248]/50 p-4">
            <a href="{{ route('profile.edit') }}"
                class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-[#005248]/80 transition-colors mb-2">
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
        class="fixed inset-0 bg-gray-900 bg-opacity-50 z-[55] lg:hidden"></div>
</aside>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>