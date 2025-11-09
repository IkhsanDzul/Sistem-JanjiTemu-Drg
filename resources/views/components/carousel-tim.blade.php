<section class="bg-[#FFA700] py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">
                Tim Kami
            </h2>
        </div>

        <div class="relative">
            <div class="flex gap-6 overflow-x-auto pb-4 scrollbar-hide" id="carousel-tim">
                @for($i = 1; $i <= 5; $i++)
                    <div class="flex-shrink-0 w-64 text-center">
                        <div class="w-48 h-48 mx-auto rounded-full bg-white mb-4 flex items-center justify-center shadow-lg">
                            <span class="text-[#FFA700] text-4xl font-bold">TM{{ $i }}</span>
                        </div>
                        <h3 class="text-white font-semibold text-lg mb-1">
                            @if($i == 1)
                                Gabriel Morvira
                            @elseif($i == 2)
                                Laquita Elliott
                            @elseif($i == 3)
                                Diego Morales
                            @else
                                Anggota Tim {{ $i }}
                            @endif
                        </h3>
                        @if($i == 2)
                            <p class="text-white text-sm">CEO & Founder</p>
                        @else
                            <p class="text-white text-sm">Tim Member</p>
                        @endif
                    </div>
                @endfor
            </div>

            <!-- Navigation Dots -->
            <div class="flex justify-center gap-2 mt-8">
                @for($i = 1; $i <= 3; $i++)
                    <button class="w-2 h-2 rounded-full {{ $i == 2 ? 'bg-white w-3 h-3' : 'bg-white/50' }} transition-all" aria-label="Slide {{ $i }}"></button>
                @endfor
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
</style>

