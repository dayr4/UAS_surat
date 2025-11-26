<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SuratMasukController;
use App\Http\Controllers\Api\SuratKeluarController;
use App\Http\Controllers\Api\KategoriSuratController;
use App\Http\Controllers\Api\JenisAgendaController;
use App\Http\Controllers\Api\AgendaKegiatanController;

Route::apiResource('surat-masuk', SuratMasukController::class);
Route::apiResource('surat-keluar', SuratKeluarController::class);
Route::apiResource('kategori-surat', KategoriSuratController::class);
Route::apiResource('jenis-agenda', JenisAgendaController::class);
Route::apiResource('agenda-kegiatan', AgendaKegiatanController::class);
