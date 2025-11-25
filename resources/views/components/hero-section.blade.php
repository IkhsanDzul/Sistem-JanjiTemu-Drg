<section class="bg-gradient-to-br from-[#005248] to-[#003d3a] relative overflow-hidden pt-16">
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-[#FFA700]/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#FFA700]/10 rounded-full blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-6 py-12 lg:py-20 relative z-10">
        <div class="grid md:grid-cols-2 gap-8 lg:gap-16 items-center">
            <!-- Konten Kiri -->
            <div class="text-white" x-data="{ loaded: false }" x-intersect="loaded = true">
                <div x-show="loaded" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0">
                    <h1 class="text-3xl lg:text-5xl xl:text-6xl font-bold mb-6 leading-tight">
                        Buat Janji Temu Dokter Gigi yang <span class="text-[#FFA700] relative inline-block">
                            <span class="relative z-10">Mudah</span>
                            <span class="absolute bottom-2 left-0 right-0 h-3 bg-[#FFA700]/20 -rotate-1 transform"></span>
                        </span> dan Terpercaya
                    </h1>
                    <p class="text-lg lg:text-xl mb-8 text-gray-200 leading-relaxed">
                        Sistem manajemen janji temu dokter gigi yang modern dan terpercaya. Dapatkan perawatan gigi terbaik dengan kemudahan booking online 24/7.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 mb-8">
                        <a href="{{ route('register') }}" class="group relative px-8 py-4 bg-[#FFA700] text-white rounded-xl font-semibold hover:bg-[#FFB733] transition-all duration-300 text-center shadow-lg hover:shadow-2xl transform hover:-translate-y-1 overflow-hidden">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                Buat Janji Temu Sekarang
                                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-[#FFB733] to-[#FFA700] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                        <a href="#tentang-kami" onclick="event.preventDefault(); document.querySelector('#tentang-kami').scrollIntoView({behavior: 'smooth'});" class="px-8 py-4 bg-white/10 backdrop-blur-sm border-2 border-white/50 text-white rounded-xl font-semibold hover:bg-white hover:text-[#005248] transition-all duration-300 text-center hover:border-white hover:shadow-lg">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 mt-12 pt-8 border-t border-white/20" 
                         x-data="{ 
                             doctors: 0, 
                             patients: 0, 
                             animated: false,
                             init() {
                                 this.$watch('animated', value => {
                                     if (value && this.doctors === 0) {
                                         this.animateCounter(0, 100, 2000, (val) => { this.doctors = val; });
                                         this.animateCounter(0, 5000, 2000, (val) => { this.patients = val; });
                                     }
                                 });
                             },
                             animateCounter(start, end, duration, callback) {
                                 const startTime = performance.now();
                                 const animate = (currentTime) => {
                                     const elapsed = currentTime - startTime;
                                     const progress = Math.min(elapsed / duration, 1);
                                     const current = start + (end - start) * progress;
                                     callback(current);
                                     if (progress < 1) {
                                         requestAnimationFrame(animate);
                                     }
                                 };
                                 requestAnimationFrame(animate);
                             }
                         }" 
                         x-intersect="animated = true">
                        <div>
                            <p class="text-3xl font-bold text-[#FFA700]" x-text="Math.floor(doctors) + '+'">0+</p>
                            <p class="text-sm text-gray-300">Dokter Profesional</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-[#FFA700]" x-text="Math.floor(patients) + '+'">0+</p>
                            <p class="text-sm text-gray-300">Pasien Puas</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-[#FFA700]">24/7</p>
                            <p class="text-sm text-gray-300">Layanan Online</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ilustrasi Kanan -->
            <div class="hidden md:block relative" x-data="{ loaded: false }" x-intersect="loaded = true">
                <div x-show="loaded" x-transition:enter="transition ease-out duration-1000 delay-300" x-transition:enter-start="opacity-0 translate-x-10 scale-95" x-transition:enter-end="opacity-100 translate-x-0 scale-100">
                    <!-- Main Image Container dengan Frame Modern -->
                    <div class="relative z-10">
                        <!-- Decorative Background Shape -->
                        <div class="absolute inset-0 bg-gradient-to-br from-[#FFA700]/20 to-[#FFB733]/10 rounded-3xl transform rotate-3 blur-xl"></div>
                        <div class="absolute inset-0 bg-gradient-to-tr from-white/5 to-transparent rounded-3xl"></div>
                        
                        <!-- Image Frame dengan Border dan Shadow -->
                        <div class="relative bg-transparent backdrop-blur-sm rounded-3xl p-6 shadow-2xl border border-white/20 overflow-hidden">
                            <!-- Inner Glow Effect -->
                            <div class="absolute inset-0 bg-gradient-to-br from-[#FFA700]/10 via-transparent to-[#005248]/10 rounded-3xl"></div>
                            
                            <!-- Image dengan proper aspect ratio dan positioning -->
                            <div class="relative rounded-2xl overflow-hidden bg-transparent shadow-inner" style="aspect-ratio: 4/3; min-height: 500px;">
                                <img src="{{asset('images/landing.png')}}" 
                                     class="w-full h-full object-cover object-center transition-transform duration-700 hover:scale-105" 
                                     alt="Dokter Gigi Profesional DentaTime"
                                     style="object-position: center 30%;">
                                
                                <!-- Overlay Gradient untuk depth -->
                                <div class="absolute inset-0 bg-gradient-to-t from-[#005248]/30 via-transparent to-transparent pointer-events-none"></div>
                                <div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-[#FFA700]/5 pointer-events-none"></div>
                            </div>
                            
                            <!-- Decorative Corner Elements -->
                            <div class="absolute -top-2 -right-2 w-16 h-16 bg-[#FFA700] rounded-full opacity-60 blur-md animate-pulse"></div>
                            <div class="absolute -bottom-2 -left-2 w-12 h-12 bg-white/30 rounded-full blur-sm animate-pulse" style="animation-delay: 0.5s;"></div>
                        </div>
                        
                        <!-- Floating Badge Elements -->
                        <div class="absolute -top-6 -left-6 bg-white/95 backdrop-blur-md rounded-2xl px-4 py-3 shadow-xl border border-white/50 transform -rotate-3 hover:rotate-0 transition-transform duration-300">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-sm font-semibold text-[#005248]">24/7 Tersedia</span>
                            </div>
                        </div>
                        
                        <div class="absolute -bottom-6 -right-6 bg-gradient-to-br from-[#FFA700] to-[#FFB733] rounded-2xl px-4 py-3 shadow-xl transform rotate-3 hover:rotate-0 transition-transform duration-300">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <span class="text-sm font-semibold text-white">Terpercaya</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 -z-10 opacity-10">
                        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gelombang Pemisah -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-0 pointer-events-none">
        <svg class="relative block w-full h-20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" preserveAspectRatio="none">
            <path fill="white" d="M0,0 C360,80 1080,80 1440,0 L1440,80 L0,80 Z"></path>
        </svg>
    </div>
</section>