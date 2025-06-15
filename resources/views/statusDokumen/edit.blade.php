@extends('layouts.index')

@section('title', 'Edit Status Dokumen')

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Status Dokumen</h2>
            <p class="mt-1 text-sm text-gray-500">Form Edit Data Status Dokumen</p>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('statusDokumen.index') }}"
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
            <form action="{{ route('statusDokumen.update', $statusDokumen->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Kode Status</label>
                    <input type="text" name="kode_status"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('kode_status') border-red-500 @enderror"
                        value="{{ old('kode_status', $statusDokumen->kode_status) }}"
                        placeholder="Masukkan kode status (contoh: ACT, ARC, DEL)">
                    @error('kode_status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Nama Status</label>
                    <input type="text" name="nama_status"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nama_status') border-red-500 @enderror"
                        value="{{ old('nama_status', $statusDokumen->nama_status) }}"
                        placeholder="Masukkan nama status (contoh: Aktif, Arsip, Dihapus)">
                    @error('nama_status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 whitespace-normal break-words resize-none @error('deskripsi') border-red-500 @enderror"
                        placeholder="Masukkan deskripsi status dokumen">{{ old('deskripsi', $statusDokumen->deskripsi) }}</textarea>
                    @error('deskripsi')
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
@endsection
