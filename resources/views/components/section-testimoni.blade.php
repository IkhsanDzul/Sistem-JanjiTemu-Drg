<section class="bg-gray-50 py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12" x-data="{ loaded: false }" x-intersect="loaded = true">
            <div x-show="loaded" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0">
                <h2 class="text-3xl lg:text-4xl font-bold text-[#005248] mb-4">
                    Apa Kata Pasien Kami?
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                    Testimoni dari pasien yang telah merasakan pelayanan terbaik dari DentaTime
                </p>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @php
                $testimoni = [
                    [
                        'nama' => 'Budi Santoso',
                        'jabatan' => 'Karyawan Swasta',
                        'avatar' => 'BS',
                        'testimoni' => 'Sangat puas dengan pelayanan DentaTime! Booking janji temu sangat mudah, dokter profesional, dan hasil perawatan gigi saya memuaskan. Recommended!'
                    ],
                    [
                        'nama' => 'Siti Nurhaliza',
                        'jabatan' => 'Ibu Rumah Tangga',
                        'avatar' => 'SN',
                        'testimoni' => 'Aplikasi yang sangat membantu! Saya bisa booking untuk seluruh keluarga dengan mudah. Dokter gigi sangat ramah dan perawatannya tidak sakit.'
                    ],
                    [
                        'nama' => 'Ahmad Rizki',
                        'jabatan' => 'Mahasiswa',
                        'avatar' => 'AR',
                        'testimoni' => 'Sebagai mahasiswa, harga yang ditawarkan sangat terjangkau. Proses booking cepat dan sistemnya user-friendly. Pelayanan sangat memuaskan!'
                    ],
                ];
            @endphp

            @foreach($testimoni as $index => $item)
                <div x-data="{ loaded: false }" 
                     x-intersect="loaded = true"
                     class="bg-white rounded-xl p-6 shadow-md border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div x-show="loaded" 
                         x-transition:enter="transition ease-out duration-1000"
                         x-transition:enter-start="opacity-0 translate-y-10"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         :style="'transition-delay: {{ $index * 150 }}ms'">
                        <!-- Rating Stars -->
                        <div class="flex gap-1 mb-4">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 text-[#FFA700]" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endfor
                        </div>
                        
                        <p class="text-gray-600 mb-6 italic leading-relaxed">
                            "{{ $item['testimoni'] }}"
                        </p>
                        
                        <div class="flex items-center gap-4 border-t border-gray-100 pt-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#005248] to-[#003d3a] rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">{{ $item['avatar'] }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $item['nama'] }}</p>
                                <p class="text-sm text-gray-600">{{ $item['jabatan'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

