<x-app-layout title="Detail Janji Temu">

    <div class="max-w-4xl mx-auto space-y-6">

        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
            <h2 class="text-2xl font-semibold text-[#005248] mb-4">
                Detail Janji Temu
            </h2>

            <div class="space-y-3">
                <p><strong>Nama Pasien:</strong> {{ $appointment->nama_pasien }}</p>
                <p><strong>Tanggal:</strong> {{ $appointment->tanggal }}</p>
                <p><strong>Waktu:</strong> {{ $appointment->waktu }}</p>
                <p><strong>Layanan:</strong> {{ $appointment->layanan }}</p>
                <p><strong>Keluhan:</strong> {{ $appointment->keluhan }}</p>
                <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
            </div>

            <div class="mt-6 flex gap-3">
                <button class="px-4 py-2 bg-[#005248] text-white rounded-lg hover:bg-[#003c35]">
                    Approve
                </button>
                <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Tolak
                </button>
            </div>

        </div>

    </div>

</x-app-layout>
