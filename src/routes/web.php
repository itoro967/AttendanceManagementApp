<?php

use App\Http\Controllers\CorrectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/attendance');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::get('/login', [UserController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function () {
  Route::prefix('attendance')->group(function () {
    Route::get('', [WorkController::class, 'attendance']);
    Route::get('list', [WorkController::class, 'attendancelist']);
    Route::get('{id}', [WorkController::class, 'detail']);
    Route::post('punch', [WorkController::class, 'punch']);
    Route::post('correct', [CorrectController::class, 'correct']);
  });
  Route::get('stamp_correction_request/list', [CorrectController::class, 'list']);
});
