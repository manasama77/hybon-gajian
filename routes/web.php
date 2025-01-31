<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataIjinController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\SlipGajiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HariLiburController;
use App\Http\Controllers\DataKasbonController;
use App\Http\Controllers\DataLemburController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\DataKehadiranController;
use App\Http\Controllers\PeriodeCutoffController;
use App\Http\Controllers\RequestKehadiranController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware([
    'auth',
])->group(function () {
    Route::middleware('role:admin')->prefix('setup')->name('setup.')->group(function () {
        Route::get('/departements', [DepartementController::class, 'index'])->name('departements.index');
        Route::get('/departements/create', [DepartementController::class, 'create'])->name('departements.create');
        Route::post('/departements', [DepartementController::class, 'store'])->name('departements.store');
        Route::get('/departements/{departement}/edit', [DepartementController::class, 'edit'])->name('departements.edit');
        Route::put('/departements/{departement}', [DepartementController::class, 'update'])->name('departements.update');
        Route::delete('/departements/{departement}', [DepartementController::class, 'destroy'])->name('departements.destroy');

        Route::get('karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
        Route::get('karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
        Route::post('karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
        Route::get('karyawan/{karyawan}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
        Route::put('karyawan/{karyawan}', [KaryawanController::class, 'update'])->name('karyawan.update');
        Route::delete('karyawan/{karyawan}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');
        Route::get('karyawan/{karyawan}/reset-password', [KaryawanController::class, 'reset_password'])->name('karyawan.reset-password');
        Route::patch('karyawan/{karyawan}', [KaryawanController::class, 'reset_password_process'])->name('karyawan.reset-password-process');

        Route::get('/periode-cutoff', [PeriodeCutoffController::class, 'index'])->name('periode-cutoff.index');
        Route::get('/periode-cutoff/create', [PeriodeCutoffController::class, 'create'])->name('periode-cutoff.create');
        Route::post('/periode-cutoff', [PeriodeCutoffController::class, 'store'])->name('periode-cutoff.store');
        Route::get('/periode-cutoff/{periode_cutoff}/edit', [PeriodeCutoffController::class, 'edit'])->name('periode-cutoff.edit');
        Route::put('/periode-cutoff/{periode_cutoff}', [PeriodeCutoffController::class, 'update'])->name('periode-cutoff.update');
        Route::delete('/periode-cutoff/{periode_cutoff}', [PeriodeCutoffController::class, 'destroy'])->name('periode-cutoff.destroy');
        Route::post('/periode-cutoff/generate-slip-gaji', [PeriodeCutoffController::class, 'generate_slip_gaji'])->name('periode-cutoff.generate-slip-gaji');
        // Route::get('/periode-cutoff/generate-slip-gaji', [PeriodeCutoffController::class, 'generate_slip_gaji'])->name('periode-cutoff.generate-slip-gaji');
        Route::get('/periode-cutoff/excel/{periode_cutoff_id}', [PeriodeCutoffController::class, 'excel'])->name('periode-cutoff.excel');

        Route::get('/hari-libur', [HariLiburController::class, 'index'])->name('hari-libur.index');
        Route::get('/hari-libur/create', [HariLiburController::class, 'create'])->name('hari-libur.create');
        Route::post('/hari-libur', [HariLiburController::class, 'store'])->name('hari-libur.store');
        Route::get('/hari-libur/{hari_libur}/edit', [HariLiburController::class, 'edit'])->name('hari-libur.edit');
        Route::put('/hari-libur/{hari_libur}', [HariLiburController::class, 'update'])->name('hari-libur.update');
        Route::delete('/hari-libur/{hari_libur}', [HariLiburController::class, 'destroy'])->name('hari-libur.destroy');
    });

    Route::get('/data-kehadiran', [DataKehadiranController::class, 'index'])->name('data-kehadiran.index');
    Route::get('/data-kehadiran/create', [DataKehadiranController::class, 'create'])->name('data-kehadiran.create');
    Route::post('/data-kehadiran', [DataKehadiranController::class, 'store'])->name('data-kehadiran.store');
    Route::get('/data-kehadiran/show', [DataKehadiranController::class, 'show'])->name('data-kehadiran.show');
    Route::delete('data-kehadiran/{data_kehadiran}', [DataKehadiranController::class, 'destroy'])->name('data-kehadiran.destroy');

    Route::get('/request-kehadiran', [RequestKehadiranController::class, 'index'])->name('request-kehadiran.index');
    Route::get('/request-kehadiran/create', [RequestKehadiranController::class, 'create'])->name('request-kehadiran.create');
    Route::post('/request-kehadiran', [RequestKehadiranController::class, 'store'])->name('request-kehadiran.store');
    Route::get('/request-kehadiran/show', [RequestKehadiranController::class, 'show'])->name('request-kehadiran.show');
    Route::delete('/request-kehadiran/{request_kehadiran}', [RequestKehadiranController::class, 'destroy'])->name('request-kehadiran.destroy');
    Route::post('/request-kehadiran/approve-reject', [RequestKehadiranController::class, 'approve_reject'])->name('request-kehadiran.approve-reject');
    Route::delete('/request-kehadiran/{data_lembur}', [RequestKehadiranController::class, 'destroy'])->name('request-kehadiran.destroy');

    Route::get('/data-lembur', [DataLemburController::class, 'index'])->name('data-lembur.index');
    Route::get('/data-lembur/create', [DataLemburController::class, 'create'])->name('data-lembur.create');
    Route::post('/data-lembur', [DataLemburController::class, 'store'])->name('data-lembur.store');
    Route::get('/data-lembur/show', [DataLemburController::class, 'show'])->name('data-lembur.show');
    Route::post('/data-lembur/approve-reject', [DataLemburController::class, 'approve_reject'])->name('data-lembur.approve-reject');
    Route::delete('/data-lembur/{data_lembur}', [DataLemburController::class, 'destroy'])->name('data-lembur.destroy');

    Route::get('/data-ijin', [DataIjinController::class, 'index'])->name('data-ijin.index');
    Route::get('/data-ijin/create', [DataIjinController::class, 'create'])->name('data-ijin.create');
    Route::post('/data-ijin', [DataIjinController::class, 'store'])->name('data-ijin.store');
    Route::delete('/data-ijin/{data_ijin}', [DataIjinController::class, 'destroy'])->name('data-ijin.destroy');
    Route::get('/data-ijin/{id}/download', [DataIjinController::class, 'download'])->name('data-ijin.download');
    Route::post('/data-ijin/approve-reject', [DataIjinController::class, 'approve_reject'])->name('data-ijin.approve-reject');

    Route::get('/data-kasbon', [DataKasbonController::class, 'index'])->name('data-kasbon.index');
    Route::get('/data-kasbon/create', [DataKasbonController::class, 'create'])->name('data-kasbon.create');
    Route::post('/data-kasbon', [DataKasbonController::class, 'store'])->name('data-kasbon.store');
    Route::get('/data-kasbon/{data_kasbon}/edit', [DataKasbonController::class, 'edit'])->name('data-kasbon.edit');
    Route::put('/data-kasbon/{data_kasbon}', [DataKasbonController::class, 'update'])->name('data-kasbon.update');
    Route::delete('/data-kasbon/{data_kasbon}', [DataKasbonController::class, 'destroy'])->name('data-kasbon.destroy');

    Route::get('/slip-gaji', [SlipGajiController::class, 'index'])->name('slip-gaji.index');
    Route::get('/slip-gaji/{slip_gaji}/download', [SlipGajiController::class, 'download'])->name('slip-gaji.download');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test', [TestController::class, 'test']);
Route::get('/test-keterlambatan', [TestController::class, 'repair_keterlambatan']);
Route::get('/test-lembur', [TestController::class, 'repair_lembur']);

require __DIR__ . '/auth.php';
