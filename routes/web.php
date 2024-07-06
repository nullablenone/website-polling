<?php

use App\Http\Controllers\PollingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PollingController::class, 'create'])->name('polling.create');
Route::get('/{polling}', [PollingController::class, 'show'])->name('polling.show');
Route::post('/polling', [PollingController::class, 'store'])->name('polling.store');
Route::post('/{polling}/vote', [PollingController::class, 'vote'])->name('polling.vote');

// Route::resource('polling', PollingController::class);

