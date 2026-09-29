<?php

use App\Http\Controllers\BackOffice\ {
	DashboardController,
	ScriptController,
	ServiceController,
	SettingController,
	UserController
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('/back-office')->name('back-office.')->group(function () {
	/** Admin authenticated routes */
	Route::middleware(['auth:admin'])->group(function () {
		Route::get('/script/{code}/{data?}', [ScriptController::class, 'script']);

		Route::controller(DashboardController::class)->group(function () {
			Route::get('/tableau-de-bord', 'index')->name('dashboard'); // back-office.dashboard
		});

		Route::controller(ServiceController::class)->prefix('/services')->name('services.')->group(function() {
			Route::get('/', 'index')->name('index'); // back-office.services.index
		});

		Route::controller(SettingController::class)->prefix('/settings')->name('settings.')->group(function() {
			Route::get('/', 'index')->name('index'); // back-office.settings.index
		});

		Route::controller(UserController::class)->prefix('/utilisateurs')->name('users.')->group(function() {
			Route::get('/', 'index')->name('index'); // back-office.users.index
		});
	});
});
