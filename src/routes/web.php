<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminCorrectController;
use App\Http\Controllers\CommonCorrectController;
use App\Http\Controllers\CommonWorkController;
use App\Http\Controllers\Staff\CorrectController;
use App\Http\Controllers\Staff\AttendanceController;
use App\Http\Controllers\Staff\WorkController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Role;

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

Route::middleware(['auth', Role::class . ':staff'])->name('staff.')->group(function () {
  Route::prefix('attendance')->group(function () {
    Route::get('', [AttendanceController::class, 'attendance'])->name('attendance'); #打刻画面
    Route::get('list', [WorkController::class, 'list'])->name('attendanceList'); #勤怠一覧
    Route::post('punch', [AttendanceController::class, 'punch'])->name('punch'); #打刻
    Route::post('correct', [CorrectController::class, 'correct'])->name('correct'); #修正
  });
});


Route::get('/admin/login', [AdminController::class, 'login'])->name('login');

Route::middleware(['auth', Role::class . ':admin'])->name('admin.')->group(function () {
  Route::get('/admin/attendance/list', [AdminController::class, 'attendanceList'])->name('attendanceList'); #勤怠一覧

  Route::get('/admin/staff/list', [AdminUserController::class, 'list'])->name('staffList'); #スタッフ一覧
  Route::get('/attendance/staff/{id}', [AdminUserController::class, 'detail'])->name('staffDetail'); #スタッフの勤怠一覧
  Route::post('/admin/attendance/correct', [AdminCorrectController::class, 'correct'])->name('correct'); #修正
  Route::get('/stamp_correction_request/approve/{attendance_correct_request}', [AdminCorrectController::class, 'correctConfirm'])->name('correctConfirm'); #修正確認
  Route::post('/confirm', [AdminCorrectController::class, 'confirm'])->name('confirm'); #修正確認
});

// 共通のルート
Route::middleware(['auth'])->group(function () {
  Route::get('/stamp_correction_request/list', [CommonCorrectController::class, 'list'])->name('correctList'); #修正一覧});
  Route::get('/attendance/{id}', [CommonWorkController::class, 'detail'])->name('detail'); #勤怠詳細
});
