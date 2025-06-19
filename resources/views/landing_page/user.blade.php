<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <!-- Tambahkan CSS di sini -->
        <style>
            {
                scroll-behavior: smooth;
            }
        </style>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: {
                                50:  '#d1d9e0', // sangat terang
                                100: '#b4c3d1',
                                200: '#96acc1',
                                300: '#7895b1',
                                400: '#5a7fa1',
                                500: '#3d6992', // warna tengah
                                600: '#2f5171',
                                700: '#223b55',
                                800: '#172a3d',
                                900: '#0e1b28',
                                950: '#080f15', // paling gelap
                            },
                            secondary: {
                                50: '#f5f3ff',
                                100: '#ede9fe',
                                200: '#ddd6fe',
                                300: '#c4b5fd',
                                400: '#a78bfa',
                                500: '#8b5cf6',
                                600: '#7c3aed',
                                700: '#6d28d9',
                                800: '#5b21b6',
                                900: '#4c1d95',
                                950: '#2e1065',
                            }
                        }
                    }
                }
            }
        </script>
        <!-- Alpine.js for interactivity -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <!-- Hero Section -->
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    </head>
    <body>
        @include('partials.navbar')

        <div class="bg-gray-100">
            @hasSection('content')
                @yield('content')
            @else
                <p>Tidak ada konten yang tersedia.</p>
            @endif
        </div>
        <div class="bg-primary-950">
            @include('partials.footer')
        </div>
        <!-- Tambahkan JS di sini -->
        @yield('scripts')
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({
                once: true, // hanya animasi sekali
                duration: 800, // durasi animasi (ms)
            });
        </script>
    </body>
</html>
