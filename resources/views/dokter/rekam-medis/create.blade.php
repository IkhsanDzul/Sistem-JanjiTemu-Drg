@extends('layouts.dokter')

@section('title', 'Tambah Rekam Medis')

@php
$title = 'Tambah Rekam Medis';
$subtitle = 'Isi form di bawah ini untuk menambahkan rekam medis baru';
@endphp

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-start justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Tambah Rekam Medis</h2>
            <p class="text-sm text-gray-600 mt-1">Isi form di bawah ini untuk menambahkan rekam medis baru</p>
        </div>
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

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('error') }}
        </div>
    </div>
    @endif

    <!-- Form Section -->
    <form action="{{ route('dokter.rekam-medis.store') }}" method="POST" class="bg-white rounded-xl shadow-md border border-gray-200 p-6 space-y-6">
        @csrf

        <!-- Pilih Janji Temu -->
        <div class="border-b border-gray-200 pb-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#005248]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Janji Temu
            </h3>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Janji Temu <span class="text-red-500">*</span>
                </label>
                <input type="hidden" name="janji_temu_id" value="{{ request()->route('id') }}">
                @php
                $selectedJanjiTemu = $janjiTemu->firstWhere('id', request()->route('id'));
                @endphp
                <div class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50 text-gray-700">
                    @if($selectedJanjiTemu)
                    {{ $selectedJanjiTemu->tanggal ? \Carbon\Carbon::parse($selectedJanjiTemu->tanggal)->format('d/m/Y') : 'N/A' }} -
                    {{ $selectedJanjiTemu->pasien->user->nama_lengkap ?? 'N/A' }} -
                    {{ $selectedJanjiTemu->dokter->user->nama_lengkap ?? 'N/A' }}
                    ({{ $selectedJanjiTemu->keluhan ? (strlen($selectedJanjiTemu->keluhan) > 50 ? substr($selectedJanjiTemu->keluhan, 0, 50) . '...' : $selectedJanjiTemu->keluhan) : 'Tidak ada keluhan' }})
                    @else
                    Janji temu tidak ditemukan
                    @endif
                </div>
            </div>
        </div>

        <!-- Informasi Pasien -->
        @if($pasien)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="text-lg font-semibold text-blue-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Informasi Pasien
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pasien</label>
                    <p class="text-gray-900 font-medium">{{ $pasien->user->nama_lengkap ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                    <p class="text-gray-900 font-medium">{{ $pasien->user->nik ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Alergi Pasien -->
        @if($pasien && $pasien->alergi)
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mt-4">
            <h3 class="text-lg font-semibold text-red-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                Informasi Alergi
            </h3>
            <div class="text-gray-800">
                <p class="whitespace-pre-wrap font-medium">{{ $pasien->alergi }}</p>
            </div>
        </div>
        @endif

        <!-- Riwayat Penyakit Pasien -->
        @if($pasien && $pasien->riwayat_penyakit)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-4">
            <h3 class="text-lg font-semibold text-yellow-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
                Riwayat Penyakit
            </h3>
            <div class="text-gray-800">
                <p class="whitespace-pre-wrap font-medium">{{ $pasien->riwayat_penyakit }}</p>
            </div>
        </div>
        @endif

        <!-- Data Rekam Medis -->
        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Data Rekam Medis
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Diagnosa -->
                <div class="md:col-span-2">
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
                <div class="md:col-span-2">
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
                <div class="md:col-span-2">
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
            </div>
        </div>

        <!-- Resep Obat Section -->
        <div class="pt-6 border-t border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                        Resep Obat
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Pilih resep obat untuk pasien (opsional)</p>
                </div>
                <button type="button" id="tambah-resep-btn" class="px-4 py-2 bg-[#005248] text-white rounded-lg hover:bg-[#003d35] transition-colors font-medium flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Obat
                </button>
            </div>

            <!-- Container untuk resep obat -->
            <div id="resep-container">
                <datalist id="obat-options">
                    @if(!empty($obatTersedia) && count($obatTersedia) > 0)
                        @foreach($obatTersedia as $obat)
                            <option value="{{ $obat['nama_obat'] }}"
                                    data-dosis="{{ $obat['dosis'] ?? 0 }}"
                                    data-aturan-pakai="{{ htmlspecialchars($obat['aturan_pakai'] ?? '', ENT_QUOTES, 'UTF-8') }}">
                        @endforeach
                    @endif
                </datalist>
                <div id="resep-list">
                    <!-- Template untuk satu item resep -->
                    <div id="resep-template" class="resep-item bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4 hidden">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                            <!-- Nama Obat -->
                            <div class="md:col-span-5">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Obat
                                </label>
                                <input type="text"
                                       list="obat-options"
                                       name="resep_obat_nama[]"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent resep-obat-input"
                                       placeholder="Cari dan pilih obat...">
                                <input type="hidden" class="resep-obat-dosis-hidden" readonly>
                                <input type="hidden" class="resep-obat-aturan-hidden" readonly>
                            </div>

                            <!-- Jumlah -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Jumlah
                                </label>
                                <input type="number"
                                       name="resep_obat_jumlah[]"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent resep-jumlah-input"
                                       min="1"
                                       placeholder="Jumlah">
                            </div>

                            <!-- Dosis -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Dosis (mg)
                                </label>
                                <input type="number"
                                       name="resep_obat_dosis[]"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-100 text-gray-800 font-medium focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent resep-dosis-input"
                                       min="0"
                                       readonly
                                       placeholder="-----">
                            </div>

                            <!-- Aturan Pakai -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Aturan Pakai
                                </label>
                                <textarea
                                    name="resep_obat_aturan_pakai[]"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-100 text-gray-800 font-medium focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent resep-aturan-pakai-input"
                                    rows="1"
                                    readonly
                                    placeholder="-----"></textarea>
                            </div>

                            <!-- Tombol Hapus -->
                            <div class="md:col-span-1 flex items-center justify-center mt-6 md:mt-0">
                                <button type="button" class="hapus-resep-btn w-full py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Item resep yang sudah ada (dari old input atau default) -->
                    @if(old('resep_obat_nama'))
                        @foreach(old('resep_obat_nama') as $index => $namaObat)
                            @php
                                $jumlah = old('resep_obat_jumlah')[$index] ?? '';
                                $dosis = old('resep_obat_dosis')[$index] ?? '';
                                $aturanPakai = old('resep_obat_aturan_pakai')[$index] ?? '';
                            @endphp
                            <div class="resep-item bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                    <!-- Nama Obat -->
                                    <div class="md:col-span-5">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Nama Obat
                                        </label>
                                        <input type="text"
                                               list="obat-options"
                                               name="resep_obat_nama[]"
                                               class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent resep-obat-input"
                                               placeholder="Cari dan pilih obat..."
                                               value="{{ $namaObat }}">
                                        <input type="hidden" name="resep_obat_dosis[]" class="resep-obat-dosis-hidden" value="{{ old('resep_obat_dosis')[$index] ?? '' }}">
                                        <input type="hidden" name="resep_obat_aturan_pakai[]" class="resep-obat-aturan-hidden" value="{{ old('resep_obat_aturan_pakai')[$index] ?? '' }}">
                                    </div>

                                    <!-- Jumlah -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Jumlah
                                        </label>
                                        <input type="number"
                                               name="resep_obat_jumlah[]"
                                               class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent resep-jumlah-input"
                                               min="1"
                                               placeholder="Jumlah"
                                               value="{{ $jumlah }}">
                                    </div>

                                    <!-- Dosis -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Dosis (mg)
                                        </label>
                                        <input type="number"
                                               name="resep_obat_dosis[]"
                                               class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-100 text-gray-800 font-medium focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent resep-dosis-input"
                                               min="0"
                                               readonly
                                               placeholder="-----"
                                               value="{{ $dosis }}">
                                    </div>

                                    <!-- Aturan Pakai -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Aturan Pakai
                                        </label>
                                        <textarea
                                            name="resep_obat_aturan_pakai[]"
                                            class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-100 text-gray-800 font-medium focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent resep-aturan-pakai-input"
                                            rows="1"
                                            readonly
                                            placeholder="-----">{{ $aturanPakai }}</textarea>
                                    </div>

                                    <!-- Tombol Hapus -->
                                    <div class="md:col-span-1 flex items-center justify-center mt-6 md:mt-0">
                                        <button type="button" class="hapus-resep-btn w-full py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Item default pertama -->
                        <div class="resep-item bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                <!-- Nama Obat -->
                                <div class="md:col-span-5">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Obat
                                    </label>
                                    <input type="text"
                                           list="obat-options"
                                           name="resep_obat_nama[]"
                                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent resep-obat-input"
                                           placeholder="Cari dan pilih obat...">
                                    <input type="hidden" name="resep_obat_dosis[]" class="resep-obat-dosis-hidden">
                                    <input type="hidden" name="resep_obat_aturan_pakai[]" class="resep-obat-aturan-hidden">
                                </div>

                                <!-- Jumlah -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Jumlah
                                    </label>
                                    <input type="number"
                                           name="resep_obat_jumlah[]"
                                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent resep-jumlah-input"
                                           min="1"
                                           placeholder="Jumlah">
                                </div>

                                <!-- Dosis -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Dosis (mg)
                                    </label>
                                    <input type="number"
                                           name="resep_obat_dosis[]"
                                           class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-100 text-gray-800 font-medium focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent resep-dosis-input"
                                           min="0"
                                           readonly
                                           placeholder="-----">
                                </div>

                                <!-- Aturan Pakai -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Aturan Pakai
                                    </label>
                                    <textarea
                                        name="resep_obat_aturan_pakai[]"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-100 text-gray-800 font-medium focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent resep-aturan-pakai-input"
                                        rows="1"
                                        readonly
                                        placeholder="-----"></textarea>
                                </div>

                                <!-- Tombol Hapus -->
                                <div class="md:col-span-1 flex items-center justify-center mt-6 md:mt-0">
                                    <button type="button" class="hapus-resep-btn w-full py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center justify-center opacity-0 pointer-events-none">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if(empty($obatTersedia) || count($obatTersedia) == 0)
                <p class="mt-2 text-sm text-yellow-600">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Belum ada master obat tersedia.
                </p>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200 mt-6">
            <a href="{{ route('dokter.janji-temu.show', request()->route('id')) }}"
                class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
            <button type="submit"
                class="px-6 py-2 bg-[#005248] text-white rounded-lg hover:bg-[#003d35] transition-colors font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Tambah Rekam Medis
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // JavaScript for dynamic resep obat functionality with search
    document.addEventListener('DOMContentLoaded', function() {
        // Create a map of obat data for quick lookup
        const obatMap = new Map();
        const options = document.querySelectorAll('#obat-options option');
        options.forEach(option => {
            obatMap.set(option.value, {
                dosis: option.getAttribute('data-dosis') || '',
                aturanPakai: option.getAttribute('data-aturan-pakai') || ''
            });
        });

        // Function to update fields when obat is selected/input
        function updateObatFields(inputElement) {
            const inputValue = inputElement.value;
            const obatData = obatMap.get(inputValue);

            // Find the parent resep-item and then locate the corresponding inputs
            const resepItem = inputElement.closest('.resep-item');
            if (resepItem && obatData) {
                const dosisInput = resepItem.querySelector('.resep-dosis-input');
                const aturanPakaiInput = resepItem.querySelector('.resep-aturan-pakai-input');
                const dosisHidden = resepItem.querySelector('.resep-obat-dosis-hidden');
                const aturanPakaiHidden = resepItem.querySelector('.resep-obat-aturan-hidden');

                if (dosisInput) {
                    dosisInput.value = obatData.dosis;
                }
                if (aturanPakaiInput) {
                    aturanPakaiInput.value = obatData.aturanPakai;
                }
                // Also update hidden fields to send to the server
                if (dosisHidden) {
                    dosisHidden.value = obatData.dosis;
                }
                if (aturanPakaiHidden) {
                    aturanPakaiHidden.value = obatData.aturanPakai;
                }
            } else if (resepItem) {
                // Clear fields if no matching obat is found
                const dosisInput = resepItem.querySelector('.resep-dosis-input');
                const aturanPakaiInput = resepItem.querySelector('.resep-aturan-pakai-input');
                const dosisHidden = resepItem.querySelector('.resep-obat-dosis-hidden');
                const aturanPakaiHidden = resepItem.querySelector('.resep-obat-aturan-hidden');

                if (dosisInput) {
                    dosisInput.value = '';
                }
                if (aturanPakaiInput) {
                    aturanPakaiInput.value = '';
                }
                if (dosisHidden) {
                    dosisHidden.value = '';
                }
                if (aturanPakaiHidden) {
                    aturanPakaiHidden.value = '';
                }
            }
        }

        // Function to add a new resep item
        function tambahResep() {
            const template = document.getElementById('resep-template');
            const resepList = document.getElementById('resep-list');
            const newResep = template.cloneNode(true);

            // Remove hidden class and clear ID
            newResep.classList.remove('hidden');
            newResep.id = '';

            // Make the delete button visible and functional
            const deleteBtn = newResep.querySelector('.hapus-resep-btn');
            if (deleteBtn) {
                deleteBtn.classList.remove('opacity-0', 'pointer-events-none');
                deleteBtn.classList.add('opacity-100', 'pointer-events-auto');
            }

            // Clear all values in the new resep item
            const inputs = newResep.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                if (input.type === 'number' || input.type === 'text') {
                    input.value = '';
                } else if (input.tagName === 'SELECT') {
                    input.selectedIndex = 0;
                } else if (input.tagName === 'TEXTAREA') {
                    input.value = '';
                }
            });

            resepList.appendChild(newResep);

            // Add event listener to the new input element
            const newInput = newResep.querySelector('.resep-obat-input');
            if (newInput) {
                newInput.addEventListener('change', function() {
                    updateObatFields(this);
                });

                newInput.addEventListener('input', function() {
                    updateObatFields(this);
                });
            }

            // Add event listener to the new delete button
            const newDeleteBtn = newResep.querySelector('.hapus-resep-btn');
            if (newDeleteBtn) {
                newDeleteBtn.addEventListener('click', function() {
                    hapusResep(this);
                });
            }
        }

        // Function to remove a resep item
        function hapusResep(button) {
            const resepItem = button.closest('.resep-item');
            if (resepItem) {
                resepItem.remove();
            }
        }

        // Add event listener to the tambah resep button
        const tambahBtn = document.getElementById('tambah-resep-btn');
        if (tambahBtn) {
            tambahBtn.addEventListener('click', tambahResep);
        }

        // Add event listener to all existing delete buttons
        document.querySelectorAll('.hapus-resep-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                hapusResep(this);
            });
        });

        // Add event listeners to all existing input elements
        document.querySelectorAll('.resep-obat-input').forEach(function(input) {
            input.addEventListener('change', function() {
                updateObatFields(this);
            });

            input.addEventListener('input', function() {
                updateObatFields(this);
            });

            // Trigger update on page load if an option is already selected
            if (input.value) {
                updateObatFields(input);
            }
        });

        // Handle form submission to ensure proper values
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            // All the input fields will automatically submit their values
            // No special handling needed as datalist just provides suggestions
        });
    });
</script>
@endpush
@endsection