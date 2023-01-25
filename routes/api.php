<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\ConsultationController;
use App\Http\Controllers\Api\DataMasterController;
use App\Http\Controllers\ChatController;

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

if (env('APP_ENV') === 'production') {
    URL::forceScheme('https');
}

Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('register', [AuthController::class, 'register'])->name('auth.register');
Route::get('/faculties', [DataMasterController::class, 'getAllFaculty']);
Route::get('/faculties/{faculty_id}/study-programs', [DataMasterController::class, 'getStudyProgramByFaculty']);
Route::get('/study-programs', [DataMasterController::class, 'getAllStudyProgram']);
// Route::get('/topic-summary', [DataMasterController::class, 'getSummeryTopic']);

Route::group([
    'prefix' => 'topics'
], function () {
    Route::get('/', [TopicController::class, 'index']);
    Route::get('/{id}', [TopicController::class, 'show']);
});

Route::group([
    'middleware' => 'api',
], function () {
    Route::get('/histories', [ConsultationController::class, 'index']);
    Route::get('/pending', [ConsultationController::class, 'pending']);
    Route::post('/schedules', [ConsultationController::class, 'store']);
    Route::get('/topic-summary', [ConsultationController::class, 'getSummeryTopic']);
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('auth.refresh');
    Route::post('/me', [AuthController::class, 'me'])->name('auth.me');

    Route::group([
        'prefix' => 'news'
    ], function () {
        Route::get('/', [NewsController::class, 'index']);
        Route::get('/{id}', [NewsController::class, 'show']);
    });

    Route::group([
        'prefix' => 'chat'
    ], function () {
        Route::get('/schedule/{schedule_id}', [ChatController::class, 'index']);
        Route::post('/schdules', [ChatController::class, 'chatStoreAPI']);
    });
});
