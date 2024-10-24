<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollingController;


// Mengaktifkan route untuk authentication
Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/', [PollingController::class, 'create'])->name('polling.create');
    Route::get('/polling-foto', [PollingController::class, 'pollingFoto'])->name('polling.pollingFoto');
    Route::get('/tentang', [PollingController::class, 'tentang'])->name('polling.tentang');
    Route::get('/dashboard', [PollingController::class, 'dashboard'])->name('polling.dashboard');

    // Route Utama
    Route::post('/polling-foto/create', [PollingController::class, 'storeFotoPolling'])->name('polling.storePollingFoto');
    Route::get('/{polling}', [PollingController::class, 'show'])->name('polling.show');
    Route::post('/polling', [PollingController::class, 'store'])->name('polling.store');    
    Route::post('/{polling}/vote', [PollingController::class, 'vote'])->name('polling.vote');
    Route::get('/{polling}/show-status', [PollingController::class, 'showStatus'])->name('polling.showStatus');
    Route::get('/show-polling/{polling}', [PollingController::class, 'showPolling'])->name('polling.showPolling');
    Route::get('/polling/polling-terbaru', [PollingController::class, 'pollingTerbaru'])->name('polling.pollingTerbaru');
    Route::delete('/dashboard/{id}/hapus', [PollingController::class, 'hapus'])->name('polling.hapus');
    Route::get('/dashboard/{id}/tutup', [PollingController::class, 'tutup'])->name('polling.tutup');
});
