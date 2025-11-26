<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\SuratMasukController;
use App\Http\Controllers\Web\SuratKeluarController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::prefix('web')->group(function () {
    Route::get('surat-masuk', [SuratMasukController::class, 'index'])->name('web.surat-masuk.index');
    Route::get('surat-masuk/create', [SuratMasukController::class, 'create'])->name('web.surat-masuk.create');
    Route::post('surat-masuk', [SuratMasukController::class, 'store'])->name('web.surat-masuk.store');

    Route::get('surat-keluar', [SuratKeluarController::class, 'index'])->name('web.surat-keluar.index');
    Route::get('surat-keluar/create', [SuratKeluarController::class, 'create'])->name('web.surat-keluar.create');
    Route::post('surat-keluar', [SuratKeluarController::class, 'store'])->name('web.surat-keluar.store');
});
