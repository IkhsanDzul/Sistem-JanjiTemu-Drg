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
                        Biaya <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="biaya" 
                           name="biaya" 
                           value="{{ old('biaya', $rekamMedis->biaya) }}"
                           min="0"
                           step="0.01"
                           required
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('biaya') border-red-500 @enderror"
                           placeholder="0">
                    @error('biaya')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Resep Obat Section -->
        <div class="pt-6 border-t border-gray-200">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                    Resep Obat
                </h3>
                <p class="text-sm text-gray-600">Edit atau hapus resep obat untuk pasien (opsional)</p>
            </div>

            @if($rekamMedis->resepObat && $rekamMedis->resepObat->count() > 0)
                <!-- Tampilkan Resep Obat yang Ada -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm font-medium text-blue-800">Resep Obat Saat Ini</p>
                        </div>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   name="hapus_resep_obat" 
                                   value="1"
                                   id="hapus_resep_obat"
                                   class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                            <span class="ml-2 text-sm text-red-600 font-medium">Hapus Resep Obat</span>
                        </label>
                    </div>
                    <div class="bg-white rounded-lg p-4 border border-blue-200">
                        @foreach($rekamMedis->resepObat as $resep)
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-3 last:mb-0">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Nama Obat</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $resep->nama_obat }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Jumlah</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $resep->jumlah }} unit</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Dosis</p>
                                <p class="text-sm font-semibold text-gray-900">{{ number_format($resep->dosis, 0, ',', '.') }} mg</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Aturan Pakai</p>
                                <p class="text-sm text-gray-900">{{ $resep->aturan_pakai }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="space-y-4">
                <!-- Pilih Obat -->
                <div>
                    <label for="resep_obat_nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Obat
                    </label>
                    <select id="resep_obat_nama" 
                            name="resep_obat_nama" 
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('resep_obat_nama') border-red-500 @enderror">
                        <option value="">Pilih Obat (Opsional)</option>
                        @if(!empty($obatTersedia) && count($obatTersedia) > 0)
                            @foreach($obatTersedia as $obat)
                                <option value="{{ $obat['nama_obat'] }}" 
                                        data-dosis="{{ $obat['dosis'] ?? 0 }}"
                                        data-aturan-pakai="{{ htmlspecialchars($obat['aturan_pakai'] ?? '', ENT_QUOTES, 'UTF-8') }}"
                                        {{ old('resep_obat_nama') == $obat['nama_obat'] ? 'selected' : '' }}>
                                    {{ $obat['nama_obat'] }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('resep_obat_nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if(empty($obatTersedia) || count($obatTersedia) == 0)
                        <p class="mt-2 text-sm text-yellow-600">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Belum ada master obat tersedia.
                        </p>
                    @endif
                </div>

                <!-- Jumlah -->
                <div>
                    <label for="resep_obat_jumlah" class="block text-sm font-medium text-gray-700 mb-2">
                        Jumlah
                    </label>
                    <input type="number" 
                           id="resep_obat_jumlah" 
                           name="resep_obat_jumlah" 
                           value="{{ old('resep_obat_jumlah') }}"
                           min="1"
                           @if(!old('resep_obat_nama') && (!$rekamMedis->resepObat || $rekamMedis->resepObat->count() == 0)) disabled @endif
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 @if(!old('resep_obat_nama') && (!$rekamMedis->resepObat || $rekamMedis->resepObat->count() == 0)) bg-gray-50 @endif focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('resep_obat_jumlah') border-red-500 @enderror"
                           placeholder="Masukkan jumlah obat">
                    @error('resep_obat_jumlah')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($rekamMedis->resepObat && $rekamMedis->resepObat->count() > 0)
                        <p class="mt-1 text-xs text-gray-500">Isi form di atas untuk mengganti resep obat yang ada</p>
                    @endif
                </div>

                <!-- Dosis (Auto-filled) -->
                <div>
                    <label for="resep_obat_dosis" class="block text-sm font-medium text-gray-700 mb-2">
                        Dosis (mg)
                    </label>
                    <input type="number" 
                           id="resep_obat_dosis" 
                           name="resep_obat_dosis" 
                           value="{{ old('resep_obat_dosis') }}"
                           min="0"
                           readonly
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-100 text-gray-800 font-medium focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('resep_obat_dosis') border-red-500 @enderror"
                           placeholder="Akan terisi otomatis saat memilih obat">
                    @error('resep_obat_dosis')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Aturan Pakai (Auto-filled) -->
                <div>
                    <label for="resep_obat_aturan_pakai" class="block text-sm font-medium text-gray-700 mb-2">
                        Aturan Pakai
                    </label>
                    <textarea id="resep_obat_aturan_pakai" 
                              name="resep_obat_aturan_pakai" 
                              rows="2"
                              class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-100 text-gray-800 font-medium focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('resep_obat_aturan_pakai') border-red-500 @enderror"
                              placeholder="Akan terisi otomatis saat memilih obat"
                              readonly
                              onfocus="this.removeAttribute('readonly')"
                              onblur="this.setAttribute('readonly', 'readonly')">{{ old('resep_obat_aturan_pakai') }}</textarea>
                    @error('resep_obat_aturan_pakai')
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

@push('scripts')
<script>
    // Auto-fill dosis dan aturan pakai saat memilih obat
    document.addEventListener('DOMContentLoaded', function() {
        const selectObat = document.getElementById('resep_obat_nama');
        const inputJumlah = document.getElementById('resep_obat_jumlah');
        const inputDosis = document.getElementById('resep_obat_dosis');
        const inputAturanPakai = document.getElementById('resep_obat_aturan_pakai');
        const checkboxHapus = document.getElementById('hapus_resep_obat');
        
        // Function untuk update field berdasarkan pilihan obat
        function updateResepFields() {
            if (!selectObat) return;
            
            if (selectObat.value) {
                // Enable jumlah jika ada obat yang dipilih
                if (inputJumlah) {
                    inputJumlah.removeAttribute('disabled');
                    inputJumlah.classList.remove('bg-gray-50');
                    inputJumlah.setAttribute('required', 'required');
                }
                
                // Auto-fill dosis dan aturan pakai dari selected option
                const selectedOption = selectObat.options[selectObat.selectedIndex];
                if (selectedOption) {
                    const dosis = selectedOption.getAttribute('data-dosis') || '';
                    const aturanPakai = selectedOption.getAttribute('data-aturan-pakai') || '';
                    
                    // Selalu update dosis dan aturan pakai saat obat dipilih
                    if (inputDosis) {
                        inputDosis.value = dosis;
                        inputDosis.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                    if (inputAturanPakai) {
                        inputAturanPakai.value = aturanPakai;
                        inputAturanPakai.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                }
            } else {
                // Disable jumlah jika tidak ada obat yang dipilih
                if (inputJumlah) {
                    inputJumlah.setAttribute('disabled', 'disabled');
                    inputJumlah.classList.add('bg-gray-50');
                    inputJumlah.removeAttribute('required');
                    inputJumlah.value = '';
                }
                // Clear dosis dan aturan pakai jika tidak ada obat
                if (inputDosis) {
                    inputDosis.value = '';
                    inputDosis.dispatchEvent(new Event('input', { bubbles: true }));
                }
                if (inputAturanPakai) {
                    inputAturanPakai.value = '';
                    inputAturanPakai.dispatchEvent(new Event('input', { bubbles: true }));
                }
            }
        }
        
        // Handle checkbox hapus resep obat
        if (checkboxHapus) {
            checkboxHapus.addEventListener('change', function() {
                if (this.checked) {
                    // Disable semua field resep obat jika checkbox dicentang
                    if (selectObat) selectObat.setAttribute('disabled', 'disabled');
                    if (inputJumlah) {
                        inputJumlah.setAttribute('disabled', 'disabled');
                        inputJumlah.classList.add('bg-gray-50');
                    }
                    if (inputDosis) inputDosis.setAttribute('disabled', 'disabled');
                    if (inputAturanPakai) inputAturanPakai.setAttribute('disabled', 'disabled');
                } else {
                    // Enable kembali field resep obat jika checkbox tidak dicentang
                    if (selectObat) selectObat.removeAttribute('disabled');
                    if (selectObat && selectObat.value) {
                        if (inputJumlah) {
                            inputJumlah.removeAttribute('disabled');
                            inputJumlah.classList.remove('bg-gray-50');
                        }
                    }
                    if (inputDosis) inputDosis.removeAttribute('disabled');
                    if (inputAturanPakai) inputAturanPakai.removeAttribute('disabled');
                }
            });
        }
        
        // Initialize pada page load
        // Jika ada old value, enable field dan auto-fill
        if (selectObat && selectObat.value) {
            setTimeout(function() {
                updateResepFields();
            }, 100);
        } else if (inputJumlah) {
            // Check jika ada resep obat yang sudah ada (ada section dengan bg-blue-50)
            const hasExistingResep = document.querySelector('.bg-blue-50');
            if (hasExistingResep) {
                // Enable field jika ada resep obat yang sudah ada (user bisa mengganti)
                inputJumlah.removeAttribute('disabled');
                inputJumlah.classList.remove('bg-gray-50');
            } else if (!inputJumlah.hasAttribute('required') && !selectObat.value) {
                // Disable jika tidak ada resep obat dan tidak ada pilihan obat
                if (!inputJumlah.hasAttribute('disabled')) {
                    inputJumlah.setAttribute('disabled', 'disabled');
                    inputJumlah.classList.add('bg-gray-50');
                }
            }
        }
        
        // Event listener untuk perubahan pilihan obat
        if (selectObat) {
            selectObat.addEventListener('change', function() {
                // Jangan update jika checkbox hapus dicentang
                if (checkboxHapus && checkboxHapus.checked) {
                    return;
                }
                updateResepFields();
            });
        }
        
        // Pastikan value ter-submit saat form di-submit
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Pastikan aturan pakai dan dosis terisi sebelum submit
                if (selectObat && selectObat.value && (!checkboxHapus || !checkboxHapus.checked)) {
                    const selectedOption = selectObat.options[selectObat.selectedIndex];
                    if (selectedOption) {
                        const dosis = selectedOption.getAttribute('data-dosis') || '';
                        const aturanPakai = selectedOption.getAttribute('data-aturan-pakai') || '';
                        
                        // Selalu update value sebelum submit untuk memastikan ter-submit
                        if (inputDosis) {
                            inputDosis.value = dosis || inputDosis.value;
                            // Remove readonly untuk memastikan value ter-submit
                            inputDosis.removeAttribute('readonly');
                        }
                        if (inputAturanPakai) {
                            // Decode HTML entities jika ada
                            const decodedAturanPakai = aturanPakai ? aturanPakai.replace(/&quot;/g, '"').replace(/&#39;/g, "'") : '';
                            inputAturanPakai.value = decodedAturanPakai || inputAturanPakai.value;
                            // Remove readonly untuk memastikan value ter-submit
                            inputAturanPakai.removeAttribute('readonly');
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection

