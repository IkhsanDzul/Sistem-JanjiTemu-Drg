@extends('layouts.dokter')

@section('title', 'Edit Resep Obat')

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
        <a href="{{ route('dokter.resep-obat.index') }}" 
           class="inline-flex items-center gap-2 text-[#005248] hover:text-[#007a6a] font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar Obat
        </a>
    </div>

    <!-- Header -->
    <div class="bg-gradient-to-r from-[#005248] to-[#007a6a] rounded-lg shadow-md p-6 text-white">
        <h2 class="text-2xl font-semibold">Edit Resep Obat</h2>
        <p class="text-white/90 text-sm mt-1">Perbarui informasi resep obat</p>
    </div>

    <!-- Info Pasien -->
    @if($resep->rekamMedis && $resep->rekamMedis->janjiTemu)
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <div>
                <p class="text-sm font-medium text-blue-900">Pasien</p>
                <p class="text-sm text-blue-700">{{ $resep->rekamMedis->janjiTemu->pasien->user->nama_lengkap ?? 'N/A' }}</p>
                <p class="text-xs text-blue-600 mt-1">
                    Tanggal: {{ \Carbon\Carbon::parse($resep->tanggal_resep)->locale('id')->isoFormat('dddd, DD MMMM YYYY') }}
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('dokter.resep-obat.update', $resep->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Obat -->
            <div>
                <label for="nama_obat" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Obat <span class="text-red-500">*</span>
                </label>
                <select id="nama_obat" 
                        name="nama_obat" 
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('nama_obat') border-red-500 @enderror">
                    <option value="">Pilih Obat</option>
                    @foreach($masterObat as $obat)
                        <option value="{{ $obat->nama_obat }}" 
                                data-dosis="{{ $obat->dosis_default ?? 0 }}"
                                data-aturan-pakai="{{ $obat->aturan_pakai_default ?? '' }}"
                                {{ old('nama_obat', $resep->nama_obat) == $obat->nama_obat ? 'selected' : '' }}>
                            {{ $obat->nama_obat }}
                        </option>
                    @endforeach
                </select>
                @error('nama_obat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jumlah -->
            <div>
                <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-2">
                    Jumlah <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       id="jumlah" 
                       name="jumlah" 
                       value="{{ old('jumlah', $resep->jumlah) }}"
                       required
                       min="1"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('jumlah') border-red-500 @enderror"
                       placeholder="Contoh: 10">
                @error('jumlah')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dosis -->
            <div>
                <label for="dosis" class="block text-sm font-medium text-gray-700 mb-2">
                    Dosis (mg) <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       id="dosis" 
                       name="dosis" 
                       value="{{ old('dosis', $resep->dosis) }}"
                       required
                       min="0"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent bg-gray-50 @error('dosis') border-red-500 @enderror"
                       placeholder="Akan terisi otomatis saat memilih obat">
                @error('dosis')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Aturan Pakai -->
            <div>
                <label for="aturan_pakai" class="block text-sm font-medium text-gray-700 mb-2">
                    Aturan Pakai <span class="text-red-500">*</span>
                </label>
                <textarea id="aturan_pakai" 
                          name="aturan_pakai" 
                          required
                          rows="3"
                          class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent bg-gray-50 @error('aturan_pakai') border-red-500 @enderror"
                          placeholder="Akan terisi otomatis saat memilih obat">{{ old('aturan_pakai', $resep->aturan_pakai) }}</textarea>
                @error('aturan_pakai')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('dokter.resep-obat.index') }}" 
                   class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-[#005248] text-white rounded-lg hover:bg-[#003d35] transition-colors font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Perbarui Resep
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Auto-fill dosis dan aturan pakai saat memilih obat
    document.getElementById('nama_obat')?.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const dosis = selectedOption.getAttribute('data-dosis');
        const aturanPakai = selectedOption.getAttribute('data-aturan-pakai');
        
        const inputDosis = document.getElementById('dosis');
        const inputAturanPakai = document.getElementById('aturan_pakai');
        
        if (inputDosis && dosis) {
            inputDosis.value = dosis;
        }
        if (inputAturanPakai && aturanPakai) {
            inputAturanPakai.value = aturanPakai;
        }
    });
</script>
@endpush
@endsection

