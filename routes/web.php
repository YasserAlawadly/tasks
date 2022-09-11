<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/' , [\App\Http\Controllers\TaskController::class , 'index'])->name('task.index');
Route::get('/create' , [\App\Http\Controllers\TaskController::class , 'create'])->name('task.create');
Route::post('/create' , [\App\Http\Controllers\TaskController::class , 'store'])->name('task.store');
Route::get('/statistics' , [\App\Http\Controllers\StatisticController::class , 'index'])->name('statistic.index');
