<?php

use App\Http\Controllers\CourseBillController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentBillController;
use App\Http\Controllers\StudentCourseController;

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

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth:teacher')->group(function () {
    //教师端-课程相关
    Route::get('/course',[CourseController::class,'index'])->name('course.index');
    Route::get('/course/create',[CourseController::class,'create'])->name('course.create');
    Route::post('/course',[CourseController::class,'store'])->name('course.store');

    //教师端-账单相关
    Route::get('/course-bill',[CourseBillController::class,'index'])->name('course-bill.index');
    Route::get('/course-bill/create',[CourseBillController::class,'create'])->name('course-bill.create');
    Route::post('/course-bill',[CourseBillController::class,'store'])->name('course-bill.store');
    Route::post('/course-bill/send',[CourseBillController::class,'sendBill'])->name('course-bill.send');
    Route::get('/course-bill/details/{id}',[CourseBillController::class,'billDetails'])->name('course-bill.details');
});
Route::middleware('auth:student')->group(function () {
    //学生端
    Route::get('/my-course',[StudentCourseController::class,'index'])->name('student-course.index');
    Route::get('/my-bill',[StudentBillController::class,'index'])->name('student-bill.index');
    Route::post('/pay-bill',[StudentBillController::class,'pay'])->name('student-bill.pay');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
