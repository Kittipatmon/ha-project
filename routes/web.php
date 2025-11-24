<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\frontend\SystemController;

use App\Http\Controllers\backend\RequestHRController;
use App\Http\Controllers\backend\requestdata\RequestDataController;
use App\Http\Controllers\backend\requestdata\SectionController;
use App\Http\Controllers\backend\requestdata\DivisionController;
use App\Http\Controllers\backend\requestdata\DepartmentController;

use App\Http\Controllers\backend\hrrequest\RequestCategoriesController;
use App\Http\Controllers\backend\hrrequest\RequestTypeController;
use App\Http\Controllers\backend\hrrequest\RequestSubtypeController;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// welcomeSystem
Route::get('/welcome-system', [SystemController::class, 'welcomeSystem'])->name('welcome.system');

Route::get('/welcomehrrequest', [RequestHRController::class, 'welcomeRequest'])->name('request.hr');
Route::get('/request-data', [RequestDataController::class, 'welcomeData'])->name('request.data');

Route::middleware('auth')->group(function () {


    Route::get('/requestHR', [RequestHRController::class, 'requestHR'])->name('requesthr.index');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('sections', SectionController::class);
    Route::resource('divisions', DivisionController::class);
    Route::resource('departments', DepartmentController::class);


    Route::resource('request-categories', RequestCategoriesController::class);
    Route::get('request-types', [RequestTypeController::class, 'index'])->name('request-types.index');
    Route::get('request-subtypes', [RequestSubtypeController::class, 'index'])->name('request-subtypes.index');

});
// 
require __DIR__.'/auth.php';
