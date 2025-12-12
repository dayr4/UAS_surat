<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Web\SuratMasukController;
use App\Http\Controllers\Web\SuratKeluarController;
use App\Http\Controllers\Web\AgendaKegiatanController;
use App\Http\Controllers\Web\KategoriSuratController;
use App\Http\Controllers\Web\JenisAgendaController;

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
| DASHBOARD
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
| PROFILE ROUTE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| WEB MODULE (SEMUA PUNYA PREFIX URL /web DAN PREFIX NAMA ROUTE web.)
|--------------------------------------------------------------------------
*/
Route::prefix('web')->as('web.')->middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ROUTE UNTUK SEMUA USER (READ)
    |--------------------------------------------------------------------------
    */

    // SURAT MASUK (READ)
    Route::get('surat-masuk', [SuratMasukController::class, 'index'])->name('surat-masuk.index');
    Route::get('surat-masuk/{id}', [SuratMasukController::class, 'show'])
        ->whereNumber('id')
        ->name('surat-masuk.show');

    // SURAT KELUAR (READ)
    Route::get('surat-keluar', [SuratKeluarController::class, 'index'])->name('surat-keluar.index');
    Route::get('surat-keluar/{id}', [SuratKeluarController::class, 'show'])
        ->whereNumber('id')
        ->name('surat-keluar.show');

    // AGENDA (READ)
    Route::get('agenda', [AgendaKegiatanController::class, 'index'])->name('agenda.index');

    // KATEGORI (READ)
    Route::get('kategori', [KategoriSuratController::class, 'index'])->name('kategori.index');

    /*
    |--------------------------------------------------------------------------
    | ROUTE DISPOSISI USER (HANYA ROLE USER)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:user')->group(function () {
        Route::get('disposisi-saya', [SuratMasukController::class, 'disposisiSaya'])->name('disposisi.saya');

        Route::put('disposisi/{surat}/selesai', [SuratMasukController::class, 'selesaikanDisposisi'])
            ->whereNumber('surat')
            ->name('disposisi.selesai');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY (CRUD)
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {

        // SURAT MASUK CRUD
        Route::get('surat-masuk/create', [SuratMasukController::class, 'create'])->name('surat-masuk.create');
        Route::post('surat-masuk', [SuratMasukController::class, 'store'])->name('surat-masuk.store');
        Route::get('surat-masuk/{id}/edit', [SuratMasukController::class, 'edit'])
            ->whereNumber('id')->name('surat-masuk.edit');
        Route::put('surat-masuk/{id}', [SuratMasukController::class, 'update'])
            ->whereNumber('id')->name('surat-masuk.update');
        Route::delete('surat-masuk/{id}', [SuratMasukController::class, 'destroy'])
            ->whereNumber('id')->name('surat-masuk.destroy');

        // DISPOSISI ADMIN (pilih banyak user)
        Route::get('surat-masuk/{id}/disposisi', [SuratMasukController::class, 'disposisiForm'])
            ->whereNumber('id')
            ->name('surat-masuk.disposisi.form');

        Route::post('surat-masuk/{id}/disposisi', [SuratMasukController::class, 'disposisiStore'])
            ->whereNumber('id')
            ->name('surat-masuk.disposisi.store');

        // SURAT KELUAR CRUD (index & show sudah dibuat manual di atas)
        Route::resource('surat-keluar', SuratKeluarController::class)->except(['index','show']);

        // AGENDA CRUD (index sudah manual)
        Route::resource('agenda', AgendaKegiatanController::class)->except(['index','show']);

        // KATEGORI CRUD (index sudah manual)
        Route::resource('kategori', KategoriSuratController::class)->except(['index','show']);

        // JENIS AGENDA CRUD (admin)
        Route::resource('jenis-agenda', JenisAgendaController::class);
    });
});

// Auth
require __DIR__.'/auth.php';
