<x-layouts.app>
    <x-slot name="title">Gempa M 5.0+ - BMKG</x-slot>
    <x-slot name="header">Gempa Bumi Magnitudo 5.0+</x-slot>

    @if (isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>Error:</strong> {{ $error }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            @if ($gempaList && isset($gempaList['Infogempa']['gempa']))
                <div class="mb-4">
                    <p class="text-gray-600">Menampilkan {{ count($gempaList['Infogempa']['gempa']) }} data gempa
                        dengan magnitudo 5.0 atau lebih</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal & Jam</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Magnitude</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kedalaman</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Wilayah</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Potensi</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($gempaList['Infogempa']['gempa'] as $index => $gempa)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $gempa['Tanggal'] }}</div>
                                        <div class="text-sm text-gray-500">{{ $gempa['Jam'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                                            @if (floatval($gempa['Magnitude']) >= 6.0) bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ $gempa['Magnitude'] }} SR
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $gempa['Kedalaman'] }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $gempa['Wilayah'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $gempa['Potensi'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <button onclick="showEarthquakeDetail({{ $index }})"
                                            class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white px-3 py-1 rounded text-xs transition-colors">
                                            <i class="fas fa-map-marked-alt mr-1"></i>
                                            Lihat Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-exclamation-circle text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">Data gempa tidak tersedia saat ini</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Detail Gempa -->
    <div id="earthquakeModal" class="hidden fixed inset-0 bg-gray-600/50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-5xl shadow-lg rounded-lg bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800" id="modalTitle">Detail Gempa</h3>
                <button onclick="closeModal()"
                    class="text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
            </div>

            <div class="mb-4">
                <div id="modalMap" class="w-full h-[500px] rounded-lg"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4" id="modalInfo">
                <!-- Info will be populated by JavaScript -->
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-blue-800 font-semibold mb-2">
                    <i class="fas fa-info-circle mr-1"></i> Zona Intensitas Gempa (MMI)
                </p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs">
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
            </div>
        </div>
    </div>

    @if ($gempaList && isset($gempaList['Infogempa']['gempa']))
        <script>
            const earthquakeData = @json($gempaList['Infogempa']['gempa']);
            let modalMap = null;

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

            function calculateRadiusZones(magnitude, depth) {
                const depthKm = parseFloat(depth) || 10;
                const baseRadius = Math.pow(10, 0.5 * magnitude - 1.5);
                const depthFactor = Math.max(0.3, 1 - (depthKm / 300));

                return {
                    veryStrong: baseRadius * 0.15 * depthFactor,
                    strong: baseRadius * 0.35 * depthFactor,
                    moderate: baseRadius * 0.65 * depthFactor,
                    weak: baseRadius * 1.0 * depthFactor
                };
            }

            function showEarthquakeDetail(index) {
                const gempa = earthquakeData[index];
                const modal = document.getElementById('earthquakeModal');

                // Update modal title
                document.getElementById('modalTitle').textContent =
                    `Detail Gempa ${gempa.Magnitude} SR - ${gempa.Tanggal}`;

                // Update info
                const infoHtml = `
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">Tanggal & Jam</p>
                        <p class="text-sm font-semibold text-gray-800">${gempa.Tanggal}<br>${gempa.Jam}</p>
                    </div>
                    <div class="bg-red-50 p-3 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">Magnitude</p>
                        <p class="text-lg font-bold text-red-600">${gempa.Magnitude} SR</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">Kedalaman</p>
                        <p class="text-sm font-semibold text-gray-800">${gempa.Kedalaman}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg md:col-span-2">
                        <p class="text-xs text-gray-500 mb-1">Wilayah</p>
                        <p class="text-sm font-semibold text-gray-800">${gempa.Wilayah}</p>
                    </div>
                    <div class="bg-yellow-50 p-3 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">Potensi</p>
                        <p class="text-sm font-semibold text-yellow-800">${gempa.Potensi}</p>
                    </div>
                `;
                document.getElementById('modalInfo').innerHTML = infoHtml;

                // Show modal
                modal.classList.remove('hidden');

                // Initialize map
                setTimeout(() => {
                    initModalMap(gempa);
                }, 100);
            }

            function initModalMap(gempa) {
                if (typeof L === 'undefined') {
                    console.error('Leaflet not loaded');
                    return;
                }

                // Remove existing map if any
                if (modalMap) {
                    modalMap.remove();
                }

                const [lat, lng] = parseCoordinates(gempa.Lintang, gempa.Bujur);

                // Initialize map with zoom disabled
                modalMap = L.map('modalMap', {
                    zoomControl: false,
                    scrollWheelZoom: false,
                    doubleClickZoom: false,
                    touchZoom: false,
                    dragging: true
                }).setView([lat, lng], 8);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors',
                    maxZoom: 18
                }).addTo(modalMap);

                const zones = calculateRadiusZones(gempa.Magnitude, gempa.Kedalaman);

                // Add circles
                L.circle([lat, lng], {
                    radius: zones.weak * 1000,
                    color: '#4ade80',
                    fillColor: '#4ade80',
                    fillOpacity: 0.1,
                    weight: 2
                }).addTo(modalMap).bindPopup(
                    '<div class="p-2"><strong>Zona Lemah (MMI I-II)</strong><br>Radius: ~' + zones.weak.toFixed(
                        1) + ' km</div>'
                );

                L.circle([lat, lng], {
                    radius: zones.moderate * 1000,
                    color: '#facc15',
                    fillColor: '#facc15',
                    fillOpacity: 0.15,
                    weight: 2
                }).addTo(modalMap).bindPopup(
                    '<div class="p-2"><strong>Zona Sedang (MMI III-IV)</strong><br>Radius: ~' + zones.moderate
                    .toFixed(1) + ' km</div>'
                );

                L.circle([lat, lng], {
                    radius: zones.strong * 1000,
                    color: '#f97316',
                    fillColor: '#f97316',
                    fillOpacity: 0.2,
                    weight: 2
                }).addTo(modalMap).bindPopup(
                    '<div class="p-2"><strong>Zona Kuat (MMI V-VI)</strong><br>Radius: ~' + zones.strong.toFixed(
                        1) + ' km</div>'
                );

                L.circle([lat, lng], {
                    radius: zones.veryStrong * 1000,
                    color: '#dc2626',
                    fillColor: '#dc2626',
                    fillOpacity: 0.25,
                    weight: 3
                }).addTo(modalMap).bindPopup(
                    '<div class="p-2"><strong>Zona Sangat Kuat (MMI VII-IX)</strong><br>Radius: ~' + zones
                    .veryStrong.toFixed(1) + ' km</div>'
                );

                // Add epicenter marker
                const epicenterIcon = L.divIcon({
                    className: 'custom-epicenter-icon',
                    html: '<div style="background: #dc2626; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(220, 38, 38, 0.5);"></div>',
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                });

                L.marker([lat, lng], {
                    icon: epicenterIcon
                }).addTo(modalMap).bindPopup(
                    `<div class="p-2"><strong>Episentrum</strong><br>M ${gempa.Magnitude} SR<br>${gempa.Wilayah}</div>`
                );

                // Fit bounds
                const bounds = L.latLngBounds([
                    [lat - zones.weak / 111, lng - zones.weak / 111],
                    [lat + zones.weak / 111, lng + zones.weak / 111]
                ]);
                modalMap.fitBounds(bounds, {
                    padding: [50, 50]
                });
            }

            function closeModal() {
                const modal = document.getElementById('earthquakeModal');
                modal.classList.add('hidden');

                if (modalMap) {
                    modalMap.remove();
                    modalMap = null;
                }
            }

            // Close modal when clicking outside
            document.getElementById('earthquakeModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });
        </script>
    @endif
</x-layouts.app>
