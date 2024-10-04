<?php

use App\Http\Controllers\PollingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PollingController::class, 'create'])->name('polling.create');
Route::get('/tentang', [PollingController::class, 'tentang'])->name('polling.tentang');

// Route Utama
Route::get('/{polling}', [PollingController::class, 'show'])->name('polling.show');

Route::post('/polling', [PollingController::class, 'store'])->name('polling.store');
Route::post('/{polling}/vote', [PollingController::class, 'vote'])->name('polling.vote');
Route::get('/{polling}/show-status', [PollingController::class, 'showStatus'])->name('polling.showStatus');
Route::get('/show-polling/{polling}', [PollingController::class, 'showPolling'])->name('polling.showPolling');
Route::get('/polling/polling-terbaru', [PollingController::class, 'pollingTerbaru'])->name('polling.pollingTerbaru');
Route::delete('/polling/{polling}', [PollingController::class, 'destroy'])->name('polling.destroy');


// Route::resource('polling', PollingController::class);
