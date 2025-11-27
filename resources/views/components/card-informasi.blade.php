<section class="bg-gray-50 py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12" x-data="{ loaded: false }" x-intersect="loaded = true">
            <div x-show="loaded" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0">
                <h2 class="text-3xl lg:text-4xl font-bold text-[#005248] mb-4">
                    Mengapa Pilih DentaTime?
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                    Platform terpercaya untuk perawatan gigi Anda dengan berbagai keunggulan yang membuat pengalaman lebih mudah dan nyaman
                </p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $features = [
                    [
                        'icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z',
                        'title' => 'Booking Online 24/7',
                        'description' => 'Buat janji temu kapan saja, di mana saja. Sistem kami tersedia 24 jam sehari untuk kenyamanan Anda.',
                        'color' => 'bg-blue-500'
                    ],
                    [
                        'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                        'title' => 'Dokter Terpercaya',
                        'description' => 'Tim dokter gigi profesional dan berpengalaman siap memberikan perawatan terbaik untuk kesehatan gigi Anda.',
                        'color' => 'bg-green-500'
                    ],
                    [
                        'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                        'title' => 'Harga Transparan',
                        'description' => 'Tidak ada biaya tersembunyi. Semua harga layanan ditampilkan dengan jelas sebelum Anda membuat janji temu.',
                        'color' => 'bg-[#FFA700]'
                    ],
                    [
                        'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
                        'title' => 'Rekam Medis Digital',
                        'description' => 'Akses rekam medis Anda kapan saja secara digital. Riwayat perawatan tersimpan dengan aman dan mudah diakses.',
                        'color' => 'bg-purple-500'
                    ],
                    [
                        'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                        'title' => 'Notifikasi Otomatis',
                        'description' => 'Dapatkan pengingat janji temu melalui email dan SMS. Tidak akan melewatkan jadwal perawatan Anda.',
                        'color' => 'bg-pink-500'
                    ],
                    [
                        'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
                        'title' => 'Keamanan Data',
                        'description' => 'Data pribadi dan medis Anda dilindungi dengan enkripsi SSL dan standar keamanan kesehatan internasional.',
                        'color' => 'bg-indigo-500'
                    ]
                ];
            @endphp

            @foreach($features as $index => $feature)
                <div x-data="{ loaded: false }" 
                     x-intersect="loaded = true"
                     class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div x-show="loaded" 
                         x-transition:enter="transition ease-out duration-1000"
                         x-transition:enter-start="opacity-0 translate-y-10"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         :style="'transition-delay: {{ $index * 200 }}ms'">
                        <!-- Icon -->
                        <div class="p-6 pb-4">
                            <div class="w-16 h-16 {{ $feature['color'] }} rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="p-6 pt-0">
                            <h3 class="text-xl font-bold text-gray-900 mb-3">
                                {{ $feature['title'] }}
                            </h3>
                            <p class="text-gray-600 mb-4 leading-relaxed">
                                {{ $feature['description'] }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

