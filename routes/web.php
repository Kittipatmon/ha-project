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

use App\Http\Controllers\backend\ApproveController;


use App\Http\Controllers\backend\NewsController;
use App\Models\datacenter\News;


Route::get('/', function () {
    $newsItems = News::where('is_active', true)
        ->orderBy('published_date', 'desc')
        ->get();

    $highlight = $newsItems->first();
    $otherNews = $newsItems->slice(1); // collection without highlight

    return view('welcome', [
        'highlight' => $highlight,
        'otherNews' => $otherNews,
        'newsItems' => $newsItems,
    ]);
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
    Route::get('/requestHR/list', [RequestHRController::class, 'requesthrList'])->name('requesthr.list');
    Route::get('/requestHR/listall', [RequestHRController::class, 'requesthrlistall'])->name('requesthr.listall');
    Route::get('/requestHR/detail/{id}', [RequestHRController::class, 'detailUser'])->name('requesthr.detailUser');
    Route::post('/requestHR/store', [RequestHRController::class, 'requestStore'])->name('request.store');

    //hrlist
    Route::get('/approvehrlistall', [ApproveController::class, 'approvehrlistall'])->name('approve.approvehrlistall');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('sections', SectionController::class);
    Route::resource('divisions', DivisionController::class);
    Route::resource('departments', DepartmentController::class);


    Route::resource('request-categories', RequestCategoriesController::class);
    Route::get('request-types', [RequestTypeController::class, 'index'])->name('request-types.index');
    Route::post('request-types', [RequestTypeController::class, 'store'])->name('request-types.store');
    Route::put('request-types/{id}', [RequestTypeController::class, 'update'])->name('request-types.update');
    Route::delete('request-types/{id}', [RequestTypeController::class, 'destroy'])->name('request-types.destroy');
    
    Route::get('request-subtypes', [RequestSubtypeController::class, 'index'])->name('request-subtypes.index');
    Route::post('request-subtypes', [RequestSubtypeController::class, 'store'])->name('request-subtypes.store');
    Route::put('request-subtypes/{id}', [RequestSubtypeController::class, 'update'])->name('request-subtypes.update');
    Route::delete('request-subtypes/{id}', [RequestSubtypeController::class, 'destroy'])->name('request-subtypes.destroy');

    //News
    Route::resource('news', NewsController::class);
    Route::get('news/detail/{id}', [NewsController::class, 'detail'])->name('news.detail');

});
// 
require __DIR__.'/auth.php';
