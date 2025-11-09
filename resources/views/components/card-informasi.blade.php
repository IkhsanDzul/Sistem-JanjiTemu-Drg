<section class="bg-white py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-[#FFA700] mb-4">
                Berapa Nilai Prototipe Cepat untuk Anda?
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto text-base">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @for($i = 1; $i <= 3; $i++)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
                    <!-- Placeholder Gambar -->
                    <div class="w-full h-48 bg-[#FFA700] flex items-center justify-center">
                        <span class="text-white font-semibold">Gambar {{ $i }}</span>
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            Lorem ipsum dolor sit amet
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                        <a href="#" class="inline-block px-4 py-2 bg-[#FFA700] text-white rounded hover:bg-[#FFB733] transition-colors">
                            Tombol CTA
                        </a>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>

