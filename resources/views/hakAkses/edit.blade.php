@extends('layouts.index')

@section('title', 'Edit Hak Akses')

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Hak Akses</h2>
            <p class="mt-1 text-sm text-gray-500">Form Edit Data Hak Akses</p>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('hak-akses.index') }}"
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
            <form action="{{ route('hak-akses.update', $hakAkses->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                
                <!-- Role Field -->
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Role</label>
                    <select name="role"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('role') border-red-500 @enderror">
                        <option value="" disabled selected>Pilih Role</option>
                        <option value="admin" {{ old('role', $hakAkses->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="operator" {{ old('role', $hakAkses->role) == 'operator' ? 'selected' : '' }}>Operator</option>
                        <option value="pimpinan" {{ old('role', $hakAkses->role) == 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Permissions Field -->
                <div class="space-y-2">
                    <label class="block font-medium text-gray-700">Hak Akses</label>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input type="checkbox" name="can_view" value="1" 
                                {{ old('can_view', $hakAkses->can_view) ? 'checked' : '' }}
                                class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                            <label class="ml-2 text-sm text-gray-700">Dapat Melihat</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="can_create" value="1" 
                                {{ old('can_create', $hakAkses->can_create) ? 'checked' : '' }}
                                class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                            <label class="ml-2 text-sm text-gray-700">Dapat Membuat</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="can_edit" value="1" 
                                {{ old('can_edit', $hakAkses->can_edit) ? 'checked' : '' }}
                                class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                            <label class="ml-2 text-sm text-gray-700">Dapat Mengedit</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="can_delete" value="1" 
                                {{ old('can_delete', $hakAkses->can_delete) ? 'checked' : '' }}
                                class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                            <label class="ml-2 text-sm text-gray-700">Dapat Menghapus</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="can_approve" value="1" 
                                {{ old('can_approve', $hakAkses->can_approve) ? 'checked' : '' }}
                                class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                            <label class="ml-2 text-sm text-gray-700">Dapat Menyetujui Dokumen</label>
                        </div>
                    </div>
                </div>

                <!-- Keterangan Field -->
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="3"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 whitespace-normal break-words resize-none @error('keterangan') border-red-500 @enderror"
                        placeholder="Masukkan keterangan hak akses">{{ old('keterangan', $hakAkses->keterangan) }}</textarea>
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
