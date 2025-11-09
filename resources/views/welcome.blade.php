<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
<body class="font-sans antialiased bg-white">
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
