<?php

use App\Http\Controllers\Public\CatalogController;
use App\Http\Controllers\Public\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CatalogController::class, 'home'])->name('home');
Route::get('/motor', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/motor/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});