<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\backend\LeaveReports;

class LeaveReportsController extends Controller
{
    public function dashboard()
    {
        $leaveReports = LeaveReports::all();
        return view('leavereports.dashboard', compact('leaveReports'));
    }
}
