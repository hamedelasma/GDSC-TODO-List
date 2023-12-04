<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::post('team', [TeamController::class, 'store'])->name('team.store');
Route::get('team', [TeamController::class, 'index'])->name('team.index');
Route::get('team/{id}', [TeamController::class, 'show'])->name('team.show');
Route::put('team/{id}', [TeamController::class, 'update'])->name('team.update');
Route::delete('team/{id}', [TeamController::class, 'destroy'])->name('team.delete');

Route::apiResource('user', UserController::class);

Route::apiResource('tasks', TaskController::class);

Route::post('login', [AuthController::class, 'login'])->name('login');
