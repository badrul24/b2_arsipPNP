@extends('layouts.index')

@section('title', 'Edit Disposisi')

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Disposisi</h2>
            <p class="mt-1 text-sm text-gray-500">Form Edit Data Disposisi</p>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('disposisi.index') }}"
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
            <form action="{{ route('disposisi.update', $disposisi->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                    <!-- Kolom Kiri -->
                    <div class="space-y-4">
                        {{-- Nomor Surat --}}
                        <div>
                            <label for="sm_nomor_surat_pengirim" class="block font-medium text-gray-700 mb-1">Nomor Surat</label>
                            <input type="text" id="sm_nomor_surat_pengirim"
                                class="w-full bg-gray-100 cursor-not-allowed border border-gray-300 rounded-md px-3 py-2"
                                value="{{ $disposisi->suratMasuk->nomor_surat_pengirim ?? '-' }}" disabled>
                        </div>

                        {{-- Perihal --}}
                        <div>
                            <label for="sm_perihal" class="block font-medium text-gray-700 mb-1">Perihal</label>
                            <input type="text" id="sm_perihal"
                                class="w-full bg-gray-100 cursor-not-allowed border border-gray-300 rounded-md px-3 py-2"
                                value="{{ $disposisi->suratMasuk->perihal ?? '-' }}" disabled>
                        </div>

                        {{-- Asal Surat --}}
                        <div>
                            <label for="sm_pengirim" class="block font-medium text-gray-700 mb-1">Asal Surat</label>
                            <input type="text" id="sm_pengirim"
                                class="w-full bg-gray-100 cursor-not-allowed border border-gray-300 rounded-md px-3 py-2"
                                value="{{ $disposisi->suratMasuk->pengirim ?? '-' }}" disabled>
                        </div>

                        {{-- Tanggal Disposisi --}}
                        <div>
                            <label for="tanggal_disposisi" class="block font-medium text-gray-700 mb-1">Tanggal Disposisi</label>
                            <input type="date" name="tanggal_disposisi" id="tanggal_disposisi"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 @error('tanggal_disposisi') border-red-500 @enderror"
                                value="{{ old('tanggal_disposisi', optional($disposisi->tanggal_disposisi)->format('Y-m-d')) }}">
                            @error('tanggal_disposisi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Disposisi Kepada --}}
                        <div>
                            <label for="instruksi_kepada" class="block font-medium text-gray-700 mb-1">Disposisi Kepada (User)</label>
                            <select name="instruksi_kepada[]" id="instruksi_kepada"
                                class="select2 w-full border border-gray-300 rounded-md @error('instruksi_kepada') border-red-500 @enderror"
                                multiple>
                                @php
                                    $selectedInstruksi = old('instruksi_kepada', $disposisi->getInstruksiKepadaArray());
                                @endphp
                                @foreach ($usersWithDivisions as $user)
                                    <option value="{{ $user->id }}" {{ in_array($user->id, $selectedInstruksi) ? 'selected' : '' }}>
                                        {{ $user->name }}{{ $user->divisi ? ' (' . $user->divisi->nama_divisi . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('instruksi_kepada')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Catatan Disposisi --}}
                        <div>
                            <label for="isi_disposisi" class="block font-medium text-gray-700 mb-1">Catatan Disposisi</label>
                            <textarea name="isi_disposisi" id="isi_disposisi" rows="5"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 @error('isi_disposisi') border-red-500 @enderror"
                                required>{{ old('isi_disposisi', $disposisi->isi_disposisi) }}</textarea>
                            @error('isi_disposisi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <input type="hidden" name="surat_masuk_id" value="{{ $disposisi->surat_masuk_id }}">
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-4">
                        {{-- Status Surat --}}
                        <div>
                            <label for="sm_status_surat_display" class="block font-medium text-gray-700 mb-1">Status Surat</label>
                            <input type="text" id="sm_status_surat_display"
                                class="w-full bg-gray-100 cursor-not-allowed border border-gray-300 rounded-md px-3 py-2"
                                value="{{ $disposisi->suratMasuk->status_surat ?? '-' }}" disabled>
                        </div>

                        {{-- Tanggal Surat --}}
                        <div>
                            <label for="sm_tanggal_surat_pengirim_kanan" class="block font-medium text-gray-700 mb-1">Tanggal Surat</label>
                            <input type="text" id="sm_tanggal_surat_pengirim_kanan"
                                class="w-full bg-gray-100 cursor-not-allowed border border-gray-300 rounded-md px-3 py-2"
                                value="{{ optional($disposisi->suratMasuk->tanggal_surat_pengirim)->format('d-m-Y') ?? '-' }}" disabled>
                    </div>

                        {{-- Tanggal Terima --}}
                        <div>
                            <label for="sm_tanggal_terima" class="block font-medium text-gray-700 mb-1">Tanggal Terima</label>
                            <input type="text" id="sm_tanggal_terima"
                                class="w-full bg-gray-100 cursor-not-allowed border border-gray-300 rounded-md px-3 py-2"
                                value="{{ optional($disposisi->suratMasuk->tanggal_terima)->format('d-m-Y') ?? '-' }}" disabled>
                        </div>

                        {{-- Status Disposisi --}}
                        <div>
                            <label for="status_disposisi" class="block font-medium text-gray-700 mb-1">Status Disposisi</label>
                            <select name="status_disposisi" id="status_disposisi"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 @error('status_disposisi') border-red-500 @enderror">
                                @foreach (['Baru', 'Diterima', 'Dikerjakan', 'Selesai', 'Ditolak', 'Diteruskan'] as $status)
                                    <option value="{{ $status }}" {{ old('status_disposisi', $disposisi->status_disposisi) == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_disposisi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Petunjuk Disposisi --}}
                        <div>
                            <label for="petunjuk_disposisi" class="block font-medium text-gray-700 mb-1">Petunjuk Disposisi</label>
                            <select name="petunjuk_disposisi[]" id="petunjuk_disposisi"
                                class="select2 w-full border border-gray-300 rounded-md @error('petunjuk_disposisi') border-red-500 @enderror"
                                multiple>
                                @php
                                    $selectedPetunjuk = old('petunjuk_disposisi', $disposisi->getPetunjukDisposisiArray());
                                @endphp
                                @foreach (['Tindak Lanjuti', 'Selesaikan', 'Edarkan', 'Arsip', 'Siapkan Rapat', 'Bahas Bersama', 'Untuk Perhatian'] as $option)
                                    <option value="{{ $option }}" {{ in_array($option, $selectedPetunjuk) ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('petunjuk_disposisi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Catatan Sekretaris --}}
                        <div>
                            <label for="catatan_sekretaris" class="block font-medium text-gray-700 mb-1">Catatan untuk Sekretaris</label>
                            <textarea name="catatan" id="catatan_sekretaris" rows="5"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 @error('catatan') border-red-500 @enderror"
                                placeholder="Catatan tambahan untuk sekretaris (opsional)">{{ old('catatan', $disposisi->catatan) }}</textarea>
                            @error('catatan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Parent Disposisi --}}
                        <div>
                            <label for="parent_disposisi_id" class="block font-medium text-gray-700 mb-1">Disposisi Induk (Opsional)</label>
                            <select name="parent_disposisi_id" id="parent_disposisi_id"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 @error('parent_disposisi_id') border-red-500 @enderror">
                                <option value="">-- Pilih Disposisi Induk --</option>
                                @foreach($parentDisposisis as $parent)
                                    <option value="{{ $parent->id }}"
                                        {{ old('parent_disposisi_id', $disposisi->parent_disposisi_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->isi_disposisi }} ({{ optional($parent->tanggal_disposisi)->format('d-m-Y') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_disposisi_id')
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
