<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\DataKeluargaController;

use App\Http\Controllers\{
    GelombangPendaftaranController,
    PromoController,
    JurusanController,
    KelasController,
    FormulirPendaftaranController,
    DokumenPendaftaranController,
    OrangTuaController,
    WaliController,
    PembayaranController,
    UserController,
    AdminDashboardController
};

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingPageController::class, 'index'])->name('landing');


/*
|--------------------------------------------------------------------------
| User Routes (Auth Required)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard user
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Formulir pendaftaran (CRUD)
    Route::resource('formulir', FormulirPendaftaranController::class);

    // Dokumen pendaftaran
    Route::resource('dokumen', DokumenPendaftaranController::class);

    // Data orang tua
    Route::resource('orangtua', OrangTuaController::class);

    // Data wali
    Route::resource('wali', WaliController::class);

    // Pembayaran (kecuali edit dan update)
    Route::resource('pembayaran', PembayaranController::class)->except(['edit', 'update']);

    // Route untuk dokumen
    Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen.index');
    Route::post('/dokumen', [DokumenController::class, 'store'])->name('dokumen.store');
    Route::get('/dokumen/{id}/download', [DokumenController::class, 'download'])->name('dokumen.download');
    Route::delete('/dokumen/{id}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');
});

// Status Pendaftaran
Route::get('/status', [FormulirPendaftaranController::class, 'status'])->name('status');

// Data Siswa
Route::get('/data-siswa', [DashboardController::class, 'dataSiswa'])->name('data-siswa');

// Pengaturan
Route::get('/pengaturan', [ProfileController::class, 'pengaturan'])->name('pengaturan');



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'can:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard admin
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('gelombang', GelombangPendaftaranController::class);
        Route::resource('promo', PromoController::class);
        Route::resource('jurusan', JurusanController::class);
        Route::resource('kelas', KelasController::class);
        Route::resource('users', UserController::class);
    });

// routes/web.php
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::middleware(['auth'])->group(function () {
    // ... routes lainnya

    Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen.index');
    Route::post('/dokumen', [DokumenController::class, 'store'])->name('dokumen.store');
    Route::get('/dokumen/{id}/download', [DokumenController::class, 'download'])->name('dokumen.download');
    Route::delete('/dokumen/{id}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');

    //datakeluarga 
    Route::prefix('data-keluarga')->group(function () {
    Route::get('/', [DataKeluargaController::class, 'index'])->name('data-keluarga.index');
    Route::post('/orang-tua', [DataKeluargaController::class, 'storeOrangTua'])->name('data-keluarga.store-orang-tua');
    Route::post('/wali', [DataKeluargaController::class, 'storeWali'])->name('data-keluarga.store-wali');
});
});

/*
|--------------------------------------------------------------------------
| Auth (Login / Register)
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';