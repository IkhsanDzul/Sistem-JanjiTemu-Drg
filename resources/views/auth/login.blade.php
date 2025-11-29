<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DentaTime</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #FFA700 0%, #FFA700 50%, #005248 50%, #005248 100%);
        }
        @media (max-width: 768px) {
            .gradient-bg {
                background: linear-gradient(180deg, #FFA700 0%, #FFA700 40%, #005248 40%, #005248 100%);
            }
        }
    </style>
</head>
<body class="min-h-screen gradient-bg flex items-center justify-center p-4 sm:p-6">
    
    <!-- Back to Home Button -->
    <a href="{{ route('home') }}" 
       class="fixed top-4 left-4 sm:top-6 sm:left-6 z-50 group flex items-center gap-2 px-4 py-2 bg-white/90 backdrop-blur-sm rounded-full shadow-lg hover:bg-white transition-all duration-300 hover:shadow-xl">
        <svg class="w-5 h-5 text-[#005248] group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span class="text-sm font-semibold text-[#005248] hidden sm:inline">Kembali</span>
    </a>

    <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl w-full max-w-5xl overflow-hidden">
        
        <!-- Header Navigation -->
        <div class="flex justify-center gap-3 sm:gap-4 p-4 sm:p-6 border-b border-gray-100">
            <a href="{{ route('login') }}" 
               class="px-6 sm:px-8 py-2.5 sm:py-3 bg-[#FFA700] text-white rounded-full text-sm sm:text-base font-semibold shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                Login
            </a>
            <a href="{{ route('register') }}" 
               class="px-6 sm:px-8 py-2.5 sm:py-3 border-2 border-[#FFA700] text-[#FFA700] rounded-full text-sm sm:text-base font-semibold hover:bg-[#FFA700] hover:text-white transition-all duration-300">
                Register
            </a>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col lg:flex-row min-h-[500px] sm:min-h-[600px]">
            
            <!-- Left Section - Illustration -->
            <div class="hidden lg:flex flex-1 bg-gradient-to-br from-[#FFA700]/10 to-[#005248]/10 items-center justify-center p-8 relative overflow-hidden">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-[#FFA700]/5 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-[#005248]/5 rounded-full blur-3xl"></div>
                
                <div class="relative z-10 float-animation">
                    <img 
                        src="{{ asset('images/vektor-login.png') }}" 
                        alt="Dental Care Illustration" 
                        class="w-full max-w-md object-contain"
                        onerror="this.style.display='none'"
                    />
                </div>
            </div>

            <!-- Right Section - Form -->
            <div class="flex-1 flex flex-col justify-center p-6 sm:p-8 lg:p-12">
                
                <!-- Heading -->
                <div class="mb-6 sm:mb-8">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-[#005248] mb-3 leading-tight">
                        Selamat Datang Kembali! 👋
                    </h1>
                    <p class="text-gray-600 text-sm sm:text-base">
                        Masuk ke akun Anda dan kelola janji temu dengan mudah
                    </p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-[#005248] text-sm font-semibold mb-2">
                            Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <input 
                                id="email" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                class="w-full pl-12 pr-4 py-3.5 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FFA700] focus:border-transparent transition-all duration-300" 
                                placeholder="nama@email.com"
                                required 
                                autofocus 
                                autocomplete="username"
                            />
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-[#005248] text-sm font-semibold mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input 
                                id="password" 
                                type="password" 
                                name="password"
                                class="w-full pl-12 pr-12 py-3.5 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FFA700] focus:border-transparent transition-all duration-300" 
                                placeholder="Masukkan password Anda"
                                required 
                                autocomplete="current-password"
                            />
                            <button 
                                type="button"
                                onclick="togglePassword()" 
                                class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-gray-400 hover:text-[#005248] transition-colors"
                                id="togglePasswordBtn"
                            >
                                <svg id="eyeIcon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeSlashIcon" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-[#FFA700] border-gray-300 rounded focus:ring-[#FFA700]">
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-[#005248] hover:text-[#FFA700] font-medium transition-colors">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-[#FFA700] to-[#FFB733] text-white py-3.5 rounded-xl text-base font-bold hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02] flex items-center justify-center gap-2 group"
                    >
                        <span>Masuk Sekarang</span>
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </button>

                    <!-- Register Link -->
                    <div class="text-center pt-4">
                        <p class="text-sm text-gray-600">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="text-[#FFA700] hover:text-[#005248] font-semibold transition-colors">
                                Daftar sekarang
                            </a>
                        </p>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        }
    </script>

</body>
</html>
