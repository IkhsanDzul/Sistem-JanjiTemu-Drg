<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center p-3 sm:p-4 md:p-5" style="background: linear-gradient(to bottom right, #FFA500 0%, #FFA500 45%, #006666 45%, #006666 100%);">
    
    <div class="bg-amber-50 rounded-2xl sm:rounded-3xl shadow-2xl w-full max-w-4xl p-4 sm:p-6 md:p-8">
        
        <!-- Header Buttons - Responsive -->
        <div class="flex justify-center gap-2 sm:gap-4 mb-4 sm:mb-6 md:mb-8">
            <a href="{{ route('login') }}" class="border-2 border-orange-500 bg-orange-500 text-white px-4 py-1.5 sm:px-6 sm:py-2 md:px-8 rounded-full text-xs sm:text-sm md:text-base font-semibold hover:bg-orange-600 transition-all inline-block text-center">
                Login
            </a>
            <a href="{{ route('register') }}" class="border-2 border-orange-500 text-orange-500 px-4 py-1.5 sm:px-6 sm:py-2 md:px-8 rounded-full text-xs sm:text-sm md:text-base font-semibold hover:bg-orange-500 hover:text-white transition-all inline-block text-center">
                Register
            </a>
        </div>

        <!-- Main Content - Responsive Layout -->
        <div class="flex flex-col md:flex-row gap-4 sm:gap-6 md:gap-8 items-stretch min-h-[300px] sm:min-h-[350px] md:min-h-[400px]">
            
            <!-- Image Section - Hidden on mobile, shown on tablet and desktop -->
            <div class="hidden md:flex flex-1 flex-col justify-center items-center">
                <img 
                    src="{{ asset('storage/images/vektor-login.png') }}" 
                    alt="Tim Dokter Profesional" 
                    class="w-full max-w-md object-cover"
                />
            </div>

            <!-- Form Section -->
            <div class="flex-1 flex flex-col justify-center px-2 sm:px-4 md:px-5">
                
                <!-- Heading - Responsive Text Size -->
                <h1 class="text-orange-500 text-2xl sm:text-3xl md:text-4xl font-bold mb-2 sm:mb-3 leading-tight">
                    Sudah punya akun?
                </h1>
                <p class="text-orange-500 text-xs sm:text-sm mb-4 sm:mb-5 md:mb-6">
                    yuk login sekarang dan buat janji temu kamu !!
                </p>

                <x-auth-session-status class="mb-3 sm:mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Field - Responsive -->
                    <div class="mb-4 sm:mb-5 md:mb-6">
                        <label for="email" class="block text-orange-500 text-base sm:text-lg md:text-xl font-semibold mb-1.5 sm:mb-2">
                            Email
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 sm:px-5 sm:py-3.5 md:px-6 md:py-4 rounded-full bg-teal-800 text-white placeholder-gray-400 outline-none focus:ring-2 focus:ring-orange-400 text-sm sm:text-base" 
                            required 
                            autofocus 
                            autocomplete="username"
                        />
                        @error('email')
                            <p class="text-red-500 text-xs sm:text-sm mt-1.5 sm:mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field - Responsive -->
                    <div class="mb-6 sm:mb-7 md:mb-8">
                        <label for="password" class="block text-orange-500 text-base sm:text-lg md:text-xl font-semibold mb-1.5 sm:mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <input 
                                id="password" 
                                type="password" 
                                name="password"
                                class="w-full px-4 py-3 sm:px-5 sm:py-3.5 md:px-6 md:py-4 pr-12 sm:pr-14 md:pr-16 rounded-full bg-teal-800 text-white placeholder-gray-400 outline-none focus:ring-2 focus:ring-orange-400 text-sm sm:text-base" 
                                required 
                                autocomplete="current-password"
                            />
                            <span 
                                onclick="togglePassword()" 
                                class="absolute right-4 sm:right-5 md:right-6 top-1/2 -translate-y-1/2 cursor-pointer"
                                id="toggleIcon"
                            >
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeSlashIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-gray-300 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </span>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs sm:text-sm mt-1.5 sm:mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button - Responsive -->
                    <button 
                        type="submit" 
                        class="w-full bg-orange-500 text-white py-3 sm:py-3.5 md:py-4 rounded-full text-base sm:text-lg md:text-xl font-bold hover:bg-orange-600 transition-all hover:shadow-lg flex items-center justify-center gap-2 sm:gap-3"
                    >
                        Login Sekarang
                        <span class="text-xl sm:text-2xl">→</span>
                    </button>
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