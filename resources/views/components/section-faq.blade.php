<section id="tentang-kami" class="bg-white py-16 lg:py-24 scroll-mt-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Konten Kiri -->
            <div x-data="{ loaded: false }" x-intersect="loaded = true">
                <div x-show="loaded" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0">
                    <h2 class="text-3xl lg:text-4xl font-bold text-[#005248] mb-6">
                        Pertanyaan yang Sering Diajukan
                    </h2>
                    <p class="text-gray-600 mb-8 text-lg leading-relaxed">
                        Temukan jawaban untuk pertanyaan umum tentang DentaTime dan cara menggunakan platform kami
                    </p>
                    <div class="space-y-3 mb-8">
                        <a href="#faq-umum" class="block px-4 py-2 text-[#005248] hover:bg-[#005248] hover:text-white rounded-lg transition-all duration-300 font-medium">UMUM</a>
                        <a href="#faq-keamanan" class="block px-4 py-2 text-[#005248] hover:bg-[#005248] hover:text-white rounded-lg transition-all duration-300 font-medium">KEAMANAN & PRIVASI</a>
                        <a href="#faq-akun" class="block px-4 py-2 text-[#005248] hover:bg-[#005248] hover:text-white rounded-lg transition-all duration-300 font-medium">PENGATURAN AKUN</a>
                        <a href="#faq-pembayaran" class="block px-4 py-2 text-[#005248] hover:bg-[#005248] hover:text-white rounded-lg transition-all duration-300 font-medium">PEMBAYARAN</a>
                        <a href="#faq-harga" class="block px-4 py-2 text-[#005248] hover:bg-[#005248] hover:text-white rounded-lg transition-all duration-300 font-medium">HARGA</a>
                    </div>
                    <div class="bg-gradient-to-br from-[#005248] to-[#003d3a] rounded-xl p-6 text-white">
                        <p class="font-semibold mb-2">Butuh Bantuan Lebih Lanjut?</p>
                        <p class="text-sm text-gray-200 mb-4">Hubungi tim support kami</p>
                        <a href="tel:080012345678" class="inline-block px-4 py-2 bg-[#FFA700] text-white rounded-lg hover:bg-[#FFB733] transition-colors font-medium">
                            📞 0800 1234 5678
                        </a>
                    </div>
                </div>
            </div>

            <!-- FAQ Accordion Kanan -->
            <div class="space-y-4" x-data="{ loaded: false }" x-intersect="loaded = true">
                <div x-show="loaded" x-transition:enter="transition ease-out duration-1000 delay-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0">
                    @php
                        $faqs = [
                            [
                                'pertanyaan' => 'Bagaimana cara membuat janji temu?',
                                'jawaban' => 'Anda dapat membuat janji temu dengan mudah melalui website DentaTime. Klik tombol "Daftar" untuk membuat akun, lalu pilih dokter dan waktu yang tersedia. Setelah itu, isi form keluhan dan konfirmasi booking Anda.'
                            ],
                            [
                                'pertanyaan' => 'Apakah saya harus punya akun terlebih dahulu?',
                                'jawaban' => 'Ya, Anda perlu membuat akun terlebih dahulu untuk dapat membuat janji temu. Proses pendaftaran sangat mudah dan cepat, hanya memerlukan beberapa menit saja. Setelah memiliki akun, Anda dapat langsung booking janji temu kapan saja.'
                            ],
                            [
                                'pertanyaan' => 'Berapa biaya untuk konsultasi?',
                                'jawaban' => 'Biaya konsultasi bervariasi tergantung jenis layanan dan dokter yang dipilih. Harga mulai dari Rp 150.000 untuk konsultasi umum. Semua harga ditampilkan dengan jelas sebelum Anda melakukan booking, sehingga tidak ada biaya tersembunyi.'
                            ],
                            [
                                'pertanyaan' => 'Bagaimana cara membatalkan janji temu?',
                                'jawaban' => 'Anda dapat membatalkan janji temu melalui dashboard akun Anda. Masuk ke menu "Janji Temu Saya", pilih janji temu yang ingin dibatalkan, lalu klik tombol "Batalkan". Pembatalan dapat dilakukan minimal 24 jam sebelum waktu janji temu.'
                            ],
                            [
                                'pertanyaan' => 'Apakah data saya aman?',
                                'jawaban' => 'Sangat aman! DentaTime menggunakan enkripsi SSL untuk melindungi semua data pribadi dan medis Anda. Kami mengikuti standar keamanan data kesehatan yang ketat dan tidak akan membagikan informasi Anda kepada pihak ketiga tanpa izin.'
                            ],
                        ];
                    @endphp

                    @foreach($faqs as $index => $faq)
                        <div x-data="{ open: false }" class="border border-gray-200 rounded-xl overflow-hidden bg-white hover:shadow-md transition-shadow">
                            <button @click="open = !open" class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-50 transition-colors">
                                <div class="flex items-center gap-3 flex-1">
                                    <div class="w-8 h-8 bg-[#FFA700] rounded-lg flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-bold text-sm">?</span>
                                    </div>
                                    <span class="font-semibold text-gray-900 text-left">{{ $faq['pertanyaan'] }}</span>
                                </div>
                                <svg class="w-5 h-5 text-gray-500 transform transition-transform flex-shrink-0" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 max-h-0"
                                 x-transition:enter-end="opacity-100 max-h-96"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 max-h-96"
                                 x-transition:leave-end="opacity-0 max-h-0"
                                 class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                                <p class="text-gray-600 leading-relaxed">{{ $faq['jawaban'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

