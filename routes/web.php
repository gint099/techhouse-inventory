<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemInController;
use App\Http\Controllers\ItemOutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('report')->name('report.')->group(function () {
        Route::get('/stocks', [ReportController::class, 'stocks'])->name('stocks');
        Route::get('/stocks/export/{format}', [ReportController::class, 'exportStocks'])->name('stocks.export')->where('format', 'excel|pdf');
        Route::get('/ins', [ReportController::class, 'ins'])->name('ins');
        Route::get('/ins/export/{format}', [ReportController::class, 'exportIns'])->name('ins.export')->where('format', 'excel|pdf');
        Route::get('/outs', [ReportController::class, 'outs'])->name('outs');
        Route::get('/outs/export/{format}', [ReportController::class, 'exportOuts'])->name('outs.export')->where('format', 'excel|pdf');
    });

    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->except('show');
        Route::resource('categories', CategoryController::class)->except('show');
        Route::resource('items', ItemController::class);
        Route::resource('item-ins', ItemInController::class)->except(['edit', 'update']);
        Route::resource('item-outs', ItemOutController::class)->except(['edit', 'update']);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profiles', [ProfilesController::class, 'index'])->name('profiles.index');
    Route::get('/profiles/edit', [ProfilesController::class, 'edit'])->name('profiles.edit');
    Route::put('/profiles', [ProfilesController::class, 'update'])->name('profiles.update');
    Route::get('/profiles/password', [ProfilesController::class, 'password'])->name('profiles.password');

    Route::get('/profile', fn () => redirect()->route('profiles.index'))->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
