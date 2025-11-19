@extends('layouts.dokter')

@section('title', 'Detail Pasien & Rekam Medis')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <p class="text-red-700 font-medium">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Back Button -->
    <div>
        <a href="{{ route('dokter.rekam-medis') }}" 
           class="inline-flex items-center gap-2 text-[#005248] hover:text-[#007a6a] font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar Pasien
        </a>
    </div>

    <!-- Pasien Info Card -->
    <div class="bg-gradient-to-r from-[#005248] to-[#007a6a] rounded-lg shadow-md p-6 text-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white font-bold text-2xl">
                    {{ substr($pasien->user->nama_lengkap ?? 'P', 0, 1) }}
                </div>
                <div>
                    <h2 class="text-2xl font-semibold">{{ $pasien->user->nama_lengkap ?? 'N/A' }}</h2>
                    <p class="text-white/90 text-sm mt-1">
                        RM-{{ str_pad($pasien->id, 6, '0', STR_PAD_LEFT) }} | 
                        {{ $pasien->user->nik ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Pasien -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <svg class="w-6 h-6 text-[#005248]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Informasi Pasien
            </h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500 mb-1">NIK</p>
                <p class="text-base font-semibold text-gray-800">{{ $pasien->user->nik ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Jenis Kelamin</p>
                <p class="text-base font-semibold text-gray-800">{{ $pasien->user->jenis_kelamin ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Tanggal Lahir</p>
                <p class="text-base font-semibold text-gray-800">
                    {{ $pasien->user->tanggal_lahir ? \Carbon\Carbon::parse($pasien->user->tanggal_lahir)->format('d/m/Y') : '-' }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Nomor Telepon</p>
                <p class="text-base font-semibold text-gray-800">{{ $pasien->user->nomor_telp ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Form Tambah Rekam Medis Baru -->
    @if($janjiTemuTersedia->count() > 0)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Rekam Medis Baru
            </h3>
            <p class="text-sm text-gray-600 mt-1">Pilih janji temu yang akan dibuatkan rekam medis</p>
        </div>
        <div class="p-6">
            <form action="{{ route('dokter.rekam-medis.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Pilih Janji Temu -->
                <div>
                    <label for="janji_temu_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Janji Temu <span class="text-red-500">*</span>
                    </label>
                    <select id="janji_temu_id" 
                            name="janji_temu_id" 
                            required
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('janji_temu_id') border-red-500 @enderror">
                        <option value="">Pilih Janji Temu</option>
                        @foreach($janjiTemuTersedia as $jt)
                            <option value="{{ $jt->id }}" {{ old('janji_temu_id') == $jt->id ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($jt->tanggal)->format('d/m/Y') }} - 
                                {{ \Carbon\Carbon::parse($jt->jam_mulai)->format('H:i') }} WIB - 
                                {{ ucfirst($jt->status) }}
                                @if($jt->dokter)
                                    - Dr. {{ $jt->dokter->user->nama_lengkap ?? 'N/A' }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('janji_temu_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Diagnosa -->
                <div>
                    <label for="diagnosa" class="block text-sm font-medium text-gray-700 mb-2">
                        Diagnosa <span class="text-red-500">*</span>
                    </label>
                    <textarea id="diagnosa" 
                              name="diagnosa" 
                              rows="3"
                              required
                              class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('diagnosa') border-red-500 @enderror"
                              placeholder="Masukkan diagnosa">{{ old('diagnosa') }}</textarea>
                    @error('diagnosa')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tindakan -->
                <div>
                    <label for="tindakan" class="block text-sm font-medium text-gray-700 mb-2">
                        Tindakan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="tindakan" 
                              name="tindakan" 
                              rows="3"
                              required
                              class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('tindakan') border-red-500 @enderror"
                              placeholder="Masukkan tindakan yang dilakukan">{{ old('tindakan') }}</textarea>
                    @error('tindakan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catatan -->
                <div>
                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan
                    </label>
                    <textarea id="catatan" 
                              name="catatan" 
                              rows="3"
                              class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('catatan') border-red-500 @enderror"
                              placeholder="Masukkan catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Biaya -->
                <div>
                    <label for="biaya" class="block text-sm font-medium text-gray-700 mb-2">
                        Biaya <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="biaya" 
                           name="biaya" 
                           value="{{ old('biaya') }}"
                           min="0"
                           step="0.01"
                           required
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('biaya') border-red-500 @enderror"
                           placeholder="0">
                    @error('biaya')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200">
                    <button type="submit" 
                            class="px-6 py-2 bg-[#005248] text-white rounded-lg hover:bg-[#003d35] transition-colors font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Rekam Medis
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Daftar Rekam Medis -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Riwayat Rekam Medis
            </h3>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($pasien->janjiTemu->where('rekamMedis', '!=', null) as $janjiTemu)
                @php
                    $rekamMedis = $janjiTemu->rekamMedis;
                @endphp
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                    {{ \Carbon\Carbon::parse($janjiTemu->tanggal)->format('d M Y') }}
                                </div>
                                <div class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">
                                    {{ \Carbon\Carbon::parse($janjiTemu->jam_mulai)->format('H:i') }} WIB
                                </div>
                                @if($janjiTemu->dokter)
                                    <div class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                        Dr. {{ $janjiTemu->dokter->user->nama_lengkap ?? 'N/A' }}
                                    </div>
                                @endif
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <p class="text-sm text-gray-500">Diagnosa</p>
                                    <p class="text-base font-medium text-gray-800">{{ $rekamMedis->diagnosa ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Tindakan</p>
                                    <p class="text-base font-medium text-gray-800">{{ $rekamMedis->tindakan ?? '-' }}</p>
                                </div>
                                @if($rekamMedis->catatan)
                                <div>
                                    <p class="text-sm text-gray-500">Catatan</p>
                                    <p class="text-base text-gray-700">{{ $rekamMedis->catatan }}</p>
                                </div>
                                @endif
                                <div>
                                    <p class="text-sm text-gray-500">Biaya</p>
                                    <p class="text-lg font-bold text-green-600">
                                        Rp {{ number_format($rekamMedis->biaya ?? 0, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 ml-4">
                            <a href="{{ route('dokter.rekam-medis.edit', $rekamMedis->id) }}" 
                               class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                Edit
                            </a>
                            <form action="{{ route('dokter.rekam-medis.destroy', $rekamMedis->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Hapus rekam medis ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-500 text-sm">Belum ada rekam medis untuk pasien ini</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

