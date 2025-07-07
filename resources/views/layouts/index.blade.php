<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SI ARSIP | Politeknik Negeri Padang</title>
    <meta name="description" content="Sistem Informasi Arsip Politeknik Negeri Padang">
    <link rel="icon" type="image/x-icon" href="https://laravel.com/img/favicon/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                            950: '#082f49',
                        },
                    }
                }
            }
        }
    </script>

    <style>
        /* Form Select2 multiple dengan padding bawah agar tidak sempit */
        .select2-container--default .select2-selection--multiple {
            min-height: 42px !important;
            padding: 6px 12px 10px 12px !important;
            /* Tambah padding bawah */
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
        }

        /* Hilangkan kolom input pencarian */
        .select2-container--default .select2-selection--multiple .select2-search--inline {
            display: none !important;
        }
    </style>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    @stack('styles')
</head>

<body class="bg-gray-50">
    <div x-data="{ sidebarOpen: true }">
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="transition-all duration-300" :class="sidebarOpen ? 'md:ml-52' : 'md:ml-16'">
            @include('layouts.header')

            <!-- Page Content -->
            <div class="p-4 sm:p-6 lg:p-8">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Pilih opsi...",
                allowClear: true,
                width: '100%' // Agar lebar full seperti input lain
            });
        });
    </script>

</body>

</html>
