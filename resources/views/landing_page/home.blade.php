<!-- Features Section -->
@extends('landing_page.user')
@section('title','Home')
@section('content')
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
<section id="beranda" class="relative h-[610px] flex bg-gradient-to-r from-primary-600 to-primary-800 overflow-hidden" style="background-image: url('{{ asset('images/home.png') }}'); background-size: 100% 100%; background-repeat: no-repeat; background-position: 0 22%;">
    <div class="absolute inset-0 bg-gradient-to-r from-primary-400 via-primary-700/60 to-transparent z-10"></div>
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-black bg-opacity-60 z-20">
        <!-- Kanan Bawah -->
        <svg class="absolute right-0 bottom-0 transform translate-x-1/2 opacity-20" width="404" height="404" fill="none" viewBox="0 0 404 404">
            <defs>
                <pattern id="pattern-right" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                    <rect x="0" y="0" width="4" height="4" class="text-white" fill="currentColor" />
                </pattern>
            </defs>
            <rect width="300" height="300" fill="url(#pattern-right)" />
        </svg>

        <!-- Kiri Bawah -->
        <svg class="absolute bottom-0 left-0 transform -translate-x-1/2 opacity-20" width="404" height="404" fill="none" viewBox="0 0 404 404">
            <defs>
                <pattern id="pattern-left" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                    <rect x="0" y="0" width="4" height="4" class="text-white" fill="currentColor" />
                </pattern>
            </defs>
            <rect width="404" height="404" fill="url(#pattern-left)" />
        </svg>
    </div>
    <!-- Konten -->
    <div class="max-w-7xl ml-[30px] px-4 sm:px-6 lg:px-8 py-16 md:py-20 relative z-30 h-full flex flex-col justify-center">
        <div class="grid grid-cols-1 md:grid-cols-1 gap-10">
            <!-- Teks -->
            <div class="mt-0 pt-[80px]">
                <h1 class="text-3xl sm:text-4xl md:text-[40px] font-extrabold tracking-tight text-white">
                    Sistem Manajemen Arsip Digital
                </h1>
                <p class="indent-6 mt-4 text-justify sm:mt-6 text-[8px] sm:text-[15px] md:text-[15px] text-white opacity-90 max-w-2xl">
                    Sistem Manajemen Arsip Digital kami dirancang khusus untuk
                    membantu organisasi dan individu dalam menyimpan,mencari, dan mengelola
                    dokumen secara efisien, membebaskan Anda dari kerumitan arsip fisik. Dengan
                    platform intuitif ini, Anda bisa mendokumentasikan, mengklasifikasikan,
                    dan menemukan setiap arsip penting dalam hitungan detik, di mana pun Anda
                    berada. Tingkatkan produktivitas tim, lindungi data sensitif dengan keamanan
                    berlapis, dan optimalkan seluruh alur kerja bisnis Anda di era digital.
                </p>

                <!-- Tombol -->
                <div class="mt-6 sm:mt-10 flex flex-col sm:flex-row gap-4">
                    <a href="#fitur" class="inline-flex justify-center items-center px-6 py-3 text-base font-medium rounded-md text-primary-700 bg-white hover:bg-gray-50 shadow">
                        Pelajari Lebih Lanjut
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-6 py-3 text-base font-medium rounded-md text-white bg-primary-900 bg-opacity-60 hover:bg-opacity-70">
                        Masuk Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Stats Section -->
