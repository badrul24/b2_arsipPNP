@extends('landing_page.user')
@section('title','Arsip Statis')
@section('content')
<section class="pt-28 bg-gray-200 min-h-screen">
    <div class="mb-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
        <h1 class="text-4xl font-bold text-primary-600">Arsip Statis</h1>
        <nav class="text-sm text-gray-500 mt-2">
            <ol class="list-reset flex">
                <li><a href="{{ url('/') }}" class="text-primary-600 hover:underline">Beranda</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="#" class="text-primary-600 hover:underline">Arsip</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-primary-700 font-semibold">Arsip Statis</li>
            </ol>
        </nav>
    </div>

    <!-- Konten Penjelasan Arsip Statis -->
    <section id="tentang" class="py-10 bg-white">
        <div class="max-w-7xl px-8 lg:px-16">
            <div class="gap-12 items-center">
                <div class="w-full">
                    <p class="text-lg text-gray-500">
                        <strong>Arsip statis</strong> adalah arsip yang tidak lagi digunakan secara langsung dalam kegiatan pencipta arsip, namun memiliki nilai guna yang tinggi sebagai bahan bukti, sumber informasi, dan memori kolektif bangsa. Arsip statis disimpan secara permanen karena mengandung nilai sejarah, budaya, hukum, atau ilmiah yang penting.
                    </p>
                    <p class="mt-4 text-lg text-gray-500">
                        Arsip statis biasanya berasal dari arsip dinamis yang telah habis retensinya dan telah melalui proses penilaian untuk ditetapkan sebagai arsip yang harus dipelihara secara permanen.
                    </p>
                    <ul class="mt-4 text-lg text-gray-500 list-disc list-inside space-y-2">
                        <li><strong>Ciri-ciri arsip statis:</strong>
                            <ul class="list-disc ml-6 mt-1 space-y-1">
                                <li>Tidak lagi digunakan dalam kegiatan administrasi sehari-hari.</li>
                                <li>Memiliki nilai guna sekunder (sejarah, hukum, ilmiah, budaya, dsb).</li>
                                <li>Disimpan secara permanen di lembaga kearsipan.</li>
                                <li>Menjadi sumber informasi dan bukti akuntabilitas institusi.</li>
                            </ul>
                        </li>
                        <li><strong>Proses penetapan arsip statis:</strong>
                            <ul class="list-disc ml-6 mt-1 space-y-1">
                                <li>Pemindahan arsip dari unit pengelola ke lembaga kearsipan setelah masa retensi berakhir.</li>
                                <li>Penilaian dan seleksi arsip berdasarkan nilai guna.</li>
                                <li>Pencatatan dan pengelolaan arsip statis secara khusus.</li>
                            </ul>
                        </li>
                    </ul>
                    <p class="mt-4 text-lg text-gray-500">
                        Pengelolaan arsip statis bertujuan untuk melestarikan dokumen penting agar tetap dapat diakses oleh generasi mendatang, serta mendukung transparansi, akuntabilitas, dan pelestarian sejarah institusi maupun bangsa.
                    </p>
                </div>
            </div>
        </div>

        <!-- Konten Tambahan & Gambar -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-16">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                <div class="mt-[27px] ml-0 mr-0">
                    <img class="h-[450px] w-[500px] shadow-lg rounded-lg" src="{{ asset('images/gudangarsip.png') }}" alt="Gudang Arsip Statis">
                </div>
                <div>
                    <p class="mt-5 text-lg text-gray-500">
                        Contoh arsip statis antara lain:
                    </p>
                    <ul class="mt-4 text-md text-gray-500 list-disc list-inside space-y-2">
                        <li>Dokumen pendirian institusi atau organisasi.</li>
                        <li>Keputusan penting, peraturan, dan perjanjian.</li>
                        <li>Dokumen sejarah, foto, peta, dan rekaman penting.</li>
                        <li>Laporan tahunan, notulen rapat strategis, dan dokumen lain yang bernilai sejarah.</li>
                    </ul>
                    <p class="mt-4 text-lg text-gray-500">
                        Arsip statis dikelola oleh lembaga kearsipan nasional, daerah, atau institusi terkait, dan dapat diakses untuk kepentingan penelitian, pendidikan, serta pelestarian sejarah.
                    </p>
                    <div class="mt-10">
                        <a href="https://www.anri.go.id/detail/halaman/arsip-statis" target="_blank"
                           class="inline-flex items-center px-7 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Arsip statis lebih lanjut
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
@endsection

