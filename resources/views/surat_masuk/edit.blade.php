@extends('layouts.index')

@section('title', 'Edit Surat Masuk')

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Surat Masuk</h2>
            <p class="mt-1 text-sm text-gray-500">Form Edit Data Surat Masuk</p>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('surat_masuk.index') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form Content -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="max-w-4xl">
            <form action="{{ route('surat_masuk.update', $suratMasuk->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-6">
                        <div>
                            <label for="nomor_agenda" class="block font-medium text-gray-700 mb-1">Nomor Agenda</label>
                            <input type="text" name="nomor_agenda" id="nomor_agenda"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nomor_agenda') border-red-500 @enderror"
                                value="{{ old('nomor_agenda', $suratMasuk->nomor_agenda) }}"
                                placeholder="Masukkan nomor agenda" required>
                            @error('nomor_agenda')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nomor_surat_pengirim" class="block font-medium text-gray-700 mb-1">Nomor Surat Pengirim</label>
                            <input type="text" name="nomor_surat_pengirim" id="nomor_surat_pengirim"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nomor_surat_pengirim') border-red-500 @enderror"
                                value="{{ old('nomor_surat_pengirim', $suratMasuk->nomor_surat_pengirim) }}"
                                placeholder="Masukkan nomor surat pengirim" required>
                            @error('nomor_surat_pengirim')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tanggal_surat_pengirim" class="block font-medium text-gray-700 mb-1">Tanggal Surat Pengirim</label>
                            <input type="date" name="tanggal_surat_pengirim" id="tanggal_surat_pengirim"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('tanggal_surat_pengirim') border-red-500 @enderror"
                                value="{{ old('tanggal_surat_pengirim', \Carbon\Carbon::parse($suratMasuk->tanggal_surat_pengirim)->format('Y-m-d')) }}" required>
                            @error('tanggal_surat_pengirim')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tanggal_terima" class="block font-medium text-gray-700 mb-1">Tanggal Terima</label>
                            <input type="date" name="tanggal_terima" id="tanggal_terima"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('tanggal_terima') border-red-500 @enderror"
                                value="{{ old('tanggal_terima', \Carbon\Carbon::parse($suratMasuk->tanggal_terima)->format('Y-m-d')) }}" required>
                            @error('tanggal_terima')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="pengirim" class="block font-medium text-gray-700 mb-1">Pengirim</label>
                            <input type="text" name="pengirim" id="pengirim"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('pengirim') border-red-500 @enderror"
                                value="{{ old('pengirim', $suratMasuk->pengirim) }}"
                                placeholder="Masukkan nama pengirim" required>
                            @error('pengirim')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-6">
                        <div>
                            <label for="perihal" class="block font-medium text-gray-700 mb-1">Perihal</label>
                            <input type="text" name="perihal" id="perihal"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('perihal') border-red-500 @enderror"
                                value="{{ old('perihal', $suratMasuk->perihal) }}"
                                placeholder="Masukkan perihal surat" required>
                            @error('perihal')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sifat_surat" class="block font-medium text-gray-700 mb-1">Sifat Surat</label>
                            <select name="sifat_surat" id="sifat_surat"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('sifat_surat') border-red-500 @enderror"
                                required>
                                <option disabled value="">Pilih Sifat</option>
                                <option value="Sangat Penting" {{ old('sifat_surat', $suratMasuk->sifat_surat) == 'Sangat Penting' ? 'selected' : '' }}>Sangat Penting</option>
                                <option value="Penting" {{ old('sifat_surat', $suratMasuk->sifat_surat) == 'Penting' ? 'selected' : '' }}>Penting</option>
                                <option value="Biasa" {{ old('sifat_surat', $suratMasuk->sifat_surat) == 'Biasa' ? 'selected' : '' }}>Biasa</option>
                            </select>
                            @error('sifat_surat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- <div>
                            <label for="status_surat" class="block font-medium text-gray-700 mb-1">Status Surat (Tidak dapat diubah dari sini)</label>
                            <input type="text" class="w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2" value="{{ $suratMasuk->status_surat }}" disabled>
                            <input type="hidden" name="status_surat" value="{{ $suratMasuk->status_surat }}">
                        </div> --}}

                        <div>
                            {{-- <label for="jurusan_id" class="block font-medium text-gray-700 mb-1">Jurusan</label> --}}
                            @php
                                $currentUser = Auth::user();
                                $canEdit = ($currentUser->isOperator() && $currentUser->id === $suratMasuk->user_id && in_array($suratMasuk->status_surat, ['Diajukan', 'Ditolak'])) || $currentUser->isAdmin();
                            @endphp
                            {{-- <select name="jurusan_id" id="jurusan_id" {{ !$canEdit ? 'disabled' : '' }}
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('jurusan_id') border-red-500 @enderror">
                                <option value="">Pilih Jurusan</option>
                                @foreach($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}" {{ old('jurusan_id', $suratMasuk->jurusan_id) == $jurusan->id ? 'selected' : '' }}>
                                        {{ $jurusan->nama_jurusan }}
                                    </option>
                                @endforeach
                            </select> --}}
                            @if(!$canEdit)
                                <input type="hidden" name="jurusan_id" value="{{ old('jurusan_id', $suratMasuk->jurusan_id) }}">
                            @endif
                            @error('jurusan_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="file_surat" class="block font-medium text-gray-700 mb-1">File Surat</label>
                            @if($suratMasuk->file_surat_path)
                                <p class="text-sm text-gray-600 mb-1">File saat ini:
                                    <a href="{{ route('surat_masuk.download', $suratMasuk->id) }}" target="_blank" class="text-blue-600 underline">
                                        {{ $suratMasuk->nama_file_surat_asli }}
                                    </a>
                                </p>
                            @endif
                            <input type="file" name="file_surat" id="file_surat"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('file_surat') border-red-500 @enderror"
                                accept=".pdf,.doc,.docx,.xls,.xlsx">
                            <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah file. Maks 10MB.</p>
                            @error('file_surat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="keterangan" class="block font-medium text-gray-700 mb-1">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="3"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 resize-none @error('keterangan') border-red-500 @enderror"
                                placeholder="Masukkan keterangan">{{ old('keterangan', $suratMasuk->keterangan) }}</textarea>
                            @error('keterangan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex space-x-2 mt-6">
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-md hover:bg-primary-700">
                        Update
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
