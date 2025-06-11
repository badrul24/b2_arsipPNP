<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Form Login dan Sign Up</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: {
                                50:  '#d1d9e0', // sangat terang
                                100: '#b4c3d1',
                                200: '#96acc1',
                                300: '#7895b1',
                                400: '#5a7fa1',
                                500: '#3d6992', // warna tengah
                                600: '#2f5171',
                                700: '#223b55',
                                800: '#172a3d',
                                900: '#0e1b28',
                                950: '#080f15', // paling gelap
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
</head>
<body class="w-full h-screen flex items-center justify-center bg-gray-200">

  <div class="relative w-full h-full bg-white shadow-xl overflow-hidden flex rounded-none">

    <!-- Form Container -->
    <div class="relative flex-1 h-full">
        <div id="loginForm"
            class="absolute top-0 left-0 w-1/2 h-full p-10 transition-all duration-700 ease-in-out opacity-100 scale-100 z-20 bg-cover bg-center bg-no-repeat">
        <!--log in form kiri-->
        <div class="max-w-md mx-auto space-y-6 bg-white/80 p-8 rounded-xl backdrop-blur-md">
            <h2 class="text-4xl font-bold text-center">Login</h2>
            <form action="#" method="post" class="space-y-5">
            @csrf
                <div>
                    <label for="login-email" class="block text-lg">Email:</label>
                    <input type="email" id="login-email" name="email" required class="w-full p-3 rounded bg-gray-200 focus:outline-none" />
                </div>
                <div>
                    <label for="login-password" class="block text-lg">Password:</label>
                    <input type="password" id="login-password" name="password" required class="w-full p-3 rounded bg-gray-200 focus:outline-none" />
                </div>
                <div class="flex items-center justify-between w-full">
                    <label class="flex items-center text-sm gap-2 text-gray-700 cursor-pointer">
                        <input type="checkbox" class="form-checkbox accent-primary-600" />
                        Remember Me
                    </label>
                    <div class="text-sm text-primary-600 cursor-pointer">Forget Your Password?</div>
                </div>
                <button type="submit" class="w-full py-3 rounded-xl bg-primary-600 text-white hover:bg-primary-700 text-lg">Login</button>
            </form>
                <div class="flex items-center my-4">
                    <div class="flex-grow h-px bg-gray-400"></div>
                    <span class="px-4 text-sm text-gray-600 font-semibold">atau login dengan</span>
                    <div class="flex-grow h-px bg-gray-400"></div>
                </div>

                <div class="flex justify-center gap-5 items-center">
                    <a href="#" class="w-7 h-7 flex items-center justify-center rounded-full bg-white shadow-md">
                        <img src="{{ asset('icons/twitter.png') }}" alt="twitter" class="w-4 h-4" />
                    </a>
                    <a href="#" class="w-7 h-7 flex items-center justify-center rounded-full bg-white shadow-md">
                        <img src="{{ asset('icons/youtube.png') }}" alt="youtube" class="w-5 h-5" />
                    </a>
                    <a href="#" class="w-7 h-7 flex items-cente r justify-center rounded-full bg-white shadow-md">
                        <img src="{{ asset('icons/google.png') }}" alt="google" class="w-4 h-4" />
                    </a>
                </div>
            </div>
        </div>

            <!-- Signup Form - KANAN -->
        <div id="signupForm" class="absolute top-0 right-0 w-1/2 h-full p-10 transition-all duration-700 ease-in-out opacity-0 scale-95 pointer-events-none bg-cover bg-center bg-no-repeat" style="background-image: url('aset/bg-signup.jpg');">
            <div class="max-w-md mx-auto space-y-6 bg-white/80 p-8 rounded-xl backdrop-blur-md">
                <h2 class="text-4xl font-bold text-center">Create Account</h2>
                <form action="#" method="post" class="space-y-5">
                <div>
                    <label for="signup-username" class="block text-lg">Username:</label>
                    <input type="text" id="signup-username" required class="w-full p-3 rounded bg-gray-200 focus:outline-none"/>
                </div>
                <div>
                    <label for="signup-email" class="block text-lg">Email:</label>
                    <input type="email" id="signup-email" required class="w-full p-3 rounded bg-gray-200 focus:outline-none"/>
                </div>
                <div>
                    <label for="signup-password" class="block text-lg">Password:</label>
                    <input type="password" id="signup-password" required class="w-full p-3 rounded bg-gray-200 focus:outline-none"/>
                </div>
                <button type="submit" class="w-full py-3 rounded-xl bg-primary-600 text-white hover:bg-primary-700 text-lg">Sign Up</button>
                </form>
                <div class="flex items-center my-4">
                    <div class="flex-grow h-px bg-gray-400"></div>
                    <span class="px-4 text-sm text-gray-600 font-semibold">atau login dengan</span>
                    <div class="flex-grow h-px bg-gray-400"></div>
                </div>

                <div class="flex justify-center gap-5 items-center">
                    <a href="#" class="w-7 h-7 flex items-center justify-center rounded-full bg-white shadow-md">
                        <img src="{{ asset('icons/twitter.png') }}" alt="twitter" class="w-4 h-4" />
                    </a>
                    <a href="#" class="w-7 h-7 flex items-center justify-center rounded-full bg-white shadow-md">
                        <img src="{{ asset('icons/youtube.png') }}" alt="youtube" class="w-5 h-5" />
                    </a>
                    <a href="#" class="w-7 h-7 flex items-center justify-center rounded-full bg-white shadow-md">
                        <img src="{{ asset('icons/google.png') }}" alt="google" class="w-4 h-4" />
                    </a>
                </div>
            </div>
        </div>

        <!-- Interaktif Panel -->
        <div class="absolute top-0 left-0 h-full w-1/2 bg-primary-600 text-white flex items-center justify-center transition-transform duration-700 ease-in-out z-30 relative" id="interactivePanel" style="background-image: url('{{ asset('images/gudangarsip.png') }}'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-black bg-opacity-60 z-0"></div>
            <div class="absolute top-4 left-4 z-10 text-white font-bold text-2xl">
                SIARSIP
            </div>
            <div class="text-center space-y-6 px-8 z-10">
                <h1 class="text-4xl font-bold" id="panelTitle">Welcome Back!</h1>
                <p class="max-w-[400px]" id="panelMessage"><'-'></p>
                <button id="toggleBtn" class="px-8 py-3 rounded-xl border border-white hover:bg-white hover:text-blue-600 transition text-lg">Login</button>
            </div>
        </div>
    </div>

  <script>
  document.addEventListener("DOMContentLoaded", () => {
    const toggleBtn = document.getElementById("toggleBtn");
    const interactivePanel = document.getElementById("interactivePanel");
    const loginForm = document.getElementById("loginForm");
    const signupForm = document.getElementById("signupForm");
    const panelTitle = document.getElementById("panelTitle");
    const panelMessage = document.getElementById("panelMessage");

    let isLogin = true; // Langsung ke mode Login saat awal dibuka

    // Atur tampilan awal saat halaman dimuat
    toggleBtn.innerText = "Sign Up";
    panelTitle.innerText = "Get Started!";
    panelMessage.innerText = "Belum punya akun? Daftar sekarang untuk mulai menyimpan, mengelola, dan mengakses arsip digital Anda dengan lebih mudah dan terjamin keamanannya.";
    interactivePanel.classList.add("translate-x-full");

    loginForm.classList.remove("opacity-0", "scale-95", "pointer-events-none");
    loginForm.classList.add("opacity-100", "scale-100");

    signupForm.classList.add("opacity-0", "scale-95", "pointer-events-none");
    signupForm.classList.remove("opacity-100", "scale-100");

    // Toggle antara Login dan Signup saat tombol diklik
    toggleBtn.addEventListener("click", () => {
      isLogin = !isLogin;

      if (isLogin) {
        toggleBtn.innerText = "Sign Up";
        panelTitle.innerText = "Get Started!";
        panelMessage.innerText = "Belum punya akun? Daftar sekarang untuk mulai menyimpan, mengelola, dan mengakses arsip digital Anda dengan lebih mudah dan terjamin keamanannya.";
        interactivePanel.classList.add("translate-x-full");

        loginForm.classList.remove("opacity-0", "scale-95", "pointer-events-none");
        loginForm.classList.add("opacity-100", "scale-100");

        signupForm.classList.add("opacity-0", "scale-95", "pointer-events-none");
        signupForm.classList.remove("opacity-100", "scale-100");

      } else {
        toggleBtn.innerText = "Login";
        panelTitle.innerText = "Welcome Back!";
        panelMessage.innerText = "Selamat datang kembali. Masuk ke akun Anda untuk melanjutkan pengelolaan arsip secara aman, cepat, dan terpercaya.";
        interactivePanel.classList.remove("translate-x-full");

        signupForm.classList.remove("opacity-0", "scale-95", "pointer-events-none");
        signupForm.classList.add("opacity-100", "scale-100");

        loginForm.classList.add("opacity-0", "scale-95", "pointer-events-none");
        loginForm.classList.remove("opacity-100", "scale-100");
      }
    });
  });
</script>


</body>
</html>
