<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>DentaTime - Sistem Manajemen Klinik Gigi</title>
    
    <!-- Font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS & Alpine.js -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        /* Sembunyikan elemen dengan x-cloak sebelum Alpine.js load */
        [x-cloak] { 
            display: none !important; 
        }
    </style>
</head>

<body class="font-sans bg-gray-50">
    <div class="min-h-screen">
        
        <!-- SIDEBAR KIRI -->
        <x-dokter-sidebar />
        
        <!-- KONTEN UTAMA (dengan margin kiri untuk sidebar) -->
        <div class="lg:ml-64">
            
            <!-- HEADER ATAS -->
            <x-dokter-header :title="$title" :subtitle="$subtitle ?? null" />
            
            <!-- ISI HALAMAN -->
            <main class="p-6">
                {{ $slot }}
            </main>
            
        </div>
        
    </div>
</body>
</html>