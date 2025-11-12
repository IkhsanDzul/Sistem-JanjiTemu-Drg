<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }} Pasien
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 dark:text-gray-100 shadow-sm sm:rounded-lg mt-5 p-5">
                <div name="list-dokter-tersedia" class="m-5">
                    <img src="" alt="">
                    <h3>Nama Dokter</h3>
                    <p>Spesialisasi</p>
                    <p>13.00 - 14.00</p>
                </div>
                <div name="list-dokter-tersedia" class="m-5">
                    <img src="" alt="">
                    <h3>Nama Dokter</h3>
                    <p>Spesialisasi</p>
                    <p>13.00 - 14.00</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>