<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register - Manajemen Arsip</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
\            position: relative;
        }

        #background-container {
            background-image: url('{{ asset('images/home2.png') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -2;
            overflow: auto;
        }

        #blur-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom right, rgba(29, 78, 216, 0.7), rgba(17, 24, 39, 0.7));
            backdrop-filter: blur(5px);
            z-index: -1;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center py-6 px-4 sm:px-6 lg:px-8 bg-gray-100">
    <div id="background-container">
        <div id="blur-overlay"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <div
            class="bg-white/95 backdrop-blur-md shadow-2xl rounded-3xl px-8 pt-4 pb-4 mb-4 border border-white/30 transform transition duration-500 hover:scale-[1.01] hover:shadow-3xl">

            <div class="flex items-center mb-4">
                <div class="p-4 bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl mr-4 shadow-lg"> <img
                        src="{{ asset('icons/logo.png') }}" alt="Logo" class="h-16 w-16"> </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Manajemen Arsip</h2>
                    <p class="text-gray-600 text-sm font-medium">Politeknik Negeri Padang</p>
                </div>
            </div>

            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-xl mb-4 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded-xl mb-4 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4"> @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-gray-700 text-sm font-semibold mb-2">Nama Lengkap</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"> <svg
                                    class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="name" id="name" placeholder="Nama Lengkap" required
                                autofocus value="{{ old('name') }}" aria-describedby="name-error"
                                class="pl-10 shadow-sm appearance-none border border-gray-300 rounded-xl w-full py-3 px-4 text-gray-700 text-sm leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 hover:border-gray-400">
                        </div>
                        @error('name')
                            <p id="name-error" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Alamat Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <input type="email" name="email" id="email" placeholder="email@anda.com" required
                                value="{{ old('email') }}" aria-describedby="email-error"
                                class="pl-10 shadow-sm appearance-none border border-gray-300 rounded-xl w-full py-3 px-4 text-gray-700 text-sm leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 hover:border-gray-400">
                        </div>
                        @error('email')
                            <p id="email-error" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Kata Sandi</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" placeholder="••••••••" required
                                aria-describedby="password-error password-strength-text"
                                class="pl-10 shadow-sm appearance-none border border-gray-300 rounded-xl w-full py-3 px-4 text-gray-700 text-sm leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 hover:border-gray-400">
                            <button type="button" onclick="togglePassword('password')"
                                class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-2"
                                aria-label="Toggle password visibility">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        <div class="password-strength mt-2">
                            <div class="flex space-x-1">
                                <div class="w-1/4 h-1 rounded bg-gray-200" id="strength-bar-1"></div>
                                <div class="w-1/4 h-1 rounded bg-gray-200" id="strength-bar-2"></div>
                                <div class="w-1/4 h-1 rounded bg-gray-200" id="strength-bar-3"></div>
                                <div class="w-1/4 h-1 rounded bg-gray-200" id="strength-bar-4"></div>
                            </div>
                            <p class="text-xs mt-1 text-gray-500" id="password-strength-text">Kekuatan kata sandi</p>
                        </div>
                        @error('password')
                            <p id="password-error" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation"
                            class="block text-gray-700 text-sm font-semibold mb-2">Konfirmasi Kata Sandi</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="••••••••" required aria-describedby="password_confirmation-error"
                                class="pl-10 shadow-sm appearance-none border border-gray-300 rounded-xl w-full py-3 px-4 text-gray-700 text-sm leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 hover:border-gray-400">
                            <button type="button" onclick="togglePassword('password_confirmation')"
                                class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-2"
                                aria-label="Toggle password visibility">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p id="password_confirmation-error" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button type="submit" id="submit-btn"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02]">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg id="submit-icon"
                            class="h-5 w-5 text-blue-300 group-hover:text-blue-200 transition duration-200"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span id="submit-text">Buat Akun</span>
                </button>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500 font-medium">Atau lanjutkan dengan</span>
                    </div>
                </div>

                <a href="{{ route('oauth.google') }}?action=register"
                    class="group relative w-full flex justify-center items-center py-3 px-4 border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-200 shadow-md hover:shadow-lg transform hover:scale-[1.02]">

                    <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200"
                        viewBox="0 0 24 24">
                        <path fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>

                    <span class="text-gray-700 group-hover:text-gray-900 transition duration-200">Daftar dengan Google</span>

                    <svg class="w-4 h-4 ml-2 text-gray-400 group-hover:text-gray-600 group-hover:translate-x-1 transition-all duration-200"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                        </path>
                    </svg>
                </a>

                <div class="mt-4 text-center">
                    <p class="text-gray-600 text-sm">Sudah punya akun? <a href="{{ route('login') }}"
                            class="text-blue-600 hover:text-blue-800 font-semibold transition duration-200 hover:underline">Masuk</a></p>
                </div>
            </form>
        </div>

        <div class="text-center text-white text-xs">
            Copyright &copy; {{ date('Y') }} PNP | Politeknik Negeri Padang
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const button = input.nextElementSibling;
            const iconPath = button.querySelector('path:nth-child(2)'); // Ambil path kedua untuk mata tertutup/terbuka

            if (input.type === 'password') {
                input.type = 'text';
                iconPath.setAttribute('d',
                    'M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21'
                );
            } else {
                input.type = 'password';
                iconPath.setAttribute('d',
                    'M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'
                );
            }
        }


        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const bars = [
                document.getElementById('strength-bar-1'),
                document.getElementById('strength-bar-2'),
                document.getElementById('strength-bar-3'),
                document.getElementById('strength-bar-4')
            ];
            const text = document.getElementById('password-strength-text');

            // Reset
            bars.forEach(bar => {
                bar.className = 'w-1/4 h-1 rounded bg-gray-200';
            });

            // Check strength
            let strength = 0;
            if (password.length > 0) strength++;
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password) || /[^A-Za-z0-9]/.test(password)) strength++;

            // Update UI
            for (let i = 0; i < strength; i++) {
                const color = strength < 2 ? 'bg-red-500' :
                    strength < 4 ? 'bg-yellow-500' : 'bg-green-500';
                bars[i].className = `w-1/4 h-1 rounded ${color}`;
            }

            const messages = ['Sangat Lemah', 'Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'];
            text.textContent = `Kekuatan kata sandi: ${messages[strength]}`;
            text.className = `text-xs mt-1 ${
                strength < 2 ? 'text-red-500' :
                strength < 4 ? 'text-yellow-500' : 'text-green-500'
            }`;
        });

        // Form submission loading state
        document.querySelector('form').addEventListener('submit', function() {
            const btn = document.getElementById('submit-btn');
            const icon = document.getElementById('submit-icon');
            const text = document.getElementById('submit-text');

            btn.disabled = true;
            btn.classList.remove('hover:from-blue-700', 'hover:to-blue-800', 'hover:shadow-xl');
            text.textContent = 'Membuat Akun...';
            icon.innerHTML =
                '<path fill-rule="evenodd" d="M4 12a8 8 0 1116 0A8 8 0 014 12zm8-6a6 6 0 100 12 6 6 0 000-12zM12 4a.5.5 0 01.5.5v2a.5.5 0 01-1 0v-2A.5.5 0 0112 4zm-4.5 7.5a.5.5 0 01-.5-.5h-2a.5.5 0 010-1h2a.5.5 0 01.5.5zm8 0a.5.5 0 01.5-.5h2a.5.5 0 010 1h-2a.5.5 0 01-.5-.5zM12 18a.5.5 0 01-.5-.5v-2a.5.5 0 011 0v2a.5.5 0 01-.5.5zM15.5 7.5a.5.5 0 000-.707l-1.414-1.414a.5.5 0 00-.707 0 .5.5 0 000 .707l1.414 1.414a.5.5 0 00.707 0zM8.5 15.5a.5.5 0 000-.707L7.086 13.379a.5.5 0 00-.707 0 .5.5 0 000 .707l1.414 1.414a.5.5 0 00.707 0zM15.5 15.5a.5.5 0 00-.707 0L13.379 14.086a.5.5 0 000-.707 .5.5 0 00.707 0l1.414 1.414a.5.5 0 000 .707zM8.5 7.5a.5.5 0 00-.707 0L6.379 8.914a.5.5 0 000 .707 .5.5 0 00.707 0l1.414-1.414a.5.5 0 000-.707z" clip-rule="evenodd" />';
            icon.classList.add('animate-spin');
        });
    </script>
</body>

</html>
