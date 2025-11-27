<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="DentaTime - Sistem manajemen janji temu dokter gigi yang modern dan terpercaya. Booking janji temu online 24/7 dengan mudah dan cepat.">
        <meta name="keywords" content="janji temu dokter gigi, booking dokter gigi, perawatan gigi, kesehatan gigi, dokter gigi online">
        <meta name="author" content="DentaTime">
        <meta property="og:title" content="DentaTime - Sistem Janji Temu Dokter Gigi">
        <meta property="og:description" content="Sistem manajemen janji temu dokter gigi yang modern dan terpercaya. Booking janji temu online 24/7 dengan mudah dan cepat.">
        <meta property="og:type" content="website">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="theme-color" content="#005248">

        <title>DentaTime - Sistem Janji Temu Dokter Gigi</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
            /* Fallback styles jika Vite belum di-build */
            body {
                font-family: 'Figtree', sans-serif;
            }
            </style>
        @endif
    </head>
<body class="font-sans antialiased bg-white scroll-smooth">
    <!-- Loading Screen -->
    <div id="loading-screen" class="fixed inset-0 bg-gradient-to-br from-[#005248] to-[#003d3a] z-50 flex items-center justify-center transition-opacity duration-500">
        <div class="text-center">
            <div class="w-20 h-20 border-4 border-[#FFA700] border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-white text-lg font-semibold">DentaTime</p>
        </div>
    </div>
    <script>
        window.addEventListener('load', function() {
            const loadingScreen = document.getElementById('loading-screen');
            setTimeout(() => {
                loadingScreen.style.opacity = '0';
                setTimeout(() => {
                    loadingScreen.style.display = 'none';
                }, 500);
            }, 500);
        });
    </script>
    <!-- Navbar -->
    <x-navbar-landing />

    <!-- Hero Section -->
    <x-hero-section />

    <!-- Card Information Section -->
    <x-card-informasi />

    <!-- Carousel Tim Kami -->
    <x-carousel-tim />

    <!-- Section Layanan -->
    <x-section-layanan />

    <!-- Section Testimoni -->
    <x-section-testimoni />

    <!-- Section FAQ -->
    <x-section-faq />

    <!-- Footer -->
    <x-footer-landing />
    </body>
</html>
