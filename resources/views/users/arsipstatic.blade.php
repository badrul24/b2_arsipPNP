@extends('user')
@section('content')
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
<div class="flex flex-wrap justify-between items-center pl-14 pr-14 gap-4 bg-gray-100 p-3 mt-[94px] rounded-md">
    <div class="flex gap-2">
        <form method="GET" action="" class="flex-grow flex gap-2 left-0 max-w-xl items-center">
            <button type="submit" class="bg-gray-200 px-3 py-1 rounded-lg font-semibold">Cari</button>
            <input type="text" name="search" value="" placeholder="Cari arsip" class="w-full border rounded-lg px-3 py-1" />
        </form>
    </div>
    <div class="flex gap-2 items-center">
        <span class="text-sm text-gray-700 font-semibold">Showing</span>
        <div class="relative">
            <select class="border px-2 py-1 rounded-lg bg-gray-200 text-gray-800 appearance-none pr-6">
                <option>10</option>
                <option>20</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center text-gray-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>
        <button class="border px-2 py-1 rounded-lg bg-gray-200 text-gray-800 font-semibold">Filter</button>
    </div>
</div>

<div class="bg-white pt-5 pb-5">
    <div class="overflow-x-auto pl-10 pr-10">
        <div class="rounded-lg overflow-hidden shadow-sm border border-gray-200">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-gray-800 font-semibold">
                    <tr class="w-1/2 mx-auto">
                        <th class="p-3 text-center">NO</th>
                        <th class="p-3 text-center">Kode Arsip</th>
                        <th class="p-3 text-center">Nama Arsip</th>
                        <th class="p-3 text-center">Tentang Arsip</th>
                        <th class="p-3 text-center">Info Arsip</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td class="p-3 text-center">1</td>
                        <td class="p-3 text-center">SN0921_43</td>
                        <td class="p-3 max-w-xl">
                            <h5>Kepegawaian Politeknik Negeri Padang</h5>
                            <p>
                                Bagian Kepegawaian Politeknik Negeri Padang bertugas mengelola administrasi dan pengembangan
                                sumber daya manusia, termasuk dosen dan tenaga kependidikan. Layanan mencakup pengarsipan
                                dokumen kepegawaian.
                            </p>
                        </td>
                        <td>
                            <div class="grid grid-cols-2 gap-x-1">
                                <div class="font-semibold ">Kategori</div>
                                <div class="ml-[-25px]">: Umum</div>
                                <div class="font-semibold">Jenis</div>
                                <div class="ml-[-25px]">: Kepegawaian</div>
                                <div class="font-semibold">Status</div>
                                <div class="ml-[-25px]">: Permanen</div>
                            </div>
                        </td>
                        <td class="p-3 text-center">
                            <a href="#" class="text-blue-600 hover:underline">Detail</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
