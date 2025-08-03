<?php

use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Authentication routes
require __DIR__.'/auth.php';

require __DIR__.'/settings.php';

Route::get('/', function () {
    return Inertia::render('home');
})->name('home');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

// Link management routes
Route::prefix('links')->group(function () {
    Route::get('/', [LinkController::class, 'index'])->name('links.index');
    Route::post('/', [LinkController::class, 'store'])->name('links.store');
    Route::get('/{id}', [LinkController::class, 'show'])->name('links.show');

    // Protected link management routes
    Route::middleware(['auth'])->group(function () {
        Route::put('/{link}', [LinkController::class, 'update'])->name('links.update');
        Route::delete('/{link}', [LinkController::class, 'destroy'])->name('links.destroy');
    });
});

// Keep this catch-all route as last to prevent conflicts
Route::get('/{code}', [LinkController::class, 'redirect'])->name('links.redirect');
