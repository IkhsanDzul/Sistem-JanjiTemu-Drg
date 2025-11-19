@props(['title' => 'Dashboard'])

<header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-40">
    <div class="px-6 py-4 flex items-center justify-between">
        <!-- Mobile Menu Button -->
        <button @click="$dispatch('toggle-sidebar')" class="lg:hidden p-2 text-gray-600 hover:text-[#005248] hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Page Title -->
        <div class="flex-1 ml-4 lg:ml-0">
            <h1 class="text-2xl font-bold text-gray-900">{{ $title }}</h1>
            <p class="text-sm text-gray-500 mt-1">Halaman Utama</p>
        </div>

        <!-- Right Side - Notifications, Profile, Date/Time -->
        <div class="flex items-center gap-4">
            <!-- Profile/User Menu -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                    class="flex items-center gap-2 p-2 text-gray-600 hover:text-[#005248] hover:bg-gray-100 rounded-lg transition-colors">
                    <div class="w-8 h-8 bg-[#005248] rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-sm">
                            @if (Auth::user()->foto_profil)
                                <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover">
                            @else
                            {{ strtoupper(substr(Auth::user()->nama_lengkap ?? 'A', 0, 1)) }}
                            @endif
                        </span>
                    </div>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open"
                    @click.away="open = false"
                    x-cloak
                    x-transition
                    class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Date and Time -->
            <div class="hidden md:block text-right border-l border-gray-200 pl-4">
                <p class="text-sm font-medium text-gray-900" id="current-date">{{ now()->format('d F Y') }}</p>
                <p class="text-xs text-gray-500" id="current-time">{{ now()->format('H:i') }}</p>
            </div>
        </div>
    </div>
</header>

<script>
    // Update time every minute
    function updateTime() {
        const now = new Date();
        const dateOptions = {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        };
        const timeOptions = {
            hour: '2-digit',
            minute: '2-digit'
        };

        document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', dateOptions);
        document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', timeOptions);
    }

    // Update immediately and then every minute
    updateTime();
    setInterval(updateTime, 60000);
</script>