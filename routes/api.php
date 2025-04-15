<?php

// Path: routes/api.php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refresh']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [AdminController::class, 'listUsers']);
        Route::get('/users/{id}', [AdminController::class, 'getUser']);
        Route::post('/users', [AdminController::class, 'createUser']);
        Route::put('/users/{id}', [AdminController::class, 'updateUser']);
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
    });

    // Teacher routes
    Route::middleware('role:teacher')->group(function () {
        Route::get('/students', [TeacherController::class, 'listStudents']);
        Route::get('/students/{id}', [TeacherController::class, 'getStudent']);
        Route::post('/students', [TeacherController::class, 'createStudent']);
        Route::put('/students/{id}', [TeacherController::class, 'updateStudent']);
        Route::post('/marks', [MarksController::class, 'assignMarks']);
        Route::post('/homework', [HomeworkController::class, 'assignHomework']);
    });

    // Student routes
    Route::middleware('role:student')->group(function () {
        Route::get('/homework', [HomeworkController::class, 'viewHomework']);
        Route::put('/homework/{id}', [HomeworkController::class, 'updateHomework']);
        Route::get('/performance', [StudentController::class, 'viewPerformance']);
    });

    // Report routes
    Route::get('/reports/student/{id}', [ReportController::class, 'generateReport']);

    // Batch import
    Route::post('/students/import', [TeacherController::class, 'importStudents']);
});
