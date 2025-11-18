<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center p-5" style="background: linear-gradient(to bottom right, #FFA500 0%, #FFA500 45%, #006666 45%, #006666 100%);">
    
    <div class="bg-amber-50 rounded-3xl shadow-2xl w-full max-w-4xl p-8">
        
        <!-- Header Buttons -->
        <div class="flex justify-center gap-4 mb-8">
            <a href="{{ route('login') }}" class="border-2 border-orange-500 text-orange-500 px-8 py-2 rounded-full text-base font-semibold hover:bg-orange-500 hover:text-white transition-all inline-block text-center">
                Login
            </a>
            <a href="{{ route('register') }}" class="border-2 border-orange-500 bg-orange-500 text-white px-8 py-2 rounded-full text-base font-semibold hover:bg-orange-600 transition-all inline-block text-center">
                Register
            </a>
        </div>

        <!-- Main Content -->
        <div class="flex gap-8 items-stretch min-h-[400px]">
            <!-- Left Section - Icons -->
            <div class="hidden md:flex justify-center items-center w-1/2">
                <img src="{{asset('images/vektor-register.png')}}" alt="Vektor Register">
            </div>

            <!-- Right Section - Form -->
            <div class="flex-1 flex flex-col justify-center px-5">
                
                <!-- Welcome Text -->
                <h1 class="text-orange-500 text-4xl font-bold mb-3 leading-tight">
                    Belum punya akun?
                </h1>
                <p class="text-orange-500 text-sm mb-6">
                    yuk daftar sekarang dan nikmati semua layanan kami !!
                </p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nama Lengkap Field -->
                    <div class="mb-4">
                        <label for="nama_lengkap" class="block text-orange-500 text-lg font-semibold mb-2">
                            Nama Lengkap
                        </label>
                        <input 
                            id="nama_lengkap" 
                            type="text" 
                            name="nama_lengkap" 
                            value="{{ old('nama_lengkap') }}"
                            class="w-full px-6 py-3 rounded-full bg-teal-800 text-white placeholder-gray-400 outline-none focus:ring-2 focus:ring-orange-400" 
                            required 
                            autofocus 
                            autocomplete="nama_lengkap"
                        />
                        @error('nama_lengkap')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="mb-4">
                        <label for="email" class="block text-orange-500 text-lg font-semibold mb-2">
                            Email
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            class="w-full px-6 py-3 rounded-full bg-teal-800 text-white placeholder-gray-400 outline-none focus:ring-2 focus:ring-orange-400" 
                            required 
                            autocomplete="username"
                        />
                        @error('email')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-4">
                        <label for="password" class="block text-orange-500 text-lg font-semibold mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <input 
                                id="password" 
                                type="password" 
                                name="password"
                                class="w-full px-6 py-3 rounded-full bg-teal-800 text-white placeholder-gray-400 outline-none focus:ring-2 focus:ring-orange-400" 
                                required 
                                autocomplete="new-password"
                            />
                            <span 
                                onclick="togglePassword('password')" 
                                class="absolute right-6 top-1/2 -translate-y-1/2 text-xl cursor-pointer"
                                id="toggle-password"
                            >
                                👁
                            </span>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-orange-500 text-lg font-semibold mb-2">
                            Konfirmasi Password
                        </label>
                        <div class="relative">
                            <input 
                                id="password_confirmation" 
                                type="password" 
                                name="password_confirmation"
                                class="w-full px-6 py-3 rounded-full bg-teal-800 text-white placeholder-gray-400 outline-none focus:ring-2 focus:ring-orange-400" 
                                required 
                                autocomplete="new-password"
                            />
                            <span 
                                onclick="togglePassword('password_confirmation')" 
                                class="absolute right-6 top-1/2 -translate-y-1/2 text-xl cursor-pointer"
                                id="toggle-password-confirmation"
                            >
                                👁
                            </span>
                        </div>
                        @error('password_confirmation')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-orange-500 text-white py-3 rounded-full text-lg font-bold hover:bg-orange-600 transition-all hover:shadow-lg flex items-center justify-center gap-3"
                    >
                        Daftar Sekarang
                        <span class="text-2xl">→</span>
                    </button>

                    <!-- Login Link -->
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-orange-500 text-sm hover:underline">
                            Sudah punya akun? Login di sini
                        </a>
                    </div>
                </form>

            </div>

        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleIcon = event.target;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = '👁';
            }
        }
    </script>

</body>
</html>