<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\EnrollmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');

    Route::get('/', [CourseController::class, 'index']);
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [CourseController::class, 'create'])->middleware('role:admin')->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->middleware('role:admin')->name('courses.store');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->middleware('role:admin')->name('courses.edit');
    Route::put('/courses/{course}', [CourseController::class, 'update'])->middleware('role:admin')->name('courses.update');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->middleware('role:admin')->name('courses.destroy');
    Route::get('/courses/{course}/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');


    Route::post('/enroll/{course}', [EnrollmentController::class, 'create'])->middleware('role:user')->name('enrollment.create');
    Route::get('/enroll', [EnrollmentController::class, 'index'])->name('enrollment.index');
    Route::delete('/enroll/{enroll}', [EnrollmentController::class, 'destroy'])->middleware('role:user')->name('enrollment.destroy');
});

require __DIR__ . '/auth.php';

Route::fallback(function () {
    return redirect()->route('courses.index');
});
