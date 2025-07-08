@extends('layouts.index')

@section('title', 'Tambah Surat Keluar')

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Tambah Surat Keluar</h2>
            <p class="mt-1 text-sm text-gray-500">Form Tambah Data Surat Keluar</p>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('surat_keluar.index') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form Content -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="max-w-4xl">
            <form action="{{ route('surat_keluar.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <!-- Hidden Inputs -->
                <input type="hidden" name="status_surat" value="Draft">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-6">
                        <div>
                            <label for="nomor_agenda" class="block font-medium text-gray-700 mb-1">Nomor Agenda</label>
                            <input type="text" name="nomor_agenda" id="nomor_agenda"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500 @error('nomor_agenda') border-red-500 @enderror"
                                value="{{ old('nomor_agenda') }}" required>
                            @error('nomor_agenda')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nomor_surat_keluar" class="block font-medium text-gray-700 mb-1">Nomor Surat Keluar</label>
                            <input type="text" name="nomor_surat_keluar" id="nomor_surat_keluar"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500 @error('nomor_surat_keluar') border-red-500 @enderror"
                                value="{{ old('nomor_surat_keluar') }}" required>
                            @error('nomor_surat_keluar')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tanggal_surat" class="block font-medium text-gray-700 mb-1">Tanggal Surat</label>
                            <input type="date" name="tanggal_surat" id="tanggal_surat"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500 @error('tanggal_surat') border-red-500 @enderror"
                                value="{{ old('tanggal_surat') }}" required>
                            @error('tanggal_surat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tujuan_surat" class="block font-medium text-gray-700 mb-1">Tujuan Surat</label>
                            <input type="text" name="tujuan_surat" id="tujuan_surat"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500 @error('tujuan_surat') border-red-500 @enderror"
                                value="{{ old('tujuan_surat') }}" required>
                            @error('tujuan_surat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="pengirim" class="block font-medium text-gray-700 mb-1">Pengirim</label>
                            <input type="text" name="pengirim" id="pengirim"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500 @error('pengirim') border-red-500 @enderror"
                                value="{{ old('pengirim') }}" required>
                            @error('pengirim')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                    </div>
                    
                    <!-- Kolom Kanan -->
                    <div class="space-y-6">
                        <div>
                            <label for="penerima" class="block font-medium text-gray-700 mb-1">Penerima</label>
                            <select name="penerima" id="penerima"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500 @error('penerima') border-red-500 @enderror"
                                required>
                                <option value="" disabled selected>Pilih Penerima</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->name }}" {{ old('penerima') == $user->name ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('penerima')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="perihal" class="block font-medium text-gray-700 mb-1">Perihal</label>
                            <input type="text" name="perihal" id="perihal"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500 @error('perihal') border-red-500 @enderror"
                                value="{{ old('perihal') }}" required>
                            @error('perihal')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jenis_surat" class="block font-medium text-gray-700 mb-1">Jenis Surat</label>
                            <select name="jenis_surat" id="jenis_surat"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500 @error('jenis_surat') border-red-500 @enderror"
                                required>
                                <option value="" disabled selected>Pilih Jenis Surat</option>
                                <option value="Surat Undangan" {{ old('jenis_surat') == 'Surat Undangan' ? 'selected' : '' }}>Surat Undangan</option>
                                <option value="Surat Pemberitahuan" {{ old('jenis_surat') == 'Surat Pemberitahuan' ? 'selected' : '' }}>Surat Pemberitahuan</option>
                                <option value="Surat Permohonan" {{ old('jenis_surat') == 'Surat Permohonan' ? 'selected' : '' }}>Surat Permohonan</option>
                                <option value="Surat Keputusan" {{ old('jenis_surat') == 'Surat Keputusan' ? 'selected' : '' }}>Surat Keputusan</option>
                                <option value="Surat Edaran" {{ old('jenis_surat') == 'Surat Edaran' ? 'selected' : '' }}>Surat Edaran</option>
                                <option value="Surat Tugas" {{ old('jenis_surat') == 'Surat Tugas' ? 'selected' : '' }}>Surat Tugas</option>
                                <option value="Surat Pengantar" {{ old('jenis_surat') == 'Surat Pengantar' ? 'selected' : '' }}>Surat Pengantar</option>
                                <option value="Surat Keterangan" {{ old('jenis_surat') == 'Surat Keterangan' ? 'selected' : '' }}>Surat Keterangan</option>
                                <option value="Surat Lainnya" {{ old('jenis_surat') == 'Surat Lainnya' ? 'selected' : '' }}>Surat Lainnya</option>
                            </select>
                            @error('jenis_surat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                                                <div>
                            <label for="sifat_surat" class="block font-medium text-gray-700 mb-1">Sifat Surat</label>
                            <select name="sifat_surat" id="sifat_surat"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500 @error('sifat_surat') border-red-500 @enderror"
                                required>
                                <option value="" disabled selected>Pilih Sifat</option>
                                <option value="Sangat Penting" {{ old('sifat_surat') == 'Sangat Penting' ? 'selected' : '' }}>Sangat Penting</option>
                                <option value="Penting" {{ old('sifat_surat') == 'Penting' ? 'selected' : '' }}>Penting</option>
                                <option value="Biasa" {{ old('sifat_surat') == 'Biasa' ? 'selected' : '' }}>Biasa</option>
                            </select>
                            @error('sifat_surat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- File Surat --}}
                        <div>
                            <label for="file_surat" class="block font-medium text-gray-700 mb-1">File Surat</label>
                            <input type="file" name="file_surat" id="file_surat"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500 @error('file_surat') border-red-500 @enderror"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <p class="text-xs text-gray-500 mt-1">PDF, DOC, DOCX, JPG, JPEG, PNG maksimal 10MB</p>
                            @error('file_surat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Isi Surat -->
                <div>
                    <label for="isi_surat" class="block font-medium text-gray-700 mb-1">Isi Surat</label>
                    <textarea name="isi_surat" id="isi_surat" rows="5"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500 resize-none @error('isi_surat') border-red-500 @enderror"
                        placeholder="Masukkan isi surat">{{ old('isi_surat') }}</textarea>
                    @error('isi_surat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Keterangan -->
                <div>
                    <label for="keterangan" class="block font-medium text-gray-700 mb-1">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="5"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500 resize-none @error('keterangan') border-red-500 @enderror"
                        placeholder="Masukkan keterangan">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex space-x-2">
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-md hover:bg-primary-700">
                        Simpan
                    </button>
                    <button type="reset"
                        class="px-4 py-2 text-sm font-medium text-white bg-yellow-500 rounded-md hover:bg-yellow-600">
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
