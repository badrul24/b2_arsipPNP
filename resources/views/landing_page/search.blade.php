@extends('landing_page.user')
@section('title','Hasil Pencarian')
@section('content')
<div class="max-w-4xl mx-auto py-16 px-4">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mt-5 mb-2">Hasil Pencarian</h1>
        @if($q)
            <p class="text-gray-600">Kata kunci: <span class="font-semibold text-primary-600">{{ $q }}</span></p>
            <p class="text-sm text-gray-500 mt-1">Ditemukan {{ $totalResults }} hasil</p>
        @endif
    </div>

    @if(empty($q))
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Masukkan kata kunci untuk mencari</h3>
            <p class="mt-1 text-sm text-gray-500">Cari berita, dokumen, surat, atau jurusan</p>
        </div>
    @elseif($totalResults == 0)
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.33" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada hasil ditemukan</h3>
            <p class="mt-1 text-sm text-gray-500">Coba kata kunci yang berbeda atau lebih spesifik</p>
        </div>
    @else
        <div class="space-y-6">
            @foreach($results as $result)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                @if($result['type'] == 'berita')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                        </svg>
                                        Berita
                                    </span>
                                @elseif($result['type'] == 'dokumen')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                        </svg>
                                        Dokumen
                                    </span>
                                @elseif($result['type'] == 'surat_masuk')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                                        </svg>
                                        Surat Masuk
                                    </span>
                                @elseif($result['type'] == 'surat_keluar')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                                        </svg>
                                        Surat Keluar
                                    </span>
                                @elseif($result['type'] == 'jurusan')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4z" clip-rule="evenodd" />
                                        </svg>
                                        Jurusan
                                    </span>
                                @endif
                                <span class="text-xs text-gray-500">{{ $result['date'] }}</span>
                            </div>
                            
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                <a href="{{ $result['url'] }}" class="hover:text-primary-600 transition-colors duration-200">
                                    {{ $result['title'] }}
                                </a>
                            </h3>
                            
                            <p class="text-gray-600 text-sm mb-3">{{ $result['description'] }}</p>
                            
                            <div class="flex items-center text-xs text-gray-500 space-x-4">
                                <span>Kategori: {{ $result['category'] }}</span>
                                <span>Oleh: {{ $result['author'] }}</span>
                            </div>
                        </div>
                        <!-- Tombol biru dihapus di sini -->
                    </div>
                </div>
            @endforeach
        </div>

        @if($totalResults > 15)
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    Menampilkan 15 dari {{ $totalResults }} hasil. 
                    <span class="text-primary-600">Coba kata kunci yang lebih spesifik untuk hasil yang lebih akurat.</span>
                </p>
            </div>
        @endif
    @endif

    <!-- Search Form -->
    <div class="mt-12 bg-gray-50 rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Cari Lagi</h3>
        <form action="{{ route('search') }}" method="GET" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="q" value="{{ $q }}" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                       placeholder="Masukkan kata kunci pencarian...">
            </div>
            <button type="submit" 
                    class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Cari
            </button>
        </form>
    </div>
</div>
@endsection 