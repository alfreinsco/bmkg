# Aplikasi Pelaporan Data BMKG

Aplikasi web untuk menampilkan data cuaca dan gempa bumi dari API terbuka BMKG (Badan Meteorologi, Klimatologi, dan Geofisika).

## Fitur Utama

### 📊 Dashboard

-   Ringkasan data gempa terkini
-   Statistik cuaca
-   Akses cepat ke semua fitur

### 🌤️ Data Cuaca

-   **Cuaca Terkini**: Data cuaca real-time dari berbagai provinsi
-   **Prakiraan Cuaca**: Prakiraan cuaca detail dengan parameter lengkap (suhu, kelembaban, arah angin, dll)

### 🏚️ Data Gempa

-   **Gempa Terkini**: Informasi gempa bumi terkini dengan shakemap
-   **Gempa M 5.0+**: Daftar gempa dengan magnitudo 5.0 atau lebih
-   **Gempa Dirasakan**: Daftar gempa yang dirasakan masyarakat
-   **Peta Gempa**: Peta interaktif dengan Leaflet untuk memantau sebaran gempa di Indonesia
-   **Gempa M 5.0+**: Daftar gempa dengan magnitudo 5.0 atau lebih
-   **Gempa Dirasakan**: Daftar gempa yang dirasakan masyarakat

### 📝 Laporan

-   Kelola laporan data cuaca dan gempa (placeholder untuk pengembangan)

### ⚙️ Pengaturan

-   Pengaturan profil pengguna
-   Informasi endpoint API BMKG

## Teknologi

-   **Framework**: Laravel 11
-   **Frontend**: Tailwind CSS
-   **Icons**: Font Awesome
-   **API**: BMKG Open Data API

## Instalasi

1. Clone repository
2. Install dependencies:

    ```bash
    composer install
    npm install
    ```

3. Setup environment:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. Build assets:

    ```bash
    npm run build
    ```

5. Jalankan aplikasi:

    ```bash
    php artisan serve
    ```

6. Akses aplikasi di `http://localhost:8000`

## Struktur File

### Controllers

-   `DashboardController.php` - Menangani halaman dashboard
-   `CuacaController.php` - Menangani data cuaca
-   `GempaController.php` - Menangani data gempa
-   `LaporanController.php` - Menangani laporan
-   `PengaturanController.php` - Menangani pengaturan

### Views

-   `dashboard.blade.php` - Halaman dashboard
-   `cuaca/terkini.blade.php` - Halaman cuaca terkini
-   `cuaca/prakiraan.blade.php` - Halaman prakiraan cuaca
-   `gempa/terkini.blade.php` - Halaman gempa terkini
-   `gempa/m5.blade.php` - Halaman gempa M 5.0+
-   `gempa/dirasakan.blade.php` - Halaman gempa dirasakan
-   `laporan/index.blade.php` - Halaman laporan
-   `pengaturan/index.blade.php` - Halaman pengaturan

### Layout

-   `components/layouts/app.blade.php` - Layout utama dengan sidebar

## API Endpoints BMKG

Aplikasi ini menggunakan API publik dari BMKG:

1. **Gempa Terkini**: `https://data.bmkg.go.id/DataMKG/TEWS/autogempa.json`
2. **Gempa M 5.0+**: `https://data.bmkg.go.id/DataMKG/TEWS/gempaterkini.json`
3. **Gempa Dirasakan**: `https://data.bmkg.go.id/DataMKG/TEWS/gempadirasakan.json`
4. **Cuaca Digital**: `https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/`

## Pengembangan Selanjutnya

-   [ ] Implementasi sistem autentikasi
-   [ ] Fitur export laporan ke PDF
-   [ ] Notifikasi real-time untuk gempa besar
-   [ ] Grafik dan visualisasi data
-   [ ] Filter dan pencarian data
-   [ ] Integrasi dengan database untuk menyimpan riwayat
-   [ ] API internal untuk mobile app

## Lisensi

Open source untuk keperluan edukasi dan pengembangan.
