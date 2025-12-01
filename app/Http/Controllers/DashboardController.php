<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Ambil data gempa terkini
            $gempaResponse = Http::get('https://data.bmkg.go.id/DataMKG/TEWS/autogempa.json');
            $gempaData = $gempaResponse->successful() ? $gempaResponse->json() : null;

            // Ambil data cuaca terkini (contoh untuk Jakarta)
            $cuacaResponse = Http::get('https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/DigitalForecast-DKIJakarta.xml');
            $cuacaData = $cuacaResponse->successful() ? $cuacaResponse->body() : null;

            return view('dashboard', compact('gempaData', 'cuacaData'));
        } catch (\Exception $e) {
            return view('dashboard', [
                'gempaData' => null,
                'cuacaData' => null,
                'error' => $e->getMessage()
            ]);
        }
    }
}
