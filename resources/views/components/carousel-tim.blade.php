<section class="bg-gradient-to-br from-[#FFA700] to-[#FFB733] py-16 lg:py-24 relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl" style="animation-delay: 1s;"></div>
    
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center mb-12" x-data="{ loaded: false }" x-intersect="loaded = true">
            <div x-show="loaded" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0">
                <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4 drop-shadow-lg">
                    Tim Profesional Kami
                </h2>
                <p class="text-white/90 max-w-2xl mx-auto text-lg">
                    Dokter gigi berpengalaman dan terpercaya siap memberikan perawatan terbaik untuk Anda
                </p>
            </div>
        </div>

        <div class="relative" x-data="{ loaded: false }" x-intersect="loaded = true">
            <div x-show="loaded" x-transition:enter="transition ease-out duration-1000 delay-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <!-- Navigation Arrows (Desktop) -->
                <div class="hidden lg:flex items-center justify-between absolute left-0 right-0 top-1/2 -translate-y-1/2 z-20 pointer-events-none">
                    <button onclick="scrollCarousel('left')" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-full p-3 text-white transition-all duration-300 hover:scale-110 pointer-events-auto shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button onclick="scrollCarousel('right')" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-full p-3 text-white transition-all duration-300 hover:scale-110 pointer-events-auto shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>

                <div class="flex gap-6 lg:gap-8 overflow-x-auto pb-4 scrollbar-hide snap-x snap-mandatory px-4 lg:px-0" id="carousel-tim">
                    @php
                        $tim = [
                            ['nama' => 'Dr. Sarah Wijaya', 'spesialis' => 'Spesialis Ortodontik', 'foto' => 'dokter1.png'],
                            ['nama' => 'Dr. Budi Santoso', 'spesialis' => 'Spesialis Endodontik', 'foto' => 'dokter2.png'],
                            ['nama' => 'Dr. Maya Sari', 'spesialis' => 'Spesialis Periodontik', 'foto' => 'dokter3.png'],
                        ];
                    @endphp
                    
                    @foreach($tim as $index => $member)
                        <div class="flex-shrink-0 w-72 lg:w-80 text-center snap-center group">
                            <!-- Card Container -->
                            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 lg:p-8 shadow-2xl border border-white/20 transform transition-all duration-500 hover:scale-105 hover:bg-white/20 hover:shadow-3xl">
                                <!-- Photo Container -->
                                <div class="relative mb-6">
                                    <div class="w-48 h-48 lg:w-56 lg:h-56 mx-auto rounded-full bg-gradient-to-br from-white to-white/80 p-1 shadow-2xl transform transition-all duration-500 group-hover:scale-110 group-hover:rotate-3">
                                        <div class="w-full h-full rounded-full overflow-hidden border-4 border-white shadow-inner">
                                            @if(isset($member['foto']))
                                                <img src="{{ asset('images/' . $member['foto']) }}" 
                                                     alt="{{ $member['nama'] }}" 
                                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-[#FFA700] to-[#FFB733] flex items-center justify-center">
                                                    <span class="text-white text-5xl font-bold">{{ $member['avatar'] ?? 'DR' }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Info Container -->
                                <div class="space-y-2 transform transition-all duration-500 group-hover:translate-y-[-8px]">
                                    <h3 class="text-white font-bold text-xl lg:text-2xl mb-2 drop-shadow-lg">
                                        {{ $member['nama'] }}
                                    </h3>
                                    <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full border border-white/30">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                        </svg>
                                        <p class="text-white font-medium text-sm lg:text-base">{{ $member['spesialis'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Scroll Indicator (Mobile) -->
                <div class="flex justify-center gap-2 mt-6 lg:hidden">
                    @php
                        $totalMembers = count($tim);
                    @endphp
                    @for($i = 0; $i < $totalMembers; $i++)
                        <div class="w-2 h-2 rounded-full bg-white/40 transition-all duration-300" id="indicator-{{ $i }}"></div>
                    @endfor
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
    .shadow-3xl {
        box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
    }
</style>

<script>
    function scrollCarousel(direction) {
        const carousel = document.getElementById('carousel-tim');
        const scrollAmount = 320; // Width of card + gap
        
        if (direction === 'left') {
            carousel.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        } else {
            carousel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
    }

    // Update scroll indicators on mobile
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.getElementById('carousel-tim');
        if (carousel) {
            const totalMembers = 3; // Total number of doctors
            carousel.addEventListener('scroll', function() {
                const scrollLeft = carousel.scrollLeft;
                const cardWidth = 288; // w-72 = 18rem = 288px
                const gap = 24; // gap-6 = 1.5rem = 24px
                const totalWidth = cardWidth + gap;
                const currentIndex = Math.round(scrollLeft / totalWidth);
                
                // Update indicators
                for (let i = 0; i < totalMembers; i++) {
                    const indicator = document.getElementById('indicator-' + i);
                    if (indicator) {
                        if (i === currentIndex) {
                            indicator.classList.remove('bg-white/40', 'w-2');
                            indicator.classList.add('bg-white', 'w-6');
                        } else {
                            indicator.classList.remove('bg-white', 'w-6');
                            indicator.classList.add('bg-white/40', 'w-2');
                        }
                    }
                }
            });
        }
    });
</script>

