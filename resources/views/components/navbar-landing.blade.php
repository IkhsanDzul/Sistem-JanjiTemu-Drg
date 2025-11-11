<nav class="bg-[#005248] px-6 py-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <!-- Logo dan Teks -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded flex items-center justify-center">
                <span class="text-[#005248] font-bold text-lg">DT</span>
            </div>
            <span class="text-white text-xl font-semibold">DentaTime</span>
        </div>

        <!-- Menu Tengah -->
        <div class="hidden md:flex items-center gap-6">
            <a href="#kontak" class="text-white hover:text-[#FFA700] transition-colors">Kontak</a>
            <a href="#tentang-kami" class="text-white hover:text-[#FFA700] transition-colors">Tentang Kami</a>
        </div>

        <!-- Tombol Login dan Register -->
        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('check') }}" class="px-4 py-2 text-white border border-white rounded hover:bg-white hover:text-[#005248] transition-colors">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 text-white border border-white rounded hover:bg-white hover:text-[#005248] transition-colors">
                    Masuk
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-[#FFA700] text-white rounded hover:bg-[#FFB733] transition-colors">
                        Daftar
                    </a>
                @endif
            @endauth
        </div>
    </div>
</nav>

