<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'book'], function () {
    Route::get('{id}',[\App\Http\Controllers\Api\BookController::class, 'read']);
    Route::post('/',[\App\Http\Controllers\Api\BookController::class, 'create']);
    Route::put('{id}',[\App\Http\Controllers\Api\BookController::class, 'update']);
    Route::delete('{id}',[\App\Http\Controllers\Api\BookController::class, 'delete']);
});

Route::get('/books',[\App\Http\Controllers\Api\BooksController::class, 'list']);
