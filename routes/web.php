<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Owner\BrandController;
use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\Owner\MotorcycleController;
use App\Http\Controllers\Public\CatalogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CatalogController::class, 'home'])->name('home');
Route::get('/motor', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/motor/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::prefix('owner')
    ->name('owner.')
    ->middleware('auth')
    ->group(function (): void {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('merek', BrandController::class)
            ->except(['show'])
            ->names('brands');

        Route::resource('motor', MotorcycleController::class)
            ->parameters(['motor' => 'motorcycle'])
            ->names('motorcycles');

        Route::patch('/motor/{motorcycle}/status', [MotorcycleController::class, 'updateStatus'])
            ->name('motorcycles.status');
    });