<section class="py-12 mb-[-50px] bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6 text-center">
                    <div class="text-5xl font-bold text-primary-600 mb-3">
                        <i class="fa-solid fa-file-archive"></i>
                    </div>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Total Arsip
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        12,500+
                    </dd>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6 text-center">
                    <div class="text-5xl font-bold text-primary-600 mb-3">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Pengguna Aktif
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        250+
                    </dd>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6 text-center">
                    <div class="text-5xl font-bold text-primary-600 mb-3">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Jurusan & Unit
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        15
                    </dd>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6 text-center">
                    <div class="text-5xl font-bold text-primary-600 mb-3">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Waktu Pencarian
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        < 5 detik
                    </dd>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="berita" class="py-12 bg-white">
  <div class="max-w-7xl mx-auto pt-12 px-10 sm:px-6 lg:px-12">
    <!-- Judul -->
    <div class="mb-6 ">
      <h1 class="text-3xl font-bold text-primary-800 flex items-center gap-2">
        <i class="fas fa-newspaper text-primary-100 text-lg"></i>  <!-- icon fontawesome -->
        Berita Terkini
      </h1>
      <h5 class="text-sm text-gray-500 mt-1">Update terbaru seputar sistem arsip digital</h5>
    </div>
    <!-- Kurangi jarak vertikal antar berita -->
    <div class="space-y-4">
      <!-- Berita 1 -->
      <article class="relative h-64 rounded-lg overflow-hidden group">
        <img src="https://picsum.photos/800/400?random=11" alt="berita" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        <div class="absolute inset-0 bg-black bg-opacity-50 p-6 flex flex-col justify-end text-white">
          <h3 class="text-xl font-semibold">
            <a href="#" class="hover:underline">Peluncuran Sistem Arsip Digital di Politeknik Negeri Padang</a>
          </h3>
          <p class="text-sm text-gray-300">1 Juni 2025 • Admin</p>
          <p class="mt-2 text-sm">
            Sistem baru ini memudahkan pegawai dan mahasiswa dalam mengelola serta mengakses arsip kampus secara digital. Peluncuran ini disambut positif oleh civitas akademika.
          </p>
          <a href="#" class="inline-block mt-3 text-sm text-primary-300 hover:underline">Baca selengkapnya →</a>
        </div>
      </article>

      <!-- Berita 2 -->
      <article class="relative h-64 rounded-lg overflow-hidden group">
        <img src="https://picsum.photos/800/400?random=12" alt="berita" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        <div class="absolute inset-0 bg-black bg-opacity-50 p-6 flex flex-col justify-end text-white">
          <h3 class="text-xl font-semibold">
            <a href="#" class="hover:underline">Workshop Keamanan Arsip Digital Diselenggarakan</a>
          </h3>
          <p class="text-sm text-gray-300">28 Mei 2025 • Humas</p>
          <p class="mt-2 text-sm">
            Workshop ini membahas pentingnya enkripsi, kontrol akses, dan pemulihan data dalam sistem digital. Peserta berasal dari berbagai jurusan dan unit kerja.
          </p>
          <a href="#" class="inline-block mt-3 text-sm text-primary-300 hover:underline">Baca selengkapnya →</a>
        </div>
      </article>

      <!-- Berita 3 -->
      <article class="relative h-64 rounded-lg overflow-hidden group">
        <img src="https://picsum.photos/800/400?random=13" alt="berita" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        <div class="absolute inset-0 bg-black bg-opacity-50 p-6 flex flex-col justify-end text-white">
          <h3 class="text-xl font-semibold">
            <a href="#" class="hover:underline">Integrasi Sistem Arsip dengan Aplikasi Mobile Kampus</a>
          </h3>
          <p class="text-sm text-gray-300">24 Mei 2025 • IT Center</p>
          <p class="mt-2 text-sm">
            Kini mahasiswa dapat mengakses arsip pribadi dan akademik langsung dari aplikasi mobile resmi kampus. Integrasi ini mempercepat proses pencarian dokumen.
          </p>
          <a href="#" class="inline-block mt-3 text-sm text-primary-300 hover:underline">Baca selengkapnya →</a>
        </div>
      </article>
    </div>

    <!-- Berita Lainnya -->
    <div class="mt-10">
      <h5 class="font-bold text-primary-800 flex items-center gap-2">
        <i class="fas fa-newspaper text-primary-100 text-lg"></i>  <!-- icon fontawesome -->
        Berita lainnya
      </h5>
      <p class="text-sm text-gray-500 mt-1">Berita lain yang menarik seputar arsip</p>
      <!-- Kurangi jarak grid gap -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-3">
        <!-- Card 1 -->
        <div class="relative h-52 rounded-lg overflow-hidden group">
          <img src="https://picsum.photos/400/300?random=21" alt="berita" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
          <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-end p-4 text-white">
            <h4 class="font-semibold text-base">Workshop Keamanan Arsip Digital</h4>
            <p class="text-sm">28 Mei 2025</p>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="relative h-52 rounded-lg overflow-hidden group">
          <img src="https://picsum.photos/400/300?random=22" alt="berita" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
          <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-end p-4 text-white">
            <h4 class="font-semibold text-base">Integrasi Arsip dengan Aplikasi Mobile</h4>
            <p class="text-sm">24 Mei 2025</p>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="relative h-52 rounded-lg overflow-hidden group">
          <img src="https://picsum.photos/400/300?random=23" alt="berita" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
          <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-end p-4 text-white">
            <h4 class="font-semibold text-base">Simulasi Backup Arsip Tahunan</h4>
            <p class="text-sm">20 Mei 2025</p>
          </div>
        </div>

        <!-- Card 4 -->
        <div class="relative h-52 rounded-lg overflow-hidden group">
          <img src="https://picsum.photos/400/300?random=24" alt="berita" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
          <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-end p-4 text-white">
            <h4 class="font-semibold text-base">Tim IT Luncurkan Fitur Log Aktivitas</h4>
            <p class="text-sm">18 Mei 2025</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- fitur section -->
