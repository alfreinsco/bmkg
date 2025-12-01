# Dokumentasi API BMKG

## Daftar API yang Digunakan

### 1. API Gempa Bumi

#### Gempa Terkini (Autogempa)

-   **URL**: `https://data.bmkg.go.id/DataMKG/TEWS/autogempa.json`
-   **Method**: GET
-   **Deskripsi**: Mendapatkan informasi gempa bumi terkini
-   **Response**: JSON dengan informasi gempa termasuk shakemap

#### Gempa M 5.0+

-   **URL**: `https://data.bmkg.go.id/DataMKG/TEWS/gempaterkini.json`
-   **Method**: GET
-   **Deskripsi**: Mendapatkan daftar gempa dengan magnitudo 5.0 atau lebih
-   **Response**: JSON array dengan list gempa

#### Gempa Dirasakan

-   **URL**: `https://data.bmkg.go.id/DataMKG/TEWS/gempadirasakan.json`
-   **Method**: GET
-   **Deskripsi**: Mendapatkan daftar gempa yang dirasakan masyarakat
-   **Response**: JSON array dengan list gempa

### 2. API Cuaca

#### Prakiraan Cuaca Digital

-   **URL**: `https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/DigitalForecast-{Provinsi}.xml`
-   **Method**: GET
-   **Deskripsi**: Mendapatkan prakiraan cuaca untuk provinsi tertentu
-   **Response**: XML dengan data prakiraan cuaca
-   **Contoh Provinsi**:
    -   DKIJakarta
    -   JawaBarat
    -   JawaTengah
    -   JawaTimur
    -   Bali

## Struktur Response

### Gempa (JSON)

```json
{
    "Infogempa": {
        "gempa": {
            "Tanggal": "01 Des 2025",
            "Jam": "10:30:45 WIB",
            "DateTime": "2025-12-01T10:30:45+07:00",
            "Coordinates": "-7.50,110.00",
            "Lintang": "7.50 LS",
            "Bujur": "110.00 BT",
            "Magnitude": "5.2",
            "Kedalaman": "10 km",
            "Wilayah": "Pusat gempa berada di laut 50 km barat daya Yogyakarta",
            "Potensi": "Tidak berpotensi tsunami",
            "Dirasakan": "III Yogyakarta",
            "Shakemap": "20251201103045.mmi.jpg"
        }
    }
}
```

### Cuaca (XML)

Data cuaca dalam format XML dengan struktur:

-   forecast
    -   area (multiple)
        -   parameter (multiple: hu, t, weather, wd, ws, dll)
            -   timerange (multiple)
                -   value

## Fitur Aplikasi

1. **Dashboard**: Menampilkan ringkasan data gempa terkini dan akses cepat
2. **Cuaca Terkini**: Menampilkan data cuaca dari beberapa provinsi
3. **Prakiraan Cuaca**: Menampilkan prakiraan cuaca detail
4. **Gempa Terkini**: Menampilkan gempa bumi terkini dengan shakemap
5. **Gempa M 5.0+**: Daftar gempa dengan magnitudo 5.0 atau lebih
6. **Gempa Dirasakan**: Daftar gempa yang dirasakan masyarakat
7. **Laporan**: Kelola laporan data (placeholder)
8. **Pengaturan**: Pengaturan aplikasi dan informasi API

## Catatan

-   Semua API bersifat publik dan tidak memerlukan autentikasi
-   Data diambil secara real-time dari server BMKG
-   Aplikasi menggunakan Laravel HTTP Client untuk mengakses API
-   Error handling sudah diimplementasikan untuk menangani kegagalan koneksi
