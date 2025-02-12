<?php

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

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::get('/login', [UserController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function () {
  Route::prefix('attendance')->group(function () {
    Route::get('', [WorkController::class, 'attendance']);
    Route::get('list', [WorkController::class, 'attendancelist']);
    Route::post('punch', [WorkController::class, 'punch']);
  });
});
