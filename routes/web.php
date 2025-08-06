<?php

use App\Http\Controllers\MatrixController;
use App\Http\Controllers\PerformanceContractController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/performance-matrix/create', [MatrixController::class, 'create'])->name('performance.create');

Route::get('/performance-matrix', [PerformanceContractController::class, 'index'])->name('performance.index');
Route::post('/performance-matrix', [PerformanceContractController::class, 'store'])->name('performance.store');
Route::put('/performance-matrix/{contract}', [PerformanceContractController::class, 'update'])->name('performance.update');
Route::delete('/performance-matrix/{contract}', [PerformanceContractController::class, 'destroy'])->name('performance.destroy');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
