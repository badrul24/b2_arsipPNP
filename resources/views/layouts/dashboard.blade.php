@extends('layouts.index')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
            <p class="mt-1 text-sm text-gray-500">Selamat datang di Sistem Informasi Arsip Politeknik Negeri Padang</p>
        </div>
        <div class="flex items-center gap-2">
            <div class="relative">
                <select class="pl-3 pr-10 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option>Hari Ini</option>
                    <option>Minggu Ini</option>
                    <option>Bulan Ini</option>
                    <option>Tahun Ini</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute w-5 h-5 text-gray-400 right-3 top-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                </svg>
            </div>
            <button class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                Ekspor Data
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-primary-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Arsip</p>
                    <p class="text-2xl font-semibold text-gray-900">1,248</p>
                </div>
            </div>
            <div class="flex items-center mt-4 text-sm">
                <span class="flex items-center text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    <span class="ml-1">12%</span>
                </span>
                <span class="ml-2 text-gray-500">dari bulan lalu</span>
            </div>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-green-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Surat Masuk</p>
                    <p class="text-2xl font-semibold text-gray-900">542</p>
                </div>
            </div>
            <div class="flex items-center mt-4 text-sm">
                <span class="flex items-center text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    <span class="ml-1">8%</span>
                </span>
                <span class="ml-2 text-gray-500">dari bulan lalu</span>
            </div>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-blue-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Surat Keluar</p>
                    <p class="text-2xl font-semibold text-gray-900">386</p>
                </div>
            </div>
            <div class="flex items-center mt-4 text-sm">
                <span class="flex items-center text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    <span class="ml-1">5%</span>
                </span>
                <span class="ml-2 text-gray-500">dari bulan lalu</span>
            </div>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-yellow-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Menunggu</p>
                    <p class="text-2xl font-semibold text-gray-900">24</p>
                </div>
            </div>
            <div class="flex items-center mt-4 text-sm">
                <span class="flex items-center text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                    <span class="ml-1">3%</span>
                </span>
                <span class="ml-2 text-gray-500">dari bulan lalu</span>
            </div>
        </div>
    </div>

    <!-- Charts and Tables -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Chart -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Statistik Arsip</h3>
                <div class="relative">
                    <select class="pl-3 pr-10 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option>6 Bulan Terakhir</option>
                        <option>1 Tahun Terakhir</option>
                        <option>2 Tahun Terakhir</option>
                    </select>
                </div>
            </div>
            <div>
                <canvas id="arsipChart" height="300"></canvas>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Distribusi Arsip</h3>
                <div class="relative">
                    <select class="pl-3 pr-10 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option>Bulan Ini</option>
                        <option>Tahun Ini</option>
                        <option>Semua Waktu</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-center">
                <div class="w-64 h-64">
                    <canvas id="distributionChart"></canvas>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-2 bg-primary-500 rounded-full"></span>
                    <span class="text-sm text-gray-600">Surat Masuk (43%)</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-2 bg-blue-500 rounded-full"></span>
                    <span class="text-sm text-gray-600">Surat Keluar (31%)</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-2 bg-yellow-500 rounded-full"></span>
                    <span class="text-sm text-gray-600">Dokumen (18%)</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-2 bg-green-500 rounded-full"></span>
                    <span class="text-sm text-gray-600">Lainnya (8%)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Archives -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Arsip Terbaru</h3>
            <a href="#" class="text-sm font-medium text-primary-600 hover:text-primary-500">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">No. Arsip</th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Judul</th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Jenis</th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">ARS-2023-0125</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Surat Undangan Rapat Koordinasi</div>
                            <div class="text-xs text-gray-500">Dari: Kementerian Pendidikan</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Surat Masuk</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">15 Mei 2023</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">Selesai</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-right whitespace-nowrap">
                            <a href="#" class="text-primary-600 hover:text-primary-900">Lihat</a>
                            <span class="mx-1 text-gray-300">|</span>
                            <a href="#" class="text-primary-600 hover:text-primary-900">Unduh</a>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">ARS-2023-0124</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Surat Permohonan Dana Penelitian</div>
                            <div class="text-xs text-gray-500">Kepada: LPPM</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Surat Keluar</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">14 Mei 2023</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full">Menunggu</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-right whitespace-nowrap">
                            <a href="#" class="text-primary-600 hover:text-primary-900">Lihat</a>
                            <span class="mx-1 text-gray-300">|</span>
                            <a href="#" class="text-primary-600 hover:text-primary-900">Unduh</a>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">ARS-2023-0123</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Laporan Keuangan Triwulan I</div>
                            <div class="text-xs text-gray-500">Bagian: Keuangan</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Dokumen</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">12 Mei 2023</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">Selesai</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-right whitespace-nowrap">
                            <a href="#" class="text-primary-600 hover:text-primary-900">Lihat</a>
                            <span class="mx-1 text-gray-300">|</span>
                            <a href="#" class="text-primary-600 hover:text-primary-900">Unduh</a>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">ARS-2023-0122</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Surat Keputusan Pengangkatan Dosen</div>
                            <div class="text-xs text-gray-500">Dari: Direktur</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Surat Masuk</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">10 Mei 2023</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-blue-800 bg-blue-100 rounded-full">Diproses</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-right whitespace-nowrap">
                            <a href="#" class="text-primary-600 hover:text-primary-900">Lihat</a>
                            <span class="mx-1 text-gray-300">|</span>
                            <a href="#" class="text-primary-600 hover:text-primary-900">Unduh</a>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">ARS-2023-0121</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Surat Permohonan Cuti</div>
                            <div class="text-xs text-gray-500">Kepada: HRD</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Surat Keluar</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">8 Mei 2023</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">Ditolak</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-right whitespace-nowrap">
                            <a href="#" class="text-primary-600 hover:text-primary-900">Lihat</a>
                            <span class="mx-1 text-gray-300">|</span>
                            <a href="#" class="text-primary-600 hover:text-primary-900">Unduh</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <span class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">5</span> dari <span class="font-medium">42</span> hasil
                    </span>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="px-3 py-1 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Sebelumnya
                    </button>
                    <button class="px-3 py-1 text-sm font-medium text-white bg-primary-600 border border-primary-600 rounded-md hover:bg-primary-700">
                        1
                    </button>
                    <button class="px-3 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        2
                    </button>
                    <button class="px-3 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        3
                    </button>
                    <button class="px-3 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Selanjutnya
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h3 class="mb-4 text-lg font-medium text-gray-900">Aksi Cepat</h3>
            <div class="space-y-3">
                <a href="#" class="flex items-center p-3 text-sm font-medium text-gray-700 transition-colors duration-200 rounded-md hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Tambah Arsip Baru
                </a>
                <a href="#" class="flex items-center p-3 text-sm font-medium text-gray-700 transition-colors duration-200 rounded-md hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Jadwalkan Pengarsipan
                </a>
                <a href="#" class="flex items-center p-3 text-sm font-medium text-gray-700 transition-colors duration-200 rounded-md hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    Buat Laporan
                </a>
                <a href="#" class="flex items-center p-3 text-sm font-medium text-gray-700 transition-colors duration-200 rounded-md hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Pencarian Lanjutan
                </a>
            </div>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h3 class="mb-4 text-lg font-medium text-gray-900">Kategori Populer</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Surat Keputusan</span>
                    <span class="px-2 py-1 text-xs font-medium text-primary-700 bg-primary-100 rounded-full">124</span>
                </div>
                <div class="w-full h-2 bg-gray-200 rounded-full">
                    <div class="h-2 bg-primary-500 rounded-full" style="width: 75%"></div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <span class="text-sm font-medium text-gray-700">Surat Edaran</span>
                    <span class="px-2 py-1 text-xs font-medium text-primary-700 bg-primary-100 rounded-full">98</span>
                </div>
                <div class="w-full h-2 bg-gray-200 rounded-full">
                    <div class="h-2 bg-primary-500 rounded-full" style="width: 60%"></div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <span class="text-sm font-medium text-gray-700">Laporan Keuangan</span>
                    <span class="px-2 py-1 text-xs font-medium text-primary-700 bg-primary-100 rounded-full">87</span>
                </div>
                <div class="w-full h-2 bg-gray-200 rounded-full">
                    <div class="h-2 bg-primary-500 rounded-full" style="width: 45%"></div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <span class="text-sm font-medium text-gray-700">Surat Perjanjian</span>
                    <span class="px-2 py-1 text-xs font-medium text-primary-700 bg-primary-100 rounded-full">65</span>
                </div>
                <div class="w-full h-2 bg-gray-200 rounded-full">
                    <div class="h-2 bg-primary-500 rounded-full" style="width: 35%"></div>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h3 class="mb-4 text-lg font-medium text-gray-900">Aktivitas Terbaru</h3>
            <div class="space-y-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <img class="w-8 h-8 rounded-full" src="https://randomuser.me/api/portraits/women/2.jpg" alt="User">
                    </div>
                    <div class="flex-1 ml-3">
                        <p class="text-sm font-medium text-gray-900">Siti Aminah</p>
                        <p class="text-xs text-gray-500">Menambahkan arsip baru: Surat Undangan Rapat</p>
                        <p class="text-xs text-gray-400">2 jam yang lalu</p>
                    </div>
                </div>

                <div class="flex">
                    <div class="flex-shrink-0">
                        <img class="w-8 h-8 rounded-full" src="https://randomuser.me/api/portraits/men/3.jpg" alt="User">
                    </div>
                    <div class="flex-1 ml-3">
                        <p class="text-sm font-medium text-gray-900">Budi Santoso</p>
                        <p class="text-xs text-gray-500">Memperbarui status arsip: Laporan Keuangan</p>
                        <p class="text-xs text-gray-400">3 jam yang lalu</p>
                    </div>
                </div>

                <div class="flex">
                    <div class="flex-shrink-0">
                        <img class="w-8 h-8 rounded-full" src="https://randomuser.me/api/portraits/women/4.jpg" alt="User">
                    </div>
                    <div class="flex-1 ml-3">
                        <p class="text-sm font-medium text-gray-900">Dewi Lestari</p>
                        <p class="text-xs text-gray-500">Mengunduh arsip: Surat Keputusan Direktur</p>
                        <p class="text-xs text-gray-400">5 jam yang lalu</p>
                    </div>
                </div>

                <div class="flex">
                    <div class="flex-shrink-0">
                        <img class="w-8 h-8 rounded-full" src="https://randomuser.me/api/portraits/men/5.jpg" alt="User">
                    </div>
                    <div class="flex-1 ml-3">
                        <p class="text-sm font-medium text-gray-900">Ahmad Rizki</p>
                        <p class="text-xs text-gray-500">Menambahkan komentar pada: Proposal Penelitian</p>
                        <p class="text-xs text-gray-400">6 jam yang lalu</p>
                    </div>
                </div>
            </div>
            <div class="mt-4 text-center">
                <a href="#" class="text-sm font-medium text-primary-600 hover:text-primary-500">Lihat semua aktivitas</a>
            </div>
        </div>
    </div>
</div>

<!-- Chart Initialization -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Line Chart
        const arsipCtx = document.getElementById('arsipChart').getContext('2d');
        const arsipChart = new Chart(arsipCtx, {
            type: 'line',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
                datasets: [
                    {
                        label: 'Surat Masuk',
                        data: [65, 78, 90, 85, 92, 105],
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(14, 165, 233, 0.1)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Surat Keluar',
                        data: [45, 58, 62, 68, 72, 80],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Pie Chart
        const distributionCtx = document.getElementById('distributionChart').getContext('2d');
        const distributionChart = new Chart(distributionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Surat Masuk', 'Surat Keluar', 'Dokumen', 'Lainnya'],
                datasets: [{
                    data: [43, 31, 18, 8],
                    backgroundColor: [
                        '#0ea5e9',
                        '#3b82f6',
                        '#eab308',
                        '#22c55e'
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endsection
