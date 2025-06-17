@extends('layouts.index')

@section('title', 'Edit Retensi')

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Retensi</h2>
            <p class="mt-1 text-sm text-gray-500">Form Edit Data Retensi Arsip</p>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('retensi.index') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form Content -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="max-w-xl">
            <form action="{{ route('retensi.update', $retensi->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="kode_retensi" class="block font-medium text-gray-700 mb-1">Kode Retensi</label>
                    <input type="text" name="kode_retensi" id="kode_retensi"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('kode_retensi') border-red-500 @enderror"
                        value="{{ old('kode_retensi', $retensi->kode_retensi) }}"
                        placeholder="Masukkan kode retensi" required>
                    @error('kode_retensi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nama_retensi" class="block font-medium text-gray-700 mb-1">Nama Retensi</label>
                    <input type="text" name="nama_retensi" id="nama_retensi"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nama_retensi') border-red-500 @enderror"
                        value="{{ old('nama_retensi', $retensi->nama_retensi) }}"
                        placeholder="Masukkan nama retensi" required>
                    @error('nama_retensi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tahun_aktif" class="block font-medium text-gray-700 mb-1">Tahun Aktif</label>
                    <input type="number" name="tahun_aktif" id="tahun_aktif"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('tahun_aktif') border-red-500 @enderror"
                        value="{{ old('tahun_aktif', $retensi->tahun_aktif) }}"
                        placeholder="Misal: 2" min="0" required>
                    @error('tahun_aktif')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tahun_inaktif" class="block font-medium text-gray-700 mb-1">Tahun Inaktif</label>
                    <input type="number" name="tahun_inaktif" id="tahun_inaktif"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('tahun_inaktif') border-red-500 @enderror"
                        value="{{ old('tahun_inaktif', $retensi->tahun_inaktif) }}"
                        placeholder="Misal: 3" min="0" required>
                    @error('tahun_inaktif')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nasib_akhir" class="block font-medium text-gray-700 mb-1">Nasib Akhir</label>
                    <select name="nasib_akhir" id="nasib_akhir"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nasib_akhir') border-red-500 @enderror"
                        required>
                        <option value="Musnah" {{ $retensi->nasib_akhir == 'Musnah' ? 'selected' : '' }}>Musnah</option>
                        <option value="Permanen" {{ $retensi->nasib_akhir == 'Permanen' ? 'selected' : '' }}>Permanen</option>
                        <option value="Dinilai Kembali" {{ $retensi->nasib_akhir == 'Dinilai Kembali' ? 'selected' : '' }}>Dinilai Kembali</option>
                    </select>
                    @error('nasib_akhir')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="keterangan" class="block font-medium text-gray-700 mb-1">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 whitespace-normal break-words resize-none @error('keterangan') border-red-500 @enderror"
                        placeholder="Masukkan keterangan tambahan">{{ old('keterangan', $retensi->keterangan) }}</textarea>
                    @error('keterangan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex space-x-2">
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        Update
                    </button>
                    <button type="reset"
                        class="px-4 py-2 text-sm font-medium text-white bg-yellow-500 rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <div class="mt-8 text-center">
        <p class="text-sm text-gray-500">
            Padang, &copy; {{ date('Y') }} Politeknik Negeri Padang
        </p>
    </div>
@endsection
