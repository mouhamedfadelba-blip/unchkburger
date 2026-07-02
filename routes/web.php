<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', function () {
        $latestOrder = null;
        $totalSpent = 0;
        $burgersCount = 0;

        return view('customer.dashboard', compact('latestOrder', 'totalSpent', 'burgersCount'));
    })->name('dashboard');
});

Route::get('/burgers', function () {
    return view('manager.burgers.index');
});
