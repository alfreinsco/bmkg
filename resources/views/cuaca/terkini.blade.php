<x-layouts.app>
    <x-slot name="title">Cuaca Terkini - BMKG</x-slot>
    <x-slot name="header">Cuaca Terkini</x-slot>

    @if (isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>Error:</strong> {{ $error }}
        </div>
    @endif

    <div class="mb-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Prakiraan Cuaca Hari Ini</h3>
        <p class="text-gray-600">Data cuaca terkini dari BMKG untuk beberapa kota besar di Indonesia</p>
    </div>

    @if (!empty($cuacaData))
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach ($cuacaData as $cityName => $data)
                @if ($data && isset($data['data'][0]['cuaca'][0]))
                    @php
                        $lokasi = $data['lokasi'] ?? [];
                        $cuacaHariIni = $data['data'][0]['cuaca'][0] ?? [];
                    @endphp

                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-cyan-500 to-blue-600 p-4">
                            <div class="flex items-center justify-between text-white">
                                <div>
                                    <h4 class="text-xl font-bold">{{ $cityName }}</h4>
                                    <p class="text-sm text-cyan-100">
                                        {{ $lokasi['kecamatan'] ?? '' }}, {{ $lokasi['kotkab'] ?? '' }}
                                    </p>
                                </div>
                                <i class="fas fa-map-marker-alt text-3xl"></i>
                            </div>
                        </div>

                        <!-- Current Weather -->
                        @if (!empty($cuacaHariIni))
                            @php
                                $currentWeather = $cuacaHariIni[0] ?? null;
                            @endphp

                            @if ($currentWeather)
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-6">
                                        <div>
                                            <p class="text-5xl font-bold text-gray-800">
                                                {{ $currentWeather['t'] ?? 'N/A' }}°C
                                            </p>
                                            <p class="text-gray-600 mt-2">{{ $currentWeather['weather_desc'] ?? 'N/A' }}
                                            </p>
                                        </div>
                                        @if (isset($currentWeather['image']))
                                            <img src="{{ $currentWeather['image'] }}" alt="Weather Icon"
                                                class="w-20 h-20">
                                        @endif
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="bg-blue-50 p-3 rounded-lg">
                                            <div class="flex items-center text-blue-600 mb-1">
                                                <i class="fas fa-tint mr-2"></i>
                                                <span class="text-xs font-semibold">Kelembaban</span>
                                            </div>
                                            <p class="text-lg font-bold text-gray-800">
                                                {{ $currentWeather['hu'] ?? 'N/A' }}%</p>
                                        </div>

                                        <div class="bg-green-50 p-3 rounded-lg">
                                            <div class="flex items-center text-green-600 mb-1">
                                                <i class="fas fa-wind mr-2"></i>
                                                <span class="text-xs font-semibold">Kec. Angin</span>
                                            </div>
                                            <p class="text-lg font-bold text-gray-800">
                                                {{ $currentWeather['ws'] ?? 'N/A' }} km/j</p>
                                        </div>

                                        <div class="bg-purple-50 p-3 rounded-lg">
                                            <div class="flex items-center text-purple-600 mb-1">
                                                <i class="fas fa-compass mr-2"></i>
                                                <span class="text-xs font-semibold">Arah Angin</span>
                                            </div>
                                            <p class="text-lg font-bold text-gray-800">
                                                {{ $currentWeather['wd'] ?? 'N/A' }}</p>
                                        </div>

                                        <div class="bg-orange-50 p-3 rounded-lg">
                                            <div class="flex items-center text-orange-600 mb-1">
                                                <i class="fas fa-eye mr-2"></i>
                                                <span class="text-xs font-semibold">Jarak Pandang</span>
                                            </div>
                                            <p class="text-sm font-bold text-gray-800">
                                                {{ $currentWeather['vs_text'] ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <!-- Hourly Forecast -->
                                    <div class="mt-6">
                                        <h5 class="text-sm font-semibold text-gray-700 mb-3">Prakiraan Per Jam</h5>
                                        <div class="flex overflow-x-auto space-x-3 pb-2">
                                            @foreach (array_slice($cuacaHariIni, 0, 6) as $hourly)
                                                <div
                                                    class="flex-shrink-0 bg-gray-50 rounded-lg p-3 text-center min-w-[80px]">
                                                    <p class="text-xs text-gray-600 mb-2">
                                                        {{ date('H:i', strtotime($hourly['local_datetime'] ?? '')) }}
                                                    </p>
                                                    @if (isset($hourly['image']))
                                                        <img src="{{ $hourly['image'] }}" alt="Weather"
                                                            class="w-10 h-10 mx-auto mb-2">
                                                    @endif
                                                    <p class="text-lg font-bold text-gray-800">
                                                        {{ $hourly['t'] ?? 'N/A' }}°</p>
                                                    <p class="text-xs text-gray-600 mt-1">
                                                        {{ $hourly['hu'] ?? 'N/A' }}%</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                @endif
            @endforeach
        </div>

        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <p class="text-sm text-blue-800">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Sumber Data:</strong> Badan Meteorologi, Klimatologi, dan Geofisika (BMKG) - Data diperbarui
                secara berkala
            </p>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <i class="fas fa-cloud text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">Data cuaca tidak tersedia saat ini</p>
            <p class="text-gray-400 text-sm mt-2">Silakan coba lagi nanti</p>
        </div>
    @endif
</x-layouts.app>
