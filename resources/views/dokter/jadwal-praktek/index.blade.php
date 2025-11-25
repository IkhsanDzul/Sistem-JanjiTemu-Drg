@extends('layouts.dokter')

@section('title', 'Jadwal Praktek')

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

    <!-- Header dengan Gradient -->
    <div class="bg-gradient-to-r from-[#005248] to-[#007a6a] rounded-lg shadow-md p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold">Jadwal Praktek</h2>
                <p class="text-sm text-white/90 mt-1">Lihat jadwal praktek Anda (untuk menambah atau mengubah jadwal, hubungi admin)</p>
            </div>
        </div>
    </div>

    <!-- Jadwal Praktek List -->
    @if($jadwalPraktek->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Daftar Jadwal Praktek</h3>
                <p class="text-sm text-gray-500 mt-1">Total: {{ $jadwalPraktek->count() }} jadwal</p>
            </div>
            
            <div class="divide-y divide-gray-200">
                @foreach($jadwalGroupedSorted ?? [] as $hari => $slotWaktu)
                    <div class="p-5 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-[#005248] rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $hari }}</h4>
                                    <p class="text-sm text-gray-500">
                                        {{ count($slotWaktu) }} slot waktu tersedia
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($slotWaktu as $jamKey => $data)
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:border-[#005248] transition-colors">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 bg-[#005248]/10 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-[#005248]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-semibold text-gray-900">
                                                {{ date('H:i', strtotime($data['jam_mulai'])) }} - 
                                                {{ date('H:i', strtotime($data['jam_selesai'])) }} WIB
                                            </span>
                                        </div>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            @if($data['status'] == 'available') bg-green-100 text-green-800
                                            @else bg-yellow-100 text-yellow-800
                                            @endif">
                                            {{ $data['status'] == 'available' ? 'Tersedia' : 'Terbooking' }}
                                        </span>
                                    </div>
                                    
                                    @php
                                        $jamMulai = \Carbon\Carbon::createFromTimeString($data['jam_mulai']);
                                        $jamSelesai = \Carbon\Carbon::createFromTimeString($data['jam_selesai']);
                                        $durasi = $jamMulai->diffInHours($jamSelesai);
                                    @endphp
                                    <p class="text-xs text-gray-500 mb-2">Durasi: {{ $durasi }} jam</p>
                                    
                                    <!-- Daftar Tanggal -->
                                    <div class="mb-3">
                                        <p class="text-xs font-medium text-gray-600 mb-1">Tanggal:</p>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($data['tanggal'] as $tanggal)
                                                <span class="px-2 py-1 text-xs bg-white rounded border border-gray-300 text-gray-700">
                                                    {{ \Carbon\Carbon::parse($tanggal)->format('d M') }}
                                                </span>
                                            @endforeach
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Total: {{ count($data['tanggal']) }} tanggal</p>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 text-center px-3 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium">
                                            {{ count($data['jadwal_ids']) }} jadwal
                                        </div>
                                        <div class="px-3 py-2 bg-blue-100 text-blue-700 rounded-lg text-xs font-medium">
                                            Hubungi admin untuk perubahan
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum Ada Jadwal Praktek</h3>
            <p class="text-gray-500 text-sm mb-6">Hubungi admin untuk menambahkan jadwal praktek Anda</p>
        </div>
    @endif
</div>
@endsection

