@extends('layouts.admin')

@section('title', 'Resep Obat')

@section('content')
<div class="space-y-6">

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6">
        <form method="GET" action="{{ route('admin.resep-obat.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Resep Obat</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari nama obat, pasien, atau dokter..."
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent">
                </div>

                <!-- Tanggal Dari -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Dari</label>
                    <input type="date" 
                           name="tanggal_dari" 
                           value="{{ request('tanggal_dari') }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent">
                </div>

                <!-- Tanggal Sampai -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Sampai</label>
                    <input type="date" 
                           name="tanggal_sampai" 
                           value="{{ request('tanggal_sampai') }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#005248] focus:border-transparent">
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" 
                        class="px-6 py-2 bg-[#005248] text-white rounded-lg hover:bg-[#003d35] transition-colors font-medium">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Filter
                </button>
                <a href="{{ route('admin.resep-obat.index') }}" 
                   class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Resep Obat</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalResepObat }}</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-full">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-green-50 border border-green-200 rounded-lg p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-700">Obat Unik</p>
                    <p class="text-2xl font-bold text-green-800 mt-1">{{ $totalObatUnik }}</p>
                </div>
                <div class="w-3 h-3 bg-green-400 rounded-full"></div>
            </div>
        </div>

        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-700">Bulan Ini</p>
                    <p class="text-2xl font-bold text-purple-800 mt-1">{{ $resepObatBulanIni }}</p>
                </div>
                <div class="w-3 h-3 bg-purple-400 rounded-full"></div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
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

    <!-- Table Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Tanggal Resep
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Nama Obat
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Pasien
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Dokter
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Jumlah
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Dosis
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($resepObat as $resep)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $resep->tanggal_resep ? \Carbon\Carbon::parse($resep->tanggal_resep)->format('d/m/Y') : 'N/A' }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $resep->created_at->format('H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $resep->nama_obat }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        @if($resep->rekamMedis && $resep->rekamMedis->janjiTemu && $resep->rekamMedis->janjiTemu->pasien && $resep->rekamMedis->janjiTemu->pasien->user && $resep->rekamMedis->janjiTemu->pasien->user->foto_profil)
                                            <img src="{{ asset('storage/' . $resep->rekamMedis->janjiTemu->pasien->user->foto_profil) }}" 
                                                 alt="Foto" 
                                                 class="h-8 w-8 rounded-full object-cover">
                                        @else
                                            <span class="text-blue-600 font-semibold text-xs">
                                                {{ strtoupper(substr($resep->rekamMedis->janjiTemu->pasien->user->nama_lengkap ?? 'P', 0, 1)) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $resep->rekamMedis->janjiTemu->pasien->user->nama_lengkap ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $resep->dokter->user->nama_lengkap ?? 'N/A' }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $resep->dokter->spesialisasi_gigi ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $resep->jumlah }} unit</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ number_format($resep->dosis, 0, ',', '.') }} mg</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.resep-obat.show', $resep->id) }}" 
                                   class="text-[#005248] hover:text-[#FFA700]" title="Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada resep obat</h3>
                                <p class="mt-1 text-sm text-gray-500">Belum ada data resep obat yang tersedia.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($resepObat->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $resepObat->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

