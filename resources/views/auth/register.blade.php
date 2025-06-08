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
            background-image: url('https://images.unsplash.com/photo-1586281380349-632531db7ed4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin {
            animation: spin 1s linear infinite;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center py-6 px-4 sm:px-6 lg:px-8 bg-gray-100">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-900/70 to-gray-900/70 backdrop-blur-sm"></div>

    <div class="w-full max-w-md relative z-10 px-2">
        <div class="bg-white/95 backdrop-blur-md shadow-2xl rounded-2xl px-6 pt-6 pb-6 mb-4 border border-gray-200/50 transform transition duration-500 hover:scale-[1.01]">
            <div class="flex items-center mb-5">
                <div class="p-3 bg-blue-50 rounded-full mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Create Account</h2>
                    <p class="text-gray-600 text-sm">Manajemen Arsip - PNP</p>
                </div>
            </div>

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-2 rounded-md mb-3 text-xs">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-4 w-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-2">
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 rounded-md mb-3 text-xs">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-2">
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-3">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label for="name" class="block text-gray-700 text-xs font-semibold mb-1">Full Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                placeholder="John Doe"
                                required
                                autofocus
                                value="{{ old('name') }}"
                                aria-describedby="name-error"
                                class="pl-8 shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 text-sm leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                            >
                        </div>
                        @error('name')
                            <p id="name-error" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-gray-700 text-xs font-semibold mb-1">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                placeholder="your@email.com"
                                required
                                value="{{ old('email') }}"
                                aria-describedby="email-error"
                                class="pl-8 shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 text-sm leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                            >
                        </div>
                        @error('email')
                            <p id="email-error" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label for="password" class="block text-gray-700 text-xs font-semibold mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="••••••••"
                                required
                                aria-describedby="password-error password-strength-text"
                                class="pl-8 shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 text-sm leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                            >
                            <button type="button" onclick="togglePassword('password')"
                                    class="absolute right-2 top-2 text-gray-400 hover:text-gray-600"
                                    aria-label="Toggle password visibility">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        <div class="password-strength mt-1">
                            <div class="flex space-x-1">
                                <div class="w-1/4 h-1 rounded bg-gray-200" id="strength-bar-1"></div>
                                <div class="w-1/4 h-1 rounded bg-gray-200" id="strength-bar-2"></div>
                                <div class="w-1/4 h-1 rounded bg-gray-200" id="strength-bar-3"></div>
                                <div class="w-1/4 h-1 rounded bg-gray-200" id="strength-bar-4"></div>
                            </div>
                            <p class="text-xs mt-1 text-gray-500" id="password-strength-text">Password strength</p>
                        </div>
                        @error('password')
                            <p id="password-error" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-gray-700 text-xs font-semibold mb-1">Confirm Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                placeholder="••••••••"
                                required
                                aria-describedby="password_confirmation-error"
                                class="pl-8 shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 text-sm leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                            >
                            <button type="button" onclick="togglePassword('password_confirmation')"
                                    class="absolute right-2 top-2 text-gray-400 hover:text-gray-600"
                                    aria-label="Toggle password visibility">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

                <div class="flex items-center">
                    <input id="terms" name="terms" type="checkbox" required
                           class="h-3 w-3 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                           aria-describedby="terms-error">
                    <label for="terms" class="ml-2 block text-xs text-gray-700">
                        I agree to the <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Terms of Service</a> and <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Privacy Policy</a>
                    </label>
                </div>
                @error('terms')
                    <p id="terms-error" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <button
                    type="submit"
                    id="submit-btn"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 shadow-lg hover:shadow-xl"
                >
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg id="submit-icon" class="h-4 w-4 text-blue-400 group-hover:text-blue-300 transition duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span id="submit-text">Create Account</span>
                </button>

                <div class="text-center">
                    <p class="text-gray-600 text-xs">Already have an account? <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium transition duration-200">Sign in</a></p>
                </div>
            </form>
        </div>

        <div class="text-center text-white text-xs">
            Copyright &copy; {{ date("Y") }} PNP | Politeknik Negeri Padang
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword(id) {
            const input = document.getElementById(id);
            const button = input.nextElementSibling;
            const icon = button.querySelector('svg');

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
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

            const messages = ['Very Weak', 'Weak', 'Medium', 'Strong', 'Very Strong'];
            text.textContent = `Password strength: ${messages[strength]}`;
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
            text.textContent = 'Creating Account...';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />';
            icon.classList.add('animate-spin');
        });
    </script>
</body>
</html>
