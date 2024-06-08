<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;

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

Route::post('/register',[AuthController::class,'register'])->name('register');
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::post('/logout',[AuthController::class,'logout'])
  ->middleware('auth:sanctum')->name('logout');

Route::group(['middleware' => ['auth:sanctum', 'admin'], 'prefix' => 'admin'], function () {
    Route::get('/users',[UserController::class,'users']);
    Route::get('/users-paginate',[UserController::class,'usersPaginate']);
    Route::post('/user',[UserController::class,'store']);
    Route::post('/user/{id}',[UserController::class,'update']);
    Route::delete('/user/{id}',[UserController::class,'delete']);
    
    Route::post('/user-role',[UserController::class,'userRole']);

    Route::post('/team', [TeamController::class,'store']);
});