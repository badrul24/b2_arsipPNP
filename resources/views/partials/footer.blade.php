<!-- Footer -->
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: {
                        50: '#133656',
                        100: '#133656',
                        200: '#133656',
                        300: '#133656',
                        400: '#133656',
                        500: '#133656',
                        600: '#133656',
                        700: '#133656',
                        800: '#133656',
                        900: '#133656',
                        950: '#133656',
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
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:py-12 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Kiri: Logo+deskripsi atas, Maps bawah -->
            <div class="flex flex-col h-full justify-between pr-4 md:pr-8">
                <div class="flex items-start mb-4">
                    <img class="h-12 w-auto bg-white-800" src="{{ asset('icons/logo.svg') }}" alt="PNP Logo">
                    <div class="ml-3">
                        <div class="text-white font-bold text-lg">SIARSIP</div>
                        <div class="text-gray-400 text-xs">Politeknik Negeri Padang</div>
                    </div>
                </div>
                <p class="text-base text-gray-400 mb-4">
                    Sistem Manajemen Arsip Digital Politeknik Negeri Padang. Solusi modern untuk pengelolaan dokumen kampus yang efisien, aman, dan terintegrasi.
                </p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.3056936183696!2d100.46099661475396!3d-0.9145129993076092!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4b8cf891947c9%3A0x3989067f95c95071!2sPoliteknik%20Negeri%20Padang!5e0!3m2!1sid!2sid!4v1650123456789!5m2!1sid!2sid" width="100%" height="180" style="border:0; min-width:200px; min-height:180px; border-radius:8px;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <!-- Kanan: Tautan dan sosmed align right -->
            <div class="flex flex-col h-full justify-between items-end">
                <div class="grid grid-cols-2 gap-8 w-full justify-end">
                    <div class="text-left flex flex-col justify-between h-full">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase mb-3">Tautan Cepat</h3>
                            <ul class="space-y-2">
                                <li><a href="#beranda" class="text-base text-gray-400 hover:text-white transition-colors duration-200">Beranda</a></li>
                                <li><a href="#fitur" class="text-base text-gray-400 hover:text-white transition-colors duration-200">Fitur</a></li>
                                <li><a href="#tentang" class="text-base text-gray-400 hover:text-white transition-colors duration-200">Tentang</a></li>
                                <li><a href="#kontak" class="text-base text-gray-400 hover:text-white transition-colors duration-200">Kontak</a></li>
                            </ul>
                        </div>
                        <div class="flex space-x-4 mt-4">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                                <i class="fa-brands fa-facebook text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                                <i class="fa-brands fa-instagram text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                                <i class="fa-brands fa-youtube text-xl"></i>
                            </a>
                        </div>
                    </div>
                    <div class="text-left">
                        <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase mb-3">Tautan Eksternal</h3>
                        <ul class="space-y-2">
                            <li><a href="https://pnp.ac.id" class="text-base text-gray-400 hover:text-white transition-colors duration-200">Website PNP</a></li>
                            <li><a href="https://siakad.pnp.ac.id" class="text-base text-gray-400 hover:text-white transition-colors duration-200">SIAKAD</a></li>
                            <li><a href="https://elearning.pnp.ac.id" class="text-base text-gray-400 hover:text-white transition-colors duration-200">E-Learning</a></li>
                            <li><a href="https://library.pnp.ac.id" class="text-base text-gray-400 hover:text-white transition-colors duration-200">Perpustakaan</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-8 border-t border-gray-700 pt-6">
            <p class="text-sm text-gray-400 text-center">
                &copy; 2023 Sistem Manajemen Arsip Digital - Politeknik Negeri Padang.
            </p>
        </div>
    </div>

