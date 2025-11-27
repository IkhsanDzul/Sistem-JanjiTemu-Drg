@extends('layouts.pasien')

@section('title', 'Detail Dokter')
@php
    $title = 'Detail Dokter';
    $subtitle = $dokter->user->nama_lengkap ?? 'Dokter Gigi';
@endphp

@section('content')
<div class="flex flex-col lg:flex-row h-screen bg-gray-50 overflow-hidden">
    <div class="flex-1 flex flex-col h-full overflow-y-auto">
        <main class="flex-1 p-6 grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 gap-6 h-full ">

            {{-- DETAIL DOKTER --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
                <div class="flex flex-col lg:flex-row lg:items-center gap-6">
                    <div class="w-md h-48 md:w-48 md:h-48 bg-gray-200 rounded-md flex items-center justify-center overflow-hidden">
                        @if($dokter->user && $dokter->user->foto_profil)
                        <img src="{{ asset('storage/' . $dokter->user->foto_profil) }}"
                            alt="Foto Dokter"
                            class="w-full h-full object-cover rounded-md"
                            onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center hidden">
                            <span class="text-gray-400 font-bold text-4xl">
                                {{ strtoupper(substr($dokter->user->nama_lengkap ?? 'D', 0, 1)) }}
                            </span>
                        </div>
                        @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400 font-bold text-4xl">
                                {{ strtoupper(substr($dokter->user->nama_lengkap ?? 'D', 0, 1)) }}
                            </span>
                        </div>
                        @endif
                    </div>

                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">{{ $dokter->user->nama_lengkap }}</h2>
                        <p class="text-gray-500">{{ $dokter->spesialisasi_gigi }}</p>
                        <p class="text-gray-500">{{ $dokter->pengalaman_tahun }} tahun pengalaman</p>
                    </div>
                </div>

                <div class="mt-6 space-y-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Informasi Kontak</h3>
                        <p class="text-gray-600">Email: {{ $dokter->user->email }}</p>
                        <p class="text-gray-600">No Telepon: {{ $dokter->user->nomor_telp }}</p>
                    </div>

                    <hr>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Pendidikan</h3>
                        <p class="text-gray-600">{{ $dokter->pendidikan ?? '-' }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Status</h3>
                        <p class="text-gray-600 capitalize">{{ $dokter->status }}</p>
                    </div>
                </div>
            </div>


            {{-- SIDEBAR BOOKING --}}
            <div class="sticky top-0 p-4 bg-white rounded-xl shadow-md space-y-4 h-fit">
                <form action="{{ route('pasien.buat-janji') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Buat Janji dengan Dokter</h2>

                    {{-- Pilih Tanggal --}}
                    <div class="mb-4">
                        <label for="tanggal" class="block text-gray-700 mb-2 font-semibold">Pilih Tanggal</label>

                        <select id="tanggal" name="tanggal"
                            class="w-full p-2 border border-gray-300 rounded"
                            onchange="window.location='?tanggal=' + this.value">
                            <option value="">-- Pilih Tanggal --</option>

                            
                            @foreach ($jadwalFormat as $tgl)
                            <option value="{{ $tgl }}"
                                {{ isset($tanggalDipilih) && $tanggalDipilih == $tgl ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($tgl)->locale('id')->isoFormat('ddd, DD MMM YYYY') }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Pilih Jam --}}
                    <div class="mb-4">
                        <label for="jam_mulai" class="block text-gray-700 mb-2 font-semibold">Pilih Jam</label>

                        <select id="jam_mulai" name="jam_mulai" class="w-full p-2 border border-gray-300 rounded" {{ !$tanggalDipilih ? 'disabled' : '' }}>

                            @if(!$tanggalDipilih)
                            <option>Silakan pilih tanggal dulu</option>
                            @else
                            @forelse ($jamPraktek as $jam)
                            <option value="{{ $jam }}">
                                {{ \Carbon\Carbon::parse($jam)->format('H:i') }}
                            </option>
                            @empty
                            <option>Tidak ada jam tersedia</option>
                            @endforelse
                            @endif

                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="keluhan" class="block text-gray-700 mb-2">Keterangan *</label>
                        <textarea id="keluhan" name="keluhan" rows="3" class="w-full border border-gray-300 rounded-md p-2" placeholder="Jelaskan keluhan" required></textarea>
                    </div>

                    <input type="hidden" name="dokter_id" value="{{ $dokter->id }}">
                    <input type="hidden" name="pasien_id" value="{{ auth()->user()->pasien->id }}">
                    <input type="hidden" name="status" value="pending">

                    <button type="submit" class="w-full bg-[#005248] hover:bg-[#004039] text-white py-2 rounded-lg">Buat Janji</button>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection