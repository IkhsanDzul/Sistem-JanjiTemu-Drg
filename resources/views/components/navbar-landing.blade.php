<nav x-data="{ open: false, scrolled: false }" 
     @scroll.window="scrolled = window.pageYOffset > 50"
     :class="scrolled ? 'bg-[#005248] shadow-lg' : 'bg-[#005248]'"
     class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 px-6 py-4 border-b-0">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <!-- Logo dan Teks -->
        <a href="/" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-md">
                <span class="text-[#005248] font-bold text-lg">DT</span>
            </div>
            <span class="text-white text-xl font-semibold">DentaTime</span>
        </a>

        <!-- Menu Tengah -->
        <div class="hidden md:flex items-center gap-6">
            <a href="#layanan" class="text-white hover:text-[#FFA700] transition-colors font-medium">Layanan</a>
            <a href="#tentang-kami" class="text-white hover:text-[#FFA700] transition-colors font-medium">Tentang Kami</a>
            <a href="#kontak" class="text-white hover:text-[#FFA700] transition-colors font-medium">Kontak</a>
        </div>

        <!-- Tombol Login dan Register -->
        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="px-4 py-2 text-white border border-white rounded-lg hover:bg-white hover:text-[#005248] transition-all duration-300 font-medium">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 text-white border border-white rounded-lg hover:bg-white hover:text-[#005248] transition-all duration-300 font-medium">
                    Masuk
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-[#FFA700] text-white rounded-lg hover:bg-[#FFB733] transition-all duration-300 font-medium shadow-md hover:shadow-lg">
                        Daftar
                    </a>
                @endif
            @endauth

            <!-- Mobile Menu Button -->
            <button @click="open = !open" class="md:hidden text-white p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" 
         x-cloak
         x-transition
         class="md:hidden mt-4 pb-4 border-t border-white/20">
        <div class="flex flex-col gap-4 pt-4">
            <a href="#layanan" @click="open = false" class="text-white hover:text-[#FFA700] transition-colors px-4 py-2">Layanan</a>
            <a href="#tentang-kami" @click="open = false" class="text-white hover:text-[#FFA700] transition-colors px-4 py-2">Tentang Kami</a>
            <a href="#kontak" @click="open = false" class="text-white hover:text-[#FFA700] transition-colors px-4 py-2">Kontak</a>
            @auth
                <a href="{{ route('dashboard') }}" @click="open = false" class="text-white hover:text-[#FFA700] transition-colors px-4 py-2">Dashboard</a>
            @else
                <a href="{{ route('login') }}" @click="open = false" class="text-white hover:text-[#FFA700] transition-colors px-4 py-2">Masuk</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" @click="open = false" class="text-white hover:text-[#FFA700] transition-colors px-4 py-2">Daftar</a>
                @endif
            @endauth
        </div>
    </div>
</nav>

