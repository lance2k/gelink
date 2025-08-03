<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\LinkController;

Route::get('/', function () {
    return Inertia::render('home');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::get('/links', [LinkController::class, 'index'])->name('links.index');
Route::post('/links', [LinkController::class, 'store'])->name('links.store');
Route::get('/links/{id}', [LinkController::class, 'show'])->name('links.show');
// Keep this as the last route to prevent conflicts
Route::get('/{code}', [LinkController::class, 'redirect'])->name('links.redirect');

//Protected routes
Route::middleware(['auth'])->group(function () {
   Route::put('links/{link}', [LinkController::class, 'update'])->name('links.update');
   Route::delete('links/{link}', [LinkController::class, 'destroy'])->name('links.destroy');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
