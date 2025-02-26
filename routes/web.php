<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\ProfileController;
use App\Models\Donation;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user/{username}', function ($username) {
    return view('donation', ['username' => $username]);
})->name('donation');

Route::post('/invoice', [App\Http\Controllers\DonationController::class, 'createInvoice'])->name('invoice');
Route::get('/user/{username}', [App\Http\Controllers\DonationController::class, 'index'])->name('donation');
Route::post('/donate', [DonationController::class, 'store'])->name('donate.store');
Route::get('/donation/success/{id}', function ($id) {
    return view('success', ['donation' => Donation::findOrFail($id)]);
})->name('donation.success');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
