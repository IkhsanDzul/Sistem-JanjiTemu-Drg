<section class="bg-gradient-to-br from-[#005248] to-[#003d3a] relative overflow-hidden pt-20">
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-[#FFA700]/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#FFA700]/10 rounded-full blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-6 py-20 lg:py-32 relative z-10">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <!-- Konten Kiri -->
            <div class="text-white" x-data="{ loaded: false }" x-intersect="loaded = true">
                <div x-show="loaded" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0">
                    <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                        Buat Janji Temu Dokter Gigi yang <span class="text-[#FFA700]">Mudah</span> dan Terpercaya
                    </h1>
                    <p class="text-lg lg:text-xl mb-8 text-gray-200 leading-relaxed">
                        Sistem manajemen janji temu dokter gigi yang modern dan terpercaya. Dapatkan perawatan gigi terbaik dengan kemudahan booking online 24/7.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-[#FFA700] text-white rounded-lg font-semibold hover:bg-[#FFB733] transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Buat Janji Temu Sekarang
                        </a>
                        <a href="#tentang-kami" class="px-8 py-4 bg-transparent border-2 border-white text-white rounded-lg font-semibold hover:bg-white hover:text-[#005248] transition-all duration-300 text-center">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 mt-12 pt-8 border-t border-white/20">
                        <div>
                            <p class="text-3xl font-bold text-[#FFA700]">100+</p>
                            <p class="text-sm text-gray-300">Dokter Profesional</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-[#FFA700]">5000+</p>
                            <p class="text-sm text-gray-300">Pasien Puas</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-[#FFA700]">24/7</p>
                            <p class="text-sm text-gray-300">Layanan Online</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ilustrasi Kanan -->
            <div class="hidden md:block" x-data="{ loaded: false }" x-intersect="loaded = true">
                <div x-show="loaded" x-transition:enter="transition ease-out duration-1000 delay-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="relative">
                        <div class="w-full h-96 bg-gradient-to-br from-white/10 to-white/5 rounded-2xl backdrop-blur-sm border border-white/20 flex items-center justify-center p-8">
                            <svg class="w-full h-full text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <!-- Floating Elements -->
                        <div class="absolute -top-4 -right-4 w-20 h-20 bg-[#FFA700] rounded-full opacity-80 animate-pulse"></div>
                        <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-white/20 rounded-full animate-pulse delay-300"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Gelombang Pemisah -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-0 pointer-events-none">
        <svg class="relative block w-full h-20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" preserveAspectRatio="none">
            <path fill="white" d="M0,0 C360,80 1080,80 1440,0 L1440,80 L0,80 Z"></path>
        </svg>
    </div>
</section>