<section id="fitur" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
        <div class="text-center">
            <h2 class="text-base font-semibold text-primary-600 tracking-wide uppercase">Fitur Unggulan</h2>
            <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight">
                Kelola Arsip dengan Mudah
            </p>
            <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">
                Sistem manajemen arsip yang dirancang khusus untuk kebutuhan Politeknik Negeri Padang
            </p>
        </div>

        <div class="mt-16">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Feature 1 -->
                <div class="flex flex-col bg-white rounded-lg shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="flex-shrink-0 bg-primary-500 p-6 flex items-center justify-center">
                        <i class="fa-solid fa-magnifying-glass text-white text-3xl"></i>
                    </div>
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900">Pencarian Cepat</h3>
                            <p class="mt-3 text-base text-gray-500">
                                Temukan arsip yang Anda butuhkan dalam hitungan detik dengan fitur pencarian canggih berdasarkan kata kunci, tanggal, kategori, dan metadata lainnya.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="flex flex-col bg-white rounded-lg shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="flex-shrink-0 bg-primary-500 p-6 flex items-center justify-center">
                        <i class="fa-solid fa-folder-tree text-white text-3xl"></i>
                    </div>
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900">Kategorisasi Otomatis</h3>
                            <p class="mt-3 text-base text-gray-500">
                                Sistem cerdas yang mengkategorikan arsip berdasarkan jenis, departemen, dan tahun secara otomatis untuk memudahkan pengelolaan dan penemuan kembali.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="flex flex-col bg-white rounded-lg shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="flex-shrink-0 bg-primary-500 p-6 flex items-center justify-center">
                        <i class="fa-solid fa-lock text-white text-3xl"></i>
                    </div>
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900">Keamanan Berlapis</h3>
                            <p class="mt-3 text-base text-gray-500">
                                Lindungi arsip penting dengan sistem keamanan berlapis, termasuk enkripsi data, kontrol akses berbasis peran, dan log aktivitas lengkap.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="flex flex-col bg-white rounded-lg shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="flex-shrink-0 bg-primary-500 p-6 flex items-center justify-center">
                        <i class="fa-solid fa-chart-line text-white text-3xl"></i>
                    </div>
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900">Analitik & Laporan</h3>
                            <p class="mt-3 text-base text-gray-500">
                                Dapatkan wawasan mendalam tentang penggunaan arsip dengan dashboard analitik dan laporan yang dapat disesuaikan untuk pengambilan keputusan yang lebih baik.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Feature 5 -->
                <div class="flex flex-col bg-white rounded-lg shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="flex-shrink-0 bg-primary-500 p-6 flex items-center justify-center">
                        <i class="fa-solid fa-mobile-screen text-white text-3xl"></i>
                    </div>
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900">Akses Mobile</h3>
                            <p class="mt-3 text-base text-gray-500">
                                Akses arsip dari mana saja dan kapan saja dengan antarmuka yang responsif dan dioptimalkan untuk perangkat mobile.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Feature 6 -->
                <div class="flex flex-col bg-white rounded-lg shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="flex-shrink-0 bg-primary-500 p-6 flex items-center justify-center">
                        <i class="fa-solid fa-clock-rotate-left text-white text-3xl"></i>
                    </div>
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900">Riwayat & Versi</h3>
                            <p class="mt-3 text-base text-gray-500">
                                Lacak perubahan dokumen dengan sistem kontrol versi dan riwayat lengkap untuk memastikan integritas data dan kepatuhan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
        <div class="text-center">
            <h2 class="text-base font-semibold text-primary-600 tracking-wide uppercase">Cara Kerja</h2>
            <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight">
                Proses Pengelolaan Arsip
            </p>
            <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">
                Sistem yang sederhana namun powerful untuk mengelola seluruh siklus hidup arsip
            </p>
        </div>

        <div class="mt-16">
            <div class="relative">
                <!-- Steps -->
                <div class="relative z-10">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <!-- Step 1 -->
                        <div class="relative flex flex-col items-center">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-primary-100 text-white text-2xl font-bold border-4 border-white shadow-lg mb-4">
                                1
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 text-center">Unggah Dokumen</h3>
                            <p class="mt-2 text-sm text-gray-500 text-center">
                                Unggah dokumen fisik yang telah dipindai atau dokumen digital langsung ke sistem
                            </p>
                        </div>

                        <!-- Step 2 -->
                        <div class="relative flex flex-col items-center">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-primary-100 text-white text-2xl font-bold border-4 border-white shadow-lg mb-4">
                                2
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 text-center">Klasifikasi & Metadata</h3>
                            <p class="mt-2 text-sm text-gray-500 text-center">
                                Tambahkan metadata dan klasifikasikan dokumen berdasarkan kategori yang sesuai
                            </p>
                        </div>

                        <!-- Step 3 -->
                        <div class="relative flex flex-col items-center">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-primary-100 text-white text-2xl font-bold border-4 border-white shadow-lg mb-4">
                                3
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 text-center">Penyimpanan & Pengindeksan</h3>
                            <p class="mt-2 text-sm text-gray-500 text-center">
                                Sistem menyimpan dan mengindeks dokumen untuk pencarian cepat
                            </p>
                        </div>

                        <!-- Step 4 -->
                        <div class="relative flex flex-col items-center">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-primary-100 text-white text-2xl font-bold border-4 border-white shadow-lg mb-4">
                                4
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 text-center">Akses & Penggunaan</h3>
                            <p class="mt-2 text-sm text-gray-500 text-center">
                                Temukan dan gunakan dokumen dengan mudah sesuai dengan hak akses yang dimiliki
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Connecting Line -->
                <div class="absolute top-8 w-full hidden md:block">
                    <div class="h-1 bg-gray-200 w-full"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
        <div class="text-center">
            <h2 class="text-base font-semibold text-primary-600 tracking-wide uppercase">Testimoni</h2>
            <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight">
                Apa Kata Pengguna
            </p>
        </div>

        <div class="mt-16 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <!-- Testimonial 1 -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center">
                        <span class="text-white font-bold text-xl">D</span>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-semibold">Dr. Dedi Irawan</h4>
                        <p class="text-gray-500">Ketua Jurusan Teknik Elektro</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">
                    "Sistem ini telah mengubah cara kami mengelola arsip jurusan. Pencarian dokumen yang dulunya memakan waktu berjam-jam, kini hanya dalam hitungan detik."
                </p>
                <div class="mt-4 flex text-primary-500">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center">
                        <span class="text-white font-bold text-xl">S</span>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-semibold">Siti Rahma</h4>
                        <p class="text-gray-500">Staff Administrasi Akademik</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">
                    "Sangat membantu dalam pekerjaan sehari-hari. Dokumen tersimpan dengan rapi dan mudah ditemukan kembali. Tidak perlu lagi mencari berkas fisik di lemari arsip yang penuh debu."
                </p>
                <div class="mt-4 flex text-primary-500">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-alt"></i>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center">
                        <span class="text-white font-bold text-xl">F</span>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-semibold">Fajar Pratama</h4>
                        <p class="text-gray-500">Mahasiswa Teknik Informatika</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">
                    "Sebagai asisten lab, saya sering membutuhkan akses cepat ke dokumen praktikum. Sistem ini membuat semuanya lebih efisien dan terorganisir dengan baik."
                </p>
                <div class="mt-4 flex text-primary-500">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- CTA Section -->
