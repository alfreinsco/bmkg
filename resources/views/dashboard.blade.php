<x-layouts.app>
    <x-slot name="title">Dashboard - BMKG</x-slot>
    <x-slot name="header">Dashboard</x-slot>

    @if (isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>Error:</strong> {{ $error }}
        </div>
    @endif

    <!-- Welcome Banner -->
    <div
        class="bg-gradient-to-r from-cyan-500 via-blue-500 to-blue-600 rounded-2xl shadow-2xl p-8 mb-8 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 opacity-10">
            <i class="fas fa-cloud-sun" style="font-size: 200px;"></i>
        </div>
        <div class="relative z-10">
            <h1 class="text-3xl font-bold mb-2">Selamat Datang di Sistem Pelaporan BMKG</h1>
            <p class="text-cyan-100 text-lg">Pantau data cuaca dan gempa bumi terkini dari seluruh Indonesia</p>
            <div class="mt-4 flex items-center space-x-4">
                <div class="flex items-center">
                    <i class="fas fa-calendar-day mr-2"></i>
                    <span>{{ date('d F Y') }}</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-clock mr-2"></i>
                    <span id="currentTime">{{ date('H:i:s') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Gempa Terkini Card -->
        <div
            class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-lg backdrop-blur-sm">
                    <i class="fas fa-house-damage text-3xl"></i>
                </div>
                @if ($gempaData && isset($gempaData['Infogempa']['gempa']['Magnitude']))
                    <span class="text-4xl font-bold">{{ $gempaData['Infogempa']['gempa']['Magnitude'] }}</span>
                @else
                    <span class="text-4xl font-bold">-</span>
                @endif
            </div>
            <p class="text-red-100 text-sm mb-1">Gempa Terkini</p>
            <p class="font-semibold">Magnitudo (SR)</p>
            @if ($gempaData && isset($gempaData['Infogempa']['gempa']['Wilayah']))
                <p class="text-xs text-red-100 mt-2 truncate">{{ $gempaData['Infogempa']['gempa']['Wilayah'] }}</p>
            @endif
        </div>

        <!-- Cuaca Card -->
        <div
            class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-lg backdrop-blur-sm">
                    <i class="fas fa-cloud-sun text-3xl"></i>
                </div>
                <span class="text-4xl font-bold">5</span>
            </div>
            <p class="text-blue-100 text-sm mb-1">Lokasi Cuaca</p>
            <p class="font-semibold">Kota Dipantau</p>
            <p class="text-xs text-blue-100 mt-2">Data real-time dari BMKG</p>
        </div>

        <!-- Peta Gempa Card -->
        <div
            class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-lg backdrop-blur-sm">
                    <i class="fas fa-map-marked-alt text-3xl"></i>
                </div>
                <span class="text-4xl font-bold">200+</span>
            </div>
            <p class="text-purple-100 text-sm mb-1">Lokasi Tersedia</p>
            <p class="font-semibold">Prakiraan Cuaca</p>
            <p class="text-xs text-purple-100 mt-2">Seluruh Indonesia</p>
        </div>

        <!-- Data Update Card -->
        <div
            class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-lg backdrop-blur-sm">
                    <i class="fas fa-sync-alt text-3xl"></i>
                </div>
                <span class="text-4xl font-bold"><i class="fas fa-check-circle"></i></span>
            </div>
            <p class="text-green-100 text-sm mb-1">Status Sistem</p>
            <p class="font-semibold">Aktif & Terhubung</p>
            <p class="text-xs text-green-100 mt-2">API BMKG Online</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Gempa Terkini -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-red-500 to-orange-500 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold mb-1">Gempa Bumi Terkini</h3>
                        <p class="text-red-100 text-sm">Informasi gempa terbaru dari BMKG</p>
                    </div>
                    <i class="fas fa-house-damage text-5xl opacity-50"></i>
                </div>
            </div>
            <div class="p-6">
                @if ($gempaData && isset($gempaData['Infogempa']['gempa']))
                    @php
                        $gempa = $gempaData['Infogempa']['gempa'];
                    @endphp
                    <div class="space-y-6">
                        <div class="flex justify-center">
                            <img src="https://data.bmkg.go.id/DataMKG/TEWS/{{ $gempa['Shakemap'] }}" alt="Shakemap"
                                class="rounded-lg shadow-md max-w-full h-auto border-4 border-gray-100">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-500 mb-1">Tanggal & Waktu</p>
                                <p class="font-bold text-gray-800">{{ $gempa['Tanggal'] }}</p>
                                <p class="text-sm text-gray-600">{{ $gempa['Jam'] }}</p>
                            </div>
                            <div class="bg-red-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-500 mb-1">Magnitude</p>
                                <p class="text-3xl font-bold text-red-600">{{ $gempa['Magnitude'] }} <span
                                        class="text-lg">SR</span></p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-500 mb-1">Kedalaman</p>
                                <p class="font-bold text-gray-800">{{ $gempa['Kedalaman'] }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-500 mb-1">Koordinat</p>
                                <p class="font-bold text-gray-800">{{ $gempa['Coordinates'] }}</p>
                            </div>
                            <div class="col-span-2 bg-blue-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-500 mb-1">Wilayah</p>
                                <p class="font-bold text-gray-800">{{ $gempa['Wilayah'] }}</p>
                            </div>
                            <div class="col-span-2 bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-500">
                                <p class="text-xs text-gray-500 mb-1">Potensi</p>
                                <p class="font-bold text-yellow-800">{{ $gempa['Potensi'] }}</p>
                            </div>
                        </div>
                        <a href="{{ route('gempa.terkini') }}"
                            class="block w-full text-center bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white font-semibold py-3 rounded-lg transition-all shadow-lg">
                            <i class="fas fa-arrow-right mr-2"></i>Lihat Detail Lengkap
                        </a>
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-exclamation-circle text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 text-lg">Data gempa tidak tersedia</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Access Menu -->
        <div class="space-y-6">
            <!-- Data Cuaca -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-cyan-500 to-blue-500 p-4 text-white">
                    <h3 class="font-bold flex items-center">
                        <i class="fas fa-cloud-sun mr-2"></i>
                        Data Cuaca
                    </h3>
                </div>
                <div class="p-4 space-y-2">
                    <a href="{{ route('cuaca.terkini') }}"
                        class="flex items-center justify-between p-3 rounded-lg hover:bg-cyan-50 transition-colors group">
                        <div class="flex items-center">
                            <div
                                class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-cyan-200 transition-colors">
                                <i class="fas fa-cloud-sun text-cyan-600"></i>
                            </div>
                            <span class="font-semibold text-gray-700">Cuaca Terkini</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-cyan-600 transition-colors"></i>
                    </a>
                    <a href="{{ route('cuaca.prakiraan') }}"
                        class="flex items-center justify-between p-3 rounded-lg hover:bg-cyan-50 transition-colors group">
                        <div class="flex items-center">
                            <div
                                class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-cyan-200 transition-colors">
                                <i class="fas fa-calendar-alt text-cyan-600"></i>
                            </div>
                            <span class="font-semibold text-gray-700">Prakiraan Cuaca</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-cyan-600 transition-colors"></i>
                    </a>
                </div>
            </div>

            <!-- Data Gempa -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-red-500 to-orange-500 p-4 text-white">
                    <h3 class="font-bold flex items-center">
                        <i class="fas fa-house-damage mr-2"></i>
                        Data Gempa
                    </h3>
                </div>
                <div class="p-4 space-y-2">
                    <a href="{{ route('gempa.terkini') }}"
                        class="flex items-center justify-between p-3 rounded-lg hover:bg-red-50 transition-colors group">
                        <div class="flex items-center">
                            <div
                                class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-200 transition-colors">
                                <i class="fas fa-house-damage text-red-600"></i>
                            </div>
                            <span class="font-semibold text-gray-700">Gempa Terkini</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-red-600 transition-colors"></i>
                    </a>
                    <a href="{{ route('gempa.m5') }}"
                        class="flex items-center justify-between p-3 rounded-lg hover:bg-red-50 transition-colors group">
                        <div class="flex items-center">
                            <div
                                class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-200 transition-colors">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </div>
                            <span class="font-semibold text-gray-700">Gempa M 5.0+</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-red-600 transition-colors"></i>
                    </a>
                    <a href="{{ route('gempa.dirasakan') }}"
                        class="flex items-center justify-between p-3 rounded-lg hover:bg-orange-50 transition-colors group">
                        <div class="flex items-center">
                            <div
                                class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-orange-200 transition-colors">
                                <i class="fas fa-bell text-orange-600"></i>
                            </div>
                            <span class="font-semibold text-gray-700">Gempa Dirasakan</span>
                        </div>
                        <i
                            class="fas fa-chevron-right text-gray-400 group-hover:text-orange-600 transition-colors"></i>
                    </a>
                    <a href="{{ route('gempa.peta') }}"
                        class="flex items-center justify-between p-3 rounded-lg hover:bg-blue-50 transition-colors group">
                        <div class="flex items-center">
                            <div
                                class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors">
                                <i class="fas fa-map-marked-alt text-blue-600"></i>
                            </div>
                            <span class="font-semibold text-gray-700">Peta Gempa</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600 transition-colors"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Footer -->
    <div class="bg-gradient-to-r from-blue-50 to-cyan-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-3xl text-blue-600"></i>
            </div>
            <div class="ml-4">
                <h4 class="text-lg font-bold text-gray-800 mb-2">Tentang Sistem</h4>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Sistem Pelaporan Data BMKG menyediakan informasi real-time tentang cuaca dan gempa bumi di seluruh
                    Indonesia.
                    Data bersumber langsung dari <strong>Badan Meteorologi, Klimatologi, dan Geofisika (BMKG)</strong>
                    dan diperbarui secara berkala untuk memberikan informasi yang akurat dan terpercaya.
                </p>
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                        <i class="fas fa-check-circle mr-1"></i>Data Real-time
                    </span>
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                        <i class="fas fa-shield-alt mr-1"></i>Sumber Resmi BMKG
                    </span>
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">
                        <i class="fas fa-globe mr-1"></i>200+ Lokasi
                    </span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Update clock every second
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('currentTime').textContent = `${hours}:${minutes}:${seconds}`;
        }
        setInterval(updateClock, 1000);
    </script>
</x-layouts.app>
