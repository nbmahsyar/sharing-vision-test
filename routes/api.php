<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostsController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/article/{id?}',[PostsController::class, 'store']);
Route::get('/article/{id?}',[PostsController::class, 'view']);
Route::get('/article/{limit?}/entries/{offset?}',[PostsController::class, 'page']);
Route::get('/article/{limit?}/status/{status?}',[PostsController::class, 'index']);
Route::delete('/article/{post?}',[PostsController::class, 'destroy']);
Route::delete('/article/{post?}/delete',[PostsController::class, 'delete']);
Route::get('/count-status',[PostsController::class, 'count']);
