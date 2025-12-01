<x-layouts.app>
    <x-slot name="title">Gempa Terkini - BMKG</x-slot>
    <x-slot name="header">Gempa Bumi Terkini</x-slot>

    @if (isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>Error:</strong> {{ $error }}
        </div>
    @endif

    @if ($gempa && isset($gempa['Infogempa']['gempa']))
        @php
            $gempaData = $gempa['Infogempa']['gempa'];
        @endphp

        <!-- Peta Interaktif -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-red-500 to-orange-600">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-map-marked-alt mr-2"></i>
                    Peta Lokasi & Zona Dampak Gempa
                </h3>
            </div>
            <div class="p-4">
                <div id="earthquakeMap" class="w-full h-[500px] rounded-lg"></div>
                <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-blue-800 font-semibold mb-2">
                        <i class="fas fa-info-circle mr-1"></i> Zona Intensitas Gempa (MMI - Modified Mercalli
                        Intensity)
                    </p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs mb-3">
                        <div class="flex items-center">
                            <div class="w-4 h-4 rounded-full bg-red-600 mr-2"></div>
                            <span>VII-IX: Sangat Kuat</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 rounded-full bg-orange-500 mr-2"></div>
                            <span>V-VI: Kuat</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 rounded-full bg-yellow-400 mr-2"></div>
                            <span>III-IV: Sedang</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 rounded-full bg-green-400 mr-2"></div>
                            <span>I-II: Lemah</span>
                        </div>
                    </div>
                    <p class="text-xs text-blue-700">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        <strong>Catatan:</strong> Zona dampak adalah estimasi berdasarkan magnitudo dan kedalaman gempa.
                        Kondisi geologi lokal dapat mempengaruhi intensitas yang dirasakan.
                    </p>
                </div>
            </div>
        </div>

        <!-- Info Detail -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                <div class="max-w-3xl mx-auto">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Informasi Gempa Bumi Terkini</h2>
                        <p class="text-gray-600">{{ $gempaData['Tanggal'] }} - {{ $gempaData['Jam'] }}</p>
                    </div>

                    <div class="flex justify-center mb-6">
                        <img src="https://data.bmkg.go.id/DataMKG/TEWS/{{ $gempaData['Shakemap'] }}"
                            alt="Shakemap Gempa" class="rounded-lg shadow-lg max-w-full h-auto">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">Tanggal</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $gempaData['Tanggal'] }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">Jam</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $gempaData['Jam'] }}</p>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">Magnitude</p>
                            <p class="text-2xl font-bold text-red-600">{{ $gempaData['Magnitude'] }} SR</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">Kedalaman</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $gempaData['Kedalaman'] }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">Koordinat</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $gempaData['Coordinates'] }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">Lintang - Bujur</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $gempaData['Lintang'] }} -
                                {{ $gempaData['Bujur'] }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                            <p class="text-sm text-gray-500 mb-1">Wilayah</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $gempaData['Wilayah'] }}</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg md:col-span-2">
                            <p class="text-sm text-gray-500 mb-1">Potensi</p>
                            <p class="text-lg font-semibold text-yellow-800">{{ $gempaData['Potensi'] }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                            <p class="text-sm text-gray-500 mb-1">Dirasakan</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $gempaData['Dirasakan'] ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            window.addEventListener('load', function() {
                initEarthquakeMap();
            });

            function initEarthquakeMap() {
                if (typeof L === 'undefined') {
                    console.error('Leaflet not loaded. Retrying...');
                    setTimeout(initEarthquakeMap, 100);
                    return;
                }

                // Parse coordinates
                function parseCoordinates(lintang, bujur) {
                    let lat = parseFloat(lintang);
                    let lng = parseFloat(bujur);

                    if (lintang.includes('LS')) {
                        lat = -Math.abs(lat);
                    }
                    if (bujur.includes('BB')) {
                        lng = -Math.abs(lng);
                    }

                    return [lat, lng];
                }

                // Get earthquake data from blade
                const gempaData = {
                    lintang: "{{ $gempaData['Lintang'] }}",
                    bujur: "{{ $gempaData['Bujur'] }}",
                    magnitude: parseFloat("{{ $gempaData['Magnitude'] }}"),
                    kedalaman: "{{ $gempaData['Kedalaman'] }}",
                    wilayah: "{{ $gempaData['Wilayah'] }}",
                    tanggal: "{{ $gempaData['Tanggal'] }}",
                    jam: "{{ $gempaData['Jam'] }}",
                    potensi: "{{ $gempaData['Potensi'] }}"
                };

                const [lat, lng] = parseCoordinates(gempaData.lintang, gempaData.bujur);

                // Initialize map with zoom disabled
                const map = L.map('earthquakeMap', {
                    zoomControl: false,
                    scrollWheelZoom: false,
                    doubleClickZoom: false,
                    touchZoom: false,
                    dragging: true
                }).setView([lat, lng], 8);

                // Add tile layer
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors',
                    maxZoom: 18
                }).addTo(map);

                // Calculate radius zones based on magnitude and depth
                // Using empirical formula based on seismological research
                function calculateRadiusZones(magnitude, depth) {
                    const depthKm = parseFloat(depth) || 10;

                    // Base radius calculation using magnitude
                    // Formula: R = 10^(0.5*M - 1.5) for felt radius
                    const baseRadius = Math.pow(10, 0.5 * magnitude - 1.5);

                    // Depth factor: deeper earthquakes have smaller felt radius
                    const depthFactor = Math.max(0.3, 1 - (depthKm / 300));

                    // Calculate zones (in km)
                    return {
                        veryStrong: baseRadius * 0.15 * depthFactor, // MMI VII-IX: ~15% of base
                        strong: baseRadius * 0.35 * depthFactor, // MMI V-VI: ~35% of base
                        moderate: baseRadius * 0.65 * depthFactor, // MMI III-IV: ~65% of base
                        weak: baseRadius * 1.0 * depthFactor // MMI I-II: 100% of base
                    };
                }

                const zones = calculateRadiusZones(gempaData.magnitude, gempaData.kedalaman);

                // Add circles for intensity zones (from outer to inner)
                L.circle([lat, lng], {
                    radius: zones.weak * 1000,
                    color: '#4ade80',
                    fillColor: '#4ade80',
                    fillOpacity: 0.1,
                    weight: 2
                }).addTo(map).bindPopup(
                    '<div class="p-2"><strong>Zona Lemah (MMI I-II)</strong><br>' +
                    'Radius: ~' + zones.weak.toFixed(1) + ' km<br>' +
                    '<small>Getaran dirasakan ringan, tidak menyebabkan kerusakan</small></div>'
                );

                L.circle([lat, lng], {
                    radius: zones.moderate * 1000,
                    color: '#facc15',
                    fillColor: '#facc15',
                    fillOpacity: 0.15,
                    weight: 2
                }).addTo(map).bindPopup(
                    '<div class="p-2"><strong>Zona Sedang (MMI III-IV)</strong><br>' +
                    'Radius: ~' + zones.moderate.toFixed(1) + ' km<br>' +
                    '<small>Getaran dirasakan jelas, benda-benda bergetar</small></div>'
                );

                L.circle([lat, lng], {
                    radius: zones.strong * 1000,
                    color: '#f97316',
                    fillColor: '#f97316',
                    fillOpacity: 0.2,
                    weight: 2
                }).addTo(map).bindPopup(
                    '<div class="p-2"><strong>Zona Kuat (MMI V-VI)</strong><br>' +
                    'Radius: ~' + zones.strong.toFixed(1) + ' km<br>' +
                    '<small>Kerusakan ringan pada bangunan, orang sulit berdiri</small></div>'
                );

                L.circle([lat, lng], {
                    radius: zones.veryStrong * 1000,
                    color: '#dc2626',
                    fillColor: '#dc2626',
                    fillOpacity: 0.25,
                    weight: 3
                }).addTo(map).bindPopup(
                    '<div class="p-2"><strong>Zona Sangat Kuat (MMI VII-IX)</strong><br>' +
                    'Radius: ~' + zones.veryStrong.toFixed(1) + ' km<br>' +
                    '<small>Kerusakan serius pada bangunan, retakan tanah</small></div>'
                );

                // Add epicenter marker
                const epicenterIcon = L.divIcon({
                    className: 'custom-epicenter-icon',
                    html: '<div style="background: #dc2626; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(220, 38, 38, 0.5);"></div>',
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                });

                const epicenterMarker = L.marker([lat, lng], {
                    icon: epicenterIcon
                }).addTo(map);

                // Popup content
                const popupContent = `
                    <div class="p-2 min-w-[250px]">
                        <h4 class="font-bold text-lg mb-2 text-red-600">
                            <i class="fas fa-exclamation-triangle"></i> Episentrum Gempa
                        </h4>
                        <div class="space-y-1 text-sm">
                            <p><strong>Tanggal:</strong> ${gempaData.tanggal}</p>
                            <p><strong>Jam:</strong> ${gempaData.jam}</p>
                            <p><strong>Magnitude:</strong> <span class="text-red-600 font-bold">${gempaData.magnitude} SR</span></p>
                            <p><strong>Kedalaman:</strong> ${gempaData.kedalaman}</p>
                            <p><strong>Lokasi:</strong> ${lat.toFixed(3)}°, ${lng.toFixed(3)}°</p>
                            <p><strong>Wilayah:</strong> ${gempaData.wilayah}</p>
                            <p><strong>Potensi:</strong> ${gempaData.potensi}</p>
                        </div>
                    </div>
                `;

                epicenterMarker.bindPopup(popupContent);

                // Fit bounds to show all zones
                const bounds = L.latLngBounds([
                    [lat - zones.weak / 111, lng - zones.weak / 111],
                    [lat + zones.weak / 111, lng + zones.weak / 111]
                ]);
                map.fitBounds(bounds, {
                    padding: [50, 50]
                });
            }
        </script>
    @else
        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                <div class="text-center py-12">
                    <i class="fas fa-exclamation-circle text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">Data gempa tidak tersedia saat ini</p>
                </div>
            </div>
        </div>
    @endif
</x-layouts.app>
