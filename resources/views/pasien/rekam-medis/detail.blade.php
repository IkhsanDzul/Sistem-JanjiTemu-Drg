@extends('layouts.pasien')

@section('title', 'Detail Rekam Medis')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Detail Rekam Medis</h2>
            <p class="text-sm text-gray-600 mt-1">Informasi lengkap tentang rekam medis Anda</p>
        </div>
        <a href="{{ route('pasien.rekam-medis') }}" 
           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Informasi Dokter -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#005248]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Dokter Penanggung Jawab
            </h3>
            <div class="space-y-4">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        @if($rekam->janjiTemu && $rekam->janjiTemu->dokter && $rekam->janjiTemu->dokter->user && $rekam->janjiTemu->dokter->user->foto_profil)
                            <img src="{{ asset('storage/' . $rekam->janjiTemu->dokter->user->foto_profil) }}" 
                                 alt="Foto Dokter" 
                                 class="w-20 h-20 rounded-lg object-cover"
                                 onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center hidden">
                                <span class="text-gray-400 font-bold text-2xl">
                                    {{ strtoupper(substr($rekam->janjiTemu->dokter->user->nama_lengkap ?? 'D', 0, 1)) }}
                                </span>
                            </div>
                        @else
                            <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                <span class="text-gray-400 font-bold text-2xl">
                                    {{ strtoupper(substr($rekam->janjiTemu->dokter->user->nama_lengkap ?? 'D', 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900">
                            {{ $rekam->janjiTemu->dokter->user->nama_lengkap ?? 'Dokter Tidak Ditemukan' }}
                        </h4>
                        <p class="text-sm text-gray-600 mt-1">{{ $rekam->janjiTemu->dokter->spesialisasi_gigi ?? 'N/A' }}</p>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Tanggal Pemeriksaan</p>
                    <p class="text-base text-gray-900 mt-1">
                        {{ $rekam->janjiTemu->tanggal ? \Carbon\Carbon::parse($rekam->janjiTemu->tanggal)->locale('id')->isoFormat('dddd, DD MMMM YYYY') : 'N/A' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Tanggal --}}
        <div class="mb-4">
            <p class="text-gray-600 text-sm">Tanggal Pemeriksaan</p>
            <p class="text-lg text-gray-800">
                {{ \Carbon\Carbon::parse($rekam->tanggal)->format('d M Y') }}
            </p>
        </div>

        {{-- Diagnosa --}}
        <div class="mb-4">
            <p class="text-gray-600 text-sm">Diagnosa</p>
            <p class="text-gray-800">
                {{ $rekam->diagnosa }}
            </p>
        </div>

        {{-- Tindakan --}}
        <div class="mb-4">
            <p class="text-gray-600 text-sm">Tindakan</p>
            <p class="text-gray-800">
                {{ $rekam->tindakan }}
            </p>
        </div>

        {{-- Catatan Dokter --}}
        <div class="mb-4">
            <p class="text-gray-600 text-sm">Catatan Dokter</p>
            <div class="text-gray-800 whitespace-pre-line bg-gray-50 border p-3 rounded">
                {{ $rekam->catatan }}
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

        {{-- Optional: Resep Obat --}}
        @if (!empty($rekam->resep))
        <div class="mb-4">
            <p class="text-gray-600 text-sm">Resep Obat</p>
            <div class="text-gray-800 whitespace-pre-line bg-gray-50 border p-3 rounded">
                {{ $rekam->resep }}
            </div>
        </div>
        @endif

        {{-- Tombol Aksi --}}
        <div class="mt-6 flex gap-3">

            {{-- Back --}}
            <a href="{{ route('pasien.rekam-medis') }}"
                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                Kembali
            </a>

            {{-- Button PDF (Optional → tinggal diaktifkan jika PDF ready) --}}
            {{--
            <a href="{{ route('pasien.rekam-medis.pdf', $rekam->id) }}"
            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            Download PDF
            </a>
            --}}
        </div>

    </div>

</div>

@endsection