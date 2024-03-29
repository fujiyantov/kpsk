<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TopicController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ScheduleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
if (env('APP_ENV') === 'production') {
    URL::forceScheme('https');
}

Route::get('/', [LoginController::class, 'index']);

// Authentication
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/register', [LoginController::class, 'register'])->name('register')->middleware('guest');
Route::post('/register', [LoginController::class, 'registerReview'])->name('register-review');

//Admin
Route::prefix('admin')
    ->middleware('auth:web')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin-dashboard');

        Route::post('/schedule-reviews/{schedule_id}', [ScheduleController::class, 'review'])->name('schedules.review');
        Route::resource('/schedules', ScheduleController::class);
        Route::resource('/news', NewsController::class);
        Route::resource('/topics', TopicController::class);

        Route::resource('user', UserController::class);
        Route::resource('setting', SettingController::class, [
            'except' => ['show']
        ]);
        Route::get('setting/password', [SettingController::class, 'change_password'])->name('change-password');
        Route::post('setting/upload-profile', [SettingController::class, 'upload_profile'])->name('profile-upload');
        Route::post('change-password', [SettingController::class, 'update_password'])->name('update.password');
        Route::get('setting/schedules', [SettingController::class, 'schedules'])->name('schedules-set');
        Route::post('setting/schedules', [SettingController::class, 'updateSchedule'])->name('update.schedule');

        // CHAT
        Route::get('/chat/{schedule_id}', [ScheduleController::class, 'chatAjax'])->name('chat.ajax');
        Route::post('/chat/{schedule_id}', [ScheduleController::class, 'chatAjaxStore'])->name('chat.ajax.store');
        Route::get('/show-chat/{chat_id}', [ScheduleController::class, 'showChat'])->name('chat.show');

        Route::get('/schedule/rekap', [ScheduleController::class, 'rekap'])->name('schedules.rekap');
    });
