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
            <input type="text" placeholder="Cari arsip..."
                class="w-64 px-4 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute w-5 h-5 text-gray-400 right-3 top-2" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    <div class="flex items-center space-x-4">
        <!-- Notifications -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="p-1 text-gray-500 rounded-full hover:bg-gray-100 focus:outline-none">
                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
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
                    <a href="#" class="block px-4 py-2 hover:bg-gray-50">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <span class="inline-block w-2 h-2 mt-1 mr-2 bg-blue-500 rounded-full"></span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Surat masuk baru</p>
                                <p class="text-xs text-gray-500">Surat dari Kementerian Pendidikan telah diterima</p>
                                <p class="text-xs text-gray-400">2 menit yang lalu</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-50">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <span class="inline-block w-2 h-2 mt-1 mr-2 bg-blue-500 rounded-full"></span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Pengajuan surat</p>
                                <p class="text-xs text-gray-500">Ahmad mengajukan surat keterangan</p>
                                <p class="text-xs text-gray-400">1 jam yang lalu</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-50">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <span class="inline-block w-2 h-2 mt-1 mr-2 bg-gray-300 rounded-full"></span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Pembaruan sistem</p>
                                <p class="text-xs text-gray-500">Sistem telah diperbarui ke versi terbaru</p>
                                <p class="text-xs text-gray-400">Kemarin</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="px-4 py-2 border-t border-gray-200">
                    <a href="#" class="text-xs font-medium text-primary-600 hover:text-primary-500">Lihat semua
                        notifikasi</a>
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
