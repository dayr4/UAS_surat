<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Web\SuratMasukController;
use App\Http\Controllers\Web\SuratKeluarController;
use App\Http\Controllers\Web\AgendaKegiatanController;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\AgendaKegiatan;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Dashboard (Sudah Ditingkatkan Jadi Versi Profesional)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    return view('dashboard', [

        // Statistik
        'countMasuk'  => SuratMasuk::count(),
        'countKeluar' => SuratKeluar::count(),
        'countAgenda' => AgendaKegiatan::count(),

        // Chart labels (bulan)
        'chartLabels' => ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],

        // Chart data surat masuk
        'chartMasuk' => SuratMasuk::selectRaw('MONTH(tanggal_diterima) as bulan, COUNT(*) as total')
                                  ->groupBy('bulan')
                                  ->pluck('total', 'bulan')
                                  ->values(),

        // Chart data surat keluar
        'chartKeluar' => SuratKeluar::selectRaw('MONTH(tanggal_surat) as bulan, COUNT(*) as total')
                                    ->groupBy('bulan')
                                    ->pluck('total', 'bulan')
                                    ->values(),
    ]);

})->middleware(['auth', 'verified'])->name('dashboard');



/*
|--------------------------------------------------------------------------
| Profile Routes (Breeze)
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
| SURAT MASUK & KELUAR (Wajib admin)
|--------------------------------------------------------------------------
*/

Route::prefix('web')->middleware(['auth', 'admin'])->group(function () {

    // ------- SURAT MASUK -------
    Route::get('surat-masuk', [SuratMasukController::class, 'index'])
        ->name('web.surat-masuk.index');

    Route::get('surat-masuk/create', [SuratMasukController::class, 'create'])
        ->name('web.surat-masuk.create');

    Route::post('surat-masuk', [SuratMasukController::class, 'store'])
        ->name('web.surat-masuk.store');

    Route::get('surat-masuk/{id}/edit', [SuratMasukController::class, 'edit'])
        ->name('web.surat-masuk.edit');

    Route::put('surat-masuk/{id}', [SuratMasukController::class, 'update'])
        ->name('web.surat-masuk.update');

    Route::delete('surat-masuk/{id}', [SuratMasukController::class, 'destroy'])
        ->name('web.surat-masuk.destroy');



    // ------- SURAT KELUAR -------
    Route::get('surat-keluar', [SuratKeluarController::class, 'index'])
        ->name('web.surat-keluar.index');

    Route::get('surat-keluar/create', [SuratKeluarController::class, 'create'])
        ->name('web.surat-keluar.create');

    Route::post('surat-keluar', [SuratKeluarController::class, 'store'])
        ->name('web.surat-keluar.store');

    Route::get('surat-keluar/{id}/edit', [SuratKeluarController::class, 'edit'])
        ->name('web.surat-keluar.edit');

    Route::put('surat-keluar/{id}', [SuratKeluarController::class, 'update'])
        ->name('web.surat-keluar.update');

    Route::delete('surat-keluar/{id}', [SuratKeluarController::class, 'destroy'])
        ->name('web.surat-keluar.destroy');



    // ------- AGENDA KEGIATAN -------
    Route::get('agenda', [AgendaKegiatanController::class, 'index'])
        ->name('web.agenda.index');

    Route::get('agenda/create', [AgendaKegiatanController::class, 'create'])
        ->name('web.agenda.create');

    Route::post('agenda', [AgendaKegiatanController::class, 'store'])
        ->name('web.agenda.store');
});


// Route auth Breeze
require __DIR__.'/auth.php';
