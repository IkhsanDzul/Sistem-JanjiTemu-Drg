<x-app-layout title="Detail Rekam Medis Pasien">
    <div class="max-w-7xl mx-auto">
        
        <!-- Breadcrumb -->
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dokter.rekam-medis') }}" class="text-gray-700 hover:text-[#FFA700] inline-flex items-center">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Rekam Medis
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Detail Pasien</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Informasi Pasien -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pasien</h3>
                    
                    <div class="flex flex-col items-center mb-6">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($pasien->user->nama_lengkap) }}&size=120&background=005248&color=fff" 
                             alt="{{ $pasien->user->nama_lengkap }}" 
                             class="w-24 h-24 rounded-full mb-3">
                        <h4 class="text-xl font-bold text-gray-800">{{ $pasien->user->nama_lengkap }}</h4>
                        <p class="text-sm text-gray-500">{{ $pasien->user->nik }}</p>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-sm text-gray-600">Jenis Kelamin</span>
                            <span class="text-sm font-medium text-gray-800">
                                {{ $pasien->user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-sm text-gray-600">Umur</span>
                            <span class="text-sm font-medium text-gray-800">
                                {{ $pasien->user->tanggal_lahir ? \Carbon\Carbon::parse($pasien->user->tanggal_lahir)->age : '-' }} tahun
                            </span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-sm text-gray-600">Tanggal Lahir</span>
                            <span class="text-sm font-medium text-gray-800">
                                {{ $pasien->user->tanggal_lahir ? \Carbon\Carbon::parse($pasien->user->tanggal_lahir)->format('d M Y') : '-' }}
                            </span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-sm text-gray-600">Golongan Darah</span>
                            <span class="text-sm font-medium text-gray-800">{{ $pasien->golongan_darah }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-sm text-gray-600">Alergi</span>
                            <span class="text-sm font-medium text-gray-800">{{ $pasien->alergi ?? 'Tidak ada' }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-sm text-gray-600">Riwayat Penyakit</span>
                            <span class="text-sm font-medium text-gray-800">{{ $pasien->riwayat_penyakit ?? 'Tidak ada' }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-sm text-gray-600">No. Telepon</span>
                            <span class="text-sm font-medium text-gray-800">{{ $pasien->user->nomor_telp ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-sm text-gray-600">Alamat</span>
                            <span class="text-sm font-medium text-gray-800 text-right">{{ $pasien->user->alamat ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Rekam Medis -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Form Input Rekam Medis Baru -->
                @if($janjiTemuTersedia->count() > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Input Rekam Medis Baru</h3>
                    
                    <form action="{{ route('dokter.rekam-medis.store') }}" method="POST">
                        @csrf
                        
                        <!-- Pilih Janji Temu -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Janji Temu</label>
                            <select name="janji_temu_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFA700] focus:border-transparent" required>
                                <option value="">-- Pilih Janji Temu --</option>
                                @foreach($janjiTemuTersedia as $jt)
                                <option value="{{ $jt->id }}">
                                    {{ \Carbon\Carbon::parse($jt->tanggal)->format('d M Y') }} - 
                                    {{ \Carbon\Carbon::parse($jt->jam_mulai)->format('H:i') }} - 
                                    {{ $jt->keluhan }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Diagnosa -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Diagnosa *</label>
                            <textarea name="diagnosa" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFA700] focus:border-transparent" placeholder="Contoh: Karies dentis pada gigi 16 (geraham kiri atas)" required></textarea>
                        </div>

                        <!-- Tindakan -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tindakan *</label>
                            <textarea name="tindakan" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFA700] focus:border-transparent" placeholder="Contoh: Pembersihan karies, penambalan dengan komposit resin" required></textarea>
                        </div>

                        <!-- Catatan -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                            <textarea name="catatan" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFA700] focus:border-transparent" placeholder="Catatan tambahan..."></textarea>
                        </div>

                        <!-- Biaya -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Biaya *</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input type="number" name="biaya" class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFA700] focus:border-transparent" placeholder="0" required min="0">
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <button type="submit" class="px-6 py-2 bg-[#005248] hover:bg-[#004039] text-white rounded-lg transition-colors">
                                Simpan Rekam Medis
                            </button>
                            <a href="{{ route('dokter.rekam-medis') }}" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg transition-colors">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
                @endif

                <!-- Riwayat Rekam Medis -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Rekam Medis</h3>
                    
                    @forelse($pasien->janjiTemu->where('status', 'completed') as $janjiTemu)
                        @if($janjiTemu->rekamMedis)
                        <div class="mb-6 p-4 border border-gray-200 rounded-lg">
                            <!-- Header Rekam Medis -->
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="font-semibold text-gray-800">
                                        {{ \Carbon\Carbon::parse($janjiTemu->tanggal)->format('d F Y') }}
                                    </h4>
                                    <p class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($janjiTemu->jam_mulai)->format('H:i') }} WIB - 
                                        Dr. {{ $janjiTemu->dokter->user->nama_lengkap }}
                                    </p>
                                </div>
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                    Selesai
                                </span>
                            </div>

                            <!-- Keluhan -->
                            <div class="mb-3">
                                <p class="text-sm font-medium text-gray-700">Keluhan:</p>
                                <p class="text-sm text-gray-600">{{ $janjiTemu->keluhan }}</p>
                            </div>

                            <!-- Diagnosa -->
                            <div class="mb-3">
                                <p class="text-sm font-medium text-gray-700">Diagnosa:</p>
                                <p class="text-sm text-gray-600">{{ $janjiTemu->rekamMedis->diagnosa }}</p>
                            </div>

                            <!-- Tindakan -->
                            <div class="mb-3">
                                <p class="text-sm font-medium text-gray-700">Tindakan:</p>
                                <p class="text-sm text-gray-600">{{ $janjiTemu->rekamMedis->tindakan }}</p>
                            </div>

                            <!-- Catatan -->
                            @if($janjiTemu->rekamMedis->catatan)
                            <div class="mb-3">
                                <p class="text-sm font-medium text-gray-700">Catatan:</p>
                                <p class="text-sm text-gray-600">{{ $janjiTemu->rekamMedis->catatan }}</p>
                            </div>
                            @endif

                            <!-- Biaya -->
                            <div class="mb-3">
                                <p class="text-sm font-medium text-gray-700">Biaya:</p>
                                <p class="text-sm font-bold text-[#005248]">Rp {{ number_format($janjiTemu->rekamMedis->biaya, 0, ',', '.') }}</p>
                            </div>

                            <!-- Footer -->
                            <div class="mt-4 pt-4 border-t border-gray-200 flex items-center justify-between">
                                <p class="text-xs text-gray-500">
                                    Dicatat pada: {{ $janjiTemu->rekamMedis->created_at->format('d M Y H:i') }}
                                </p>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('dokter.rekam-medis.edit', $janjiTemu->rekamMedis->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-500 text-sm">Belum ada riwayat rekam medis</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>

    </div>
</x-app-layout>