<?php

use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;


Route::post('team', [TeamController::class, 'store'])->name('team.store');
Route::get('team', [TeamController::class, 'index'])->name('team.index');
Route::get('team/{id}', [TeamController::class, 'show'])->name('team.show');
Route::put('team/{id}', [TeamController::class, 'update'])->name('team.update');
Route::delete('team/{id}', [TeamController::class, 'delete'])->name('team.delete');

