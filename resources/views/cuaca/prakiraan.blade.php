<x-layouts.app>
    <x-slot name="title">Prakiraan Cuaca - BMKG</x-slot>
    <x-slot name="header">Prakiraan Cuaca</x-slot>

    @if (isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>Error:</strong> {{ $error }}
        </div>
    @endif

    <!-- Location Selector -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" action="{{ route('cuaca.prakiraan') }}" id="locationForm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-search mr-2"></i>Cari Lokasi:
                    </label>
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Cari kota, kecamatan..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                        oninput="this.form.submit()">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-map-marker-alt mr-2"></i>Pilih Lokasi:
                    </label>
                    <select name="adm4" onchange="this.form.submit()"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        @foreach ($locations as $code => $name)
                            <option value="{{ $code }}" {{ $adm4Code == $code ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">
                        Menampilkan {{ count($locations) }} lokasi
                        @if ($search)
                            dari pencarian "{{ $search }}"
                            <a href="{{ route('cuaca.prakiraan') }}" class="text-cyan-600 hover:underline ml-2">
                                <i class="fas fa-times-circle"></i> Reset
                            </a>
                        @endif
                    </p>
                </div>
            </div>
        </form>
    </div>

    @if ($prakiraan && isset($prakiraan['data'][0]['cuaca']))
        @php
            $lokasi = $prakiraan['lokasi'] ?? [];
            $cuacaData = $prakiraan['data'][0]['cuaca'] ?? [];
        @endphp

        <!-- Location Info -->
        <div class="bg-gradient-to-r from-cyan-500 to-blue-600 rounded-lg shadow-lg p-6 mb-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">{{ $lokasi['desa'] ?? 'N/A' }}</h2>
                    <p class="text-cyan-100">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        {{ $lokasi['kecamatan'] ?? '' }}, {{ $lokasi['kotkab'] ?? '' }},
                        {{ $lokasi['provinsi'] ?? '' }}
                    </p>
                    <p class="text-cyan-100 text-sm mt-1">
                        <i class="fas fa-globe mr-2"></i>
                        Koordinat: {{ $lokasi['lat'] ?? 'N/A' }}, {{ $lokasi['lon'] ?? 'N/A' }}
                    </p>
                </div>
                <i class="fas fa-cloud-sun text-6xl opacity-50"></i>
            </div>
        </div>

        <!-- Weather Forecast by Day -->
        <div class="space-y-6">
            @foreach ($cuacaData as $dayIndex => $dayData)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gray-100 px-6 py-3 border-b">
                        <h3 class="text-lg font-bold text-gray-800">
                            <i class="fas fa-calendar-day mr-2 text-cyan-600"></i>
                            Hari ke-{{ $dayIndex + 1 }}
                            @if ($dayIndex == 0)
                                <span class="text-sm font-normal text-cyan-600">(Hari Ini)</span>
                            @endif
                        </h3>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            @foreach ($dayData as $forecast)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-center justify-between mb-3">
                                        <p class="text-sm font-semibold text-gray-700">
                                            {{ date('H:i', strtotime($forecast['local_datetime'] ?? '')) }}
                                        </p>
                                        @if (isset($forecast['image']))
                                            <img src="{{ $forecast['image'] }}" alt="Weather Icon" class="w-12 h-12">
                                        @endif
                                    </div>

                                    <p class="text-2xl font-bold text-gray-800 mb-2">
                                        {{ $forecast['t'] ?? 'N/A' }}°C
                                    </p>

                                    <p class="text-sm text-gray-600 mb-3">
                                        {{ $forecast['weather_desc'] ?? 'N/A' }}
                                    </p>

                                    <div class="space-y-2 text-xs">
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-tint w-4 text-blue-500"></i>
                                            <span class="ml-2">Kelembaban: {{ $forecast['hu'] ?? 'N/A' }}%</span>
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-wind w-4 text-green-500"></i>
                                            <span class="ml-2">Angin: {{ $forecast['ws'] ?? 'N/A' }} km/j dari
                                                {{ $forecast['wd'] ?? 'N/A' }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-eye w-4 text-purple-500"></i>
                                            <span class="ml-2">{{ $forecast['vs_text'] ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <p class="text-sm text-blue-800 font-semibold mb-2">
                <i class="fas fa-info-circle mr-2"></i> Keterangan Parameter Cuaca
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-blue-700">
                <div>• <strong>t:</strong> Suhu (°C)</div>
                <div>• <strong>hu:</strong> Kelembaban Udara (%)</div>
                <div>• <strong>ws:</strong> Kecepatan Angin (km/jam)</div>
                <div>• <strong>wd:</strong> Arah Angin</div>
                <div>• <strong>vs_text:</strong> Jarak Pandang</div>
            </div>
            <p class="text-xs text-blue-700 mt-3">
                <strong>Sumber Data:</strong> Badan Meteorologi, Klimatologi, dan Geofisika (BMKG)
            </p>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <i class="fas fa-cloud text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">Data prakiraan cuaca tidak tersedia saat ini</p>
            <p class="text-gray-400 text-sm mt-2">Silakan pilih lokasi lain atau coba lagi nanti</p>
        </div>
    @endif
</x-layouts.app>
