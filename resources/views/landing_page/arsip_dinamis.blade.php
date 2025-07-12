@extends('landing_page.user')
@section('title','Arsip Dinamis')
@section('content')
<section class="pt-28 bg-gray-200 min-h-screen">
    <div class="mb-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
            <h1 class="text-4xl font-bold text-primary-600">Arsip Dinamis</h1>
            <nav class="text-sm text-gray-500 mt-2">
                <ol class="list-reset flex">
                    <li><a href="{{ url('/') }}" class="text-primary-600 hover:underline">Beranda</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="#" class="text-primary-600 hover:underline">Arsip</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-primary-700 font-semibold">Arsip Dinamis</li>
                </ol>
            </nav>
        </div>

    <!-- Konten Tentang Kami -->
    <section id="tentang" class="py-10 bg-white">
        <div class="max-w-7xl px-8 lg:px-16">
            <div class="gap-12 items-center">
                <div class="w-full">
                    <p class=" text-lg text-gray-500">
                        Arsip dinamis adalah arsip yang digunakan secara langsung dalam kegiatan pencipta arsip dan disimpan selama jangka waktu tertentu. Sedangkan pengelolaan arsip dinamis adalah proses pengendalian arsip dinamis secara efisien, efektif, dan sistematis yang meliputi penciptaan, penggunaan dan pemeliharaan, serta penyusutan arsip.
                    </p>
                    <p class="mt-4 text-lg text-gray-500">
                        Pengelolaan arsip dinamis meliputi:
                    </p>
                    <ul class="mt-4 text-lg text-gray-500 list-decimal list-inside space-y-2">
                        <li>Arsip vital, merupakan arsip yang keberadaannya merupakan persyaratan dasar bagi kelangsungan operasional pencipta arsip, tidak dapat diperbarui, dan tidak tergantikan apabila rusak atau hilang.</li>
                        <li>Arsip aktif, merupakan arsip yang frekuensi penggunaannya tinggi dan/atau terus menerus.</li>
                        <li>Arsip inaktif, merupakan arsip yang frekuensi penggunaannya telah menurun.</li>
                    </ul>
                    <p class="mt-4 text-lg text-gray-500">
                        Pengelolaan arsip dinamis dilaksanakan untuk menjamin ketersediaan arsip dalam penyelenggaraan kegiatan sebagai bahan akuntabilitas kinerja dan alat bukti yang sah.
                    </p>
                </div>
            </div>
        </div>

        <!-- Konten Tambahan & Gambar -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-16">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                <div class="mt-[27px] ml-0 mr-0">
                    <img class="h-[450px] w-[500px] shadow-lg rounded-lg" src="{{ asset('images/dinamis.png') }}" alt="Gudang Arsip Statis">
                </div>
                <div>
                    <p class="mt-5 text-lg text-gray-500">
                        Untuk mendukung pengelolaan arsip dinamis yang efektif dan efisien, pencipta arsip perlu membuat:
                    </p>
                    <ul class="mt-4 text-md text-gray-500 list-disc list-inside space-y-2">
                        <li><strong>Tata naskah dinas</strong>, adalah pengaturan tentang jenis, format, penyiapan, pengamanan, pengabsahan, distribusi dan media yang digunakan dalam komunikasi kedinasan.</li>
                        <li><strong>Klasifikasi arsip</strong>, adalah pola pengaturan arsip secara berjenjang dari hasil pelaksanaan fungsi dan tugas instansi menjadi beberapa kategori unit informasi kearsipan.</li>
                        <li><strong>Jadwal retensi arsip</strong>, yang disusun berdasarkan pedoman retensi arsip yang telah dibuat.</li>
                        <li><strong>Sistem klasifikasi keamanan dan akses arsip</strong>, yang disusun sebagai dasar untuk melindungi hak dan kewajiban pencipta arsip dan publik terhadap akses arsip.</li>
                    </ul>
                    <p class="mt-4 text-lg text-gray-500">
                        Pengelolaan arsip dinamis pada lembaga negara, pemerintah daerah, perguruan tinggi negeri, serta BUMN dan/atau BUMD dilaksanakan dalam suatu sistem kearsipan nasional.
                    </p>
                    <div class="mt-10">
                        <a href="https://www.djkn.kemenkeu.go.id/kanwil-kaltim/baca-artikel/13999/Mengenal-Arsip-Statis-dan-Arsip-Dinamis.html" target="_blank"
                           class="inline-flex items-center px-7 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Arsip dinamis lebih lanjut
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
@endsection
