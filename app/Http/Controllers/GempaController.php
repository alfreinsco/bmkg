<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GempaController extends Controller
{
    public function terkini()
    {
        try {
            $response = Http::get('https://data.bmkg.go.id/DataMKG/TEWS/autogempa.json');
            $gempa = $response->successful() ? $response->json() : null;

            return view('gempa.terkini', compact('gempa'));
        } catch (\Exception $e) {
            return view('gempa.terkini', [
                'gempa' => null,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function m5()
    {
        try {
            $response = Http::get('https://data.bmkg.go.id/DataMKG/TEWS/gempaterkini.json');
            $gempaList = $response->successful() ? $response->json() : null;

            return view('gempa.m5', compact('gempaList'));
        } catch (\Exception $e) {
            return view('gempa.m5', [
                'gempaList' => null,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function dirasakan()
    {
        try {
            $response = Http::get('https://data.bmkg.go.id/DataMKG/TEWS/gempadirasakan.json');
            $gempaList = $response->successful() ? $response->json() : null;

            return view('gempa.dirasakan', compact('gempaList'));
        } catch (\Exception $e) {
            return view('gempa.dirasakan', [
                'gempaList' => null,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function peta()
    {
        return view('gempa.peta');
    }
}
