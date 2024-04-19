<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CourseController;
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
        Route::get('/getPost/{search}/{sortBy}/{sortDir}', 'getPostPagination');
        Route::get('/getPost/{id}', 'getOnePost');
        Route::post('/createPost', 'createPost');
        Route::put('/updatePost/{id}', 'updatePost');
        Route::delete('/deletePost/{id}', 'deletePost');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/user', 'getAllUsers');
        Route::post('/user/{id}', 'getUserById');
        Route::post('/createUser', 'createUser');
        Route::put('/updateUser/{id}', 'updateUser');
        Route::delete('/deleteUser/{id}', 'deleteUser');
    });

    Route::controller(CourseController::class)->group(function () {
        Route::get('/course', 'getAllCourses');
        Route::post('/course/{id}', 'getCourseById');
        Route::post('/createCourse', 'createCourse');
        Route::put('/updateCourse/{id}', 'updateCourse');
        Route::delete('/deleteCourse/{id}', 'deleteCourse');
    });
});
