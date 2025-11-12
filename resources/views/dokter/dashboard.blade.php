@extends('layouts.dokter')

@section('title', 'Dashboard Dokter')

@section('content')
    <div class="space-y-6">
        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Pasien -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                            <p class="text-sm text-gray-600 mb-1">Total Pasien</p>
                            <p class="text-3xl font-bold text-gray-800">0</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                </div>
            </div>

            <!-- Total Dokter -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                            <p class="text-sm text-gray-600 mb-1">Total Dokter</p>
                            <p class="text-3xl font-bold text-gray-800">0</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                </div>
            </div>

            <!-- Janji Temu Bulan Ini -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                            <p class="text-sm text-gray-600 mb-1">Janji Temu Bulan Ini</p>
                            <p class="text-3xl font-bold text-gray-800">0</p>
                            <p class="text-xs text-gray-500 mt-1">Hari ini: 0</p>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                </div>
            </div>

            <!-- Pendapatan Bulan Ini -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                            <p class="text-sm text-gray-600 mb-1">Pendapatan Bulan Ini</p>
                            <p class="text-3xl font-bold text-gray-800">Rp 0</p>
                            <p class="text-xs text-gray-500 mt-1">Hari ini: Rp 0</p>
                        </div>
                        <div class="bg-emerald-100 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
        </div>

        <!-- Status Cards Row -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <!-- Pending -->
            <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Pending</p>
                        <p class="text-3xl font-bold text-gray-800">0</p>
                    </div>
                    <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                </div>
            </div>

            <!-- Confirmed -->
            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Confirmed</p>
                        <p class="text-3xl font-bold text-gray-800">0</p>
                    </div>
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                </div>
            </div>

            <!-- Completed -->
            <div class="bg-green-50 border-l-4 border-green-500 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Completed</p>
                        <p class="text-3xl font-bold text-gray-800">0</p>
                    </div>
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                </div>
            </div>

            <!-- Canceled -->
            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Canceled</p>
                        <p class="text-3xl font-bold text-gray-800">0</p>
                    </div>
                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Janji Temu Terbaru -->
            <div class="bg-white rounded-lg shadow">
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Janji Temu Terbaru</h3>
                        <a href="#" class="text-sm text-[#005248] hover:text-[#FFA700] font-semibold">Lihat Semua</a>
                    </div>
                    
                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada janji temu
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            </div>

            <!-- User Terbaru -->
            <div class="bg-white rounded-lg shadow">
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">User Terbaru</h3>
                        <a href="#" class="text-sm text-[#005248] hover:text-[#FFA700] font-semibold">Lihat Semua</a>
                    </div>
                    
                    <!-- User List -->
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- User 1 -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-[#005248] text-white w-10 h-10 rounded-full flex items-center justify-center font-semibold">
                                        A
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">Admin</p>
                                        <p class="text-xs text-gray-500">admin@gmail.com</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 text-xs font-semibold text-purple-600 bg-purple-100 rounded-full">Admin</span>
                            </div>

                            <!-- User 2 -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-[#005248] text-white w-10 h-10 rounded-full flex items-center justify-center font-semibold">
                                        A
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">akram</p>
                                        <p class="text-xs text-gray-500">j.akram.w.a@gmail.com</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 text-xs font-semibold text-blue-600 bg-blue-100 rounded-full">Pasien</span>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <!-- Bottom Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <!-- Dokter Aktif -->
            <div class="bg-white rounded-lg shadow">
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Dokter Aktif</h3>
                        <a href="#" class="text-sm text-[#005248] hover:text-[#FFA700] font-semibold">Lihat Semua</a>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-6">
                        <div class="text-center py-8 text-gray-500">
                            Belum ada data dokter aktif
                        </div>
                </div>
            </div>

            <!-- Log Aktivitas -->
            <div class="bg-white rounded-lg shadow">
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Log Aktivitas</h3>
                        <a href="#" class="text-sm text-[#005248] hover:text-[#FFA700] font-semibold">Lihat Semua</a>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Activity Item -->
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                                </div>
                                <div class="flex-grow">
                                    <p class="text-sm text-gray-800">
                                        <span class="font-semibold">Admin</span> melakukan login
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">Baru saja</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                </div>
                                <div class="flex-grow">
                                    <p class="text-sm text-gray-800">
                                        <span class="font-semibold">Akram</span> mendaftar sebagai pasien baru
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">5 menit yang lalu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection