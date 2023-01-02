<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\ConsultationController;
use App\Http\Controllers\Api\DataMasterController;

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
Route::post('register', [AuthController::class, 'register'])->name('auth.register');
Route::get('/faculties', [DataMasterController::class, 'getAllFaculty']);
Route::get('/faculties/{faculty_id}/study-programs', [DataMasterController::class, 'getStudyProgramByFaculty']);
Route::get('/study-programs', [DataMasterController::class, 'getAllStudyProgram']);

Route::group([
    'prefix' => 'topics'
], function () {
    Route::get('/', [TopicController::class, 'index']);
    Route::get('/{id}', [TopicController::class, 'show']);
});

Route::group([
    'middleware' => 'api',
], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('auth.refresh');
    Route::post('/me', [AuthController::class, 'me'])->name('auth.me');

    Route::group([
        'prefix' => 'news'
    ], function () {
        Route::get('/', [NewsController::class, 'index']);
        Route::get('/{id}', [NewsController::class, 'show']);
    });

    Route::post('/schedules', [ConsultationController::class, 'store']);
});
