<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: {
                        50: '#133656',
                        100: '#133656',
                        200: '#133656',
                        300: '#133656',
                        400: '#133656',
                        500: '#133656',
                        600: '#133656',
                        700: '#133656',
                        800: '#133656',
                        900: '#133656',
                        950: '#133656',
                    },
                    secondary: {
                        50: '#f5f3ff',
                        100: '#ede9fe',
                        200: '#ddd6fe',
                        300: '#c4b5fd',
                        400: '#a78bfa',
                        500: '#8b5cf6',
                        600: '#7c3aed',
                        700: '#6d28d9',
                        800: '#5b21b6',
                        900: '#4c1d95',
                        950: '#2e1065',
                    }
                }
            }
        }
    }
</script>
<nav class="fixed top-0 left-0 w-full bg-white shadow z-50" x-data="{ open: false }">
  <!-- Topbar -->
  <div class="bg-primary-800 text-white text-sm py-1 lg:px-4">
    <div class="max-w-7xl ml-[25px] mx-auto flex justify-between items-center">
        <div class="flex items-center space-x-2 text-xs">
            <a href="#" class="lang-switch hover:opacity-80 transition-opacity">
                <img src="{{ asset('icons/indonesia.png') }}" alt="Bahasa Indonesia" class="w-5 h-auto" />
            </a>
            <span>|</span>
            <a href="#" class="lang-switch hover:opacity-80 transition-opacity">
                <img src="{{ asset('icons/united-kingdom.png') }}" alt="English" class="w-5 h-auto" />
            </a>
        </div>

      <div class="flex items-center space-x-4 pr-1 sm:pr-5 lg:pr-1">
        <div class="flex space-x-3 items-center">
            <a href="https://youtube.com" target="_blank" class="hover:opacity-80 transition-opacity">
                <img src="{{ asset('icons/youtube.png') }}" alt="youtube" class="w-5 h-auto" />
            </a>
            <span>|</span>
            <a href="https://instagram.com" target="_blank" class="hover:opacity-80 transition-opacity">
                <img src="{{ asset('icons/instagram.png') }}" alt="instagram" class="w-4 h-4 " />
            </a>
            <span>|</span>
            <a href="https://x.com" target="_blank" class="hover:opacity-80 transition-opacity">
                <img src="{{ asset('icons/twitter.png') }}" alt="twitter" class="w-4 h-4 " />
            </a>
            <span>|</span>
            <button id="toggleSearch" class="hover:text-gray-300 transition">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                    <path d="M10 2a8 8 0 105.3 14.3l4.4 4.4 1.4-1.4-4.4-4.4A8 8 0 0010 2zm0 2a6 6 0 110 12 6 6 0 010-12z" />
                </svg>
            </button>

            <div id="searchContainer" class="transition-all duration-300 overflow-hidden w-0 flex items-center">
                <input type="text" placeholder="Cari..."
                    class="border border-gray-300 p-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-400 w-40 text-xs" />
            </div>
        </div>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center h-16">
      <!-- Logo -->
      <div class="flex items-center">
        <img class="h-12 w-auto" src="{{ asset('icons/logo.png') }}" alt="PNP Logo" />
        <a href="/home" class="ml-3">
          <div class="text-primary-700 font-bold text-lg leading-tight">SIARSIP</div>
          <div class="text-xs text-gray-500">Politeknik Negeri Padang</div>
        </a>
      </div>

      <!-- Desktop Menu -->
      <div class="hidden sm:flex space-x-8 ml-10 h-full items-center">
        <!-- Home -->
        <div class="relative group inline-block h-16">
            <a href="/"
                class="nav-link relative inline-flex items-center px-1 h-full text-sm font-medium text-gray-500 hover:text-primary-500 cursor-pointer
                    after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-primary-500 after:transition-all after:duration-200
                    group-hover:after:w-full">
                Home
                <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414L10 13.414 5.293 8.707a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
                </svg>
            </a>
        <div
            class="absolute left-0 top-full mt-0 w-40 bg-white border border-gray-200 rounded shadow-md opacity-0 invisible group-hover:visible group-hover:opacity-100 transition-opacity duration-200 z-10 pointer-events-auto">
            <a href="#beranda"
              class="nav-sub-link block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">Beranda</a>
            <a href="#berita"
              class="nav-sub-link block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">Berita</a>
            <a href="#fitur"
              class="nav-sub-link block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">Fitur</a>
            <a href="#kontak"
              class="nav-sub-link block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">Kontak</a>
          </div>
        </div>

        <!-- Profil -->
        <div class="relative group inline-block h-16">
          <a href="/profil"
            class="nav-link relative inline-flex items-center px-1 h-full text-sm font-medium text-gray-500 hover:text-primary-500 cursor-pointer
                   after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-primary-500 after:transition-all after:duration-200
                   group-hover:after:w-full">
            Profil
            <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414L10 13.414 5.293 8.707a1 1 0 010-1.414z"
                clip-rule="evenodd" />
            </svg>
          </a>
          <div
            class="absolute left-0 top-full mt-0 w-40 bg-white border border-gray-200 rounded shadow-md opacity-0 invisible group-hover:visible group-hover:opacity-100 transition-opacity duration-200 z-10 pointer-events-auto">
            <a href="#tentang"
              class="nav-sub-link block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">Tentang Kami</a>
            <a href="#visi&misi"
              class="nav-sub-link block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">Visi &amp;
              Misi</a>
            <a href="#struktur-organisasi"
              class="nav-sub-link block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">Struktur
              Organisasi</a>
          </div>
        </div>

        <!-- Arsip -->
        <div class="relative group inline-block h-16">
          <a href="#"
            class="nav-link relative inline-flex items-center px-1 h-full text-sm font-medium text-gray-500 hover:text-primary-500 cursor-pointer
                   after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-primary-500 after:transition-all after:duration-200
                   group-hover:after:w-full">
            Arsip
            <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414L10 13.414 5.293 8.707a1 1 0 010-1.414z"
                clip-rule="evenodd" />
            </svg>
          </a>
          <div class="absolute left-0 top-full mt-0 w-40 bg-white border border-gray-200 rounded shadow-md opacity-0 invisible group-hover:visible group-hover:opacity-100 transition-opacity duration-200 z-10 pointer-events-auto">
            <a href="/arsipstatic"
              class="nav-sub-link block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">Arsip
              Static</a>
            <a href="/arsipdinamis"
              class="nav-sub-link block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">Arsip
              Dinamis</a>
            <a href="/laporanarsip"
              class="nav-sub-link block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">Laporan
              Arsip</a>
          </div>
        </div>
      </div>

      <div class="hidden sm:flex items-center space-x-4 ml-auto">
        <a href="{{ route('login') }}"
          class="px-4 py-2 text-sm font-medium rounded-md text-primary-700 hover:text-white border border-primary bg-white hover:bg-primary-50">Masuk</a>
      </div>

      <!-- Hamburger -->
      <button @click="open = !open" class="ml-auto sm:hidden text-gray-600 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div class="sm:hidden" x-show="open" x-transition>
    <div class="px-4 pt-2 pb-3 space-y-1 bg-white shadow">
      <a href="#beranda"
        class="nav-link-mobile block py-2 text-gray-600 hover:text-primary hover:border-l-4 hover:border-primary cursor-pointer">Beranda</a>
      <a href="#fitur"
        class="nav-link-mobile block py-2 text-gray-600 hover:text-primary hover:border-l-4 hover:border-primary cursor-pointer">Fitur</a>
      <a href="#tentang"
        class="nav-link-mobile block py-2 text-gray-600 hover:text-primary hover:border-l-4 hover:border-primary cursor-pointer">Tentang</a>
      <a href="#kontak"
        class="nav-link-mobile block py-2 text-gray-600 hover:text-primary hover:border-l-4 hover:border-primary cursor-pointer">Kontak</a>
      <div class="pt-4 border-t border-gray-200">
        <a href="{{ route('login') }}"
          class="block w-full text-center px-4 py-2 border border-primary-600 text-primary-600 rounded-md hover:bg-primary-600 hover:text-white">Masuk</a>
        <a href="{{ route('login') }}"
          class="mt-2 block w-full text-center px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">Daftar</a>
      </div>
    </div>
  </div>
