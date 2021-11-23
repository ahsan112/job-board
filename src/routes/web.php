<?php

use App\Http\Controllers\ListingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [ListingController::class, 'index'])->name('listings.index');
Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
Route::post('/listings/create', [ListingController::class, 'store'])->name('listings.store');

Route::get('/dashboard', function (Request $request) {
    return view('dashboard', [
        'listings' => $request->user()
            ->listings()
            ->with('tags')
            ->withCount('clicks')
            ->get()
    ]);
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/{listing:slug}', [ListingController::class, 'show'])->name('listings.show');
Route::get('/{listing:slug}/apply', [ListingController::class, 'apply'])->name('listings.apply');