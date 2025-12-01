<x-layouts.app>
    <x-slot name="title">Peta Gempa - BMKG</x-slot>
    <x-slot name="header">Peta Pemantauan Gempa</x-slot>

    @if (isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>Error:</strong> {{ $error }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Map Container -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-cyan-500 to-blue-600">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-map-marked-alt mr-2"></i>
                        Peta Sebaran Gempa Bumi Indonesia
                    </h3>
                </div>
                <div id="map" class="w-full h-[600px]"></div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Legenda</h3>
                </div>
                <div class="p-4 space-y-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-700 mb-2">Magnitudo</p>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full bg-green-500 mr-2"></div>
                                <span class="text-sm text-gray-600">M &lt; 5.0</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-5 h-5 rounded-full bg-yellow-500 mr-2"></div>
                                <span class="text-sm text-gray-600">5.0 ≤ M &lt; 6.0</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-6 h-6 rounded-full bg-orange-500 mr-2"></div>
                                <span class="text-sm text-gray-600">6.0 ≤ M &lt; 7.0</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-7 h-7 rounded-full bg-red-500 mr-2"></div>
                                <span class="text-sm text-gray-600">M ≥ 7.0</span>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Filter</p>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" id="showM5" checked
                                    class="rounded text-cyan-600 focus:ring-cyan-500">
                                <span class="ml-2 text-sm text-gray-600">Gempa M 5.0+</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" id="showDirasakan" checked
                                    class="rounded text-cyan-600 focus:ring-cyan-500">
                                <span class="ml-2 text-sm text-gray-600">Gempa Dirasakan</span>
                            </label>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Statistik</p>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Gempa:</span>
                                <span class="font-semibold text-gray-800" id="totalGempa">0</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">M 5.0+:</span>
                                <span class="font-semibold text-gray-800" id="totalM5">0</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Dirasakan:</span>
                                <span class="font-semibold text-gray-800" id="totalDirasakan">0</span>
                            </div>
                        </div>
                    </div>

                    <button onclick="window.refreshMapData(event)"
                        class="w-full mt-4 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white px-4 py-2 rounded-lg transition-colors shadow-lg flex items-center justify-center">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Refresh Data
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Ensure script runs after Leaflet is loaded
        window.addEventListener('load', function() {
            initMap();
        });

        function initMap() {
            // Check if Leaflet is loaded
            if (typeof L === 'undefined') {
                console.error('Leaflet library not loaded. Retrying...');
                setTimeout(initMap, 100);
                return;
            }

            // Initialize map centered on Indonesia
            const map = L.map('map').setView([-2.5, 118.0], 5);

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 18
            }).addTo(map);

            // Layer groups for different earthquake types
            const m5Layer = L.layerGroup().addTo(map);
            const dirasakanLayer = L.layerGroup().addTo(map);

            // Store earthquake data
            let earthquakeData = {
                m5: [],
                dirasakan: []
            };

            // Get marker color based on magnitude
            function getMarkerColor(magnitude) {
                const mag = parseFloat(magnitude);
                if (mag >= 7.0) return '#ef4444';
                if (mag >= 6.0) return '#f97316';
                if (mag >= 5.0) return '#eab308';
                return '#22c55e';
            }

            // Get marker size based on magnitude
            function getMarkerSize(magnitude) {
                const mag = parseFloat(magnitude);
                if (mag >= 7.0) return 14;
                if (mag >= 6.0) return 12;
                if (mag >= 5.0) return 10;
                return 8;
            }

            // Parse coordinates from string
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

            // Add earthquake marker to map
            function addEarthquakeMarker(gempa, layer) {
                try {
                    const [lat, lng] = parseCoordinates(gempa.Lintang, gempa.Bujur);

                    if (isNaN(lat) || isNaN(lng)) {
                        console.error('Invalid coordinates:', gempa);
                        return;
                    }

                    const color = getMarkerColor(gempa.Magnitude);
                    const size = getMarkerSize(gempa.Magnitude);

                    const marker = L.circleMarker([lat, lng], {
                        radius: size,
                        fillColor: color,
                        color: '#fff',
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.7
                    });

                    const popupContent = `
                        <div class="p-2 min-w-[250px]">
                            <h4 class="font-bold text-lg mb-2 text-gray-800">Gempa Bumi</h4>
                            <div class="space-y-1 text-sm">
                                <p><strong>Tanggal:</strong> ${gempa.Tanggal}</p>
                                <p><strong>Jam:</strong> ${gempa.Jam}</p>
                                <p><strong>Magnitude:</strong> <span class="text-red-600 font-bold">${gempa.Magnitude} SR</span></p>
                                <p><strong>Kedalaman:</strong> ${gempa.Kedalaman}</p>
                                <p><strong>Wilayah:</strong> ${gempa.Wilayah}</p>
                                <p><strong>Potensi:</strong> ${gempa.Potensi}</p>
                                ${gempa.Dirasakan ? `<p><strong>Dirasakan:</strong> ${gempa.Dirasakan}</p>` : ''}
                            </div>
                        </div>
                    `;

                    marker.bindPopup(popupContent);
                    marker.addTo(layer);
                } catch (error) {
                    console.error('Error adding marker:', error, gempa);
                }
            }

            // Load earthquake data
            async function loadEarthquakeData() {
                try {
                    const m5Response = await fetch('https://data.bmkg.go.id/DataMKG/TEWS/gempaterkini.json');
                    const m5Data = await m5Response.json();

                    if (m5Data && m5Data.Infogempa && m5Data.Infogempa.gempa) {
                        earthquakeData.m5 = m5Data.Infogempa.gempa;
                    }

                    const dirasakanResponse = await fetch(
                        'https://data.bmkg.go.id/DataMKG/TEWS/gempadirasakan.json');
                    const dirasakanData = await dirasakanResponse.json();

                    if (dirasakanData && dirasakanData.Infogempa && dirasakanData.Infogempa.gempa) {
                        earthquakeData.dirasakan = dirasakanData.Infogempa.gempa;
                    }

                    updateMap();
                    updateStatistics();
                } catch (error) {
                    console.error('Error loading earthquake data:', error);
                    alert('Gagal memuat data gempa. Silakan coba lagi.');
                }
            }

            // Update map with earthquake markers
            function updateMap() {
                m5Layer.clearLayers();
                dirasakanLayer.clearLayers();

                if (document.getElementById('showM5').checked) {
                    earthquakeData.m5.forEach(gempa => {
                        addEarthquakeMarker(gempa, m5Layer);
                    });
                }

                if (document.getElementById('showDirasakan').checked) {
                    earthquakeData.dirasakan.forEach(gempa => {
                        addEarthquakeMarker(gempa, dirasakanLayer);
                    });
                }
            }

            // Update statistics
            function updateStatistics() {
                const totalM5 = earthquakeData.m5.length;
                const totalDirasakan = earthquakeData.dirasakan.length;
                const total = totalM5 + totalDirasakan;

                document.getElementById('totalGempa').textContent = total;
                document.getElementById('totalM5').textContent = totalM5;
                document.getElementById('totalDirasakan').textContent = totalDirasakan;
            }

            // Refresh map data - exposed to global scope
            window.refreshMapData = function(event) {
                const btn = event.target.closest('button');
                const icon = btn ? btn.querySelector('i') : null;

                if (icon) {
                    icon.classList.add('fa-spin');
                }

                loadEarthquakeData().finally(() => {
                    if (icon) {
                        icon.classList.remove('fa-spin');
                    }
                });
            };

            // Filter change handlers
            document.getElementById('showM5').addEventListener('change', updateMap);
            document.getElementById('showDirasakan').addEventListener('change', updateMap);

            // Initial load
            loadEarthquakeData();

            // Auto refresh every 5 minutes
            setInterval(loadEarthquakeData, 5 * 60 * 1000);
        }
    </script>
</x-layouts.app>
