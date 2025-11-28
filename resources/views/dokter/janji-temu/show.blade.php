@extends('layouts.dokter')

@section('title', 'Detail Janji Temu')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">
    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <p class="text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
            <p class="text-red-700 font-medium">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Back Button -->
    <div>
        <a href="{{ route('dokter.janji-temu.index') }}"
            class="inline-flex items-center gap-2 text-[#005248] hover:text-[#007a6a] font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
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
                <span class="px-4 py-2 rounded-full text-sm font-semibold inline-block shadow-md
                        @if($appointment->status == 'pending') bg-gradient-to-r from-yellow-400 to-amber-500 text-white
                        @elseif($appointment->status == 'confirmed') bg-gradient-to-r from-green-400 to-emerald-500 text-white
                        @elseif($appointment->status == 'completed') bg-gradient-to-r from-blue-400 to-cyan-500 text-white
                        @elseif($appointment->status == 'canceled') bg-gradient-to-r from-red-400 to-rose-500 text-white
                        @else bg-gradient-to-r from-gray-400 to-slate-500 text-white
                        @endif">
                    {{ ucfirst($appointment->status) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Detail Information -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-100 flex items-center">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <svg class="w-6 h-6 text-[#005248]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Informasi Janji Temu
            </h3>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Tanggal -->
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Tanggal</p>
                    <p class="text-base font-semibold text-gray-800">
                        {{ \Carbon\Carbon::parse($appointment->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                    </p>
                </div>
            </div>

            <!-- Waktu -->
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
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
        <div class="p-6 border-t border-gray-100">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
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

    @if($appointment->status == 'completed')
    <div class="bg-white rounded-lg shadow-md border-2 border-gray-200 p-6 flex justify-between items-center mb-6">
        <div class="text-lg font-semibold mb-4">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">Rekam Medis Pasien</h3>
        </div>
        <div class="flex items-center space-x-2">
            <!-- Lihat Detail -->
            <a href="{{ route('dokter.rekam-medis.show', $rekamMedis->id) }}"
                class="text-blue-600 hover:text-blue-800 transition-colors"
                title="Lihat Detail">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </a>

            <!-- Edit -->
            <a href="{{ route('dokter.rekam-medis.edit', $rekamMedis->id) }}"
                class="text-[#005248] hover:text-[#003d35] transition-colors"
                title="Edit Rekam Medis">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </a>

            <!-- Hapus -->
            <form action="{{ route('dokter.rekam-medis.destroy', $rekamMedis->id) }}" method="POST"
                onsubmit="return confirm('Apakah Anda yakin ingin menghapus rekam medis ini?');"
                class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="text-red-600 hover:text-red-800 transition-colors flex justify-center items-center"
                    title="Hapus Rekam Medis">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
    @endif

    <!-- Action Buttons -->
    @if($appointment->status == 'pending')
    <div class="bg-white rounded-lg shadow-md border-2 border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-[#005248]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            Tindakan
        </h3>
        <div class="flex flex-col sm:flex-row gap-3">

            <!-- Approve Button -->
            <form action="{{ route('dokter.janji-temu.approve', $appointmentModel->id) }}" method="POST" class="flex-1">
                @csrf
                @method('PATCH')
                <button type="submit"
                    onclick="return confirm('Apakah Anda yakin ingin menyetujui janji temu ini?')"
                    class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all font-semibold shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Setujui Janji Temu
                </button>
            </form>

            <!-- Reject Button -->
            <form action="{{ route('dokter.janji-temu.reject', $appointmentModel->id) }}" method="POST" class="flex-1">
                @csrf
                @method('PATCH')
                <button type="submit"
                    onclick="return confirm('Apakah Anda yakin ingin menolak janji temu ini?')"
                    class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-lg hover:from-red-600 hover:to-rose-700 transition-all font-semibold shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Tolak Janji Temu
                </button>
            </form>

        </div>
    </div>
    @endif

    <!-- Complete Button (if confirmed) -->
    @if($appointment->status == 'confirmed')
    <div class="bg-white rounded-lg shadow-md border-2 border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-[#005248]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Tindakan
        </h3>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <!-- Tombol Tandai Sebagai Selesai -->
            @if($appointmentModel->rekamMedis)
            <form action="{{ route('dokter.janji-temu.complete', $appointmentModel->id) }}" method="POST" class="w-full">
                @csrf
                @method('PATCH')
                <button type="submit"
                    onclick="return confirm('Tandai janji temu ini sebagai selesai?')"
                    class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-[#005248] to-[#007a6a] text-white rounded-lg hover:from-[#007a6a] hover:to-[#009688] transition-all font-semibold shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Tandai Sebagai Selesai
                </button>
            </form>
            @else
            <button type="button" disabled class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-gray-400 text-white rounded-lg transition-all font-semibold shadow-md cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Tandai Sebagai Selesai
            </button>
            @endif

            <!-- Tombol Tambah Rekam Medis -->
            @if(!$appointmentModel->rekamMedis)
            <a href="{{ route('dokter.rekam-medis.create', $appointmentModel->id) }}"
                class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-[#34C759] to-[#2ECC71] text-white rounded-lg hover:bg-gradient-to-r hover:from-[#2ECC71] hover:to-[#34C759] transition-all font-semibold shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Tambah Rekam Medis
            </a>
            @else
            <button type="button" disabled class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-gray-400 text-white rounded-lg transition-all font-semibold shadow-md cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Tambah Rekam Medis
            </button>
            @endif
        </div>
    </div>
    @endif

    <!-- Info Note -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
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
@endsection