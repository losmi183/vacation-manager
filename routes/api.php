<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RequestController;

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

// Auth routes
Route::post('/register',[AuthController::class,'register'])->name('register');
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::post('/logout',[AuthController::class,'logout'])
  ->middleware('auth:sanctum')->name('logout');

// Only for admin - 'Administrator' role
Route::group(['middleware' => ['auth:sanctum', 'admin'], 'prefix' => 'admin'], function () {
    // User administrations - basic CRUD and pagination
    Route::get('/users',[UserController::class,'users']);
    Route::get('/users-paginate',[UserController::class,'usersPaginate']);
    Route::post('/user',[UserController::class,'store']);
    Route::post('/user/{id}',[UserController::class,'update']);
    Route::delete('/user/{id}',[UserController::class,'delete']);
    
    // Change user role
    Route::post('/user-role',[UserController::class,'userRole']);

    // Create new team
    Route::post('/team', [TeamController::class,'store']);

    // User to team
    Route::post('/team/assign-user', [TeamController::class,'assignUser']);

    // Assigning teams array to user 
    Route::post('/team/manager', [TeamController::class,'teamManager']);
});

// User routes
Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'user'], function () {
    
    // User create request
    Route::post('/request', [RequestController::class,'request']);
    
    // User requests
    Route::get('/requests', [RequestController::class,'requests']);
    
    // Team requests
    Route::get('/team/requests', [RequestController::class,'teamRequests']);
});

// Manager routes
Route::group(['middleware' => ['auth:sanctum', 'manager'], 'prefix' => 'manager'], function () {
    
    // Team requests for team manager - all requests per team
    Route::get('/team/requests', [RequestController::class,'managerTeamRequests']);

    // Approve request
    Route::post('/request-approve/{id}', [RequestController::class,'managerResolveRequest']);
    // deny request
    Route::post('/request-deny/{id}', [RequestController::class,'managerResolveRequest']);
});