<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TrainingCourseController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'throttle:enrollments'])->group(function () {
    Route::post('/enrollments', [EnrollmentController::class, 'store'])->name('enrollments.store');
});

Route::get('lang/{lang}', function ($lang) {
    if (in_array($lang, ['ar', 'en'])) {
        session(['locale' => $lang]);
    }
    return redirect()->back();
})->name('lang.switch');
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes - جميع الـ Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('courses', CourseController::class);
        Route::resource('students', StudentController::class);
        Route::resource('training-courses', TrainingCourseController::class);
        Route::resource('enrollments', EnrollmentController::class);

        // عرض الطلاب في دورة معينة
        Route::get(
            'training-courses/{trainingCourse}/students',
            [EnrollmentController::class, 'showStudents']
        )
            ->name('training-courses.students');
    });
});

require __DIR__ . '/auth.php';
