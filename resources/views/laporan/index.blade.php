<x-layouts.app>
    <x-slot name="title">Laporan - BMKG</x-slot>
    <x-slot name="header">Laporan</x-slot>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">Daftar Laporan</h3>
                    <p class="text-gray-600 text-sm">Kelola laporan data cuaca dan gempa</p>
                </div>
                <button
                    class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors shadow-lg">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Laporan
                </button>
            </div>

            <div class="mb-4">
                <div class="flex gap-4">
                    <input type="text" placeholder="Cari laporan..."
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    <select
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option>Semua Kategori</option>
                        <option>Cuaca</option>
                        <option>Gempa</option>
                    </select>
                </div>
            </div>

            <div class="text-center py-12">
                <i class="fas fa-file-alt text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg mb-2">Belum ada laporan</p>
                <p class="text-gray-400 text-sm">Klik tombol "Buat Laporan" untuk membuat laporan baru</p>
            </div>
        </div>
    </div>
</x-layouts.app>