</nav>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll('.nav-link');
    const navSubLinks = document.querySelectorAll('.nav-sub-link');
    const navMobileLinks = document.querySelectorAll('.nav-link-mobile');

    // Fungsi reset semua aktif
    function resetActive() {
      [...navLinks, ...navSubLinks, ...navMobileLinks].forEach(el => {
        el.classList.remove('text-primary', 'border-primary', 'border-l-4', 'border-b-2', 'font-semibold');
        el.classList.add('text-gray-500', 'border-transparent');
      });
    }

    // Klik nav utama
    navSubLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
                if (!href || href === '#' || href === 'javascript:void(0)') {
                }

                resetActive();

                this.classList.remove('text-gray-500');
                this.classList.add('text-primary', 'font-semibold');

                const parentNav = this.closest('.group')?.querySelector('.nav-link');
                if (parentNav) {
                parentNav.classList.remove('text-gray-500');
                parentNav.classList.add('text-primary', 'font-semibold');

                if (window.innerWidth >= 640) {
                    parentNav.classList.add('border-b-2', 'border-primary');
                } else {
                    parentNav.classList.add('border-l-4', 'border-primary');
                }
                }
            });
        });


    // Klik submenu dropdown
    navSubLinks.forEach(link => {
      link.addEventListener('click', function (e) {
        resetActive();

        this.classList.remove('text-gray-500');
        this.classList.add('text-primary', 'font-semibold');

        // Highlight parent nav-link juga
        const parentNav = this.closest('.group').querySelector('.nav-link');
        if (parentNav) {
          parentNav.classList.remove('text-gray-500');
          parentNav.classList.add('text-primary', 'font-semibold');

          if (window.innerWidth >= 640) {
            parentNav.classList.add('border-b-2', 'border-primary');
          } else {
            parentNav.classList.add('border-l-4', 'border-primary');
          }
        }
      });
    });

    // Klik mobile menu link
    navMobileLinks.forEach(link => {
      link.addEventListener('click', function () {
        resetActive();

        this.classList.remove('text-gray-500');
        this.classList.add('text-primary', 'font-semibold', 'border-l-4', 'border-primary');
      });
    });
  });
    const button = document.getElementById("toggleSearch");
    const searchContainer = document.getElementById("searchContainer");

    let isOpen = false;

    button.addEventListener("click", () => {
        isOpen = !isOpen;
        if (isOpen) {
            searchContainer.classList.remove("w-0");
            searchContainer.classList.add("w-40");
            // Fokus otomatis ke input setelah terbuka
            setTimeout(() => {
                searchContainer.querySelector("input").focus();
            }, 300);
        } else {
            searchContainer.classList.remove("w-40");
            searchContainer.classList.add("w-0");
        }
    });
</script>
