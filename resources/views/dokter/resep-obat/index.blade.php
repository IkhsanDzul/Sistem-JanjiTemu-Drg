<x-app-layout title="Pilih Pasien - Resep Obat">

    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Header -->
        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200">
            <h1 class="text-2xl font-semibold text-gray-800">Resep Obat</h1>
            <p class="text-gray-600 text-sm">Pilih pasien untuk membuat resep obat.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Daftar Pasien -->
        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200">
            <h2 class="font-semibold text-lg mb-4">Daftar Pasien</h2>

            @if($pasienList->isEmpty())
                <p class="text-gray-600 text-center py-8">Belum ada data pasien.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="px-4 py-3">No. RM</th>
                                <th class="px-4 py-3">Nama Pasien</th>
                                <th class="px-4 py-3">Usia</th>
                                <th class="px-4 py-3">Jenis Kelamin</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($pasienList as $pasien)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $pasien->no_rm }}</td>
                                    <td class="px-4 py-3">{{ $pasien->nama }}</td>
                                    <td class="px-4 py-3">{{ $pasien->usia }} tahun</td>
                                    <td class="px-4 py-3">{{ ucfirst($pasien->jenis_kelamin) }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('dokter.resep-obat.index', ['pasien_id' => $pasien->id]) }}"
                                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 inline-block text-xs">
                                            Buat Resep
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $pasienList->links() }}
                </div>
            @endif

        </div>

    </div>

</x-app-layout>