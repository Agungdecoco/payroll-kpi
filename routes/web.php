<?php

use App\Http\Controllers\AllowanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\KpiController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SegmentController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\UserController;

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
    redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');

    Route::prefix('master')->group(function () {
        Route::prefix('karyawan')->group(function () {
            Route::get('', [UserController::class, 'index'])->name('karyawan.index');
            Route::get('/create', [UserController::class, 'create'])->name('karyawan.create');
            Route::post('', [UserController::class, 'store'])->name('karyawan.store');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('karyawan.edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('karyawan.update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('karyawan.destroy');
            Route::get('/{id}', [UserController::class, 'show'])->name('karyawan.show');
        });
        Route::prefix('level')->group(function () {
            Route::get('', [LevelController::class, 'index'])->name('level.index');
            Route::get('/create', [LevelController::class, 'create'])->name('level.create');
            Route::post('', [LevelController::class, 'store'])->name('level.store');
            Route::get('/{id}/edit', [LevelController::class, 'edit'])->name('level.edit');
            Route::put('/{id}', [LevelController::class, 'update'])->name('level.update');
            Route::delete('/{id}', [LevelController::class, 'destroy'])->name('level.destroy');
        });
        Route::prefix('divisi')->group(function () {
            Route::get('', [DivisionController::class, 'index'])->name('divisi.index');
            Route::get('/create', [DivisionController::class, 'create'])->name('divisi.create');
            Route::post('', [DivisionController::class, 'store'])->name('divisi.store');
            Route::get('/{id}/edit', [DivisionController::class, 'edit'])->name('divisi.edit');
            Route::put('/{id}', [DivisionController::class, 'update'])->name('divisi.update');
            Route::delete('/{id}', [DivisionController::class, 'destroy'])->name('divisi.destroy');
        });
        Route::prefix('segmen')->group(function () {
            Route::get('', [SegmentController::class, 'index'])->name('segmen.index');
            Route::get('/create', [SegmentController::class, 'create'])->name('segmen.create');
            Route::post('', [SegmentController::class, 'store'])->name('segmen.store');
            Route::get('/{id}/edit', [SegmentController::class, 'edit'])->name('segmen.edit');
            Route::put('/{id}', [SegmentController::class, 'update'])->name('segmen.update');
            Route::delete('/{id}', [SegmentController::class, 'destroy'])->name('segmen.destroy');
            Route::get('/by_division/{divisionId}', [SegmentController::class, 'getSegmentsByDivision']);
        });
        Route::prefix('parameter')->group(function () {
            Route::get('', [ParameterController::class, 'index'])->name('parameter.index');
            Route::get('/create', [ParameterController::class, 'create'])->name('parameter.create');
            Route::post('', [ParameterController::class, 'store'])->name('parameter.store');
            Route::get('/{id}/edit', [ParameterController::class, 'edit'])->name('parameter.edit');
            Route::put('/{id}', [ParameterController::class, 'update'])->name('parameter.update');
            Route::delete('/{id}', [ParameterController::class, 'destroy'])->name('parameter.destroy');
        });
        Route::prefix('tunjangan')->group(function () {
            Route::get('', [AllowanceController::class, 'index'])->name('tunjangan.index');
            Route::get('/create', [AllowanceController::class, 'create'])->name('tunjangan.create');
            Route::post('', [AllowanceController::class, 'store'])->name('tunjangan.store');
            Route::get('/{id}/edit', [AllowanceController::class, 'edit'])->name('tunjangan.edit');
            Route::put('/{id}', [AllowanceController::class, 'update'])->name('tunjangan.update');
            Route::delete('/{id}', [AllowanceController::class, 'destroy'])->name('tunjangan.destroy');
        });
        Route::prefix('pajak')->group(function () {
            Route::get('/', [TaxController::class, 'index'])->name('pajak.index');
            Route::put('/{id}', [TaxController::class, 'update'])->name('pajak.update');
        });
    });

    Route::prefix('kpi')->group(function () {
        Route::get('/', [KpiController::class, 'index'])->name('kpi.index');
        Route::get('/user_{id}/score', [KpiController::class, 'indexScore'])->name('kpi.score');
        Route::get('create', [KpiController::class, 'create'])->name('kpi.create');
        Route::post('', [KpiController::class, 'store'])->name('kpi.store');
        Route::get('edit/{id}', [KpiController::class, 'edit'])->name('kpi.edit');
        Route::put('edit/{id}', [KpiController::class, 'update'])->name('kpi.update');
    });

    Route::prefix('penggajian')->group(function () {
        Route::get('/', [PayrollController::class, 'index'])->name('payroll.index');
        Route::get('pay/{id}', [PayrollController::class, 'pay'])->name('payroll.create');
        Route::put('/{id}', [PayrollController::class, 'store'])->name('payroll.store');
    });

    Route::prefix('laporan')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('report.index');
        Route::get('/user_{id}/list', [ReportController::class, 'indexReport'])->name('report.list');
        Route::get('detail/{id}', [ReportController::class, 'show'])->name('report.detail');
        Route::get('download/{id}', [ReportController::class, 'viewPdf'])->name('report.view');
    });
});


Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
