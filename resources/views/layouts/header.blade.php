<!-- Header -->
<header class="sticky top-0 z-10 flex items-center justify-between h-16 px-4 bg-white border-b border-gray-200 sm:px-6">
    <div class="flex items-center">
        <button @click="sidebarOpen = !sidebarOpen"
            class="p-1 mr-2 rounded-md text-primary-500 hover:bg-gray-100 md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <button @click="sidebarOpen = !sidebarOpen"
            class="hidden p-1 mr-2 rounded-md text-primary-500 hover:bg-gray-100 md:block">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
        </button>
        <div class="relative">
            <form action="{{ route('dashboard') }}" method="GET" class="flex items-center">
                <input type="text" name="search" placeholder="Cari arsip..."
                    value="{{ request('search') }}"
                    class="w-64 px-4 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <button type="submit" class="absolute right-3 top-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <div class="flex items-center space-x-4">
        <!-- Notifications -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="p-1 text-gray-500 rounded-full hover:bg-gray-100 focus:outline-none">
                @php
                    $notifCount = ($notifications['suratMasuk'] ?? 0) + ($notifications['suratKeluar'] ?? 0) + ($notifications['disposisi'] ?? 0);
                @endphp
                @if($notifCount > 0)
                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                @endif
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </button>

            <div x-show="open" @click.away="open = false"
                class="absolute right-0 w-80 mt-2 bg-white border border-gray-200 rounded-md shadow-lg">
                <div class="px-4 py-2 border-b border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-700">Notifikasi</h3>
                </div>
                <div class="max-h-64 overflow-y-auto">
                    {{-- Surat Masuk Notifikasi --}}
                    @if(isset($notifSuratMasuk) && count($notifSuratMasuk) > 0)
                        @foreach($notifSuratMasuk as $surat)
                            <a href="{{ route('surat_masuk.index') }}"
                               class="block px-4 py-2 hover:bg-gray-50 {{ in_array($surat->status_surat, ['Diajukan','Ditolak','Diproses']) ? 'bg-yellow-50 font-bold' : '' }}">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <span class="inline-block w-2 h-2 mt-1 mr-2 bg-green-500 rounded-full"></span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Surat Masuk
                                            @if(in_array($surat->status_surat, ['Diajukan','Ditolak','Diproses']))
                                                <span class="ml-2 inline-block px-2 py-0.5 text-xs bg-yellow-400 text-white rounded">Baru</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500">Pengirim: {{ $surat->pengirim ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">Perihal: {{ $surat->perihal ?? '-' }}</p>
                                        <p class="text-xs text-gray-400">Tanggal: {{ $surat->tanggal_surat ? $surat->tanggal_surat->format('d M Y') : '-' }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @endif
                    {{-- Surat Keluar Notifikasi --}}
                    @if(isset($notifSuratKeluar) && count($notifSuratKeluar) > 0)
                        @foreach($notifSuratKeluar as $surat)
                            <a href="{{ route('surat_keluar.index') }}"
                               class="block px-4 py-2 hover:bg-gray-50 {{ in_array($surat->status_surat, ['Baru','Terkirim']) ? 'bg-blue-50 font-bold' : '' }}">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <span class="inline-block w-2 h-2 mt-1 mr-2 bg-blue-500 rounded-full"></span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Surat Keluar
                                            @if(in_array($surat->status_surat, ['Baru','Terkirim']))
                                                <span class="ml-2 inline-block px-2 py-0.5 text-xs bg-blue-400 text-white rounded">Baru</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500">Tujuan: {{ $surat->tujuan_surat ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">Perihal: {{ $surat->perihal ?? '-' }}</p>
                                        <p class="text-xs text-gray-400">Tanggal: {{ $surat->tanggal_surat ? $surat->tanggal_surat->format('d M Y') : '-' }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @endif
                    {{-- Disposisi Notifikasi --}}
                    @if(isset($notifDisposisi) && count($notifDisposisi) > 0)
                        @foreach($notifDisposisi as $disposisi)
                            <a href="{{ Auth::user() && (Auth::user()->isKepalaLembaga() || Auth::user()->isKepalaBidang()) ? route('surat_masuk.index') : route('disposisi.index') }}"
                               class="block px-4 py-2 hover:bg-gray-50 {{ $disposisi->status_disposisi == 'Baru' ? 'bg-yellow-50 font-bold' : '' }}">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <span class="inline-block w-2 h-2 mt-1 mr-2 bg-yellow-500 rounded-full"></span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Disposisi
                                            @if($disposisi->status_disposisi == 'Baru')
                                                <span class="ml-2 inline-block px-2 py-0.5 text-xs bg-yellow-400 text-white rounded">Baru</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500">Pengirim: {{ $disposisi->userPemberi->name ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">Isi: {{ $disposisi->isi_disposisi ?? '-' }}</p>
                                        <p class="text-xs text-gray-400">Tanggal: {{ $disposisi->tanggal_disposisi ? \Carbon\Carbon::parse($disposisi->tanggal_disposisi)->format('d M Y') : '-' }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @endif
                    @if((!isset($notifSuratMasuk) || count($notifSuratMasuk) == 0) && (!isset($notifDisposisi) || count($notifDisposisi) == 0) && (!isset($notifSuratKeluar) || count($notifSuratKeluar) == 0))
                        <div class="px-4 py-2 text-sm text-gray-500">Tidak ada notifikasi baru.</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- User Menu -->
        <div x-data="{ open: false }" class="relative">
            <form method="POST" action="{{ route('logout') }}">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center space-x-2 focus:outline-none text-gray-700 hover:text-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 16l4-4m0 0l-4-4m4 4H3m13 4v1a2 2 0 002 2h1a2 2 0 002-2V7a2 2 0 00-2-2h-1a2 2 0 00-2 2v1" />
                        </svg>
                        <span class="text-sm font-medium">Logout</span>
                    </button>
                </form>

                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 w-48 mt-2 bg-white border border-gray-200 rounded-md shadow-lg">
                    <div class="py-1">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan</a>
                        <div class="border-t border-gray-200"></div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            Keluar
                        </a>
                    </div>
                </div>
        </div>
    </div>
</header>
