<section class="bg-gradient-to-br from-[#FFA700] to-[#FFB733] py-16 lg:py-24 relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center mb-12" x-data="{ loaded: false }" x-intersect="loaded = true">
            <div x-show="loaded" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0">
                <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">
                    Tim Profesional Kami
                </h2>
                <p class="text-white/90 max-w-2xl mx-auto text-lg">
                    Dokter gigi berpengalaman dan terpercaya siap memberikan perawatan terbaik untuk Anda
                </p>
            </div>
        </div>

        <div class="relative" x-data="{ loaded: false }" x-intersect="loaded = true">
            <div x-show="loaded" x-transition:enter="transition ease-out duration-1000 delay-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <div class="flex gap-6 overflow-x-auto pb-4 scrollbar-hide snap-x snap-mandatory" id="carousel-tim">
                    @php
                        $tim = [
                            ['nama' => 'Dr. Sarah Wijaya', 'spesialis' => 'Spesialis Ortodontik', 'avatar' => 'SW'],
                            ['nama' => 'Dr. Budi Santoso', 'spesialis' => 'Spesialis Endodontik', 'avatar' => 'BS'],
                            ['nama' => 'Dr. Maya Sari', 'spesialis' => 'Spesialis Periodontik', 'avatar' => 'MS'],
                            ['nama' => 'Dr. Ahmad Rizki', 'spesialis' => 'Spesialis Prosthodontik', 'avatar' => 'AR'],
                            ['nama' => 'Dr. Indah Permata', 'spesialis' => 'Spesialis Bedah Mulut', 'avatar' => 'IP'],
                        ];
                    @endphp
                    
                    @foreach($tim as $index => $member)
                        <div class="flex-shrink-0 w-64 text-center snap-center">
                            <div class="w-48 h-48 mx-auto rounded-full bg-white mb-4 flex items-center justify-center shadow-xl border-4 border-white/50 transform hover:scale-105 transition-transform duration-300">
                                <span class="text-[#FFA700] text-4xl font-bold">{{ $member['avatar'] }}</span>
                            </div>
                            <h3 class="text-white font-semibold text-lg mb-1">
                                {{ $member['nama'] }}
                            </h3>
                            <p class="text-white/90 text-sm">{{ $member['spesialis'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .snap-x {
        scroll-snap-type: x mandatory;
    }
    .snap-center {
        scroll-snap-align: center;
    }
</style>

