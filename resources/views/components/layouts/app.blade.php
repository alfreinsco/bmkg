<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'BMKG - Sistem Pelaporan Data' }}</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('leaflet/leaflet.css') }}">
</head>

<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-br from-cyan-500 via-cyan-600 to-blue-600 text-white flex flex-col shadow-xl">
            <!-- Logo & Brand -->
            <div class="p-6 border-b border-cyan-400/30">
                <div class="flex items-center space-x-3">
                    <div class="bg-white rounded-lg p-2 shadow-lg">
                        <i class="fas fa-cloud-sun text-cyan-600 text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-lg">BMKG</h1>
                        <p class="text-xs text-cyan-100">Data Cuaca & Gempa</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 overflow-y-auto py-4">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-6 py-3 hover:bg-cyan-400/30 transition-colors {{ request()->routeIs('dashboard') ? 'bg-cyan-400/30 border-l-4 border-white' : '' }}">
                    <i class="fas fa-home w-6"></i>
                    <span class="ml-3">Dashboard</span>
                </a>

                <!-- Data Cuaca -->
                <div class="mt-4">
                    <p class="px-6 text-xs font-semibold text-cyan-100 uppercase tracking-wider mb-2">Data Cuaca</p>
                    <a href="{{ route('cuaca.terkini') }}"
                        class="flex items-center px-6 py-3 hover:bg-cyan-400/30 transition-colors {{ request()->routeIs('cuaca.terkini') ? 'bg-cyan-400/30 border-l-4 border-white' : '' }}">
                        <i class="fas fa-cloud-sun w-6"></i>
                        <span class="ml-3">Cuaca Terkini</span>
                    </a>
                    <a href="{{ route('cuaca.prakiraan') }}"
                        class="flex items-center px-6 py-3 hover:bg-cyan-400/30 transition-colors {{ request()->routeIs('cuaca.prakiraan') ? 'bg-cyan-400/30 border-l-4 border-white' : '' }}">
                        <i class="fas fa-calendar-alt w-6"></i>
                        <span class="ml-3">Prakiraan Cuaca</span>
                    </a>
                </div>

                <!-- Data Gempa -->
                <div class="mt-4">
                    <p class="px-6 text-xs font-semibold text-cyan-100 uppercase tracking-wider mb-2">Data Gempa</p>
                    <a href="{{ route('gempa.terkini') }}"
                        class="flex items-center px-6 py-3 hover:bg-cyan-400/30 transition-colors {{ request()->routeIs('gempa.terkini') ? 'bg-cyan-400/30 border-l-4 border-white' : '' }}">
                        <i class="fas fa-house-damage w-6"></i>
                        <span class="ml-3">Gempa Terkini</span>
                    </a>
                    <a href="{{ route('gempa.m5') }}"
                        class="flex items-center px-6 py-3 hover:bg-cyan-400/30 transition-colors {{ request()->routeIs('gempa.m5') ? 'bg-cyan-400/30 border-l-4 border-white' : '' }}">
                        <i class="fas fa-exclamation-triangle w-6"></i>
                        <span class="ml-3">Gempa M 5.0+</span>
                    </a>
                    <a href="{{ route('gempa.dirasakan') }}"
                        class="flex items-center px-6 py-3 hover:bg-cyan-400/30 transition-colors {{ request()->routeIs('gempa.dirasakan') ? 'bg-cyan-400/30 border-l-4 border-white' : '' }}">
                        <i class="fas fa-bell w-6"></i>
                        <span class="ml-3">Gempa Dirasakan</span>
                    </a>
                    <a href="{{ route('gempa.peta') }}"
                        class="flex items-center px-6 py-3 hover:bg-cyan-400/30 transition-colors {{ request()->routeIs('gempa.peta') ? 'bg-cyan-400/30 border-l-4 border-white' : '' }}">
                        <i class="fas fa-map-marked-alt w-6"></i>
                        <span class="ml-3">Peta Gempa</span>
                    </a>
                </div>

                <!-- Laporan -->
                <div class="mt-4">
                    <p class="px-6 text-xs font-semibold text-cyan-100 uppercase tracking-wider mb-2">Laporan</p>
                    <a href="{{ route('laporan.index') }}"
                        class="flex items-center px-6 py-3 hover:bg-cyan-400/30 transition-colors {{ request()->routeIs('laporan.*') ? 'bg-cyan-400/30 border-l-4 border-white' : '' }}">
                        <i class="fas fa-file-alt w-6"></i>
                        <span class="ml-3">Laporan</span>
                    </a>
                </div>

                <!-- Pengaturan -->
                <div class="mt-4">
                    <p class="px-6 text-xs font-semibold text-cyan-100 uppercase tracking-wider mb-2">Pengaturan</p>
                    <a href="{{ route('pengaturan') }}"
                        class="flex items-center px-6 py-3 hover:bg-cyan-400/30 transition-colors {{ request()->routeIs('pengaturan') ? 'bg-cyan-400/30 border-l-4 border-white' : '' }}">
                        <i class="fas fa-cog w-6"></i>
                        <span class="ml-3">Pengaturan</span>
                    </a>
                </div>
            </nav>

            <!-- User Profile -->
            <div class="p-4 border-t border-cyan-400/30">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-cyan-300 flex items-center justify-center shadow-lg">
                        <i class="fas fa-user text-cyan-700"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold">Admin BMKG</p>
                        <p class="text-xs text-cyan-100">admin@bmkg.go.id</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">{{ $header ?? 'Dashboard' }}</h2>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="relative text-gray-600 hover:text-gray-800">
                            <i class="fas fa-bell text-xl"></i>
                            <span
                                class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                        </button>
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-white shadow-lg">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script src="{{ asset('fontawesome/js/all.min.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet.js') }}"></script>
</body>

</html>
