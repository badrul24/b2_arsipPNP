@extends('layouts.index')

@section('title', 'Edit Dokumen')

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Dokumen</h2>
            <p class="mt-1 text-sm text-gray-500">Form Edit Data Dokumen</p>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('dokumen.index') }}"
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
        <div class="max-w-4xl">
            <form action="{{ route('dokumen.update', $dokumen->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-6">
                        <div>
                            <label for="nomor_surat" class="block font-medium text-gray-700 mb-1">Nomor Surat</label>
                            <input type="text" name="nomor_surat" id="nomor_surat"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nomor_surat') border-red-500 @enderror"
                                value="{{ old('nomor_surat', $dokumen->nomor_surat) }}"
                                placeholder="Masukkan nomor surat">
                            @error('nomor_surat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="judul" class="block font-medium text-gray-700 mb-1">Judul</label>
                            <input type="text" name="judul" id="judul"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('judul') border-red-500 @enderror"
                                value="{{ old('judul', $dokumen->judul) }}"
                                placeholder="Masukkan judul dokumen">
                            @error('judul')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tanggal_dokumen" class="block font-medium text-gray-700 mb-1">Tanggal Dokumen</label>
                            <input type="date" name="tanggal_dokumen" id="tanggal_dokumen"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('tanggal_dokumen') border-red-500 @enderror"
                                value="{{ old('tanggal_dokumen', $dokumen->tanggal_dokumen->format('Y-m-d')) }}">
                            @error('tanggal_dokumen')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kategori_id" class="block font-medium text-gray-700 mb-1">Kategori</label>
                            <select name="kategori_id" id="kategori_id"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('kategori_id') border-red-500 @enderror">
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ (old('kategori_id', $dokumen->kategori_id) == $kategori->id) ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kode_id" class="block font-medium text-gray-700 mb-1">Kode Klasifikasi</label>
                            <select name="kode_id" id="kode_id"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('kode_id') border-red-500 @enderror">
                                <option value="" disabled selected>Pilih Kode</option>
                                @foreach($kodes as $kode)
                                    <option value="{{ $kode->id }}" {{ (old('kode_id', $dokumen->kode_id) == $kode->id) ? 'selected' : '' }}>
                                        {{ $kode->kode }} - {{ $kode->nama_kode }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kode_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="lokasi_id" class="block font-medium text-gray-700 mb-1">Lokasi Penyimpanan</label>
                            <select name="lokasi_id" id="lokasi_id"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('lokasi_id') border-red-500 @enderror">
                                <option value="" disabled selected>Pilih Lokasi</option>
                                @foreach($lokasis as $lokasi)
                                    <option value="{{ $lokasi->id }}" {{ (old('lokasi_id', $dokumen->lokasi_id) == $lokasi->id) ? 'selected' : '' }}>
                                        {{ $lokasi->nama_lokasi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('lokasi_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-6">
                        <div>
                            <label for="retensi_id" class="block font-medium text-gray-700 mb-1">Retensi Arsip</label>
                            <select name="retensi_id" id="retensi_id"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('retensi_id') border-red-500 @enderror">
                                <option value="" disabled selected>Pilih Retensi</option>
                                @foreach($retensis as $retensi)
                                    <option value="{{ $retensi->id }}" {{ (old('retensi_id', $dokumen->retensi_id) == $retensi->id) ? 'selected' : '' }}>
                                        {{ $retensi->nama_retensi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('retensi_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sifat" class="block font-medium text-gray-700 mb-1">Sifat Dokumen</label>
                            <select name="sifat" id="sifat"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('sifat') border-red-500 @enderror"
                                required>
                                <option value="" disabled selected>Pilih Sifat</option>
                                <option value="Sangat Penting" {{ old('sifat', $dokumen->sifat) == 'Sangat Penting' ? 'selected' : '' }}>Sangat Penting</option>
                                <option value="Penting" {{ old('sifat', $dokumen->sifat) == 'Penting' ? 'selected' : '' }}>Penting</option>
                                <option value="Biasa" {{ old('sifat', $dokumen->sifat) == 'Biasa' ? 'selected' : '' }}>Biasa</option>
                            </select>
                            @error('sifat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block font-medium text-gray-700 mb-1">Status Dokumen</label>
                            <select name="status" id="status"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('status') border-red-500 @enderror"
                                required>
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="Aktif" {{ old('status', $dokumen->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Inaktif" {{ old('status', $dokumen->status) == 'Inaktif' ? 'selected' : '' }}>Inaktif</option>
                                <option value="Musnah" {{ old('status', $dokumen->status) == 'Musnah' ? 'selected' : '' }}>Musnah</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jenis" class="block font-medium text-gray-700 mb-1">Jenis Dokumen</label>
                            <select name="jenis" id="jenis"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('jenis') border-red-500 @enderror"
                                required>
                                <option value="" disabled selected>Pilih Jenis</option>
                                <option value="Surat" {{ old('jenis', $dokumen->jenis) == 'Surat' ? 'selected' : '' }}>Surat</option>
                                <option value="Laporan" {{ old('jenis', $dokumen->jenis) == 'Laporan' ? 'selected' : '' }}>Laporan</option>
                                <option value="Memorandum" {{ old('jenis', $dokumen->jenis) == 'Memorandum' ? 'selected' : '' }}>Memorandum</option>
                                <option value="Perjanjian" {{ old('jenis', $dokumen->jenis) == 'Perjanjian' ? 'selected' : '' }}>Perjanjian</option>
                                <option value="SK" {{ old('jenis', $dokumen->jenis) == 'SK' ? 'selected' : '' }}>SK</option>
                            </select>
                            @error('jenis')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jurusan_id" class="block font-medium text-gray-700 mb-1">Jurusan</label>
                            @php
                                $currentUser = Auth::user();
                                $isDisabled = $currentUser && $currentUser->isOperator() ? 'disabled' : '';
                            @endphp
                            <select name="jurusan_id" id="jurusan_id" {{ $isDisabled }}
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('jurusan_id') border-red-500 @enderror">
                                <option value="" disabled selected>Pilih Jurusan</option>
                                @foreach($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}" {{ old('jurusan_id', $dokumen->jurusan_id) == $jurusan->id ? 'selected' : '' }}>
                                        {{ $jurusan->nama_jurusan }}
                                    </option>
                                @endforeach
                            </select>
                            @if($isDisabled)
                                <input type="hidden" name="jurusan_id" value="{{ old('jurusan_id', $currentUser->jurusan_id) }}">
                            @endif
                            @error('jurusan_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="file" class="block font-medium text-gray-700 mb-1">File Dokumen</label>
                            @if($dokumen->file_path)
                                <div class="mb-2">
                                    <p class="text-sm text-gray-600">File saat ini: {{ $dokumen->nama_file_asli }}</p>
                                    <a href="{{ asset($dokumen->file_path) }}" target="_blank" class="text-primary-600 hover:text-primary-500">
                                        Lihat File
                                    </a>
                                </div>
                            @endif
                            <input type="file" name="file" id="file"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('file') border-red-500 @enderror"
                                accept=".pdf,.doc,.docx,.xls,.xlsx">
                            <p class="text-xs text-gray-500 mt-1">PDF, DOC, DOCX, XLS, XLSX maksimal 10MB</p>
                            @error('file')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label for="keterangan" class="block font-medium text-gray-700 mb-1">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 whitespace-normal break-words resize-none @error('keterangan') border-red-500 @enderror"
                        placeholder="Masukkan keterangan dokumen">{{ old('keterangan', $dokumen->keterangan) }}</textarea>
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
@endsection
