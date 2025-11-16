@extends('layouts.pasien')

@section('title', 'Detail Janji Temu')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
    <div class="container mx-auto px-6 py-4">
        <h3 class="text-gray-700 text-3xl font-semibold">Detail Janji Temu</h3>

        <div class="mt-8">
            <div class="flex flex-col">
                <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                    <div class="align-middle inline-block min-w-full shadow sm:rounded-lg border-b border-gray-200">
                        <div class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <img src="{{ asset('storage/' . $janjiTemu->dokter->user->foto_profil) }}" alt="Foto Dokter" class="w-60 h-60 object-cover rounded-md">
                        </div>
                        <div class="flex w-full">
                            <table class="w-full">
                                <tbody class="bg-white">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            Dokter
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $janjiTemu->dokter->user->nama_lengkap }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            Tanggal
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $tanggalFormat }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            Jam Mulai
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $janjiTemu->jam_mulai = \Carbon\Carbon::parse($janjiTemu->jam_mulai)->format('H:i') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            Status
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $janjiTemu->status }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 bg-white">
                                <img src="{{ asset('storage/' . $janjiTemu->foto_gigi) }}" alt="Foto Kondisi Gigi" class="w-60 h-60 object-cover rounded-md">
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 bg-white rounded-xl shadow-sm p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Catatan Penting</h3>
                        <p class="text-sm text-gray-500">Pastikan datang pada 20 atau 10 menit sebelum waktu yang telah ditentukan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection