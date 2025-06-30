<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password - Manajemen Arsip</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            position: relative; /* Penting untuk posisi fixed child elements */
        }

        #background-container {
            background-image: url('{{ asset('images/home2.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed; /* Menjaga gambar tetap pada posisinya saat scroll */
            position: fixed; /* Selalu menutupi seluruh viewport */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -2; /* Di belakang blur-overlay */
            overflow: auto; /* Tambahkan ini jika ingin background bisa discroll */
        }

        #blur-overlay {
            position: absolute; /* Posisikan relatif terhadap #background-container */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* Sesuaikan warna overlay agar sesuai dengan gradien di login */
            background: linear-gradient(to bottom right, rgba(29, 78, 216, 0.7), rgba(17, 24, 39, 0.7));
            backdrop-filter: blur(5px); /* Terapkan blur langsung ke overlay ini */
            z-index: -1; /* Di bawah konten login tapi di atas background-container */
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center py-6 px-4 sm:px-6 lg:px-8 bg-gray-100">
    <div id="background-container">
        <div id="blur-overlay"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <div class="bg-white/95 backdrop-blur-md shadow-2xl rounded-3xl px-8 pt-6 pb-6 mb-4 border border-white/30 transform transition duration-500 hover:scale-[1.01] hover:shadow-3xl">

            <div class="flex items-center mb-6"> <div class="p-4 bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl mr-4 shadow-lg">
                    <img src="{{ asset('icons/logo.png') }}" alt="Logo" class="h-16 w-16">
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Lupa Kata Sandi?</h2>
                    <p class="text-gray-600 text-sm font-medium">Manajemen Arsip - PNP</p>
                </div>
            </div>

            @if (session('status'))
                <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded-xl mb-4 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('status') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-xl mb-4 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <p class="text-gray-600 text-sm mb-6">
                Masukkan alamat email Anda yang terdaftar dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
            </p>

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" placeholder="your@email.com" required autofocus
                            value="{{ old('email') }}"
                            class="pl-10 shadow-sm appearance-none border border-gray-300 rounded-xl w-full py-3 px-4 text-gray-700 text-sm leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 hover:border-gray-400">
                    </div>
                </div>

                <button type="submit"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02]">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-blue-300 group-hover:text-blue-200 transition duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 8a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    Kirim Tautan Reset Password
                </button>

                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold transition duration-200 hover:underline text-sm">
                        Kembali ke Login
                    </a>
                </div>
            </form>
        </div>

        <div class="text-center text-white text-xs">
            Copyright &copy; {{ date('Y') }} PNP | Politeknik Negeri Padang
        </div>
    </div>
</body>

</html>