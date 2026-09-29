<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/tableau-de-bord', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/mon-compte', [AccountController::class, 'edit'])->name('account.edit');
    Route::patch('/mon-compte', [AccountController::class, 'update'])->name('account.update');
});

require __DIR__.'/auth.php';
require __DIR__.'/back-office.php';
