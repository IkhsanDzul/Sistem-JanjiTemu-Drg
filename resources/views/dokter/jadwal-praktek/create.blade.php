@extends('layouts.dokter')

@section('title', 'Tambah Jadwal Praktek')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-[#005248] to-[#007a6a] rounded-lg shadow-md p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold">Tambah Jadwal Praktek</h2>
                <p class="text-sm text-white/90 mt-1">Tambahkan jadwal praktek baru untuk ketersediaan Anda</p>
            </div>
            <a href="{{ route('dokter.jadwal-praktek.index') }}" 
               class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-colors">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="font-semibold text-red-700">Terdapat kesalahan dalam pengisian form:</span>
            </div>
            <ul class="list-disc list-inside ml-8 space-y-1 text-sm text-red-600">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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

    <!-- Form Section -->
    <form action="{{ route('dokter.jadwal-praktek.store') }}" method="POST" class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 space-y-6">
        @csrf

        <!-- Form Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Tanggal -->
            <div>
                <label for="tanggal" class="block text-sm font-semibold text-gray-700 mb-2">
                    Tanggal <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       id="tanggal" 
                       name="tanggal" 
                       value="{{ old('tanggal') }}"
                       min="{{ date('Y-m-d') }}"
                       required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('tanggal') border-red-500 @enderror">
                @error('tanggal')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select id="status" 
                        name="status" 
                        required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('status') border-red-500 @enderror">
                    <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Terbooking</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jam Mulai -->
            <div>
                <label for="jam_mulai" class="block text-sm font-semibold text-gray-700 mb-2">
                    Jam Mulai <span class="text-red-500">*</span>
                </label>
                <input type="time" 
                       id="jam_mulai" 
                       name="jam_mulai" 
                       value="{{ old('jam_mulai') }}"
                       required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('jam_mulai') border-red-500 @enderror">
                @error('jam_mulai')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jam Selesai -->
            <div>
                <label for="jam_selesai" class="block text-sm font-semibold text-gray-700 mb-2">
                    Jam Selesai <span class="text-red-500">*</span>
                </label>
                <input type="time" 
                       id="jam_selesai" 
                       name="jam_selesai" 
                       value="{{ old('jam_selesai') }}"
                       required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#005248] focus:border-transparent @error('jam_selesai') border-red-500 @enderror">
                @error('jam_selesai')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
            <a href="{{ route('dokter.jadwal-praktek.index') }}" 
               class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-[#005248] text-white rounded-lg hover:bg-[#007a6a] transition-colors font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Tambah Jadwal
            </button>
        </div>
    </form>
</div>
@endsection

