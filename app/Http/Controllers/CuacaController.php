<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class CuacaController extends Controller
{
    public function terkini()
    {
        try {
            // Beberapa kode wilayah untuk ditampilkan
            $locations = [
                '31.71.01.1001' => 'Jakarta Pusat',
                '32.01.01.1001' => 'Bandung',
                '33.01.01.1001' => 'Semarang',
                '35.01.01.1001' => 'Surabaya',
                '51.01.01.1001' => 'Denpasar',
            ];

            $cuacaData = [];
            foreach ($locations as $code => $name) {
                $response = Http::timeout(10)->get("https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={$code}");
                if ($response->successful()) {
                    $cuacaData[$name] = $response->json();
                }
            }

            return view('cuaca.terkini', compact('cuacaData'));
        } catch (\Exception $e) {
            return view('cuaca.terkini', [
                'cuacaData' => [],
                'error' => $e->getMessage()
            ]);
        }
    }

    public function prakiraan()
    {
        try {
            $adm4Code = request()->get('adm4', '31.71.01.1001');
            $search = request()->get('search', '');

            $response = Http::timeout(10)->get("https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={$adm4Code}");
            $prakiraan = $response->successful() ? $response->json() : null;

            $locations = $this->getAllLocations();

            // Filter berdasarkan pencarian
            if ($search) {
                $locations = array_filter($locations, function($name) use ($search) {
                    return stripos($name, $search) !== false;
                });
            }

            return view('cuaca.prakiraan', compact('prakiraan', 'locations', 'adm4Code', 'search'));
        } catch (\Exception $e) {
            return view('cuaca.prakiraan', [
                'prakiraan' => null,
                'locations' => $this->getAllLocations(),
                'adm4Code' => '31.71.01.1001',
                'search' => '',
                'error' => $e->getMessage()
            ]);
        }
    }

    private function getAllLocations()
    {
        return [
            // DKI Jakarta
            '31.71.01.1001' => 'Jakarta Pusat - Gambir',
            '31.71.02.1001' => 'Jakarta Pusat - Tanah Abang',
            '31.71.03.1001' => 'Jakarta Pusat - Menteng',
            '31.71.04.1001' => 'Jakarta Pusat - Senen',
            '31.71.05.1001' => 'Jakarta Pusat - Cempaka Putih',
            '31.71.06.1001' => 'Jakarta Pusat - Johar Baru',
            '31.71.07.1001' => 'Jakarta Pusat - Kemayoran',
            '31.71.08.1001' => 'Jakarta Pusat - Sawah Besar',
            '31.72.01.1001' => 'Jakarta Utara - Penjaringan',
            '31.72.02.1001' => 'Jakarta Utara - Pademangan',
            '31.72.03.1001' => 'Jakarta Utara - Tanjung Priok',
            '31.72.04.1001' => 'Jakarta Utara - Koja',
            '31.72.05.1001' => 'Jakarta Utara - Kelapa Gading',
            '31.72.06.1001' => 'Jakarta Utara - Cilincing',
            '31.73.01.1001' => 'Jakarta Barat - Cengkareng',
            '31.73.02.1001' => 'Jakarta Barat - Grogol Petamburan',
            '31.73.03.1001' => 'Jakarta Barat - Taman Sari',
            '31.73.04.1001' => 'Jakarta Barat - Tambora',
            '31.73.05.1001' => 'Jakarta Barat - Kebon Jeruk',
            '31.73.06.1001' => 'Jakarta Barat - Kalideres',
            '31.73.07.1001' => 'Jakarta Barat - Palmerah',
            '31.73.08.1001' => 'Jakarta Barat - Kembangan',
            '31.74.01.1001' => 'Jakarta Selatan - Kebayoran Baru',
            '31.74.02.1001' => 'Jakarta Selatan - Kebayoran Lama',
            '31.74.03.1001' => 'Jakarta Selatan - Pesanggrahan',
            '31.74.04.1001' => 'Jakarta Selatan - Cilandak',
            '31.74.05.1001' => 'Jakarta Selatan - Pasar Minggu',
            '31.74.06.1001' => 'Jakarta Selatan - Jagakarsa',
            '31.74.07.1001' => 'Jakarta Selatan - Mampang Prapatan',
            '31.74.08.1001' => 'Jakarta Selatan - Pancoran',
            '31.74.09.1001' => 'Jakarta Selatan - Tebet',
            '31.74.10.1001' => 'Jakarta Selatan - Setiabudi',
            '31.75.01.1001' => 'Jakarta Timur - Matraman',
            '31.75.02.1001' => 'Jakarta Timur - Pulo Gadung',
            '31.75.03.1001' => 'Jakarta Timur - Jatinegara',
            '31.75.04.1001' => 'Jakarta Timur - Kramat Jati',
            '31.75.05.1001' => 'Jakarta Timur - Pasar Rebo',
            '31.75.06.1001' => 'Jakarta Timur - Cakung',
            '31.75.07.1001' => 'Jakarta Timur - Duren Sawit',
            '31.75.08.1001' => 'Jakarta Timur - Makasar',
            '31.75.09.1001' => 'Jakarta Timur - Ciracas',
            '31.75.10.1001' => 'Jakarta Timur - Cipayung',

            // Jawa Barat
            '32.01.01.1001' => 'Bandung - Bandung Wetan',
            '32.01.02.1001' => 'Bandung - Sumur Bandung',
            '32.01.03.1001' => 'Bandung - Cibeunying Kaler',
            '32.01.04.1001' => 'Bandung - Cibeunying Kidul',
            '32.01.05.1001' => 'Bandung - Coblong',
            '32.73.01.1001' => 'Bekasi - Bekasi Barat',
            '32.73.02.1001' => 'Bekasi - Bekasi Selatan',
            '32.73.03.1001' => 'Bekasi - Bekasi Timur',
            '32.73.04.1001' => 'Bekasi - Bekasi Utara',
            '32.74.01.1001' => 'Depok - Beji',
            '32.74.02.1001' => 'Depok - Pancoran Mas',
            '32.74.03.1001' => 'Depok - Sukmajaya',
            '32.75.01.1001' => 'Cimahi - Cimahi Selatan',
            '32.75.02.1001' => 'Cimahi - Cimahi Tengah',
            '32.75.03.1001' => 'Cimahi - Cimahi Utara',
            '32.76.01.1001' => 'Tasikmalaya - Cibeureum',
            '32.76.02.1001' => 'Tasikmalaya - Cipedes',
            '32.77.01.1001' => 'Banjar - Banjar',
            '32.77.02.1001' => 'Banjar - Pataruman',

            // Jawa Tengah
            '33.01.01.1001' => 'Semarang - Semarang Tengah',
            '33.01.02.1001' => 'Semarang - Semarang Utara',
            '33.01.03.1001' => 'Semarang - Semarang Timur',
            '33.01.04.1001' => 'Semarang - Gayamsari',
            '33.01.05.1001' => 'Semarang - Genuk',
            '33.71.01.1001' => 'Surakarta - Laweyan',
            '33.71.02.1001' => 'Surakarta - Serengan',
            '33.71.03.1001' => 'Surakarta - Pasar Kliwon',
            '33.71.04.1001' => 'Surakarta - Jebres',
            '33.71.05.1001' => 'Surakarta - Banjarsari',
            '33.72.01.1001' => 'Salatiga - Sidorejo',
            '33.72.02.1001' => 'Salatiga - Argomulyo',
            '33.73.01.1001' => 'Pekalongan - Pekalongan Barat',
            '33.73.02.1001' => 'Pekalongan - Pekalongan Timur',
            '33.74.01.1001' => 'Tegal - Tegal Barat',
            '33.74.02.1001' => 'Tegal - Tegal Timur',

            // DI Yogyakarta
            '34.01.01.1001' => 'Yogyakarta - Mantrijeron',
            '34.01.02.1001' => 'Yogyakarta - Kraton',
            '34.01.03.1001' => 'Yogyakarta - Mergangsan',
            '34.01.04.1001' => 'Yogyakarta - Umbulharjo',
            '34.01.05.1001' => 'Yogyakarta - Kotagede',
            '34.01.06.1001' => 'Yogyakarta - Gondokusuman',
            '34.01.07.1001' => 'Yogyakarta - Danurejan',
            '34.01.08.1001' => 'Yogyakarta - Pakualaman',
            '34.01.09.1001' => 'Yogyakarta - Gondomanan',
            '34.01.10.1001' => 'Yogyakarta - Ngampilan',
            '34.01.11.1001' => 'Yogyakarta - Wirobrajan',
            '34.01.12.1001' => 'Yogyakarta - Gedongtengen',
            '34.01.13.1001' => 'Yogyakarta - Jetis',
            '34.01.14.1001' => 'Yogyakarta - Tegalrejo',

            // Jawa Timur
            '35.01.01.1001' => 'Surabaya - Genteng',
            '35.01.02.1001' => 'Surabaya - Tegalsari',
            '35.01.03.1001' => 'Surabaya - Bubutan',
            '35.01.04.1001' => 'Surabaya - Simokerto',
            '35.01.05.1001' => 'Surabaya - Pabean Cantian',
            '35.71.01.1001' => 'Malang - Klojen',
            '35.71.02.1001' => 'Malang - Blimbing',
            '35.71.03.1001' => 'Malang - Kedungkandang',
            '35.71.04.1001' => 'Malang - Sukun',
            '35.71.05.1001' => 'Malang - Lowokwaru',
            '35.72.01.1001' => 'Probolinggo - Kademangan',
            '35.72.02.1001' => 'Probolinggo - Mayangan',
            '35.73.01.1001' => 'Pasuruan - Gadingrejo',
            '35.73.02.1001' => 'Pasuruan - Panggungrejo',
            '35.74.01.1001' => 'Mojokerto - Prajurit Kulon',
            '35.74.02.1001' => 'Mojokerto - Magersari',
            '35.75.01.1001' => 'Madiun - Manguharjo',
            '35.75.02.1001' => 'Madiun - Taman',
            '35.76.01.1001' => 'Kediri - Mojoroto',
            '35.76.02.1001' => 'Kediri - Kota',
            '35.77.01.1001' => 'Blitar - Sukorejo',
            '35.77.02.1001' => 'Blitar - Kepanjenkidul',
            '35.78.01.1001' => 'Batu - Batu',
            '35.78.02.1001' => 'Batu - Junrejo',

            // Bali
            '51.01.01.1001' => 'Denpasar - Denpasar Selatan',
            '51.01.02.1001' => 'Denpasar - Denpasar Timur',
            '51.01.03.1001' => 'Denpasar - Denpasar Barat',
            '51.01.04.1001' => 'Denpasar - Denpasar Utara',

            // Kalimantan Timur
            '64.01.01.1001' => 'Balikpapan - Balikpapan Selatan',
            '64.01.02.1001' => 'Balikpapan - Balikpapan Timur',
            '64.01.03.1001' => 'Balikpapan - Balikpapan Utara',
            '64.71.01.1001' => 'Samarinda - Samarinda Ulu',
            '64.71.02.1001' => 'Samarinda - Samarinda Ilir',
            '64.72.01.1001' => 'Bontang - Bontang Utara',
            '64.72.02.1001' => 'Bontang - Bontang Selatan',

            // Sulawesi Selatan
            '73.01.01.1001' => 'Makassar - Mariso',
            '73.01.02.1001' => 'Makassar - Mamajang',
            '73.01.03.1001' => 'Makassar - Tamalate',
            '73.01.04.1001' => 'Makassar - Rappocini',
            '73.01.05.1001' => 'Makassar - Makassar',
            '73.71.01.1001' => 'Palopo - Wara',
            '73.71.02.1001' => 'Palopo - Wara Utara',
            '73.72.01.1001' => 'Parepare - Bacukiki',
            '73.72.02.1001' => 'Parepare - Ujung',

            // Sulawesi Utara
            '71.01.01.1001' => 'Manado - Malalayang',
            '71.01.02.1001' => 'Manado - Sario',
            '71.01.03.1001' => 'Manado - Wenang',
            '71.01.04.1001' => 'Manado - Tikala',
            '71.71.01.1001' => 'Bitung - Maesa',
            '71.71.02.1001' => 'Bitung - Ranowulu',
            '71.72.01.1001' => 'Tomohon - Tomohon Tengah',
            '71.72.02.1001' => 'Tomohon - Tomohon Utara',
            '71.73.01.1001' => 'Kotamobagu - Kotamobagu Barat',
            '71.73.02.1001' => 'Kotamobagu - Kotamobagu Timur',

            // Maluku
            '81.01.01.1001' => 'Ambon - Nusaniwe',
            '81.01.02.1001' => 'Ambon - Sirimau',
            '81.01.03.1001' => 'Ambon - Teluk Ambon',
            '81.01.04.1001' => 'Ambon - Baguala',
            '81.01.05.1001' => 'Ambon - Leitimur Selatan',
            '81.71.01.1001' => 'Tual - Pulau Dullah Utara',
            '81.71.02.1001' => 'Tual - Pulau Dullah Selatan',

            // Maluku Utara
            '82.01.01.1001' => 'Ternate - Ternate Selatan',
            '82.01.02.1001' => 'Ternate - Ternate Tengah',
            '82.01.03.1001' => 'Ternate - Ternate Utara',
            '82.71.01.1001' => 'Tidore Kepulauan - Tidore',
            '82.71.02.1001' => 'Tidore Kepulauan - Tidore Timur',

            // Papua
            '91.01.01.1001' => 'Jayapura - Jayapura Utara',
            '91.01.02.1001' => 'Jayapura - Jayapura Selatan',
            '91.01.03.1001' => 'Jayapura - Abepura',
            '91.01.04.1001' => 'Jayapura - Heram',

            // Sumatera Utara
            '12.01.01.1001' => 'Medan - Medan Kota',
            '12.01.02.1001' => 'Medan - Medan Barat',
            '12.01.03.1001' => 'Medan - Medan Timur',
            '12.01.04.1001' => 'Medan - Medan Utara',
            '12.01.05.1001' => 'Medan - Medan Selatan',
            '12.71.01.1001' => 'Pematangsiantar - Siantar Barat',
            '12.71.02.1001' => 'Pematangsiantar - Siantar Timur',
            '12.72.01.1001' => 'Binjai - Binjai Kota',
            '12.72.02.1001' => 'Binjai - Binjai Utara',

            // Sumatera Barat
            '13.01.01.1001' => 'Padang - Padang Barat',
            '13.01.02.1001' => 'Padang - Padang Timur',
            '13.01.03.1001' => 'Padang - Padang Utara',
            '13.01.04.1001' => 'Padang - Padang Selatan',
            '13.71.01.1001' => 'Bukittinggi - Guguk Panjang',
            '13.71.02.1001' => 'Bukittinggi - Mandiangin Koto Selayan',
            '13.72.01.1001' => 'Padang Panjang - Padang Panjang Barat',
            '13.72.02.1001' => 'Padang Panjang - Padang Panjang Timur',

            // Riau
            '14.01.01.1001' => 'Pekanbaru - Sukajadi',
            '14.01.02.1001' => 'Pekanbaru - Pekanbaru Kota',
            '14.01.03.1001' => 'Pekanbaru - Sail',
            '14.71.01.1001' => 'Dumai - Dumai Barat',
            '14.71.02.1001' => 'Dumai - Dumai Timur',

            // Lampung
            '18.01.01.1001' => 'Bandar Lampung - Telukbetung Selatan',
            '18.01.02.1001' => 'Bandar Lampung - Telukbetung Utara',
            '18.01.03.1001' => 'Bandar Lampung - Tanjung Karang Barat',
            '18.01.04.1001' => 'Bandar Lampung - Tanjung Karang Timur',
            '18.71.01.1001' => 'Metro - Metro Pusat',
            '18.71.02.1001' => 'Metro - Metro Barat',

            // Kalimantan Barat
            '61.01.01.1001' => 'Pontianak - Pontianak Kota',
            '61.01.02.1001' => 'Pontianak - Pontianak Barat',
            '61.01.03.1001' => 'Pontianak - Pontianak Timur',
            '61.71.01.1001' => 'Singkawang - Singkawang Barat',
            '61.71.02.1001' => 'Singkawang - Singkawang Timur',

            // Kalimantan Selatan
            '63.01.01.1001' => 'Banjarmasin - Banjarmasin Tengah',
            '63.01.02.1001' => 'Banjarmasin - Banjarmasin Barat',
            '63.01.03.1001' => 'Banjarmasin - Banjarmasin Timur',
            '63.71.01.1001' => 'Banjarbaru - Banjarbaru Utara',
            '63.71.02.1001' => 'Banjarbaru - Banjarbaru Selatan',

            // Nusa Tenggara Barat
            '52.01.01.1001' => 'Mataram - Ampenan',
            '52.01.02.1001' => 'Mataram - Mataram',
            '52.01.03.1001' => 'Mataram - Cakranegara',
            '52.71.01.1001' => 'Bima - Raba',
            '52.71.02.1001' => 'Bima - Asakota',

            // Nusa Tenggara Timur
            '53.01.01.1001' => 'Kupang - Kupang Kota',
            '53.01.02.1001' => 'Kupang - Kelapa Lima',
            '53.01.03.1001' => 'Kupang - Oebobo',
        ];
    }
}

