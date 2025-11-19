<x-app-layout title="Daftar Pasien">
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Header -->
        <div class="bg-gradient-to-r from-[#005248] to-[#007a6a] p-6 rounded-xl shadow-md text-white">
            <div class="flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h2 class="text-2xl font-bold">Daftar Pasien</h2>
                    <p class="text-sm text-white/80">Kelola seluruh data pasien</p>
                </div>

                <!-- Search + Actions -->
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('dokter.daftar-pasien') }}" class="flex items-center">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari nama / No RM / telepon..."
                               class="px-4 py-2 w-80 rounded-lg border border-white/30 bg-white/20 text-white placeholder-white/60 focus:bg-white/30 focus:ring-2 focus:ring-white outline-none">
                    </form>

                    <!-- Optional: tombol tambah atau export -->
                    {{-- <a href="{{ route('dokter.pasien.create') }}" class="bg-white text-[#005248] px-4 py-2 rounded-lg shadow-sm">Tambah</a> --}}
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 overflow-x-auto">

            <table class="w-full min-w-[900px] table-auto text-left">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="py-3 px-3 text-sm font-semibold text-gray-600">No</th>
                        <th class="py-3 px-3 text-sm font-semibold text-gray-600">Nama</th>
                        <th class="py-3 px-3 text-sm font-semibold text-gray-600">No. RM</th>
                        <th class="py-3 px-3 text-sm font-semibold text-gray-600">Jenis Kelamin</th>
                        <th class="py-3 px-3 text-sm font-semibold text-gray-600">Telepon</th>
                        <th class="py-3 px-3 text-sm font-semibold text-gray-600">Alamat (singkat)</th>
                        <th class="py-3 px-3 text-sm font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($patients as $index => $pasien)
                        @php
                            // fallback beberapa nama field (sesuaikan kalau table/alias kamu berbeda)
                            $nama = $pasien->nama ?? optional($pasien->user)->nama_lengkap ?? '-';
                            $noRm = $pasien->nomor_rm ?? $pasien->no_rm ?? $pasien->id ?? '-';
                            $jkRaw = optional($pasien->user)->jenis_kelamin ?? $pasien->jenis_kelamin ?? null;
                            $jenisKelamin = ($jkRaw === 'L' || strtolower($jkRaw) === 'laki-laki' || strtolower($jkRaw) === 'male') ? 'Laki-laki'
                                           : (($jkRaw === 'P' || strtolower($jkRaw) === 'perempuan' || strtolower($jkRaw) === 'female') ? 'Perempuan' : '-');
                            $telepon = $pasien->nomor_telp ?? optional($pasien->user)->nomor_telp ?? optional($pasien->user)->nomor_telp ?? '-';
                            $alamat = optional($pasien->user)->alamat ? Str::limit(optional($pasien->user)->alamat, 40) : ($pasien->alamat ? Str::limit($pasien->alamat, 40) : '-');
                        @endphp

                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-3 px-3 align-top text-sm text-gray-600">
                                {{ $patients->firstItem() + $index }}
                            </td>

                            <td class="py-3 px-3 align-top">
                                <div class="font-medium text-gray-800">{{ $nama }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">
                                    {{-- show nik/email optionally --}}
                                    {{ optional($pasien->user)->nik ? 'NIK: '.optional($pasien->user)->nik : '' }}
                                </div>
                            </td>

                            <td class="py-3 px-3 align-top text-sm text-gray-700">{{ $noRm }}</td>

                            <td class="py-3 px-3 align-top text-sm text-gray-700">{{ $jenisKelamin }}</td>

                            <td class="py-3 px-3 align-top text-sm text-gray-700">{{ $telepon }}</td>

                            <td class="py-3 px-3 align-top text-sm text-gray-600">{{ $alamat }}</td>

                            <td class="py-3 px-3 align-top">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('dokter.daftar-pasien.show', $pasien->id) }}"
                                       class="px-3 py-1 text-sm bg-[#005248] hover:bg-[#007a6a] text-white rounded-lg">
                                        Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-gray-500">
                                Tidak ada data pasien ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $patients->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
