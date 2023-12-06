<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\TaskController as UserTaskController;
use Illuminate\Support\Facades\Route;


Route::post('admin/login', AdminAuthController::class)->name('admin.login');
Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::post('team', [TeamController::class, 'store'])->name('team.store');
    Route::get('team', [TeamController::class, 'index'])->name('team.index');
    Route::get('team/{id}', [TeamController::class, 'show'])->name('team.show');
    Route::put('team/{id}', [TeamController::class, 'update'])->name('team.update');
    Route::delete('team/{id}', [TeamController::class, 'destroy'])->name('team.delete');
    Route::apiResource('user', UserController::class);
    Route::apiResource('tasks', TaskController::class);
});


Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::middleware('auth:api')->prefix('user')->group(function () {
    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('tasks', [UserTaskController::class, 'index'])->name('task.index');
    Route::post('tasks', [UserTaskController::class, 'store'])->name('task.store');
    Route::put('tasks/{id}', [UserTaskController::class, 'update'])->name('task.update');
    Route::get('tasks/team', [UserTaskController::class, 'teamTasks'])->name('task.tasks-team');
    Route::put('tasks/{id}/assign', [UserTaskController::class, 'assignTask'])->name('task-assign');

});
