<section id="layanan" class="bg-white py-16 lg:py-24 scroll-mt-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-[#005248] mb-4">
                Layanan Kami
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Berbagai layanan kesehatan gigi yang dapat Anda nikmati di DentaTime
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $layanan = [
                    ['judul' => 'Konsultasi Gigi', 'deskripsi' => 'Konsultasi dengan dokter gigi profesional untuk masalah kesehatan gigi Anda'],
                    ['judul' => 'Pembersihan Gigi', 'deskripsi' => 'Layanan pembersihan gigi profesional untuk menjaga kesehatan mulut'],
                    ['judul' => 'Perawatan Ortodontik', 'deskripsi' => 'Perawatan untuk memperbaiki posisi gigi dan rahang'],
                    ['judul' => 'Pencabutan Gigi', 'deskripsi' => 'Layanan pencabutan gigi yang aman dan nyaman'],
                    ['judul' => 'Perawatan Saluran Akar', 'deskripsi' => 'Perawatan untuk mengatasi masalah pada saluran akar gigi'],
                    ['judul' => 'Pemasangan Crown', 'deskripsi' => 'Pemasangan mahkota gigi untuk memperbaiki bentuk dan fungsi gigi'],
                ];
            @endphp

            @foreach($layanan as $item)
                <div class="bg-white rounded-lg p-6 shadow-lg border border-gray-200 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-[#FFA700] rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                        {{ $item['judul'] }}
                    </h3>
                    <p class="text-gray-600">
                        {{ $item['deskripsi'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>

