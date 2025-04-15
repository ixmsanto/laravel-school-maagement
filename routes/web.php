<?php

// Path: routes/web.php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->middleware('auth:web');
Route::get('/teacher/dashboard', fn() => view('teacher.dashboard'))->middleware('auth:web');
Route::get('/student/dashboard', fn() => view('student.dashboard'))->middleware('auth:web');
