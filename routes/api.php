<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::controller(AuthController::class)->group(function () {
    Route::prefix('auth')->name('auth.')->group(function () {

        # Auth Routes
        Route::post('register', 'register')->name('register');
        Route::post('login', 'login')->name('login');

        # Auth Middleware Routes
        Route::middleware(['auth:api'])->group(function () {
            Route::get('profile', 'userProfile')->name('profile');
            Route::get('logout', 'logout')->name('logout');
        });
    });
});
