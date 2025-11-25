<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\requestdata\SectionController;
use App\Http\Controllers\backend\requestdata\DivisionController;
use App\Http\Controllers\backend\requestdata\DepartmentController;
use App\Http\Controllers\hrrequest\RequestDataController;


Route::get('/sections', [SectionController::class, 'apiSection']);
Route::get('/divisions', [DivisionController::class, 'apiDivision']);
Route::get('/departments', [DepartmentController::class, 'apiDepartment']);
// HR Request dynamic data
Route::get('/request-types', [RequestDataController::class, 'types']);
Route::get('/request-subtypes', [RequestDataController::class, 'subtypes']);
    
