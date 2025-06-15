@extends('layouts.index')

@section('title', 'Tambah Jurusan')

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Tambah Jurusan</h2>
            <p class="mt-1 text-sm text-gray-500">Tambah data jurusan baru</p>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('jurusan.index') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('jurusan.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="kode_jurusan" class="block text-sm font-medium text-gray-700 mb-1">Kode Jurusan</label>
                <input type="text" name="kode_jurusan" id="kode_jurusan" value="{{ old('kode_jurusan') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('kode_jurusan') border-red-500 @enderror"
                    placeholder="Masukkan kode jurusan">
                @error('kode_jurusan')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nama_jurusan" class="block text-sm font-medium text-gray-700 mb-1">Nama Jurusan</label>
                <input type="text" name="nama_jurusan" id="nama_jurusan" value="{{ old('nama_jurusan') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nama_jurusan') border-red-500 @enderror"
                    placeholder="Masukkan nama jurusan">
                @error('nama_jurusan')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('keterangan') border-red-500 @enderror"
                    placeholder="Masukkan keterangan jurusan">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-2">
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                    Simpan
                </button>
                <button type="reset"
                    class="px-4 py-2 text-sm font-medium text-white bg-yellow-500 rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                    Reset
                </button>
            </div>
        </form>
    </div>
@endsection
