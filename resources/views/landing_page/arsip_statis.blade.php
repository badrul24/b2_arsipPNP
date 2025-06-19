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

<div class="bg-white pb-5 relative z-0">
    <!-- Filter & Search -->
    <div class="flex flex-wrap justify-between text-primary-900 items-center px-[63px] gap-4 p-3 rounded-md">
        <form method="GET" action="" class="flex-grow flex gap-2 max-w-xl items-center">
            <button type="submit" class="border border-gray-300 bg-gray-100 px-3 py-1 rounded-lg font-semibold hover:bg-gray-200">Cari</button>
            <input type="text" name="search" value="" placeholder="Cari arsip" class="w-full border rounded-lg px-3 py-1" />
        </form>

        <div class="flex gap-2 items-center">
            <span class="text-sm text-gray-700 font-semibold">Showing</span>
            <select class="border px-2 py-1 font-semibold rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200">
                <option>10</option>
                <option>20</option>
            </select>

        <div class="relative">
            <button onclick="toggleFilter()" type="button" class="border px-2 py-1 rounded-lg bg-gray-100 text-gray-800 font-semibold hover:bg-gray-200">
                Filter
            </button>

            <!-- Pindahkan panel ke dalam elemen relative -->
            <div id="filterPanel" class="hidden absolute top-[calc(100%+4px)] right-0 w-[700px] bg-white border border-gray-300 shadow-lg px-6 py-6 z-50 rounded-md">
                <form method="GET" action="">
                    <div class="flex flex-wrap gap-12">
                        <!-- Jenis Arsip -->
                        <div>
                            <h2 class="text-lg font-bold text-gray-700 mb-3">Jenis Arsip</h2>
                            <div class="flex flex-col gap-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="checkbox" name="jenis[]" value="Statis" class="form-checkbox">
                                    <span>Statis</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="checkbox" name="jenis[]" value="Dinamis" class="form-checkbox">
                                    <span>Dinamis</span>
                                </label>
                            </div>
                        </div>

                        <!-- Kategori Arsip -->
                        <div>
                            <h2 class="text-lg font-bold text-gray-700 mb-3">Kategori</h2>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="checkbox" name="kategori[]" value="Kepegawaian" class="form-checkbox">
                                    <span>Kepegawaian</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="checkbox" name="kategori[]" value="Keuangan" class="form-checkbox">
                                    <span>Keuangan</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="checkbox" name="kategori[]" value="Kemahasiswaan" class="form-checkbox">
                                    <span>Kemahasiswaan</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="submit" class="px-4 py-2 bg-primary-500 text-white rounded hover:bg-primary-600">Terapkan Filter</button>
                        <button type="button" onclick="toggleFilter()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- Tabel Arsip -->
    <div class="overflow-x-auto px-[60px]">
        <div class="rounded-lg overflow-hidden shadow-sm border border-gray-200">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-gray-800 font-semibold">
                    <tr class="text-primary-900">
                        <th class="p-3 text-center">NO</th>
                        <th class="p-3 text-center">Kode Arsip</th>
                        <th class="p-3 text-center">Nama Arsip</th>
                        <th class="p-3 text-center">Tentang Arsip</th>
                        <th class="p-3 text-center">Info Arsip</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-primary-100">
                    <!-- Data 1 -->
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-center">1</td>
                        <td class="p-4 text-center">SN0921_43</td>
                        <td class="p-4">
                            <h5 class="font-semibold">Kepegawaian Politeknik Negeri Padang</h5>
                            <p class="text-sm text-gray-600">Bagian Kepegawaian Politeknik Negeri Padang mengelola SDM.</p>
                        </td>
                        <td class="p-4">
                            <div class="space-y-1">
                                <div><span class="font-semibold">Kategori:</span> Umum</div>
                                <div><span class="font-semibold">Jenis:</span> Kepegawaian</div>
                                <div><span class="font-semibold">Status:</span> Permanen</div>
                            </div>
                        </td>
                        <td class="p-4 text-center space-x-4">
                            <a href="#"><img src="{{ asset('icons/details.png') }}" class="w-5 h-5 inline"></a>
                            <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/724/724933.png" class="w-5 h-5 inline"></a>
                        </td>
                    </tr>

                    <!-- Data 2 -->
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-center">2</td>
                        <td class="p-4 text-center">SN0922_12</td>
                        <td class="p-4">
                            <h5 class="font-semibold">Akademik Mahasiswa</h5>
                            <p class="text-sm text-gray-600">Pengelolaan administrasi akademik mahasiswa aktif.</p>
                        </td>
                        <td class="p-4">
                            <div class="space-y-1">
                                <div><span class="font-semibold">Kategori:</span> Akademik</div>
                                <div><span class="font-semibold">Jenis:</span> Mahasiswa</div>
                                <div><span class="font-semibold">Status:</span> Aktif</div>
                            </div>
                        </td>
                        <td class="p-4 text-center space-x-4">
                            <a href="#"><img src="{{ asset('icons/details.png') }}" class="w-5 h-5 inline"></a>
                            <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/724/724933.png" class="w-5 h-5 inline"></a>
                        </td>
                    </tr>

                    <!-- Data 3 -->
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-center">3</td>
                        <td class="p-4 text-center">SN0923_21</td>
                        <td class="p-4">
                            <h5 class="font-semibold">Inventaris Kampus</h5>
                            <p class="text-sm text-gray-600">Data barang inventaris kampus.</p>
                        </td>
                        <td class="p-4">
                            <div class="space-y-1">
                                <div><span class="font-semibold">Kategori:</span> Umum</div>
                                <div><span class="font-semibold">Jenis:</span> Inventaris</div>
                                <div><span class="font-semibold">Status:</span> Permanen</div>
                            </div>
                        </td>
                        <td class="p-4 text-center space-x-4">
                            <a href="#"><img src="{{ asset('icons/details.png') }}" class="w-5 h-5 inline"></a>
                            <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/724/724933.png" class="w-5 h-5 inline"></a>
                        </td>
                    </tr>

                    <!-- Data 4 -->
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-center">4</td>
                        <td class="p-4 text-center">SN0924_31</td>
                        <td class="p-4">
                            <h5 class="font-semibold">Data Alumni</h5>
                            <p class="text-sm text-gray-600">Arsip data alumni kampus.</p>
                        </td>
                        <td class="p-4">
                            <div class="space-y-1">
                                <div><span class="font-semibold">Kategori:</span> Umum</div>
                                <div><span class="font-semibold">Jenis:</span> Alumni</div>
                                <div><span class="font-semibold">Status:</span> Arsip</div>
                            </div>
                        </td>
                        <td class="p-4 text-center space-x-4">
                            <a href="#"><img src="{{ asset('icons/details.png') }}" class="w-5 h-5 inline"></a>
                            <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/724/724933.png" class="w-5 h-5 inline"></a>
                        </td>
                    </tr>

                    <!-- Data 5 -->
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-center">5</td>
                        <td class="p-4 text-center">SN0925_11</td>
                        <td class="p-4">
                            <h5 class="font-semibold">Keuangan Kampus</h5>
                            <p class="text-sm text-gray-600">Rekap laporan keuangan tahunan.</p>
                        </td>
                        <td class="p-4">
                            <div class="space-y-1">
                                <div><span class="font-semibold">Kategori:</span> Keuangan</div>
                                <div><span class="font-semibold">Jenis:</span> Laporan</div>
                                <div><span class="font-semibold">Status:</span> Arsip</div>
                            </div>
                        </td>
                        <td class="p-4 text-center space-x-4">
                            <a href="#"><img src="{{ asset('icons/details.png') }}" class="w-5 h-5 inline"></a>
                            <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/724/724933.png" class="w-5 h-5 inline"></a>
                        </td>
                    </tr>

                    <!-- Data 6 -->
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-center">6</td>
                        <td class="p-4 text-center">SN0926_44</td>
                        <td class="p-4">
                            <h5 class="font-semibold">Arsip Surat Masuk</h5>
                            <p class="text-sm text-gray-600">Rekap surat masuk resmi kampus.</p>
                        </td>
                        <td class="p-4">
                            <div class="space-y-1">
                                <div><span class="font-semibold">Kategori:</span> Surat</div>
                                <div><span class="font-semibold">Jenis:</span> Masuk</div>
                                <div><span class="font-semibold">Status:</span> Arsip</div>
                            </div>
                        </td>
                        <td class="p-4 text-center space-x-4">
                            <a href="#"><img src="{{ asset('icons/details.png') }}" class="w-5 h-5 inline"></a>
                            <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/724/724933.png" class="w-5 h-5 inline"></a>
                        </td>
                    </tr>

                    <!-- Data 7 -->
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-center">7</td>
                        <td class="p-4 text-center">SN0927_02</td>
                        <td class="p-4">
                            <h5 class="font-semibold">Arsip Surat Keluar</h5>
                            <p class="text-sm text-gray-600">Rekap surat keluar dari instansi.</p>
                        </td>
                        <td class="p-4">
                            <div class="space-y-1">
                                <div><span class="font-semibold">Kategori:</span> Surat</div>
                                <div><span class="font-semibold">Jenis:</span> Keluar</div>
                                <div><span class="font-semibold">Status:</span> Arsip</div>
                            </div>
                        </td>
                        <td class="p-4 text-center space-x-4">
                            <a href="#"><img src="{{ asset('icons/details.png') }}" class="w-5 h-5 inline"></a>
                            <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/724/724933.png" class="w-5 h-5 inline"></a>
                        </td>
                    </tr>

                    <!-- Data 8 -->
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-center">8</td>
                        <td class="p-4 text-center">SN0928_33</td>
                        <td class="p-4">
                            <h5 class="font-semibold">Data Kerjasama</h5>
                            <p class="text-sm text-gray-600">Dokumen kerjasama dengan instansi luar.</p>
                        </td>
                        <td class="p-4">
                            <div class="space-y-1">
                                <div><span class="font-semibold">Kategori:</span> Kerjasama</div>
                                <div><span class="font-semibold">Jenis:</span> MoU</div>
                                <div><span class="font-semibold">Status:</span> Arsip</div>
                            </div>
                        </td>
                        <td class="p-4 text-center space-x-4">
                            <a href="#"><img src="{{ asset('icons/details.png') }}" class="w-5 h-5 inline"></a>
                            <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/724/724933.png" class="w-5 h-5 inline"></a>
                        </td>
                    </tr>

                    <!-- Data 9 -->
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-center">9</td>
                        <td class="p-4 text-center">SN0929_66</td>
                        <td class="p-4">
                            <h5 class="font-semibold">Data Pengadaan</h5>
                            <p class="text-sm text-gray-600">Rekap pengadaan barang & jasa.</p>
                        </td>
                        <td class="p-4">
                            <div class="space-y-1">
                                <div><span class="font-semibold">Kategori:</span> Pengadaan</div>
                                <div><span class="font-semibold">Jenis:</span> Barang</div>
                                <div><span class="font-semibold">Status:</span> Arsip</div>
                            </div>
                        </td>
                        <td class="p-4 text-center space-x-4">
                            <a href="#"><img src="{{ asset('icons/details.png') }}" class="w-5 h-5 inline"></a>
                            <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/724/724933.png" class="w-5 h-5 inline"></a>
                        </td>
                    </tr>

                    <!-- Data 10 -->
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-center">10</td>
                        <td class="p-4 text-center">SN0930_99</td>
                        <td class="p-4">
                            <h5 class="font-semibold">Data Perpustakaan</h5>
                            <p class="text-sm text-gray-600">Dokumen perpustakaan kampus.</p>
                        </td>
                        <td class="p-4">
                            <div class="space-y-1">
                                <div><span class="font-semibold">Kategori:</span> Perpustakaan</div>
                                <div><span class="font-semibold">Jenis:</span> Buku</div>
                                <div><span class="font-semibold">Status:</span> Permanen</div>
                            </div>
                        </td>
                        <td class="p-4 text-center space-x-4">
                            <a href="#"><img src="{{ asset('icons/details.png') }}" class="w-5 h-5 inline"></a>
                            <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/724/724933.png" class="w-5 h-5 inline"></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-end mt-4 pr-10">
            <nav class="inline-flex items-center space-x-1 text-sm">
                <a href="#" class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100">&laquo;</a>
                <a href="#" class="px-3 py-1 bg-primary-500 text-white border border-primary-500 rounded">1</a>
                <a href="#" class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100">2</a>
                <a href="#" class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100">3</a>
                <span class="px-2 py-1 text-gray-500">...</span>
                <a href="#" class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100">&raquo;</a>
            </nav>
        </div>
    </div>
</div>
</section>
<script>
    function toggleFilter() {
        const panel = document.getElementById('filterPanel');
        panel.classList.toggle('hidden');
    }

    document.addEventListener('click', function (event) {
        const panel = document.getElementById('filterPanel');
        const button = event.target.closest('button[onclick="toggleFilter()"]');
        if (!panel.contains(event.target) && !button && !panel.classList.contains('hidden')) {
            panel.classList.add('hidden');
        }
    });
</script>
@endsection
