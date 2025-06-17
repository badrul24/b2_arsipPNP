<!-- Sidebar -->
<aside
    class="fixed inset-y-0 left-0 z-10 w-64 bg-white border-r border-gray-200 shadow-sm transition-all duration-300 transform"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0 md:w-16'"
>
    <!-- Logo -->
    <div class="flex items-center justify-between h-20 px-4 border-b border-gray-200">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
            </svg>
            <div class="ml-2" x-show="sidebarOpen">
                <span class="block text-lg font-bold text-gray-800">SI ARSIP</span>
                <span class="block text-sm text-primary-600">Politeknik Negeri Padang</span>
            </div>
        </div>
        <button
            @click="sidebarOpen = !sidebarOpen"
            class="p-1 rounded-md md:hidden hover:bg-gray-100"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="p-2 space-y-1 overflow-y-auto h-[calc(100vh-5rem)]">
        <!-- 1. Dashboard -->
        <div x-data="{ open: true }">
            <a href="/dashboard" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('dashboard') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span x-show="sidebarOpen">Dashboard Utama</span>
            </a>
        </div>

        <!-- 2. Manajemen Arsip -->
        <div x-data="{ open: {{ request()->is('surat-masuk*') || request()->is('surat-keluar*') || request()->is('dokumen*') || request()->is('disposisi*') ? 'true' : 'false' }} }">
            <button
                @click="open = !open"
                class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 hover:text-gray-900"
            >
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                    </svg>
                    <span x-show="sidebarOpen">Manajemen Arsip</span>
                </div>
                <svg
                    x-show="sidebarOpen"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 transition-transform duration-200"
                    :class="open ? 'rotate-90' : ''"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            <div x-show="open && sidebarOpen" class="pl-6 mt-1 space-y-1">
                <a href="/surat-masuk" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('surat-masuk*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    Surat Masuk
                </a>
                <a href="/surat-keluar" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('surat-keluar*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Surat Keluar
                </a>
                <a href="/dokumen" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('dokumen*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Dokumen
                </a>
                <a href="/disposisi" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('disposisi*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                    Disposisi
                </a>
            </div>
        </div>

        <!-- 3. Data Master -->
        <div x-data="{ open: {{ request()->is('kategori*') || request()->is('kode*') || request()->is('lokasi*') || request()->is('retensi*') ? 'true' : 'false' }} }">
            <button
                @click="open = !open"
                class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 hover:text-gray-900"
            >
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span x-show="sidebarOpen">Data Master</span>
                </div>
                <svg
                    x-show="sidebarOpen"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 transition-transform duration-200"
                    :class="open ? 'rotate-90' : ''"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            <div x-show="open && sidebarOpen" class="pl-6 mt-1 space-y-1">
                <a href="/kategori" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('kategori*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    Kategori
                </a>
                <a href="/kode" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('kode*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Kode Klasifikasi
                </a>
                <a href="/lokasi" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('lokasi*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Lokasi Penyimpanan
                </a>
                <a href="/retensi" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('retensi*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Retensi Arsip
                </a>
            </div>
        </div>

        <!-- 4. Pengaturan Sistem -->
        <div x-data="{ open: {{ request()->is('user*') || request()->is('hak-akses*') || request()->is('jurusan*') || request()->is('log-aktivitas*') ? 'true' : 'false' }} }">
            <button
                @click="open = !open"
                class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 hover:text-gray-900"
            >
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span x-show="sidebarOpen">Pengaturan Sistem</span>
                </div>
                <svg
                    x-show="sidebarOpen"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 transition-transform duration-200"
                    :class="open ? 'rotate-90' : ''"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            <div x-show="open && sidebarOpen" class="pl-6 mt-1 space-y-1">
                <a href="/user" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('user*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Manajemen Pengguna
                </a>
                <a href="/jurusan" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('jurusan*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Jurusan
                </a>
                <a href="/log-aktivitas" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('log-aktivitas*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Riwayat Aktivitas
                </a>
            </div>
        </div>

        <!-- 5. Konten & Informasi -->
        <div x-data="{ open: {{ request()->is('berita*') ? 'true' : 'false' }} }" class="mb-4">
            <button
                @click="open = !open"
                class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 hover:text-gray-900"
            >
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v12a2 2 0 01-2 2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 2v4M8 2v4M3 10h18M8 14h8" />
                    </svg>
                    <span x-show="sidebarOpen">Konten & Informasi</span>
                </div>
                <svg
                    x-show="sidebarOpen"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 transition-transform duration-200"
                    :class="open ? 'rotate-90' : ''"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            <div x-show="open && sidebarOpen" class="pl-6 mt-1 space-y-1">
                <a href="/berita" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('berita*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    Berita & Pengumuman
                </a>
            </div>
        </div>
    </nav>
</aside>
