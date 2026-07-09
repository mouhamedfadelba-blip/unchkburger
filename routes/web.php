<?php

use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\Customer\CardController;
use App\Http\Controllers\Manager\StatController;
use App\Http\Controllers\Manager\BurgerController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Manager\OrderController as ManagerOrderController;

Route::get('/', [HomeController::class, 'index'])->name('welcome');

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('manager')) return redirect()->route('manager.dashboard');
    if ($user->hasRole('customer')) return redirect()->route('customer.dashboard');
    abort(403);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

Route::middleware(['auth', 'verified', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/catalogues', [CatalogueController::class, 'index'])->name('catalogues.index');
        Route::get('/customer/orders/{order}/download', [OrderController::class, 'downloadInvoice'])
            ->name('orders.download-invoice');

        Route::prefix('card')->name('cards.')->group(function () {
            Route::get('/', [CardController::class, 'index'])->name('index');
            Route::post('/add/{burger}', [CardController::class, 'add'])->name('add');
            Route::delete('/remove/{id}', [CardController::class, 'remove'])->name('remove');
            Route::post('/clear', [CardController::class, 'clear'])->name('clear');
        });

        Route::resource('orders', CustomerOrderController::class)->only(['index', 'store', 'show']);
    });

Route::middleware(['auth', 'verified', 'role:manager'])
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {
        Route::get('/dashboard', [StatController::class, 'index'])->name('dashboard');
        Route::resource('burgers', BurgerController::class);
        Route::resource('orders', ManagerOrderController::class)->except(['create', 'store']);
    });

require __DIR__ . '/auth.php';
