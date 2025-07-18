<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Surat Pondok Pesantren</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen flex items-center justify-center p-4 bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="flex w-full max-w-5xl h-[600px] items-center justify-center">
        <!-- Card besar: gradient + form login -->
        <div class="h-full flex-1 rounded-l-2xl shadow-2xl bg-white flex items-center justify-center overflow-hidden">
            <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(to right,hsla(192, 88.30%, 59.60%, 0.52) 0%,hsla(194, 48.10%, 47.60%, 0.52) 100%);">
                <div class="w-full max-w-md p-8">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <div class="mx-auto w-20 h-20 mb-4 bg-blue-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-envelope text-white text-3xl"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang</h1>
                        <p class="text-gray-600">Sistem Surat Pondok Pesantren</p>
                    </div>

                    @if ($errors->any())
                    <div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-lg font-semibold text-red-600">Terjadi Kesalahan</h2>
                                <button onclick="document.getElementById('errorModal').remove()" class="text-gray-500 hover:text-red-600 text-xl">&times;</button>
                            </div>
                            <ul class="text-sm text-gray-800 list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <div class="mt-4 text-right">
                                <button onclick="document.getElementById('errorModal').remove()" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Tutup</button>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Login Form -->
                    <form action="{{route('login')}}" method="POST" id="loginForm" class="space-y-6" onsubmit="handleLogin(event)">
                        @csrf
                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                    placeholder="Masukkan email"
                                >
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                    placeholder="Masukkan password"
                                >
                                <button 
                                    type="button" 
                                    id="togglePassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                                >
                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input 
                                id="remember" 
                                name="remember" 
                                type="checkbox" 
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                            >
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Ingat saya
                            </label>
                        </div>

                        <!-- Login Button -->
                        <button 
                            type="submit" 
                            id="loginBtn"
                            class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors font-medium"
                        >
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            <span id="loginBtnText">Masuk</span>
                        </button>
                    </form>
                    <!-- Footer -->
                    <div class="mt-6 text-center">
                        <p class="text-xs text-gray-500">
                            © 2024 Sistem Surat Pondok Pesantren. Semua hak dilindungi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gambar sekolah di luar card besar -->
        <div class="h-full w-[33%] flex items-center justify-center">
            <img src="https://ruangsastra.com/wp-content/uploads/2022/07/Kiai-Genggong-ilustrasi-Istimewa.jpg" alt="Sekolah" class="object-cover w-full h-full rounded-r-2xl"/>
        </div>
    </div>
    <!-- Notification Container -->
    <div id="notificationContainer" class="fixed top-4 right-4 z-50"></div>
</body>
</html>