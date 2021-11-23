<?php

use App\Http\Controllers\ListingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ListingController::class, 'index'])->name('listings.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/{listing:slug}', [ListingController::class, 'show'])->name('listings.show');
Route::get('/{listing:slug}/apply', [ListingController::class, 'apply'])->name('listings.apply');