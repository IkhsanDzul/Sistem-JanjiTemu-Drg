<x-app-layout title="Detail Pasien">
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Header -->
        <div class="bg-gradient-to-r from-[#005248] to-[#007a6a] p-6 rounded-lg shadow text-white">
            <h1 class="text-2xl font-semibold">Detail Pasien</h1>
            <p class="text-sm text-gray-200">Informasi lengkap mengenai data pasien</p>
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-6 flex gap-3">
            <a href="{{ url('/dokter/daftar-pasien') }}"
               class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                Kembali
            </a>

            @if($pasien->rekamMedis->count() > 0)
                <a href="{{ route('dokter.rekam-medis.show', $pasien->rekamMedis->first()->id) }}"
                   class="bg-[#005248] text-white px-4 py-2 rounded-lg hover:bg-[#007a6a] transition">
                    Lihat Rekam Medis
                </a>
            @else
                <span class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed">
                    Belum Ada Rekam Medis
                </span>
            @endif
        </div>
        <!-- Card Informasi -->
        <div class="bg-white shadow rounded-lg p-6 border border-gray-200">

            <!-- Data Pribadi -->
            <h2 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Data Pribadi</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <p class="text-sm text-gray-500">Nama Lengkap</p>
                    <p class="text-base font-medium text-gray-800">{{ $pasien->user->nama_lengkap }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Nomor Rekam Medis (No. RM)</p>
                    <p class="text-base font-medium text-gray-800">{{ $pasien->no_rm ?? 'Belum ada No. RM' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Jenis Kelamin</p>
                    <p class="text-base font-medium text-gray-800">{{ $pasien->user->jenis_kelamin }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Tanggal Lahir</p>
                    <p class="text-base font-medium text-gray-800">
                        {{ $pasien->user->tanggal_lahir ? \Carbon\Carbon::parse($pasien->user->tanggal_lahir)->format('d M Y') : '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Nomor Telepon</p>
                    <p class="text-base font-medium text-gray-800">{{ $pasien->user->nomor_telp }}</p>
                </div>

                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500">Alamat</p>
                    <p class="text-base font-medium text-gray-800">{{ $pasien->user->alamat }}</p>
                </div>

            </div>

        </div>

        <!-- Card Informasi Medis -->
        <div class="bg-white shadow rounded-lg p-6 border border-gray-200">

            <h2 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Informasi Medis</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <p class="text-sm text-gray-500">Golongan Darah</p>
                    <p class="text-base font-medium text-gray-800">{{ $pasien->golongan_darah ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Alergi</p>
                    <p class="text-base font-medium text-gray-800">{{ $pasien->alergi ?? '-' }}</p>
                </div>

                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500">Riwayat Penyakit</p>
                    <p class="text-base font-medium text-gray-800">
                        {{ $pasien->riwayat_penyakit ?? '-' }}
                    </p>
                </div>

            </div>
        </div>


</x-app-layout>
