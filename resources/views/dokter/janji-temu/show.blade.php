<x-app-layout title="Detail Janji Temu">

    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Back Button -->
        <div>
            <a href="{{ route('dokter.janji-temu.index') }}" 
               class="inline-flex items-center gap-2 text-[#005248] hover:text-[#007a6a] font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Daftar
            </a>
        </div>

        <!-- Header Card -->
        <div class="bg-gradient-to-r from-[#005248] to-[#007a6a] rounded-lg shadow-md p-6 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white font-bold text-2xl">
                        {{ substr($appointment->nama_pasien, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-2xl font-semibold">{{ $appointment->nama_pasien }}</h2>
                        <p class="text-white/90 text-sm mt-1">ID Janji Temu: #{{ str_pad($appointment->id, 4, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="px-4 py-2 rounded-full text-sm font-medium inline-block
                        @if($appointment->status == 'pending') bg-yellow-400 text-yellow-900
                        @elseif($appointment->status == 'approved') bg-green-400 text-green-900
                        @elseif($appointment->status == 'completed') bg-blue-400 text-blue-900
                        @elseif($appointment->status == 'rejected') bg-red-400 text-red-900
                        @else bg-gray-400 text-gray-900
                        @endif">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Detail Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-[#005248]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Informasi Janji Temu
                </h3>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Tanggal -->
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Tanggal</p>
                        <p class="text-base font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($appointment->tanggal)->format('l, d F Y') }}
                        </p>
                    </div>
                </div>

                <!-- Waktu -->
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Waktu</p>
                        <p class="text-base font-semibold text-gray-800">{{ $appointment->waktu }} WIB</p>
                    </div>
                </div>

                <!-- Layanan -->
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Layanan</p>
                        <p class="text-base font-semibold text-gray-800">{{ $appointment->layanan }}</p>
                    </div>
                </div>

                <!-- Status -->
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Status</p>
                        <p class="text-base font-semibold text-gray-800">{{ ucfirst($appointment->status) }}</p>
                    </div>
                </div>

            </div>

            <!-- Keluhan Section -->
            @if($appointment->keluhan)
            <div class="p-6 border-t border-gray-100 bg-gray-50">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500 mb-2">Keluhan Pasien</p>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <p class="text-gray-700 leading-relaxed">{{ $appointment->keluhan }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Action Buttons -->
        @if($appointment->status == 'pending')
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tindakan</h3>
            <div class="flex flex-col sm:flex-row gap-3">
                
                <!-- Approve Button -->
                <form action="{{ route('dokter.janji-temu.approve', $appointment->id) }}" method="POST" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            onclick="return confirm('Apakah Anda yakin ingin menyetujui janji temu ini?')"
                            class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Setujui Janji Temu
                    </button>
                </form>

                <!-- Reject Button -->
                <form action="{{ route('dokter.janji-temu.reject', $appointment->id) }}" method="POST" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            onclick="return confirm('Apakah Anda yakin ingin menolak janji temu ini?')"
                            class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Tolak Janji Temu
                    </button>
                </form>

            </div>
        </div>
        @endif

        <!-- Complete Button (if approved) -->
        @if($appointment->status == 'approved')
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tindakan</h3>
            <form action="{{ route('dokter.janji-temu.complete', $appointment->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" 
                        onclick="return confirm('Tandai janji temu ini sebagai selesai?')"
                        class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-[#005248] text-white rounded-lg hover:bg-[#007a6a] transition-colors font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Tandai Sebagai Selesai
                </button>
            </form>
        </div>
        @endif

        <!-- Info Note -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex gap-3">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <p class="text-sm text-blue-800 font-medium">Catatan</p>
                    <p class="text-sm text-blue-700 mt-1">
                        Pastikan untuk menghubungi pasien sebelum mengkonfirmasi janji temu. 
                        Setelah disetujui, pasien akan menerima notifikasi.
                    </p>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>