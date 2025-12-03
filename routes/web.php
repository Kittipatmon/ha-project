<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\frontend\SystemController;

use App\Http\Controllers\backend\RequestHRController;
use App\Http\Controllers\backend\requestdata\RequestDataController;
use App\Http\Controllers\backend\users\SectionController;
use App\Http\Controllers\backend\users\DivisionController;
use App\Http\Controllers\backend\users\DepartmentController;

use App\Http\Controllers\backend\hrrequest\RequestCategoriesController;
use App\Http\Controllers\backend\hrrequest\RequestTypeController;
use App\Http\Controllers\backend\hrrequest\RequestSubtypeController;

use App\Http\Controllers\backend\ApproveController;
use App\Http\Controllers\backend\LeaveReportsController;


use App\Http\Controllers\backend\NewsController;
use App\Http\Controllers\backend\users\UserController;
use App\Http\Controllers\backend\users\UserTypeController;
use App\Models\datacenter\News;
use App\Models\hrrequest\HrRequests;

Route::get('/api/departments', [DepartmentController::class, 'apiDepartments']);
Route::resource('departments', DepartmentController::class);

Route::get('/api/sections', [SectionController::class, 'apiSections']);
Route::resource('sections', SectionController::class);

Route::get('/api/divisions', [DivisionController::class, 'apiDivisions']);
Route::resource('division', DivisionController::class);

Route::get('/api/users', [UserController::class, 'apiUsers']);
Route::resource('users', UserController::class);

Route::get('/', function () {
    $newsItems = News::where('is_active', true)
        ->orderBy('published_date', 'desc')
        ->get();

    $highlight = $newsItems->first();
    $otherNews = $newsItems->slice(1);

    return view('welcome', [
        'highlight' => $highlight,
        'otherNews' => $otherNews,
        'newsItems' => $newsItems
    ]);
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// welcomeSystem
Route::get('/welcome-system', [SystemController::class, 'welcomeSystem'])->name('welcome.system');
Route::get('/requestHR/dashboard', [RequestHRController::class, 'dashboard'])->name('requesthr.dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/welcomehrrequest', [RequestHRController::class, 'welcomeRequest'])->name('request.hr');
    Route::get('/request-data', [RequestDataController::class, 'welcomeData'])->name('request.data');

    Route::get('/requestHR', [RequestHRController::class, 'requestHR'])->name('requesthr.index');
    Route::get('/requestHR/list', [RequestHRController::class, 'requesthrList'])->name('requesthr.list');
    Route::get('/requestHR/listall', [RequestHRController::class, 'requesthrlistall'])->name('requesthr.listall');
    Route::get('/requestHR/detail/{id}', [RequestHRController::class, 'detailUser'])->name('requesthr.detailUser');
    Route::post('/requestHR/store', [RequestHRController::class, 'requestStore'])->name('request.store');
    Route::get('/requestHR/edit/{id}', [RequestHRController::class, 'requestHREdit'])->name('requesthr.edit');
    Route::post('/requestHR/update/{id}', [RequestHRController::class, 'requestUpdate'])->name('request.update');

    //hrlist
    Route::get('/approvehrlist', [ApproveController::class, 'approvehrlist'])->name('approve.approvehrlist');
    Route::get('/detailHR/{id}', [RequestHRController::class, 'detailHr'])->name('requesthr.detailhr');
    Route::post('/hrCheck/{id}', [ApproveController::class, 'hrCheck'])->name('approve.hrCheck');
    //hrlistall
    Route::get('/approvehrlistall', [ApproveController::class, 'approvehrlistall'])->name('approve.approvehrlistall');
    Route::get('/approvehrlistall/export', [ApproveController::class, 'approvehrlistallExport'])->name('approve.approvehrlistall.export');
    Route::get('/approvehrlistall/data', [ApproveController::class, 'approvehrlistallData'])->name('approve.approvehrlistall.data');
    Route::get('/approvehrlistall/pdf', [ApproveController::class, 'approvehrlistallPdf'])->name('approve.approvehrlistall.pdf');

    //manager
    Route::get('/approvemanalist', [ApproveController::class, 'approvemanalist'])->name('approve.approvemanalist');
    Route::get('/detailMana/{id}', [RequestHRController::class, 'detailMana'])->name('requesthr.detailMana');
    Route::post('/managerCheck/{id}', [ApproveController::class, 'managerCheck'])->name('approve.managerCheck');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('sections', SectionController::class);
    Route::resource('divisions', DivisionController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('users', UserController::class);
    Route::delete('users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::resource('usertypes', UserTypeController::class);
    // Route::post('users/storeUser', [UserController::class, 'store'])->name('users.storeUser');


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

    //profile user
    Route::get('users/profile/{id}', [UserController::class, 'profileUser'])->name('users.profile');

    //Leave Reports
    Route::get('/leavereports/dashboard', [LeaveReportsController::class, 'dashboard'])->name('leavereports.dashboard');

});
// 
require __DIR__.'/auth.php';
