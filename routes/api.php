<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/xendit/callback', [App\Http\Controllers\DonationController::class, 'notificationCallback'])->name('notification');
