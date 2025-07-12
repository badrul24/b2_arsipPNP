@extends('landing_page.user')
@section('title','Profil')
@section('content')
<head>
    <style>
        {
            scroll-behavior: smooth;
        }
    </style>
</head>
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
<body class="overflow-x-hidden">
    <section id="tentang" class="py-16 pt-[100px] bg-white">
        <div class="flex flex-col max-w-7xl px-16 mx-auto">
            <div class="flex flex-col md:flex-row gap-12 items-center">
                <div class="w-3/5">
                    <h2 class="text-base font-semibold text-primary-600 tracking-wide uppercase">Tentang Kami</h2>
                    <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight">
                        Politeknik Negeri Padang
                    </p>
                    <p class="mt-5 text-lg text-gray-500">
                        Politeknik Negeri Padang (PNP) merupakan perguruan tinggi negeri yang berfokus pada pendidikan vokasi dan didirikan pada tahun 1987. Sebagai salah satu dari 17 politeknik pertama di Indonesia, PNP hadir untuk menjawab tantangan dunia industri dan dunia usaha. Kampusnya terletak di Kota Padang dan bersebelahan langsung dengan Universitas Andalas. Saat ini, PNP memiliki tujuh jurusan dan 33 program studi yang mencakup jenjang D3, D4, hingga S2 Terapan. Pendidikan di PNP menitikberatkan pada keterampilan praktis serta relevansi terhadap kebutuhan industri, dengan kurikulum yang dinamis dan berorientasi pada praktik.
                    </p>
                    <p class="mt-4 text-lg text-gray-500">
                        PNP bertujuan menghasilkan lulusan yang kompeten dan siap kerja, baik sebagai Ahli Madya (A.Md) maupun Sarjana Sains Terapan (SST). Dalam mendukung proses pendidikan dan penelitian, PNP menjalin berbagai kerjasama dengan institusi dalam maupun luar negeri. Selain itu, fasilitas penunjang seperti Anjungan Internet Mandiri (AIM) dan kawasan hot spot area disediakan bagi mahasiswa. Dalam perjalanannya, PNP juga pernah masuk dalam daftar 50 Perguruan Tinggi Unggulan di Indonesia versi Direktorat Jenderal Pendidikan Tinggi (DIKTI). Kepemimpinan PNP berada di bawah seorang Direktur yang bertanggung jawab atas seluruh aktivitas akademik dan operasional kampus.
                    </p>
                </div>
                <div class="w-2/5 gap-4">
                    <div class="flex space-y-4">
                        <div class="aspect-w-3 aspect-h-2">
                            <img class="object-cover w-[250px] h-[150px] shadow-lg rounded-lg" src="{{ asset('images/gedung.png') }}" alt="Gedung PNP">
                        </div>
                        <div class="aspect-w-3 aspect-h-2 pl-2">
                            <img class="object-cover w-[250px] h-[150px] shadow-lg rounded-lg" src="{{ asset('images/kampus.png') }}" alt="Kampus PNP">
                        </div>
                    </div>
                    <div class="flex space-y-4">
                        <div class="aspect-w-3 aspect-h-2">
                            <img class="object-cover w-[250px] h-[150px] shadow-lg rounded-lg" src="{{ asset('images/mahasiswa.png') }}" alt="Mahasiswa PNP">
                        </div>
                        <div class="aspect-w-3 aspect-h-2 pl-2">
                            <img class="object-cover w-[250px] h-[150px] shadow-lg rounded-lg" src="{{ asset('images/laboratorium.png') }}" alt="Laboratorium PNP">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-16">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <div class="m-[40px] ml-0 mr-0 flex-shrink-0">
                        <img class="h-[350px] w-[450px] shadow-lg rounded-lg object-contain" src="{{ asset('images/ruang.png') }}" alt="Gedung PNP">
                    </div>
                <div>
                    <p class="mt-1 text-[5px] font-bold text-gray-900 sm:text-2xl sm:tracking-tight">
                        Arsip Politeknik Negeri Padang
                    </p>
                    <p class="mt-5 text-lg text-gray-500">
                        Arsip Politeknik Negeri Padang merupakan bagian dari Politeknik Negeri Padang (PNP) yang bertanggung jawab atas pengelolaan informasi, perpustakaan, dan kearsipan di lingkungan kampus. Sebagai institusi vokasi yang berfokus pada bidang teknik dan teknologi, PNP membutuhkan sistem pengelolaan dokumen yang tertib dan profesional untuk mendukung berbagai kegiatan akademik dan administrasi.
                    </p>
                    <p class="mt-4 text-lg text-gray-500">
                        Arsip PNP memiliki peran penting dalam menjaga, mengelola, dan melestarikan berbagai dokumen penting yang dihasilkan oleh institusi. Selain itu, Arsip PNP juga menyediakan akses informasi yang terdokumentasi bagi sivitas akademika dan pihak lain yang berkepentingan, baik dari kalangan internal maupun eksternal.
                    </p>
                    <p class="mt-4 text-lg text-gray-500">
                        Fungsi utama Arsip PNP meliputi pengelolaan dokumen, penyediaan akses informasi, serta pengembangan sistem kearsipan yang efektif dan efisien. Dalam hal ini, Arsip PNP tidak hanya berfokus pada penyimpanan data, tetapi juga berkontribusi dalam memastikan kelangsungan tata kelola administrasi kampus yang modern dan akuntabel.
                    </p>
                    <div class="mt-10">
                        <a href="https://pnp.ac.id" target="_blank"
                        class="inline-flex items-center px-7 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Kunjungi Website PNP
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id='visi&misi'class="pt-[90px] flex min-h-screen bg-white font-sans text-gray-800 px-16" data-aos="fade-right">
        <aside class="w-1/4 bg-white pt-3 flex flex-col items-start justify-start">
            <div class="text-2xl font-bold text-primary-700">Politeknik Negeri Padang</div>
            <h3 class="font-semibold text-primary-700">Arsip Politeknik Negeri Padang</h3>
        </aside>

        <div class="w-3/4 flex flex-col ">
            <section class="bg-primary-700 text-white py-4 px-6 shadow rounded-tl-lg rounded-tr-lg">
                <div class="text-left">
                    <h2 class="text-2xl font-extrabold">Visi & Misi</h2>
                    <p class="text-sm">Mewujudkan pendidikan vokasi unggul yang berwawasan internasional</p>
                </div>
            </section>

            <main class="p-8 space-y-12 overflow-y-auto shadow rounded-bl-lg rounded-br-lg mb-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-2xl font-semibold text-primary-700 mb-4">Visi</h3>
                        <p class="text-md leading-relaxed">
                            “Pada tahun 2025 menjadi institusi pendidikan vokasional terbaik di Asia Tenggara, bermartabat, dan berwawasan internasional.”
                        </p>
                    </div>
                <div>
                    <h3 class="text-2xl font-semibold text-primary-700 mb-4">Misi</h3>
                    <ul class="list-disc pl-5 space-y-3 text-md leading-relaxed">
                        <li>Menyelenggarakan pendidikan vokasional sesuai perkembangan IPTEK berwawasan internasional.</li>
                        <li>Menyelenggarakan penelitian yang inovatif dan adaptif.</li>
                        <li>Menerapkan IPTEK untuk memecahkan masalah masyarakat.</li>
                        <li>Menjalin kerjasama nasional dan internasional yang berkelanjutan.</li>
                    </ul>
                </div>
            </div>

            <div>
                <h3 class="text-2xl font-semibold text-primary-700 mb-4">Tujuan</h3>
                <ul class="list-disc pl-5 space-y-3 text-md leading-relaxed">
                <li>Menghasilkan lulusan yang kompeten dan bertakwa.</li>
                <li>Menghasilkan penelitian dan paten bermanfaat.</li>
                <li>Meningkatkan kesejahteraan masyarakat melalui teknologi terapan.</li>
                <li>Menjalin kerjasama yang saling menguntungkan.</li>
                </ul>
            </div>
        </main>
    </div>
    </section>

