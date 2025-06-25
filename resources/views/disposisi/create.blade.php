@extends('layouts.index')

@section('title', 'Tambah Disposisi')

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Tambah Disposisi</h2>
            <p class="mt-1 text-sm text-gray-500">Form Tambah Data Disposisi</p>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('disposisi.index') }}"
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
            <form action="{{ route('disposisi.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-6">
                        <div>
                            <label for="surat_masuk_id" class="block font-medium text-gray-700 mb-1">Surat Masuk</label>
                            @php
                                $isDisabledSuratMasuk = !empty($selectedSuratMasuk);
                            @endphp
                            <select name="surat_masuk_id" id="surat_masuk_id" 
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('surat_masuk_id') border-red-500 @enderror" 
                                {{ $isDisabledSuratMasuk ? 'disabled' : '' }} required>
                                <option value="" disabled {{ !old('surat_masuk_id', $selectedSuratMasuk ? $selectedSuratMasuk->id : '') ? 'selected' : '' }}>Pilih Surat Masuk</option>
                                @foreach($suratMasuks as $sm)
                                    <option value="{{ $sm->id }}" 
                                        {{ old('surat_masuk_id', $selectedSuratMasuk ? $selectedSuratMasuk->id : '') == $sm->id ? 'selected' : '' }}>
                                        {{ $sm->nomor_surat_pengirim }} - {{ $sm->perihal }}
                                    </option>
                                @endforeach
                            </select>
                            @if($isDisabledSuratMasuk)
                                <input type="hidden" name="surat_masuk_id" value="{{ old('surat_masuk_id', $selectedSuratMasuk ? $selectedSuratMasuk->id : '') }}">
                            @endif
                            @error('surat_masuk_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Instruksi Kepada (Multi-select) --}}
                        <div>
                            <label for="instruksi_kepada" class="block font-medium text-gray-700 mb-1">Disposisi Kepada (Tindakan)</label>
                            <select name="instruksi_kepada[]" id="instruksi_kepada" multiple
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('instruksi_kepada') border-red-500 @enderror">
                                {{-- Opsi sesuai dengan yang Anda sebutkan --}}
                                @php
                                    $instruksiKepadaOptions = [
                                        'Teliti dan Pendapat',
                                        'Untuk Diketahui',
                                        'Sebarkan',
                                        'File',
                                        'Edarkan',
                                        'Selesai',
                                        'Tindak Lanjuti',
                                        'Jawab',
                                        'Buatkan Konsep',
                                    ];
                                    $oldInstruksiKepada = old('instruksi_kepada', []);
                                    // Jika $disposisi ada (edit mode) dan data tersimpan sebagai JSON
                                    // $oldInstruksiKepada = $disposisi->instruksi_kepada ? json_decode($disposisi->instruksi_kepada, true) : [];
                                @endphp
                                @foreach($instruksiKepadaOptions as $option)
                                    <option value="{{ $option }}" {{ in_array($option, $oldInstruksiKepada) ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                            @error('instruksi_kepada')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Petunjuk Disposisi (Multi-select) --}}
                        <div>
                            <label for="petunjuk_disposisi" class="block font-medium text-gray-700 mb-1">Petunjuk Disposisi</label>
                            <select name="petunjuk_disposisi[]" id="petunjuk_disposisi" multiple
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('petunjuk_disposisi') border-red-500 @enderror">
                                {{-- Opsi sesuai dengan yang Anda sebutkan --}}
                                @php
                                    $petunjukDisposisiOptions = [
                                        'Tindak Lanjuti',
                                        'Selesaikan',
                                        'Edarkan',
                                        'Arsip',
                                        'Siapkan Rapat',
                                        'Bahas Bersama',
                                        'Untuk Perhatian',
                                    ];
                                    $oldPetunjukDisposisi = old('petunjuk_disposisi', []);
                                    // Jika $disposisi ada (edit mode) dan data tersimpan sebagai JSON
                                    // $oldPetunjukDisposisi = $disposisi->petunjuk_disposisi ? json_decode($disposisi->petunjuk_disposisi, true) : [];
                                @endphp
                                @foreach($petunjukDisposisiOptions as $option)
                                    <option value="{{ $option }}" {{ in_array($option, $oldPetunjukDisposisi) ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                            @error('petunjuk_disposisi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="isi_disposisi" class="block font-medium text-gray-700 mb-1">Isi Disposisi (Catatan Bebas)</label>
                            <textarea name="isi_disposisi" id="isi_disposisi" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('isi_disposisi') border-red-500 @enderror" placeholder="Masukkan instruksi atau catatan bebas disposisi" required>{{ old('isi_disposisi') }}</textarea>
                            @error('isi_disposisi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="catatan" class="block font-medium text-gray-700 mb-1">Catatan Tambahan</label>
                            <textarea name="catatan" id="catatan" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('catatan') border-red-500 @enderror" placeholder="Masukkan catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <!-- Kolom Kanan (Penerima dan Status) -->
                    <div class="space-y-6">
                        <div>
                            <label for="user_penerima_id" class="block font-medium text-gray-700 mb-1">User Penerima</label>
                            <select name="user_penerima_id" id="user_penerima_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('user_penerima_id') border-red-500 @enderror">
                                <option value="" selected>-- Pilih User Penerima (opsional) --</option>
                                @foreach($users as $userOption)
                                    <option value="{{ $userOption->id }}" {{ old('user_penerima_id') == $userOption->id ? 'selected' : '' }}>{{ $userOption->name }}</option>
                                @endforeach
                            </select>
                            @error('user_penerima_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="divisi_penerima_id" class="block font-medium text-gray-700 mb-1">Divisi Penerima</label>
                            <select name="divisi_penerima_id" id="divisi_penerima_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('divisi_penerima_id') border-red-500 @enderror">
                                <option value="" selected>-- Pilih Divisi Penerima (opsional) --</option>
                                @foreach($divisis as $divisi)
                                    <option value="{{ $divisi->id }}" {{ old('divisi_penerima_id') == $divisi->id ? 'selected' : '' }}>{{ $divisi->nama_divisi }}</option>
                                @endforeach
                            </select>
                            @error('divisi_penerima_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="jurusan_penerima_id" class="block font-medium text-gray-700 mb-1">Jurusan Penerima</label>
                            <select name="jurusan_penerima_id" id="jurusan_penerima_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('jurusan_penerima_id') border-red-500 @enderror">
                                <option value="" selected>-- Pilih Jurusan Penerima (opsional) --</option>
                                @foreach($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}" {{ old('jurusan_penerima_id') == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama_jurusan }}</option>
                                @endforeach
                            </select>
                            @error('jurusan_penerima_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        @if($errors->has('penerima'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('penerima') }}</p>
                        @endif

                        <div>
                            <label for="tanggal_disposisi" class="block font-medium text-gray-700 mb-1">Tanggal Disposisi</label>
                            <input type="date" name="tanggal_disposisi" id="tanggal_disposisi" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('tanggal_disposisi') border-red-500 @enderror" value="{{ old('tanggal_disposisi', date('Y-m-d')) }}" required>
                            @error('tanggal_disposisi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="status_disposisi" class="block font-medium text-gray-700 mb-1">Status Disposisi</label>
                            <select name="status_disposisi" id="status_disposisi" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('status_disposisi') border-red-500 @enderror" required>
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="Baru" {{ old('status_disposisi') == 'Baru' ? 'selected' : '' }}>Baru</option>
                                <option value="Diterima" {{ old('status_disposisi') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="Dikerjakan" {{ old('status_disposisi') == 'Dikerjakan' ? 'selected' : '' }}>Dikerjakan</option>
                                <option value="Selesai" {{ old('status_disposisi') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Ditolak" {{ old('status_disposisi') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                <option value="Diteruskan" {{ old('status_disposisi') == 'Diteruskan' ? 'selected' : '' }}>Diteruskan</option>
                            </select>
                            @error('status_disposisi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="parent_disposisi_id" class="block font-medium text-gray-700 mb-1">Disposisi Induk (Parent)</label>
                            <select name="parent_disposisi_id" id="parent_disposisi_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('parent_disposisi_id') border-red-500 @enderror">
                                <option value="" selected>-- Pilih Disposisi Induk (opsional) --</option>
                                @foreach($parentDisposisis as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_disposisi_id') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->isi_disposisi }} ({{ $parent->tanggal_disposisi ? date('d-m-Y', strtotime($parent->tanggal_disposisi)) : '' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_disposisi_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        Simpan
                    </button>
                    <button type="reset"
                        class="px-4 py-2 text-sm font-medium text-white bg-yellow-500 rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
