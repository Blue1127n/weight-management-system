<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WeightController;

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

Route::get('/register/step1', [AuthController::class, 'showStep1'])->name('register.step1');
Route::post('/register/step1', [AuthController::class, 'storeStep1']);
Route::get('/register/step2', [AuthController::class, 'showStep2'])->name('register.step2');
Route::post('/register/step2', [AuthController::class, 'storeStep2'])->name('register.step2');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/weight_logs', [WeightController::class, 'index'])->name('weight_logs');
    Route::post('/weight_logs/create', [WeightController::class, 'store'])->name('weight_logs.store');
    Route::get('/weight_logs/{weightLogId}/edit', [WeightController::class, 'edit'])->name('weight_logs.edit');
    Route::put('/weight_logs/{weightLogId}/update', [WeightController::class, 'update'])->name('weight_logs.update');
    Route::delete('/weight_logs/{weightLogId}/delete', [WeightController::class, 'delete'])->name('weight_logs.destroy');
    Route::get('/weight_logs/goal_setting', [WeightController::class, 'showGoalSetting'])->name('weight_logs.goal_setting');
    Route::post('/weight_logs/goal_setting', [WeightController::class, 'setGoal'])->name('weight_logs.set_goal');

    Route::post('/clear-old-input', [WeightController::class, 'clearOldInput'])->name('clear_old_input');
});