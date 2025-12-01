<x-layouts.app>
    <x-slot name="title">Pengaturan - BMKG</x-slot>
    <x-slot name="header">Pengaturan</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sidebar Menu -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow">
                <div class="p-4">
                    <nav class="space-y-1">
                        <a href="#profil"
                            class="flex items-center px-4 py-3 text-sm font-medium text-cyan-600 bg-cyan-50 rounded-lg">
                            <i class="fas fa-user w-5 mr-3"></i>
                            Profil
                        </a>
                        <a href="#notifikasi"
                            class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">
                            <i class="fas fa-bell w-5 mr-3"></i>
                            Notifikasi
                        </a>
                        <a href="#api"
                            class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">
                            <i class="fas fa-code w-5 mr-3"></i>
                            API Settings
                        </a>
                        <a href="#keamanan"
                            class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">
                            <i class="fas fa-shield-alt w-5 mr-3"></i>
                            Keamanan
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Profil Pengguna</h3>

                    <form class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" value="Admin BMKG"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" value="admin@bmkg.go.id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="tel" value="+62 21 1234567"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                            <input type="text" value="Administrator"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="button"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-lg hover:from-cyan-600 hover:to-blue-700 transition-colors shadow-lg">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow mt-6">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Informasi API BMKG</h3>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-3">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Endpoint Gempa Terkini</p>
                            <code
                                class="text-xs bg-gray-800 text-green-400 px-3 py-1 rounded block">https://data.bmkg.go.id/DataMKG/TEWS/autogempa.json</code>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Endpoint Gempa M 5.0+</p>
                            <code
                                class="text-xs bg-gray-800 text-green-400 px-3 py-1 rounded block">https://data.bmkg.go.id/DataMKG/TEWS/gempaterkini.json</code>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Endpoint Gempa Dirasakan</p>
                            <code
                                class="text-xs bg-gray-800 text-green-400 px-3 py-1 rounded block">https://data.bmkg.go.id/DataMKG/TEWS/gempadirasakan.json</code>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Endpoint Cuaca Digital</p>
                            <code
                                class="text-xs bg-gray-800 text-green-400 px-3 py-1 rounded block">https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
