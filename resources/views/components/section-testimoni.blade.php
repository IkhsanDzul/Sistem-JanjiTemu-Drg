<section class="bg-white py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-[#FFA700] mb-4">
                Berapa Nilai Prototipe Cepat untuk Anda??
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto text-base">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @php
                $testimoni = [
                    ['nama' => 'Danny Postma', 'jabatan' => 'Marketing Consultant @ Landingloka', 'perusahaan' => 'SpaceCube'],
                    ['nama' => 'Sarah Johnson', 'jabatan' => 'Business Owner', 'perusahaan' => 'TechStart'],
                    ['nama' => 'Michael Chen', 'jabatan' => 'Software Engineer', 'perusahaan' => 'DevCorp'],
                ];
            @endphp

            @foreach($testimoni as $item)
                <div class="bg-white rounded-lg p-6 shadow-lg border border-gray-200">
                    <!-- Placeholder Gambar -->
                    <div class="w-full h-32 bg-[#FFA700] rounded-lg mb-4 flex items-center justify-center">
                        <span class="text-white font-semibold">{{ $item['perusahaan'] }}</span>
                    </div>
                    
                    <p class="text-gray-600 mb-4 italic">
                        "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation."
                    </p>
                    
                    <div class="border-t border-gray-200 pt-4">
                        <p class="font-semibold text-gray-900">{{ $item['nama'] }}</p>
                        <p class="text-sm text-gray-600">{{ $item['jabatan'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

