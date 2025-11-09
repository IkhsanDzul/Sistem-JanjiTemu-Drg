<section id="tentang-kami" class="bg-white py-16 lg:py-24 scroll-mt-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Konten Kiri -->
            <div>
                <h2 class="text-3xl lg:text-4xl font-bold text-[#005248] mb-6">
                    Mulai membuat janji temu
                </h2>
                <div class="space-y-4 mb-8">
                    <a href="#faq-umum" class="block text-[#005248] hover:text-[#FFA700] transition-colors">UMUM</a>
                    <a href="#faq-keamanan" class="block text-[#005248] hover:text-[#FFA700] transition-colors">KEAMANAN & PRIVASI</a>
                    <a href="#faq-akun" class="block text-[#005248] hover:text-[#FFA700] transition-colors">PENGATURAN AKUN</a>
                    <a href="#faq-pembayaran" class="block text-[#005248] hover:text-[#FFA700] transition-colors">PEMBAYARAN</a>
                    <a href="#faq-harga" class="block text-[#005248] hover:text-[#FFA700] transition-colors">HARGA</a>
                </div>
                <p class="text-gray-600">
                    Ada pertanyaan tentang hal lain? Hubungi kami di 0800 1234 5678
                </p>
            </div>

            <!-- FAQ Accordion Kanan -->
            <div class="space-y-4">
                @php
                    $faqs = [
                        ['pertanyaan' => 'Bagaimana cara membuat janji temu?', 'jawaban' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'],
                        ['pertanyaan' => 'Apa saya harus punya akun terlebih dahulu?', 'jawaban' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.'],
                        ['pertanyaan' => 'Berapa biaya untuk konsultasi?', 'jawaban' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'],
                        ['pertanyaan' => 'Bagaimana cara membatalkan janji temu?', 'jawaban' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'],
                    ];
                @endphp

                @foreach($faqs as $index => $faq)
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <button class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-50 transition-colors" onclick="toggleFaq({{ $index }})">
                            <div class="flex items-center gap-3">
                                <span class="text-[#FFA700] font-semibold">?</span>
                                <span class="font-semibold text-gray-900">{{ $faq['pertanyaan'] }}</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" id="icon-{{ $index }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="hidden px-6 py-4 bg-gray-50 border-t border-gray-200" id="jawaban-{{ $index }}">
                            <p class="text-gray-600">{{ $faq['jawaban'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<script>
    function toggleFaq(index) {
        const jawaban = document.getElementById('jawaban-' + index);
        const icon = document.getElementById('icon-' + index);
        
        if (jawaban.classList.contains('hidden')) {
            jawaban.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            jawaban.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }
</script>

