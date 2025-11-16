@extends('layouts.pasien')

@section('title', 'Detail Dokter')

@section('content')
<div class="flex flex-col lg:flex-row h-screen bg-gray-50 overflow-hidden">
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        <main class="flex-1 p-6 grid grid-cols-1 lg:grid-cols-3 gap-6 h-full overflow-hidden">

            {{-- DETAIL DOKTER --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
                <div class="flex flex-col lg:flex-row lg:items-center gap-6">
                    <div class="w-60 h-60 bg-gray-200 rounded-md flex items-center justify-center text-gray-400 text-xl">
                        <img src="{{ asset('storage/' . $dokter->user->foto_profil) }}" alt="Foto Dokter"
                            class="w-full h-full object-cover rounded-md">
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
            <div>
                <div class="sticky top-0 p-4 bg-white rounded-xl shadow-md space-y-4">

                    <h3 class="text-lg font-semibold text-gray-800">Buat Janji Temu</h3>

                    {{-- PILIH TANGGAL --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Tanggal</label>

                        <div class="grid grid-cols-3 gap-2">
                            @foreach ($jadwalFormatted as $tgl)
                            <button
                                class="px-2 py-1 bg-gray-100 rounded-md text-sm hover:bg-teal-600 hover:text-white focus:ring focus:ring-teal-300 transition">
                                {{ $tgl }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- PILIH JAM --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pilih Jam</label>
                        <select class="w-full px-3 py-2 border rounded-md mt-1 focus:ring-2 focus:ring-teal-500">
                            <option>08:00</option>
                            <option>10:00</option>
                            <option>13:00</option>
                            <option>15:00</option>
                        </select>
                    </div>

                    {{-- BUTTON --}}
                    <button class="w-full bg-teal-600 text-white py-2 rounded-lg font-semibold hover:bg-teal-700">
                        Buat Janji
                    </button>

                </div>
            </div>

        </main>
    </div>
</div>
@endsection