<section id="struktur-organisasi" class="pt-[90px] flex min-h-screen bg-white font-sans text-gray-800 px-16" data-aos="fade-left">
        <div class="w-3/4 flex flex-col mb-2">
            <section class="bg-primary-700 text-white py-4 px-6 shadow rounded-tl-lg rounded-tr-lg">
                <div class="text-left">
                    <h2 class="text-2xl font-extrabold">Struktur Organisasi</h2>
                    <p class="text-sm">Struktur kelembagaan Politeknik Negeri Padang</p>
                </div>
            </section>

            <main class="p-8 space-y-12 overflow-y-auto shadow rounded-bl-lg rounded-br-lg">
                <div class="space-y-6">
                    <h3 class="text-xl font-semibold text-primary-700">Struktur Utama</h3>
                    <ul class="list-disc pl-5 space-y-2 text-md leading-relaxed">
                    <li>Direktur</li>
                    <li>Wakil Direktur I – Akademik</li>
                    <li>Wakil Direktur II – Umum & Keuangan</li>
                    <li>Wakil Direktur III – Kemahasiswaan</li>
                    <li>Senat Politeknik</li>
                    </ul>
                </div>

                <div class="space-y-6">
                    <h3 class="text-xl font-semibold text-primary-700">Unit Pendukung</h3>
                    <ul class="list-disc pl-5 space-y-2 text-md leading-relaxed">
                    <li>Bagian Administrasi Akademik</li>
                    <li>Bagian Administrasi Umum</li>
                    <li>UPT Perpustakaan</li>
                    <li>UPT Teknologi Informasi</li>
                    <li>UPT Bahasa</li>
                    </ul>
                </div>
            </main>
        </div>

        <!-- Sidebar kanan -->
        <aside class="w-1/4 bg-white mt-[-5px] pt-4 pl-4 flex flex-col items-start justify-start border-l border-gray-100 order-last">
            <div class="text-2xl font-bold text-primary-700">Politeknik Negeri Padang</div>
            <h3 class="font-semibold text-primary-700">Organisasi Arsip</h3>
        </aside>
    </section>
</body>

@endsection
