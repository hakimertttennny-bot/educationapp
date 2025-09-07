<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\StudentController;

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

// Authentication API routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout']);

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::put('/password', [AuthController::class, 'changePassword']);
    
    // Admin routes
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/users', [AdminController::class, 'getAllUsers']);
        Route::get('/users/{id}', [AdminController::class, 'getUser']);
        Route::post('/users', [AdminController::class, 'createUser']);
        Route::put('/users/{id}', [AdminController::class, 'updateUser']);
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
        Route::delete('/courses/{id}', [AdminController::class, 'deleteCourse']);
        Route::get('/categories', [AdminController::class, 'getCategories']);
        Route::get('/settings', [AdminController::class, 'getPlatformSettings']);
        Route::post('/settings', [AdminController::class, 'savePlatformSettings']);
    });
    
    // Instructor routes
    Route::prefix('instructor')->middleware('instructor')->group(function () {
        Route::get('/dashboard', [InstructorController::class, 'dashboard']);
        Route::get('/courses', [InstructorController::class, 'getCourses']);
        Route::post('/courses', [InstructorController::class, 'createCourse']);
        Route::put('/courses/{id}', [InstructorController::class, 'updateCourse']);
        Route::delete('/courses/{id}', [InstructorController::class, 'deleteCourse']);
        Route::get('/enrollments', [InstructorController::class, 'getEnrollments']);
        Route::get('/categories', [InstructorController::class, 'getCategories']);
        Route::get('/profile', [InstructorController::class, 'getProfile']);
        Route::put('/profile', [InstructorController::class, 'updateProfile']);
    });
    
    // Student routes
    Route::prefix('student')->middleware('student')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard']);
        Route::get('/courses', [StudentController::class, 'getCourses']);
        Route::get('/courses/{id}', [StudentController::class, 'getCourse']);
        Route::post('/courses/{id}/enroll', [StudentController::class, 'enrollCourse']);
        Route::get('/enrolled-courses', [StudentController::class, 'getEnrolledCourses']);
        Route::put('/courses/{courseId}/progress', [StudentController::class, 'updateProgress']);
        Route::get('/instructors', [StudentController::class, 'getInstructors']);
        Route::get('/instructors/{id}', [StudentController::class, 'getInstructor']);
        Route::post('/instructors/{id}/follow', [StudentController::class, 'followInstructor']);
        Route::delete('/instructors/{id}/follow', [StudentController::class, 'unfollowInstructor']);
        Route::get('/categories', [StudentController::class, 'getCategories']);
        Route::get('/wishlist', [StudentController::class, 'getWishlist']);
        Route::post('/wishlist/{courseId}', [StudentController::class, 'addToWishlist']);
        Route::delete('/wishlist/{courseId}', [StudentController::class, 'removeFromWishlist']);
    });
});
