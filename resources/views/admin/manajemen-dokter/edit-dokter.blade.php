@extends('layouts.admin')

@section('title', 'Edit Dokter')

@section('content')
{{-- Main Content --}}
<div class="space-y-2 px-6">
    <h2 class="text-2xl font-semibold text-gray-800">Edit Dokter</h2>
    <p class="text-gray-600">Perbarui informasi dokter di sini.</p>
</div>
<main class="p-4 sm:p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 flex flex-col gap-6">
        <div class="bg-white rounded-xl shadow-sm p-4">
            <form action="{{ route('admin.update-dokter', $dokter->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="mb-4">
                    <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                    <x-text-input id="nama_lengkap" name="nama_lengkap" type="text" class="mt-1 block w-full" :value="old('nama_lengkap', $dokter->user->nama_lengkap)" required autofocus />
                    <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="spesialisasi_gigi" :value="__('Spesialisasi Gigi')" />
                    <x-text-input id="spesialisasi_gigi" name="spesialisasi_gigi" type="text" class="mt-1 block w-full" :value="old('spesialisasi_gigi', $dokter->spesialisasi_gigi)" required />
                    <x-input-error :messages="$errors->get('spesialisasi_gigi')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="pengalaman_tahun" :value="__('Pengalaman (Tahun)')" />
                    <x-text-input id="pengalaman_tahun" name="pengalaman_tahun" type="number" class="mt-1 block w-full" :value="old('pengalaman_tahun', $dokter->pengalaman_tahun)" required />
                    <x-input-error :messages="$errors->get('pengalaman_tahun')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="nomor_telp" :value="__('No Telepon')" />
                    <x-text-input id="nomor_telp" name="nomor_telp" type="text" class="mt-1 block w-full" :value="old('nomor_telp', $dokter->user->nomor_telp)" required />
                    <x-input-error :messages="$errors->get('nomor_telp')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $dokter->user->email)" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="alamat" :value="__('Alamat')" />
                    <x-text-input id="alamat" name="alamat" type="text" class="mt-1 block w-full" :value="old('alamat', $dokter->user->alamat)" required />
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="status" :value="__('Status')" />
                    <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#005248] focus:border-[#005248]">
                        <option value="tersedia" {{ old('status', $dokter->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="tidak tersedia" {{ old('status', $dokter->status) == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="no_str" :value="__('Nomor STR')" />
                    <x-text-input id="no_str" name="no_str" type="text" class="mt-1 block w-full" :value="old('no_str', $dokter->no_str)" required />
                    <x-input-error :messages="$errors->get('no_str')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="pendidikan" :value="__('Pendidikan')" />
                    <x-text-input id="pendidikan" name="pendidikan" type="text" class="mt-1 block w-full" :value="old('pendidikan', $dokter->pendidikan)" required />
                    <x-input-error :messages="$errors->get('pendidikan')" class="mt-2" />
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-[#005248] hover:bg-[#004137] text-white font-semibold py-2 px-4 rounded-lg transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Sidebar Info --}}
    <div class="w-full lg:col-span-1">
        <div class="sticky top-0 space-y-4">
            <div class="bg-white rounded-xl shadow-sm p-4 space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Informasi Akun Dokter</h3>
                <p class="text-gray-600">Email: {{ $dokter->user->email }}</p>
                <p class="text-gray-600">Password: <span class="font-mono">{{ $dokter->user->email }}123</span></p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4 space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Info Dokter</h3>
                <p class="text-gray-600">Pastikan semua informasi sudah benar sebelum menyimpan perubahan.</p>
            </div>
                <form action="{{ route('admin.delete-dokter', $dokter->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokter ini?');">
                    @csrf
                    @method('delete')
                    <button type="submit" class="mt-4 w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                        Hapus Dokter
                    </button>
                </form>
        </div>
    </div>
</main>
@endsection