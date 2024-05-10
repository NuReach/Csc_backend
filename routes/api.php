<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\API\VideoController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\ServiceContoller;
use App\Http\Controllers\API\CountryController;
use App\Http\Controllers\Api\ProgramController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\DashboardController;
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

Route::middleware('auth:sanctum')->get('/user/detail', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/users', 'getAllUsers');
        Route::get('/dashboard', 'dashboard');
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
        Route::get('/courses', 'getAllCourses');
        Route::get('/courses/{id}', 'getCourseById');
        Route::get('/courses/{search}/{sortBy}/{sortDir}', 'getCoursesPagination');
        Route::post('/courses/create', 'createCourse');
        Route::put('/courses/update/{id}', 'updateCourse');
        Route::delete('/courses/delete/{id}', 'deleteCourse');
        Route::post('/courses/add/student/{user_id}/{course_id}', 'addUserToCourse');
    });

    Route::controller(VideoController::class)->group(function () {
        Route::get('/videos', 'getAllVideos');
        Route::get('/videos/{id}', 'getVideoByID');
        Route::get('/videos/course/{course_id}', 'getVideoBelongToCourse');
        Route::post('/videos/create', 'createVideo');
        Route::put('/videos/update/{id}', 'updateVideo');
        Route::delete('/videos/delete/{id}', 'deleteVideo');
    });

    Route::controller(CountryController::class)->group(function () {
        Route::get('/countries', 'index');
        Route::post('/countries', 'store');
        Route::get('/countries/{id}', 'show');
        Route::put('/countries/{id}', 'update');
        Route::delete('/countries/{id}', 'destroy');
    });

    
    Route::controller(LanguageController::class)->group(function () {
        Route::post('/language/create', 'store');
        Route::delete('/language/delete/{id}', 'destroy');
    });

    Route::controller(ProgramController::class)->group(function () {
        Route::post('/program/create', 'store');
        Route::delete('/program/delete/{id}', 'destroy');
    });

    Route::controller(ServiceContoller::class)->group(function () {
        Route::post('/service/create', 'store');
        Route::delete('/service/delete/{id}', 'destroy');
    });

});
