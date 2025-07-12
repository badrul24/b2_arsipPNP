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
<nav class="fixed top-0 left-0 w-full bg-primary-800 shadow z-50" x-data="{ open: false }">
  <!-- Menu utama -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center h-16">
      <!-- Logo -->
      <div class="flex items-center">
        <img class="h-12 w-auto" src="{{ asset('icons/logo.svg') }}" alt="PNP Logo" />
        <a href="/home" class="ml-3">
          <div class="text-white font-bold text-lg leading-tight">SIARSIP</div>
          <div class="text-xs text-gray-200">Politeknik Negeri Padang</div>
        </a>
      </div>

      <!-- Desktop Menu -->
      <div class="hidden sm:flex space-x-8 ml-10 h-full items-center">
        <!-- Home -->
        <div class="relative group inline-block h-16">
            <a href="/"
                class="nav-link relative inline-flex items-center px-1 h-full text-sm font-medium text-white hover:text-secondary-300 cursor-pointer
                    after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-secondary-300 after:transition-all after:duration-200
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
            <a href="/#beranda"
              class="nav-sub-link block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">Beranda</a>
            <a href="/#berita"
              class="nav-sub-link block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">Berita</a>
            <a href="/#fitur"
              class="nav-sub-link block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">Fitur</a>
            <a href="/#kontak"
              class="nav-sub-link block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">Kontak</a>
          </div>
        </div>

        <!-- Profil -->
        <div class="relative group inline-block h-16">
          <a href="/profil"
            class="nav-link relative inline-flex items-center px-1 h-full text-sm font-medium text-white hover:text-secondary-300 cursor-pointer
                   after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-secondary-300 after:transition-all after:duration-200
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
            <a href="/profil#tentang"
              class="nav-sub-link block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">Tentang Kami</a>
            <a href="/profil#visi&misi"
              class="nav-sub-link block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">Visi &amp;
              Misi</a>
            <a href="/profil#struktur-organisasi"
              class="nav-sub-link block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">Struktur
              Organisasi</a>
          </div>
        </div>

        <!-- Arsip -->
        <div class="relative group inline-block h-16">
          <a href="#"
            class="nav-link relative inline-flex items-center px-1 h-full text-sm font-medium text-white hover:text-secondary-300 cursor-pointer
                   after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-secondary-300 after:transition-all after:duration-200
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
              Statis</a>
            <a href="/arsipdinamis"
              class="nav-sub-link block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">Arsip
              Dinamis</a>
            <a href="/laporanarsip"
              class="nav-sub-link block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">Laporan
              Arsip</a>
          </div>
        </div>
      </div>

      <!-- Search Button (Desktop) -->
      <div class="hidden sm:flex items-center ml-auto">
        <button id="toggleSearch" class="text-white hover:text-secondary-300 transition focus:outline-none">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
          </svg>
        </button>
        <div id="searchContainer" class="transition-all duration-300 overflow-hidden w-0 flex items-center ml-2">
          <div class="relative">
            <input id="searchInput" type="text" placeholder="Cari berita, dokumen, surat..."
              class="border border-gray-300 px-3 py-2 pr-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-300 w-64 text-sm" />
            <button id="searchSubmit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Hamburger -->
      <button @click="open = !open" class="ml-2 sm:hidden text-white focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div class="sm:hidden bg-primary-800" x-show="open" x-transition>
    <div class="px-4 pt-2 pb-3 space-y-1">
      <!-- Search Button (Mobile) -->
      <div class="flex items-center mb-2">
        <button id="toggleSearchMobile" class="text-white hover:text-secondary-300 transition focus:outline-none">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
          </svg>
        </button>
        <div id="searchContainerMobile" class="transition-all duration-300 overflow-hidden w-0 flex items-center ml-2">
          <div class="relative">
            <input id="searchInputMobile" type="text" placeholder="Cari berita, dokumen, surat..."
              class="border border-gray-300 px-3 py-2 pr-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-300 w-48 text-sm" />
            <button id="searchSubmitMobile" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </button>
          </div>
        </div>
      </div>
      <a href="#beranda"
        class="nav-link-mobile block py-2 text-white hover:text-secondary-300 hover:border-l-4 hover:border-secondary-300 cursor-pointer">Beranda</a>
      <a href="#fitur"
        class="nav-link-mobile block py-2 text-white hover:text-secondary-300 hover:border-l-4 hover:border-secondary-300 cursor-pointer">Fitur</a>
      <a href="#tentang"
        class="nav-link-mobile block py-2 text-white hover:text-secondary-300 hover:border-l-4 hover:border-secondary-300 cursor-pointer">Tentang</a>
      <a href="#kontak"
        class="nav-link-mobile block py-2 text-white hover:text-secondary-300 hover:border-l-4 hover:border-secondary-300 cursor-pointer">Kontak</a>
      <div class="pt-4 border-t border-gray-200">
        <a href="{{ route('login') }}"
          class="block w-full text-center px-4 py-2 border border-secondary-300 text-secondary-300 rounded-md hover:bg-secondary-300 hover:text-primary-800">Masuk</a>
        <a href="{{ route('login') }}"
          class="mt-2 block w-full text-center px-4 py-2 bg-secondary-300 text-primary-800 rounded-md hover:bg-secondary-400">Daftar</a>
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

    // Search Button Desktop
    const button = document.getElementById("toggleSearch");
    const searchContainer = document.getElementById("searchContainer");
    const searchInput = document.getElementById("searchInput");
    const searchSubmit = document.getElementById("searchSubmit");
    let isOpen = false;
    if (button && searchContainer) {
      button.addEventListener("click", () => {
        isOpen = !isOpen;
        if (isOpen) {
          searchContainer.classList.remove("w-0");
          searchContainer.classList.add("w-64");
          setTimeout(() => {
            searchInput && searchInput.focus();
          }, 300);
        } else {
          searchContainer.classList.remove("w-64");
          searchContainer.classList.add("w-0");
        }
      });
      // Search submit on Enter
      if (searchInput) {
        searchInput.addEventListener("keydown", function(e) {
          if (e.key === "Enter") {
            const q = searchInput.value.trim();
            if (q) window.location.href = `{{ route('search') }}?q=${encodeURIComponent(q)}`;
          }
        });
      }
      // Search submit on button click
      if (searchSubmit) {
        searchSubmit.addEventListener("click", function() {
          const q = searchInput.value.trim();
          if (q) window.location.href = `{{ route('search') }}?q=${encodeURIComponent(q)}`;
        });
      }
    }
    // Search Button Mobile
    const buttonMobile = document.getElementById("toggleSearchMobile");
    const searchContainerMobile = document.getElementById("searchContainerMobile");
    const searchInputMobile = document.getElementById("searchInputMobile");
    const searchSubmitMobile = document.getElementById("searchSubmitMobile");
    let isOpenMobile = false;
    if (buttonMobile && searchContainerMobile) {
      buttonMobile.addEventListener("click", () => {
        isOpenMobile = !isOpenMobile;
        if (isOpenMobile) {
          searchContainerMobile.classList.remove("w-0");
          searchContainerMobile.classList.add("w-48");
          setTimeout(() => {
            searchInputMobile && searchInputMobile.focus();
          }, 300);
        } else {
          searchContainerMobile.classList.remove("w-48");
          searchContainerMobile.classList.add("w-0");
        }
      });
      // Search submit on Enter (Mobile)
      if (searchInputMobile) {
        searchInputMobile.addEventListener("keydown", function(e) {
          if (e.key === "Enter") {
            const q = searchInputMobile.value.trim();
            if (q) window.location.href = `{{ route('search') }}?q=${encodeURIComponent(q)}`;
          }
        });
      }
      // Search submit on button click (Mobile)
      if (searchSubmitMobile) {
        searchSubmitMobile.addEventListener("click", function() {
          const q = searchInputMobile.value.trim();
          if (q) window.location.href = `{{ route('search') }}?q=${encodeURIComponent(q)}`;
        });
      }
    }
  });
</script>
