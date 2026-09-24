<?php

use App\Http\Controllers\BackOffice\ {
	AuthController,
	DashboardController,
	FaqController,
	PermissionController,
	SettingController,
	WatchController
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('/back-office')->name('back-office.')->group(function () {
	Route::get('/', [AuthController::class, 'index'])->name('index'); // back-office.index
	Route::post('/login', [AuthController::class, 'login'])->name('login'); // back-office.login

	/** Admin authenticated routes */
	Route::middleware(['auth:admin'])->group(function () {
		Route::get('/documents/{filename}', function ($filename) {
			$disk = Storage::disk('private');
			$basePath = realpath($disk->path(''));
			$resolvedPath = realpath($disk->path($filename));

			if(!$resolvedPath || !str_starts_with($resolvedPath, $basePath . DIRECTORY_SEPARATOR)) abort(404, 'Fichier introuvable');

			return response()->file($resolvedPath);
		})->where('filename', '[a-zA-Z0-9_\-\.\/]+')->name('documents.show');

		Route::controller(AuthController::class)->group(function () {
			Route::get('/log-as-user/{user}', 'logAsUser')->name('log-as-user'); // back-office.log-as-user
			Route::get('/sign-out-as-user', 'signOutAsUser')->name('sign-out-as-user'); // back-office.sign-out-as-user
			Route::post('/logout', 'logout')->name('logout'); // back-office.logout
		});

		Route::controller(DashboardController::class)->group(function () {
			Route::get('/dashboard', 'index')->name('dashboard'); // back-office.dashboard
		});

		Route::controller(FaqController::class)->prefix('/faqs')->name('faqs.')->group(function() {
			Route::get('/', 'index')->name('index'); // back-office.faqs.index
			Route::post('/upload', 'upload')->name('upload'); // back-office.faqs.upload
		});

		Route::controller(SettingController::class)->prefix('/settings')->name('settings.')->group(function() {
			Route::get('/', 'index')->name('index'); // back-office.settings.index
		});

		Route::controller(PermissionController::class)->prefix('/permissions')->name('permissions.')->group(function () {
			Route::get('/index', 'index')->name('index'); // back-office.permissions.index
			Route::get('/create', 'create')->name('create'); // back-office.permissions.create
			Route::get('/edit', 'edit')->name('edit'); // back-office.permissions.edit
			Route::get('/destroy', 'destroy')->name('destroy'); // back-office.permissions.destroy
		});

		Route::controller(WatchController::class)->prefix('/watches')->name('watches.')->group(function() {
			Route::get('/', 'index')->name('index'); // back-office.watches.index
		});
	});
});
