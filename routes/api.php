<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login'])->name('auth.login');

Route::group([
    // 'middleware' => 'api',
], function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');;
    Route::post('refresh', [AuthController::class, 'refresh'])->name('auth.refresh');;
    Route::post('me', [AuthController::class, 'me'])->name('auth.me');;
});
