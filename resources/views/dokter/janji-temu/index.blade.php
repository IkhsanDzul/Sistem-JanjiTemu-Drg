<x-app-layout title="Janji Temu">
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Header -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
            <h2 class="text-2xl font-semibold text-[#005248]">Daftar Janji Temu</h2>
            <p class="text-gray-600 text-sm">Semua janji temu pasien dalam sistem</p>
        </div>

        <!-- Tabel Janji Temu -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-[#005248] text-white text-left">
                        <th class="p-3">Pasien</th>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Waktu</th>
                        <th class="p-3">Layanan</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $item)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="p-3">{{ $item->nama_pasien }}</td>
                        <td class="p-3">{{ $item->tanggal }}</td>
                        <td class="p-3">{{ $item->waktu }}</td>
                        <td class="p-3">{{ $item->layanan }}</td>
                        <td class="p-3">
                            <span class="px-3 py-1 rounded-full text-sm
                                @if($item->status == 'pending') bg-yellow-200 text-yellow-800 
                                @elseif($item->status == 'approved') bg-green-200 text-green-800 
                                @else bg-gray-200 text-gray-800 @endif">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="p-3">
                            <a href="{{ route('dokter.janji-temu.show', $item->id) }}" 
                               class="text-[#005248] font-semibold hover:text-[#FFA700]">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 p-4">
                            Belum ada janji temu.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
