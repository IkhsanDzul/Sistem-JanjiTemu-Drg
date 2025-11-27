<section id="layanan" class="bg-white py-16 lg:py-24 scroll-mt-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12" x-data="{ loaded: false }" x-intersect="loaded = true">
            <div x-show="loaded" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0">
                <h2 class="text-3xl lg:text-4xl font-bold text-[#005248] mb-4">
                    Layanan Kami
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                    Berbagai layanan kesehatan gigi profesional yang dapat Anda nikmati di DentaTime
                </p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $layanan = [
                    [
                        'judul' => 'Konsultasi Gigi',
                        'deskripsi' => 'Konsultasi dengan dokter gigi profesional untuk masalah kesehatan gigi Anda',
                        'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                    [
                        'judul' => 'Pembersihan Gigi',
                        'deskripsi' => 'Layanan pembersihan gigi profesional untuk menjaga kesehatan mulut',
                        'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'
                    ],
                    [
                        'judul' => 'Perawatan Ortodontik',
                        'deskripsi' => 'Perawatan untuk memperbaiki posisi gigi dan rahang',
                        'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                    [
                        'judul' => 'Pencabutan Gigi',
                        'deskripsi' => 'Layanan pencabutan gigi yang aman dan nyaman',
                        'icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4'
                    ],
                    [
                        'judul' => 'Perawatan Saluran Akar',
                        'deskripsi' => 'Perawatan untuk mengatasi masalah pada saluran akar gigi',
                        'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'
                    ],
                    [
                        'judul' => 'Pemasangan Crown',
                        'deskripsi' => 'Pemasangan mahkota gigi untuk memperbaiki bentuk dan fungsi gigi',
                        'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z'
                    ],
                ];
            @endphp

            @foreach($layanan as $index => $item)
                <div x-data="{ loaded: false, hovered: false }" 
                     x-intersect="loaded = true"
                     @mouseenter="hovered = true"
                     @mouseleave="hovered = false"
                     class="bg-white rounded-xl p-6 shadow-md border border-gray-100 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105 group cursor-pointer">
                    <div x-show="loaded" 
                         x-transition:enter="transition ease-out duration-1000"
                         x-transition:enter-start="opacity-0 translate-y-10"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         :style="'transition-delay: {{ $index * 100 }}ms'">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#FFA700] to-[#FFB733] rounded-xl flex items-center justify-center mb-4 shadow-lg transform transition-all duration-300 group-hover:scale-110 group-hover:rotate-3">
                            <svg class="w-8 h-8 text-white transform transition-transform duration-300" :class="{'scale-110': hovered}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-[#005248] transition-colors">
                            {{ $item['judul'] }}
                        </h3>
                        <p class="text-gray-600 leading-relaxed group-hover:text-gray-700 transition-colors">
                            {{ $item['deskripsi'] }}
                        </p>
                        <div class="mt-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="text-[#FFA700] font-semibold text-sm flex items-center gap-2">
                                Pelajari lebih lanjut
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

