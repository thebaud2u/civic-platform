<?php

use App\Http\Controllers\BackOffice\ {
	AuthController,
	DashboardController,
	ServiceController,
	UserController
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('/back-office')->name('back-office.')->group(function () {
	Route::get('/', [AuthController::class, 'index'])->name('index'); // back-office.index
	Route::post('/login', [AuthController::class, 'store'])->name('login'); // back-office.login

	/** Admin authenticated routes */
	Route::middleware(['auth:admin'])->group(function () {
		Route::controller(AuthController::class)->group(function () {
			Route::get('/log-as-user/{user}', 'logAsUser')->name('log-as-user'); // back-office.log-as-user
			Route::get('/sign-out-as-user', 'signOutAsUser')->name('sign-out-as-user'); // back-office.sign-out-as-user
			Route::post('/logout', 'logout')->name('logout'); // back-office.logout
		});

		Route::controller(DashboardController::class)->group(function () {
			Route::get('/tableau-de-bord', 'index')->name('dashboard'); // back-office.dashboard
		});

		Route::controller(ServiceController::class)->prefix('/services')->name('services.')->group(function() {
			Route::get('/', 'index')->name('index'); // back-office.services.index
		});

		Route::controller(UserController::class)->prefix('/utilisateurs')->name('users.')->group(function() {
			Route::get('/', 'index')->name('index'); // back-office.users.index
		});
	});
});
