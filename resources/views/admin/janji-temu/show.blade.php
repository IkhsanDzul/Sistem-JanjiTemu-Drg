@extends('layouts.admin')

@section('title', 'Detail Janji Temu')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Detail Janji Temu</h2>
            <p class="text-sm text-gray-600 mt-1">Informasi lengkap tentang janji temu</p>
        </div>
        <a href="{{ route('admin.janji-temu.index') }}" 
           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Status Badge -->
    <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Status Janji Temu</p>
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                        'confirmed' => 'bg-blue-100 text-blue-800 border-blue-300',
                        'completed' => 'bg-green-100 text-green-800 border-green-300',
                        'canceled' => 'bg-red-100 text-red-800 border-red-300',
                    ];
                    $statusLabels = [
                        'pending' => 'Menunggu Konfirmasi',
                        'confirmed' => 'Dikonfirmasi',
                        'completed' => 'Selesai',
                        'canceled' => 'Dibatalkan',
                    ];
                    $statusColor = $statusColors[$janjiTemu->status] ?? 'bg-gray-100 text-gray-800';
                    $statusLabel = $statusLabels[$janjiTemu->status] ?? ucfirst($janjiTemu->status);
                @endphp
                <span class="inline-block mt-2 px-4 py-2 text-sm font-semibold rounded-lg border-2 {{ $statusColor }}">
                    {{ $statusLabel }}
                </span>
            </div>
            
            <!-- Update Status Form -->
            @if($janjiTemu->status != 'completed' && $janjiTemu->status != 'canceled')
                <form method="POST" action="{{ route('admin.janji-temu.update-status', $janjiTemu->id) }}" class="flex gap-2">
                    @csrf
                    @method('PATCH')
                    <select name="status" 
                            class="rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent">
                        <option value="pending" {{ $janjiTemu->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $janjiTemu->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ $janjiTemu->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="canceled" {{ $janjiTemu->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                    </select>
                    <button type="submit" 
                            class="px-4 py-2 bg-[#005248] text-white rounded-lg hover:bg-[#003d35] transition-colors font-medium">
                        Update Status
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Informasi Janji Temu -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#005248]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Informasi Janji Temu
            </h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tanggal</p>
                    <p class="text-base text-gray-900 mt-1">
                        {{ \Carbon\Carbon::parse($janjiTemu->tanggal)->format('l, d F Y') }}
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Waktu</p>
                    <p class="text-base text-gray-900 mt-1">
                        {{ \Carbon\Carbon::parse($janjiTemu->jam_mulai)->format('H:i') }} - 
                        {{ \Carbon\Carbon::parse($janjiTemu->jam_selesai)->format('H:i') }} WIB
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Keluhan</p>
                    <p class="text-base text-gray-900 mt-1 bg-gray-50 p-3 rounded-lg">
                        {{ $janjiTemu->keluhan }}
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Dibuat Pada</p>
                    <p class="text-base text-gray-900 mt-1">
                        {{ \Carbon\Carbon::parse($janjiTemu->created_at)->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Informasi Pasien -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Informasi Pasien
            </h3>
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 font-bold text-xl">
                            {{ strtoupper(substr($janjiTemu->pasien->user->nama_lengkap ?? 'P', 0, 1)) }}
                        </span>
                    </div>
                </div>
                <div class="flex-1 space-y-3">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Nama Lengkap</p>
                        <p class="text-base text-gray-900">{{ $janjiTemu->pasien->user->nama_lengkap ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Email</p>
                        <p class="text-base text-gray-900">{{ $janjiTemu->pasien->user->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Nomor Telepon</p>
                        <p class="text-base text-gray-900">{{ $janjiTemu->pasien->user->nomor_telp ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Alamat</p>
                        <p class="text-base text-gray-900">{{ $janjiTemu->pasien->user->alamat ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Dokter -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Informasi Dokter
            </h3>
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="h-16 w-16 bg-green-100 rounded-full flex items-center justify-center">
                        <span class="text-green-600 font-bold text-xl">
                            {{ strtoupper(substr($janjiTemu->dokter->user->nama_lengkap ?? 'D', 0, 1)) }}
                        </span>
                    </div>
                </div>
                <div class="flex-1 space-y-3">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Nama Dokter</p>
                        <p class="text-base text-gray-900">{{ $janjiTemu->dokter->user->nama_lengkap ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Spesialisasi</p>
                        <p class="text-base text-gray-900">{{ $janjiTemu->dokter->spesialisasi_gigi ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">No. STR</p>
                        <p class="text-base text-gray-900">{{ $janjiTemu->dokter->no_str ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pengalaman</p>
                        <p class="text-base text-gray-900">{{ $janjiTemu->dokter->pengalaman_tahun ?? 'N/A' }} tahun</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rekam Medis (jika ada) -->
        @if($janjiTemu->rekamMedis)
            <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Rekam Medis
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Diagnosa</p>
                        <p class="text-base text-gray-900 mt-1 bg-gray-50 p-3 rounded-lg">
                            {{ $janjiTemu->rekamMedis->diagnosa }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Tindakan</p>
                        <p class="text-base text-gray-900 mt-1 bg-gray-50 p-3 rounded-lg">
                            {{ $janjiTemu->rekamMedis->tindakan }}
                        </p>
                    </div>
                    @if($janjiTemu->rekamMedis->catatan)
                        <div>
                            <p class="text-sm font-medium text-gray-600">Catatan</p>
                            <p class="text-base text-gray-900 mt-1 bg-gray-50 p-3 rounded-lg">
                                {{ $janjiTemu->rekamMedis->catatan }}
                            </p>
                        </div>
                    @endif
                    <div>
                        <p class="text-sm font-medium text-gray-600">Biaya</p>
                        <p class="text-2xl font-bold text-[#005248] mt-1">
                            Rp {{ number_format($janjiTemu->rekamMedis->biaya, 0, ',', '.') }}
                        </p>
                    </div>

                    <!-- Resep Obat (jika ada) -->
                    @if($janjiTemu->rekamMedis->resepObat && $janjiTemu->rekamMedis->resepObat->count() > 0)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <p class="text-sm font-medium text-gray-600 mb-3">Resep Obat</p>
                            <div class="space-y-2">
                                @foreach($janjiTemu->rekamMedis->resepObat as $resep)
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <p class="font-medium text-gray-900">{{ $resep->nama_obat }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $resep->jumlah }} tablet/kapsul, 
                                            Dosis: {{ $resep->dosis }}mg, 
                                            {{ $resep->aturan_pakai }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada rekam medis</h3>
                    <p class="mt-1 text-sm text-gray-500">Rekam medis akan tersedia setelah janji temu selesai.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

