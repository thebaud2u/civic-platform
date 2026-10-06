<?php

use App\Http\Controllers\{AccountController, DashboardController};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return redirect()->route('login');
})->name('home');

Route::middleware('auth')->group(function () {
	Route::controller(AccountController::class)->group(function () {
		Route::get('/mon-compte', [AccountController::class, 'edit'])->name('account.edit');
		Route::patch('/mon-compte', [AccountController::class, 'update'])->name('account.update');
	});

	Route::controller(DashboardController::class)->group(function () {
		Route::get('/tableau-de-bord', 'index')->name('dashboard'); // dashboard
		Route::get('/demandes', 'requests')->name('requests'); // requests
	});
});

require __DIR__.'/auth.php';
require __DIR__.'/back-office.php';
