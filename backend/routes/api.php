<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\TodoListController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/todo/lists', [TodoListController::class, 'index']);

Route::post('/todo/add', [TodoController::class, 'addTodo']);
Route::put('/todo/resolve/{id}', [TodoController::class, 'resolveOrUnresolveTodo']);
Route::put('/todo/move/{id}', [TodoController::class, 'moveTodoToNearbyList']);

Route::delete('/todo/remove/{id}', [TodoController::class, 'removeTodo']);
