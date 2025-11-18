@extends('layouts.admin')

@section('title', 'Edit Rekam Medis')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Rekam Medis</h2>
            <p class="text-sm text-gray-600 mt-1">Perbarui informasi rekam medis</p>
        </div>
        <a href="{{ route('admin.rekam-medis.show', $rekamMedis->id) }}" 
           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-semibold">Terdapat kesalahan dalam pengisian form:</span>
            </div>
            <ul class="list-disc list-inside ml-7 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Section -->
    <form action="{{ route('admin.rekam-medis.update', $rekamMedis->id) }}" method="POST" class="bg-white rounded-lg shadow-md border border-gray-100 p-6 space-y-6">
        @csrf
        @method('PUT')

        <!-- Informasi Janji Temu (Read Only) -->
        <div class="border-b border-gray-200 pb-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#005248]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Informasi Janji Temu
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tanggal</p>
                    <p class="text-base text-gray-900">
                        {{ $rekamMedis->janjiTemu->tanggal ? \Carbon\Carbon::parse($rekamMedis->janjiTemu->tanggal)->format('d/m/Y') : 'N/A' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Pasien</p>
                    <p class="text-base text-gray-900">{{ $rekamMedis->janjiTemu->pasien->user->nama_lengkap ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Dokter</p>
                    <p class="text-base text-gray-900">{{ $rekamMedis->janjiTemu->dokter->user->nama_lengkap ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Keluhan</p>
                    <p class="text-base text-gray-900">{{ $rekamMedis->janjiTemu->keluhan ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Data Rekam Medis -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Data Rekam Medis
            </h3>

            <div class="space-y-6">
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
                              placeholder="Masukkan diagnosa">{{ old('diagnosa', $rekamMedis->diagnosa) }}</textarea>
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
                              placeholder="Masukkan tindakan yang dilakukan">{{ old('tindakan', $rekamMedis->tindakan) }}</textarea>
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
                              placeholder="Masukkan catatan tambahan (opsional)">{{ old('catatan', $rekamMedis->catatan) }}</textarea>
                    @error('catatan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Biaya -->
                <div>
                    <label for="biaya" class="block text-sm font-medium text-gray-700 mb-2">
                        Biaya
                    </label>
                    <input type="number" 
                           id="biaya" 
                           name="biaya" 
                           value="{{ old('biaya', $rekamMedis->biaya) }}"
                           min="0"
                           step="0.01"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('biaya') border-red-500 @enderror"
                           placeholder="0">
                    @error('biaya')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200">
            <a href="{{ route('admin.rekam-medis.show', $rekamMedis->id) }}" 
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-[#005248] text-white rounded-lg hover:bg-[#003d35] transition-colors font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

