<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Web\SuratMasukController;
use App\Http\Controllers\Web\SuratKeluarController;
use App\Http\Controllers\Web\AgendaKegiatanController;
use App\Http\Controllers\Web\KategoriSuratController;
use App\Http\Controllers\Web\JenisAgendaController;   // 📌 TAMBAHAN PENTING

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\AgendaKegiatan;


/*
|--------------------------------------------------------------------------
| PUBLIC ROUTE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| DASHBOARD MODERN
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    return view('dashboard', [

        'countMasuk'  => SuratMasuk::count(),
        'countKeluar' => SuratKeluar::count(),
        'countAgenda' => AgendaKegiatan::count(),

        'chartLabels' => ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],

        'chartMasuk' => SuratMasuk::selectRaw('MONTH(tanggal_diterima) as bulan, COUNT(*) as total')
                                  ->groupBy('bulan')
                                  ->pluck('total', 'bulan')
                                  ->values(),

        'chartKeluar' => SuratKeluar::selectRaw('MONTH(tanggal_surat) as bulan, COUNT(*) as total')
                                    ->groupBy('bulan')
                                    ->pluck('total', 'bulan')
                                    ->values(),
    ]);

})->middleware(['auth', 'verified'])->name('dashboard');



/*
|--------------------------------------------------------------------------
| PROFILE ROUTE (Breeze)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});



/*
|--------------------------------------------------------------------------
| SURAT MASUK, KELUAR, AGENDA, KATEGORI, JENIS AGENDA
| USER = READ ONLY
| ADMIN = FULL CRUD
|--------------------------------------------------------------------------
*/

Route::prefix('web')->middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | USER & ADMIN BISA AKSES (READ ONLY)
    |--------------------------------------------------------------------------
    */

    // ================= SURAT MASUK ===================
    Route::get('surat-masuk', [SuratMasukController::class, 'index'])
        ->name('web.surat-masuk.index');

    Route::get('surat-masuk/{id}', [SuratMasukController::class, 'show'])
        ->whereNumber('id')
        ->name('web.surat-masuk.show');


    // ================= SURAT KELUAR ===================
    Route::get('surat-keluar', [SuratKeluarController::class, 'index'])
        ->name('web.surat-keluar.index');

    Route::get('surat-keluar/{id}', [SuratKeluarController::class, 'show'])
        ->whereNumber('id')
        ->name('web.surat-keluar.show');


    // ================= AGENDA KEGIATAN ===================
    Route::get('agenda', [AgendaKegiatanController::class, 'index'])
        ->name('web.agenda.index');

    // ================= KATEGORI SURAT (READ ONLY) ==============
    Route::get('kategori', [KategoriSuratController::class, 'index'])
        ->name('web.kategori.index');


    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY (CRUD)
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {

        // -------- SURAT MASUK (ADMIN CRUD) -----------
        Route::get('surat-masuk/create', [SuratMasukController::class, 'create'])
            ->name('web.surat-masuk.create');

        Route::post('surat-masuk', [SuratMasukController::class, 'store'])
            ->name('web.surat-masuk.store');

        Route::get('surat-masuk/{id}/edit', [SuratMasukController::class, 'edit'])
            ->whereNumber('id')
            ->name('web.surat-masuk.edit');

        Route::put('surat-masuk/{id}', [SuratMasukController::class, 'update'])
            ->whereNumber('id')
            ->name('web.surat-masuk.update');

        Route::delete('surat-masuk/{id}', [SuratMasukController::class, 'destroy'])
            ->whereNumber('id')
            ->name('web.surat-masuk.destroy');


        // -------- SURAT KELUAR (ADMIN CRUD) -----------
        Route::get('surat-keluar/create', [SuratKeluarController::class, 'create'])
            ->name('web.surat-keluar.create');

        Route::post('surat-keluar', [SuratKeluarController::class, 'store'])
            ->name('web.surat-keluar.store');

        Route::get('surat-keluar/{id}/edit', [SuratKeluarController::class, 'edit'])
            ->whereNumber('id')
            ->name('web.surat-keluar.edit');

        Route::put('surat-keluar/{id}', [SuratKeluarController::class, 'update'])
            ->whereNumber('id')
            ->name('web.surat-keluar.update');

        Route::delete('surat-keluar/{id}', [SuratKeluarController::class, 'destroy'])
            ->whereNumber('id')
            ->name('web.surat-keluar.destroy');


        // -------- AGENDA KEGIATAN (ADMIN CRUD) --------
        Route::get('agenda/create', [AgendaKegiatanController::class, 'create'])
            ->name('web.agenda.create');

        Route::post('agenda', [AgendaKegiatanController::class, 'store'])
            ->name('web.agenda.store');


        // -------- KATEGORI SURAT (ADMIN CRUD) --------
        Route::get('kategori/create', [KategoriSuratController::class, 'create'])
            ->name('web.kategori.create');

        Route::post('kategori', [KategoriSuratController::class, 'store'])
            ->name('web.kategori.store');

        Route::get('kategori/{id}/edit', [KategoriSuratController::class, 'edit'])
            ->whereNumber('id')
            ->name('web.kategori.edit');

        Route::put('kategori/{id}', [KategoriSuratController::class, 'update'])
            ->whereNumber('id')
            ->name('web.kategori.update');

        Route::delete('kategori/{id}', [KategoriSuratController::class, 'destroy'])
            ->whereNumber('id')
            ->name('web.kategori.destroy');


        // 📌==================== JENIS AGENDA CRUD ====================
        Route::get('jenis-agenda', [JenisAgendaController::class, 'index'])
            ->name('web.jenis-agenda.index');

        Route::get('jenis-agenda/create', [JenisAgendaController::class, 'create'])
            ->name('web.jenis-agenda.create');

        Route::post('jenis-agenda', [JenisAgendaController::class, 'store'])
            ->name('web.jenis-agenda.store');

        Route::get('jenis-agenda/{id}/edit', [JenisAgendaController::class, 'edit'])
            ->whereNumber('id')
            ->name('web.jenis-agenda.edit');

        Route::put('jenis-agenda/{id}', [JenisAgendaController::class, 'update'])
            ->whereNumber('id')
            ->name('web.jenis-agenda.update');

        Route::delete('jenis-agenda/{id}', [JenisAgendaController::class, 'destroy'])
            ->whereNumber('id')
            ->name('web.jenis-agenda.destroy');
    });
});


// Route auth (Breeze)
require __DIR__.'/auth.php';
