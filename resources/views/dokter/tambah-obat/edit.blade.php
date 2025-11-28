@extends('layouts.dokter')

@section('title', 'Edit Master Obat')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
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
        <a href="{{ route('dokter.tambah-obat.index') }}" 
           class="inline-flex items-center gap-2 text-[#005248] hover:text-[#007a6a] font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar Obat
        </a>
    </div>

    <!-- Header -->
    <div class="bg-gradient-to-r from-[#005248] to-[#007a6a] rounded-lg shadow-md p-6 text-white">
        <h2 class="text-2xl font-semibold">Edit Master Obat</h2>
        <p class="text-white/90 text-sm mt-1">Perbarui data master obat</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('dokter.tambah-obat.update', $obat->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Obat -->
            <div>
                <label for="nama_obat" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Obat <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="nama_obat" 
                       name="nama_obat" 
                       value="{{ old('nama_obat', $obat->nama_obat) }}"
                       required
                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('nama_obat') border-red-500 @enderror"
                       placeholder="Contoh: Paracetamol 500mg">
                @error('nama_obat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Satuan -->
            <div>
                <label for="satuan" class="block text-sm font-medium text-gray-700 mb-2">
                    Satuan
                </label>
                <select id="satuan" 
                        name="satuan" 
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('satuan') border-red-500 @enderror">
                    <option value="">Pilih Satuan</option>
                    <option value="mg" {{ old('satuan', $obat->satuan) == 'mg' ? 'selected' : '' }}>mg (Miligram)</option>
                    <option value="ml" {{ old('satuan', $obat->satuan) == 'ml' ? 'selected' : '' }}>ml (Mililiter)</option>
                    <option value="tablet" {{ old('satuan', $obat->satuan) == 'tablet' ? 'selected' : '' }}>Tablet</option>
                    <option value="kapsul" {{ old('satuan', $obat->satuan) == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
                    <option value="botol" {{ old('satuan', $obat->satuan) == 'botol' ? 'selected' : '' }}>Botol</option>
                    <option value="tube" {{ old('satuan', $obat->satuan) == 'tube' ? 'selected' : '' }}>Tube</option>
                    <option value="sachet" {{ old('satuan', $obat->satuan) == 'sachet' ? 'selected' : '' }}>Sachet</option>
                    <option value="ampul" {{ old('satuan', $obat->satuan) == 'ampul' ? 'selected' : '' }}>Ampul</option>
                </select>
                @error('satuan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dosis Default -->
            <div>
                <label for="dosis_default" class="block text-sm font-medium text-gray-700 mb-2">
                    Dosis Default
                </label>
                <input type="number" 
                       id="dosis_default" 
                       name="dosis_default" 
                       value="{{ old('dosis_default', $obat->dosis_default) }}"
                       min="0"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('dosis_default') border-red-500 @enderror"
                       placeholder="Contoh: 500">
                <p class="mt-1 text-xs text-gray-500">Dosis default yang akan digunakan saat memilih obat ini</p>
                @error('dosis_default')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Aturan Pakai Default -->
            <div>
                <label for="aturan_pakai_default" class="block text-sm font-medium text-gray-700 mb-2">
                    Aturan Pakai Default
                </label>
                <textarea id="aturan_pakai_default" 
                          name="aturan_pakai_default" 
                          rows="3"
                          class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('aturan_pakai_default') border-red-500 @enderror"
                          placeholder="Contoh: 3x1 sehari setelah makan">{{ old('aturan_pakai_default', $obat->aturan_pakai_default) }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Aturan pakai default yang akan digunakan saat memilih obat ini</p>
                @error('aturan_pakai_default')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi
                </label>
                <textarea id="deskripsi" 
                          name="deskripsi" 
                          rows="3"
                          class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('deskripsi') border-red-500 @enderror"
                          placeholder="Deskripsi singkat tentang obat (opsional)">{{ old('deskripsi', $obat->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('dokter.tambah-obat.index') }}" 
                   class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-[#005248] text-white rounded-lg hover:bg-[#003d35] transition-colors font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Master Obat
                </button>
            </div>
        </form>
    </div>
</div>
@endsection