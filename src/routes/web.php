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

// AuthController
Route::get('/register/step1', [AuthController::class, 'showStep1'])->name('register.step1');
Route::post('/register/step1', [AuthController::class, 'storeStep1']);
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// WeightController
Route::get('/register/step2', [WeightController::class, 'showStep2'])->name('register.step2');
Route::post('/register/step2', [WeightController::class, 'storeStep2']);
Route::get('/weight_logs', [WeightController::class, 'index'])->name('weight_logs');
Route::post('/weight_logs/{id}/update', [WeightController::class, 'updateWeight']);
Route::post('/weight_logs/goal_setting', [WeightController::class, 'setGoal']);