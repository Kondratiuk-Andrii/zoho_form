<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ZohoAuthController;
use App\Http\Controllers\ZohoCrmAccountController;
use App\Http\Controllers\ZohoCrmDealController;
use App\Models\AuthToken;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    // $isToken = AuthToken::all()->count() > 0;
    return Inertia::render('Dashboard', [
        // 'isToken' => $isToken,
    ]);
})->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::prefix('zoho')->name('zoho.')
    ->group(function () {
        Route::get('/authorize', [ZohoAuthController::class, 'redirectToZoho'])->name('authorize');
        Route::get('/callback', [ZohoAuthController::class, 'handleZohoCallback']);
        Route::get('/logout', [ZohoAuthController::class, 'handleLogout'])->name('logout');
    });

Route::prefix('accounts')->name('accounts.')
    ->group(function () {
        Route::get('', [ZohoCrmAccountController::class, 'index'])->name('index');
        Route::get('/create', [ZohoCrmAccountController::class, 'create'])->name('create');
        Route::post('/', [ZohoCrmAccountController::class, 'store'])->name('store');
        Route::get('/{account}', [ZohoCrmAccountController::class, 'show'])->name('show');
        Route::patch('/{account}', [ZohoCrmAccountController::class, 'update'])->name('update');
        Route::delete('/{account}', [ZohoCrmAccountController::class, 'destroy'])->name('destroy');
    });
Route::prefix('deals')->name('deals.')
    ->group(function () {
        Route::get('', [ZohoCrmDealController::class, 'index'])->name('index');
        Route::get('/create', [ZohoCrmDealController::class, 'create'])->name('create');
        Route::post('/', [ZohoCrmDealController::class, 'store'])->name('store');
        Route::get('/{deal}', [ZohoCrmDealController::class, 'show'])->name('show');
        Route::patch('/{deal}', [ZohoCrmDealController::class, 'update'])->name('update');
        Route::delete('/{deal}', [ZohoCrmDealController::class, 'destroy'])->name('destroy');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
