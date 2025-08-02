<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DownloadTemplateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\PemilihController;
use App\Http\Controllers\UserController;

// Route untuk pemilih yang belum login
Route::middleware(['guest:pemilih'])->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/prosesLoginVoters', [AuthController::class, 'prosesLoginVoters'])->name('login.voters');
});

// Route untuk admin yang belum login
Route::middleware(['guest:admin'])->group(function () {
    Route::get('/panel ', [AuthController::class, 'indexAdmin'])->name('loginAdmin');
    Route::post('/prosesLoginAdmin', [AuthController::class, 'prosesLoginAdmin'])->name('login.admin');
});

// Route untuk pemilih yang sudah login
Route::middleware(['auth:pemilih'])->group(function () {
    Route::get('/voting', [DashboardController::class, 'index'])->name('dashboard.voters');
    Route::get('/logoutvoters', [AuthController::class, 'logoutvoters'])->name('logoutvoters');
    Route::post('/prosesvoting', [DashboardController::class, 'voting'])->name('voting.post');
});

// Route untuk admin yang sudah login
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/logoutadmin', [AuthController::class, 'logoutadmin'])->name('logoutadmin');
    Route::get('/dashboard', [DashboardController::class, 'dashboardAdmin'])->name('dashboard');
    Route::resource('jurusan', JurusanController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('kandidat', KandidatController::class);
    Route::resource('pemilih', PemilihController::class);
    Route::resource('user', UserController::class);

    // Route Import
    Route::post('/pemilih/import', [PemilihController::class, 'import'])->name('pemilih.import');

    // Route Export
    Route::get('/pemilih/export/{id}', [PemilihController::class, 'exportIndex'])->name('pemilih.export');

    // Route Config
    Route::get('/configs', [ConfigController::class, 'index'])->name('config.index');
    Route::post('/configs', [ConfigController::class, 'update'])->name('config.update');

    // Route Sub Dashboard
    Route::get('/dashboard/sudah-memilih', [DashboardController::class, 'sudahMemilih'])->name('sudah');
    Route::get('/dashboard/belum-memilih', [DashboardController::class, 'belumMemilih'])->name('belum');

    // Route Hasil Pemilu
    Route::get('/hasil', [DashboardController::class, 'hasilPemilu'])->name('hasil');

    // Route Download Template
    Route::get('/download-template', [DownloadTemplateController::class, 'template'])->name('download.template');
});
