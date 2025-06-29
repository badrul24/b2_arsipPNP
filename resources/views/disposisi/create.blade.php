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
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start"> {{-- Added items-start to align columns from top --}}
                    <!-- Kolom Kiri -->
                    <div class="space-y-4">
                        <div>
                            <label for="sm_nomor_surat_pengirim" class="block font-medium text-gray-700 mb-1">Nomor
                                Surat</label>
                            <input type="text" id="sm_nomor_surat_pengirim"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100 cursor-not-allowed"
                                value="{{ $selectedSuratMasuk->nomor_surat_pengirim ?? '-' }}" disabled>
                        </div>
                        {{-- Perihal Surat --}}
                        <div>
                            <label for="sm_perihal" class="block font-medium text-gray-700 mb-1">Perihal Surat</label>
                            <input type="text" id="sm_perihal"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100 cursor-not-allowed"
                                value="{{ $selectedSuratMasuk->perihal ?? '-' }}" disabled>
                        </div>
                        {{-- Pengirim (Asal Surat) --}}
                        <div>
                            <label for="sm_pengirim" class="block font-medium text-gray-700 mb-1">Asal Surat</label>
                            <input type="text" id="sm_pengirim"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100 cursor-not-allowed"
                                value="{{ $selectedSuratMasuk->pengirim ?? '-' }}" disabled>
                        </div>

                        {{-- Disposisi Kepada (Multi-select) --}}
                        <div>
                            <label for="instruksi_kepada" class="block font-medium text-gray-700 mb-1">
                                Disposisi Kepada (User)
                            </label>

                            <select name="instruksi_kepada[]" id="instruksi_kepada"
                                class="select2 w-full h-[42px] px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('instruksi_kepada') border-red-500 @enderror"
                                multiple required>

                                @foreach ($usersWithDivisions as $userOption)
                                    <option value="{{ $userOption->id }}"
                                        {{ in_array($userOption->id, old('instruksi_kepada', [])) ? 'selected' : '' }}>
                                        {{ $userOption->name }}
                                        ({{ $userOption->divisi->nama_divisi ?? 'Tanpa Divisi' }})
                                    </option>
                                @endforeach
                            </select>

                            @error('instruksi_kepada')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        {{-- Isi Disposisi (Catatan Bebas) --}}
                        <div>
                            <label for="isi_disposisi" class="block font-medium text-gray-700 mb-1">Catatan
                                Disposisi</label>
                            <textarea name="isi_disposisi" id="isi_disposisi" rows="5"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('isi_disposisi') border-red-500 @enderror"
                                placeholder="Masukkan isi disposisi atau catatan" required>{{ old('isi_disposisi') }}</textarea> {{-- rows="5" untuk mencocokkan tinggi multi-select --}}
                            @error('isi_disposisi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Input hidden untuk surat_masuk_id agar terkirim --}}
                        <input type="hidden" name="surat_masuk_id"
                            value="{{ old('surat_masuk_id', $selectedSuratMasuk->id ?? '') }}">
                        {{-- Menghilangkan input hidden lainnya yang tidak diperlukan di form ini --}}
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-4"> {{-- Reduced space-y for tighter packing --}}
                        {{-- Status Surat Masuk (read-only) --}}
                        <div>
                            <label for="sm_status_surat_display" class="block font-medium text-gray-700 mb-1">Status
                                Surat</label>
                            <input type="text" id="sm_status_surat_display"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100 cursor-not-allowed"
                                value="{{ $selectedSuratMasuk->status_surat ?? '-' }}" disabled>
                        </div>
                        {{-- Tanggal Surat Pengirim (read-only) --}}
                        <div>
                            <label for="sm_tanggal_surat_pengirim_kanan"
                                class="block font-medium text-gray-700 mb-1">Tanggal Surat</label>
                            <input type="text" id="sm_tanggal_surat_pengirim_kanan"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100 cursor-not-allowed"
                                value="{{ optional($selectedSuratMasuk->tanggal_surat_pengirim)->format('d-m-Y') ?? '-' }}"
                                disabled>
                        </div>
                        {{-- Tanggal Terima (read-only) --}}
                        <div>
                            <label for="sm_tanggal_terima" class="block font-medium text-gray-700 mb-1">Tanggal
                                Terima</label>
                            <input type="text" id="sm_tanggal_terima"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100 cursor-not-allowed"
                                value="{{ optional($selectedSuratMasuk->tanggal_terima)->format('d-m-Y') ?? '-' }}"
                                disabled>
                        </div>

                        {{-- Petunjuk Disposisi (Multi-select) --}}
                        <div>
                            <label for="sm_tanggal_terima" class="block font-medium text-gray-700 mb-1">Petunjuk
                                Disposisi</label>
                            <select name="petunjuk_disposisi[]" id="petunjuk_disposisi"
                                class="select2 w-full h-[42px] px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('petunjuk_disposisi') border-red-500 @enderror"
                                multiple>
                                @foreach (['Tindak Lanjuti', 'Selesaikan', 'Edarkan', 'Arsip', 'Siapkan Rapat', 'Bahas Bersama', 'Untuk Perhatian'] as $option)
                                    <option value="{{ $option }}"
                                        {{ in_array($option, old('petunjuk_disposisi', [])) ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Catatan untuk Sekretaris --}}
                        <div>
                            <label for="catatan_sekretaris" class="block font-medium text-gray-700 mb-1">Catatan untuk
                                Sekretaris</label>
                            <textarea name="catatan" id="catatan_sekretaris" rows="5"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('catatan') border-red-500 @enderror"
                                placeholder="Catatan tambahan untuk sekretaris (opsional)">{{ old('catatan') }}</textarea> {{-- rows="5" untuk mencocokkan tinggi multi-select --}}
                            @error('catatan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Hapus field-field disposisi lain yang tidak diatur pimpinan di form ini --}}
                        {{-- <input type="hidden" name="user_penerima_id" value="{{ old('user_penerima_id') }}"> --}}
                        {{-- <input type="hidden" name="divisi_penerima_id" value="{{ old('divisi_penerima_id') }}"> --}}
                        {{-- <input type="hidden" name="jurusan_penerima_id" value="{{ old('jurusan_penerima_id') }}"> --}}
                        {{-- <input type="hidden" name="tanggal_disposisi" value="{{ date('Y-m-d') }}"> --}}
                        {{-- <input type="hidden" name="status_disposisi" value="Baru"> --}}
                        {{-- <input type="hidden" name="parent_disposisi_id" value=""> --}}
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
