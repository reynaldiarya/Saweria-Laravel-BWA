<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\ProfileController;
use App\Models\Donation;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user/{pageId}', function ($pageId) {
    return view('donation', ['pageId' => $pageId]);
})->name('donation');

Route::post('/invoice', [DonationController::class, 'createInvoice'])->name('invoice');
Route::get('/user/{pageId}', [DonationController::class, 'index'])->name('donation');
Route::post('/donate', [DonationController::class, 'store'])->name('donate.store');
Route::get('/donation/success/{uuid}', function ($uuid) {
    return view('success', ['donation' => Donation::findOrFail($uuid)]);
})->name('donation.success');

Route::prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});



require __DIR__ . '/auth.php';
