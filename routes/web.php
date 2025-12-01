<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CuacaController;
use App\Http\Controllers\GempaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Cuaca Routes
Route::prefix('cuaca')->group(function () {
    Route::get('/terkini', [CuacaController::class, 'terkini'])->name('cuaca.terkini');
    Route::get('/prakiraan', [CuacaController::class, 'prakiraan'])->name('cuaca.prakiraan');
});

// Gempa Routes
Route::prefix('gempa')->group(function () {
    Route::get('/terkini', [GempaController::class, 'terkini'])->name('gempa.terkini');
    Route::get('/m5', [GempaController::class, 'm5'])->name('gempa.m5');
    Route::get('/dirasakan', [GempaController::class, 'dirasakan'])->name('gempa.dirasakan');
    Route::get('/peta', [GempaController::class, 'peta'])->name('gempa.peta');
});

// Laporan Routes
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

// Pengaturan Routes
Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
