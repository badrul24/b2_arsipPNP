@extends('layouts.index')

@section('title', 'Edit Divisi')

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Divisi</h2>
            <p class="mt-1 text-sm text-gray-500">Edit data divisi</p>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('divisi.index') }}"
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
        <form action="{{ route('divisi.update', $divisi->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="kode_divisi" class="block text-sm font-medium text-gray-700 mb-1">Kode Divisi</label>
                <input type="text" name="kode_divisi" id="kode_divisi" value="{{ old('kode_divisi', $divisi->kode_divisi) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('kode_divisi') border-red-500 @enderror"
                    placeholder="Masukkan kode divisi">
                @error('kode_divisi')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nama_divisi" class="block text-sm font-medium text-gray-700 mb-1">Nama Divisi</label>
                <input type="text" name="nama_divisi" id="nama_divisi" value="{{ old('nama_divisi', $divisi->nama_divisi) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nama_divisi') border-red-500 @enderror"
                    placeholder="Masukkan nama divisi">
                @error('nama_divisi')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('keterangan') border-red-500 @enderror"
                    placeholder="Masukkan keterangan divisi">{{ old('keterangan', $divisi->keterangan) }}</textarea>
                @error('keterangan')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
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
@endsection
