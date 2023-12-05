<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\TaskController as UserTaskController;
use Illuminate\Support\Facades\Route;

Route::post('admin/login', AdminAuthController::class)->name('admin.login');
Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::apiResource('user', UserController::class);
    Route::apiResource('team', TeamController::class);
    Route::apiResource('tasks', TaskController::class);
    Route::get('dashboard', DashboardController::class)->name('dashboard');
});


Route::post('user/login', [AuthController::class, 'login'])->name('login');
Route::post('user/register', [AuthController::class, 'register'])->name('register');
Route::middleware('auth:api')->prefix('user')->group(function () {
    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    Route::apiResource('tasks', UserTaskController::class);
    Route::put('tasks/{id}/assign', [UserTaskController::class, 'assignedTask'])->name('tasks.assigned');
    Route::get('dashboard', UserDashboardController::class)->name('dashboard');
    Route::get('team', [UserTaskController::class, 'teamTasks'])->name('team');
});
