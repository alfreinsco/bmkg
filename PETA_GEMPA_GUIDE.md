# Panduan Peta Gempa Interaktif

## Fitur Peta Gempa

Aplikasi BMKG dilengkapi dengan peta interaktif menggunakan Leaflet.js untuk memantau sebaran gempa bumi di Indonesia secara real-time.

## Fitur Utama

### 1. Peta Interaktif

-   **Zoom & Pan**: Navigasi peta dengan mouse atau touch
-   **Marker Dinamis**: Titik gempa ditampilkan dengan warna dan ukuran berdasarkan magnitudo
-   **Popup Info**: Klik marker untuk melihat detail gempa

### 2. Legenda Magnitudo

Marker gempa menggunakan kode warna:

-   🟢 **Hijau**: M < 5.0 (Gempa kecil)
-   🟡 **Kuning**: 5.0 ≤ M < 6.0 (Gempa sedang)
-   🟠 **Orange**: 6.0 ≤ M < 7.0 (Gempa besar)
-   🔴 **Merah**: M ≥ 7.0 (Gempa sangat besar)

Ukuran marker juga menyesuaikan dengan magnitudo - semakin besar gempa, semakin besar markernya.

### 3. Filter Data

-   **Gempa M 5.0+**: Toggle untuk menampilkan/menyembunyikan gempa dengan magnitudo 5.0 atau lebih
-   **Gempa Dirasakan**: Toggle untuk menampilkan/menyembunyikan gempa yang dirasakan masyarakat

### 4. Statistik Real-time

Panel sidebar menampilkan:

-   Total gempa yang ditampilkan
-   Jumlah gempa M 5.0+
-   Jumlah gempa yang dirasakan

### 5. Auto Refresh

-   Data gempa diperbarui otomatis setiap 5 menit
-   Tombol refresh manual tersedia untuk update langsung

## Informasi Marker

Setiap marker gempa menampilkan informasi lengkap:

-   **Tanggal & Jam**: Waktu terjadinya gempa
-   **Magnitude**: Kekuatan gempa dalam skala Richter
-   **Kedalaman**: Kedalaman episentrum gempa
-   **Wilayah**: Lokasi gempa
-   **Potensi**: Potensi tsunami atau dampak lainnya
-   **Dirasakan**: Skala intensitas yang dirasakan (jika ada)

## Sumber Data

Peta mengambil data dari API BMKG:

1. **Gempa M 5.0+**: `https://data.bmkg.go.id/DataMKG/TEWS/gempaterkini.json`
2. **Gempa Dirasakan**: `https://data.bmkg.go.id/DataMKG/TEWS/gempadirasakan.json`

## Teknologi

-   **Leaflet.js**: Library peta interaktif open-source
-   **OpenStreetMap**: Tile layer untuk base map
-   **JavaScript Fetch API**: Untuk mengambil data dari BMKG
-   **Tailwind CSS**: Styling UI

## Cara Parsing Koordinat

Aplikasi secara otomatis mengkonversi format koordinat BMKG:

-   **Lintang**: "7.50 LS" (Lintang Selatan) → -7.50
-   **Lintang**: "7.50 LU" (Lintang Utara) → 7.50
-   **Bujur**: "110.00 BT" (Bujur Timur) → 110.00
-   **Bujur**: "110.00 BB" (Bujur Barat) → -110.00

## Tips Penggunaan

1. **Zoom In**: Untuk melihat detail area tertentu
2. **Klik Marker**: Untuk melihat informasi lengkap gempa
3. **Gunakan Filter**: Untuk fokus pada jenis gempa tertentu
4. **Refresh Berkala**: Untuk mendapatkan data terbaru
5. **Perhatikan Warna**: Untuk identifikasi cepat gempa besar

## Troubleshooting

### Peta tidak muncul

-   Pastikan koneksi internet aktif
-   Cek console browser untuk error
-   Pastikan file Leaflet CSS dan JS sudah ter-load

### Marker tidak muncul

-   Cek apakah API BMKG dapat diakses
-   Periksa filter yang aktif
-   Refresh halaman atau klik tombol refresh

### Koordinat tidak akurat

-   Data koordinat berasal langsung dari BMKG
-   Beberapa gempa mungkin memiliki koordinat yang kurang presisi

## Pengembangan Lanjutan

Fitur yang bisa ditambahkan:

-   [ ] Clustering marker untuk area dengan banyak gempa
-   [ ] Heatmap untuk visualisasi kepadatan gempa
-   [ ] Timeline slider untuk filter berdasarkan waktu
-   [ ] Export data gempa ke CSV/Excel
-   [ ] Notifikasi browser untuk gempa besar
-   [ ] Layer tambahan (batas provinsi, kota besar, dll)
-   [ ] Mode dark untuk peta
-   [ ] Pencarian lokasi
-   [ ] Radius circle untuk area dampak gempa
