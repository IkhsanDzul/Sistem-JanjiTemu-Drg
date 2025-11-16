@extends('layouts.admin')

@section('title', 'Tambah Dokter')

@section('content')
{{-- Main Content --}}
<div class="space-y-2 px-6">
    <h2 class="text-2xl font-semibold text-gray-800">Daftarkan Dokter</h2>
    <p class="text-gray-600">Daftarkan dokter di sini.</p>
</div>
<main class="p-4 sm:p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 flex flex-col gap-6">
        <div class="bg-white rounded-xl shadow-sm p-4">
            <form action="{{ route('admin.daftarkan-dokter') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="mb-4">
                    <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                    <x-text-input id="nama_lengkap" name="nama_lengkap" type="text" class="mt-1 block w-full" placeholder="Masukkan nama lengkap dengan Dokter dan Gelar" required autofocus />
                    <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="nik" :value="__('NIK')" />
                    <x-text-input id="nik" name="nik" type="number" class="mt-1 block w-full" placeholder="Masukkan NIK dokter" required />
                    <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="nomor_telp" :value="__('No Telepon')" />
                    <x-text-input id="nomor_telp" name="nomor_telp" type="number" class="mt-1 block w-full" placeholder="Masukkan nomor telepon dokter" required />
                    <x-input-error :messages="$errors->get('nomor_telp')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" placeholder="Masukkan email dokter" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="alamat" :value="__('Alamat')" />
                    <x-text-input id="alamat" name="alamat" type="text" class="mt-1 block w-full" placeholder="Masukkan alamat dokter" required />
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                    <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                    <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#005248] focus:border-[#005248]">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                    <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                </div>
                <!-- <div class="mb-4">
                    <x-input-label for="status" :value="__('Status')" />
                    <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#005248] focus:border-[#005248]">
                        <option value="tersedia">Tersedia</option>
                        <option value="tidak tersedia">Tidak Tersedia</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div> -->
                <div class="mb-4">
                    <x-input-label for="spesialisasi_gigi" :value="__('Spesialisasi Gigi')" />
                    <x-text-input id="spesialisasi_gigi" name="spesialisasi_gigi" type="text" class="mt-1 block w-full" placeholder="Masukkan spesialisasi gigi dokter" required />
                    <x-input-error :messages="$errors->get('spesialisasi_gigi')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="pengalaman_tahun" :value="__('Pengalaman (Tahun)')" />
                    <x-text-input id="pengalaman_tahun" name="pengalaman_tahun" type="number" class="mt-1 block w-full" placeholder="Masukkan pengalaman dalam tahun" required />
                    <x-input-error :messages="$errors->get('pengalaman_tahun')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="no_str" :value="__('Nomor STR')" />
                    <x-text-input id="no_str" name="no_str" type="text" class="mt-1 block w-full" placeholder="Masukkan nomor STR dokter" required />
                    <x-input-error :messages="$errors->get('no_str')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="pendidikan" :value="__('Pendidikan')" />
                    <x-text-input id="pendidikan" name="pendidikan" type="text" class="mt-1 block w-full" placeholder="Masukkan pendidikan dokter" required />
                    <x-input-error :messages="$errors->get('pendidikan')" class="mt-2" />
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-[#005248] hover:bg-[#004137] text-white font-semibold py-2 px-4 rounded-lg transition">
                        Daftarkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Sidebar Info --}}
    <div class="w-full lg:col-span-1">
        <div class="sticky top-0">
            <div class="bg-white rounded-xl shadow-sm p-4 space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Info Dokter</h3>
                <p class="text-gray-600">Pastikan semua informasi sudah benar sebelum mendaftarkan dokter.</p>
            </div>
        </div>
    </div>
</main>
@endsection