<section class="bg-primary-700">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-12 lg:flex lg:items-center lg:justify-between">
        <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
            <span class="block">Siap untuk memulai?</span>
            <span class="block text-white">Akses sistem manajemen arsip sekarang.</span>
        </h2>
        <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
            <div class="inline-flex rounded-md shadow">
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-primary-600 bg-white hover:text-white hover:bg-primary-50">
                    Masuk
                </a>
            </div>
            <div class="ml-3 inline-flex rounded-md shadow">
                <a href="#kontak" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-500">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section -->
<section id="kontak" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
        <div class="text-center">
            <h2 class="text-base font-semibold text-primary-600 tracking-wide uppercase">Kontak</h2>
            <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight">
                Hubungi Kami
            </p>
            <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">
                Punya pertanyaan atau butuh bantuan? Jangan ragu untuk menghubungi kami.
            </p>
        </div>

        <div class="mt-16 grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Contact Card 1 -->
            <div class="bg-gray-50 rounded-lg shadow-md p-6 flex flex-col items-center text-center">
                <div class="h-16 w-16 bg-primary-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-solid fa-location-dot text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Alamat</h3>
                <p class="mt-2 text-base text-gray-500">
                    Kampus Politeknik Negeri Padang<br>
                    Limau Manis, Kec. Pauh<br>
                    Kota Padang, Sumatera Barat 25164
                </p>
            </div>

            <!-- Contact Card 2 -->
            <div class="bg-gray-50 rounded-lg shadow-md p-6 flex flex-col items-center text-center">
                <div class="h-16 w-16 bg-primary-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-solid fa-phone text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Telepon</h3>
                <p class="mt-2 text-base text-gray-500">
                    +62 751 72590<br>
                    +62 751 72576 (Fax)
                </p>
            </div>

            <!-- Contact Card 3 -->
            <div class="bg-gray-50 rounded-lg shadow-md p-6 flex flex-col items-center text-center">
                <div class="h-16 w-16 bg-primary-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-solid fa-envelope text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Email</h3>
                <p class="mt-2 text-base text-gray-500">
                    info@pnp.ac.id<br>
                    arsip@pnp.ac.id
                </p>
            </div>
        </div>

        <div class="mt-16 bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="p-6 sm:p-10">
                    <h3 class="text-2xl font-bold text-gray-900">Kirim Pesan</h3>
                    <p class="mt-4 text-gray-500">
                        Isi formulir di bawah ini dan tim kami akan menghubungi Anda sesegera mungkin.
                    </p>
                    <form class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                        <div>
                            <label for="first-name" class="block text-sm font-medium text-gray-700">Nama Depan</label>
                            <div class="mt-1">
                                <input type="text" name="first-name" id="first-name" class="py-3 px-4 block w-full shadow-sm focus:ring-primary-500 focus:border-primary-500 border-gray-300 rounded-md">
                            </div>
                        </div>
                        <div>
                            <label for="last-name" class="block text-sm font-medium text-gray-700">Nama Belakang</label>
                            <div class="mt-1">
                                <input type="text" name="last-name" id="last-name" class="py-3 px-4 block w-full shadow-sm focus:ring-primary-500 focus:border-primary-500 border-gray-300 rounded-md">
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" class="py-3 px-4 block w-full shadow-sm focus:ring-primary-500 focus:border-primary-500 border-gray-300 rounded-md">
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="subject" class="block text-sm font-medium text-gray-700">Subjek</label>
                            <div class="mt-1">
                                <input type="text" name="subject" id="subject" class="py-3 px-4 block w-full shadow-sm focus:ring-primary-500 focus:border-primary-500 border-gray-300 rounded-md">
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="message" class="block text-sm font-medium text-gray-700">Pesan</label>
                            <div class="mt-1">
                                <textarea id="message" name="message" rows="4" class="py-3 px-4 block w-full shadow-sm focus:ring-primary-500 focus:border-primary-500 border-gray-300 rounded-md"></textarea>
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>
                    <div class="bg-primary-50 p-6 sm:p-10 flex items-center justify-center">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.3056936183696!2d100.46099661475396!3d-0.9145129993076092!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4b8cf891947c9%3A0x3989067f95c95071!2sPoliteknik%20Negeri%20Padang!5e0!3m2!1sid!2sid!4v1650123456789!5m2!1sid!2sid" width="100%" height="100%" style="border:0; min-height: 400px;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
            </div>
        </div>
    </div>
</section>
@endsection
