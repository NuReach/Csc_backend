<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\PostController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [LogoutController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/users', 'getAllUsers');
    });

    Route::controller(PostController::class)->group(function () {
        Route::get('/getPost', 'getPosts');
        Route::get('/getPost/{id}', 'getOnePost');
        Route::post('/createPost', 'createPost');
        Route::put('/updatePost/{id}', 'updatePost');
        Route::delete('/deletePost/{id}', 'deletePost');
    });
});
