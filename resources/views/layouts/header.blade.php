<header class="sticky top-0 z-10 flex items-center justify-between h-16 px-4 bg-white border-b border-gray-200 sm:px-6">
    <div class="flex items-center">
        <button @click="sidebarOpen = !sidebarOpen" class="p-1 mr-2 rounded-md text-primary-500 hover:bg-gray-100 md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
        </button>
        <button @click="sidebarOpen = !sidebarOpen" class="hidden p-1 mr-2 rounded-md text-primary-500 hover:bg-gray-100 md:block">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
        </button>
    </div>

    <div class="flex items-center space-x-4">
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="p-1 text-gray-500 rounded-full hover:bg-gray-100 focus:outline-none">
                
                @php
                    $totalNotifCount = ($notifications['suratMasukCount'] ?? 0) + ($notifications['disposisiCount'] ?? 0) + ($notifications['suratKeluarCount'] ?? 0);
                @endphp
                @if($totalNotifCount > 0)
                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                @endif
                
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
            </button>

            <div x-show="open" @click.away="open = false" class="absolute right-0 w-80 mt-2 bg-white border border-gray-200 rounded-md shadow-lg" style="display: none;">
                <div class="px-4 py-2 border-b border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-700">Notifikasi</h3>
                </div>
                <div class="max-h-80 overflow-y-auto">

                    @if(($notifications['suratMasukCount'] ?? 0) > 0)
                        @foreach($notifications['suratMasukItems'] as $surat)
                            @php
                                if ($surat instanceof \App\Models\Disposisi && $surat->suratMasuk) {
                                    $sm = $surat->suratMasuk;
                                } else {
                                    $sm = $surat;
                                }
                            @endphp
                            <a href="{{ route('surat_masuk.index') }}" class="block px-4 py-2 hover:bg-gray-100 bg-yellow-50 font-medium">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 pt-1">
                                        <span class="inline-block w-2 h-2 mr-3 bg-yellow-500 rounded-full"></span>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-900 font-bold">Surat Masuk Baru</p>
                                        <p class="text-xs text-gray-600">No. Agenda: {{ $sm->nomor_agenda ?? '-' }}</p>
                                        <p class="text-xs text-gray-500 truncate">Perihal: {{ $sm->perihal ?? '-' }}</p>
                                        <p class="text-xs text-gray-400">{{ $sm->created_at ? $sm->created_at->diffForHumans() : '-' }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @endif

                    @if(($notifications['disposisiCount'] ?? 0) > 0)
                        @foreach($notifications['disposisiItems'] as $disposisi)
                            <a href="{{ route('disposisi.index') }}" class="block px-4 py-2 hover:bg-gray-100 bg-blue-50 font-medium">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 pt-1">
                                        <span class="inline-block w-2 h-2 mr-3 bg-blue-500 rounded-full"></span>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-900 font-bold">Disposisi Baru</p>
                                        <p class="text-xs text-gray-600">Dari: {{ $disposisi->userPemberi->name ?? '-' }}</p>
                                        <p class="text-xs text-gray-500 truncate">Perihal: {{ $disposisi->suratMasuk->perihal ?? '-' }}</p>
                                        <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($disposisi->tanggal_disposisi)->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @endif
                    
                    @if(($notifications['suratKeluarCount'] ?? 0) > 0)
                        @foreach($notifications['suratKeluarItems'] as $sk)
                            <a href="{{ route('surat_keluar.index') }}" class="block px-4 py-2 hover:bg-gray-100 bg-purple-50 font-medium">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 pt-1">
                                        <span class="inline-block w-2 h-2 mr-3 bg-purple-500 rounded-full"></span>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-900">Surat Keluar {{ $sk->status_surat }}</p>
                                        <p class="text-xs text-gray-600">Dari: {{ $sk->pengirim ?? '-' }}</p>
                                        <p class="text-xs text-gray-500 truncate">Perihal: {{ $sk->perihal ?? '-' }}</p>
                                        <p class="text-xs text-gray-400">{{ $sk->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @endif
                    
                    @if($totalNotifCount === 0)
                        <div class="px-4 py-3 text-sm text-center text-gray-500">Tidak ada notifikasi baru.</div>
                    @endif

                </div>
            </div>
        </div>

        <div class="relative">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center space-x-2 focus:outline-none text-gray-700 hover:text-red-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H9m11 4v1a3 3 0 01-3 3H8a3 3 0 01-3-3V8a3 3 0 013-3h1a3 3 0 013 3v1" /></svg>
                    <span class="text-sm font-medium">Logout</span>
                </button>
            </form>
        </div>
    </div>
</header>