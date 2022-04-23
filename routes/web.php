<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});


Route::resource('student', StudentController::class);
Route::resource('course', CourseController::class);

Route::get('student/{student}/courses', [StudentController::class, 'viewCourses'])->name('student.courses');
Route::put('student/{student}/courses/assign', [StudentController::class, 'assignCourse'])->name('student.assignCourse');
Route::put('student/{student}/courses/unassign', [StudentController::class, 'unassignCourse'])->name('student.unassignCourse');

Route::get('course/{course}/students', [CourseController::class, 'viewStudents'])->name('course.students');
Route::put('course/{course}/students/assign', [CourseController::class, 'assignStudent'])->name('course.assignStudent');
Route::put('course/{course}/students/unassign', [CourseController::class, 'unassignStudent'])->name('course.unassignStudent');
