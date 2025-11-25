<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\hrrequest\HrRequests;

class ApproveController extends Controller
{

    public function approvehrlistall()
    {
        $hrrequests = HrRequests::with(['user', 'approverManager', 'approverhr', 'category', 'type', 'subtype'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('requesthr.approve.approvehrlistall', compact('hrrequests'));
    }



    // public function approveManager(Request $request, $id)
    // {
    //     $hrrequest = HrRequests::findOrFail($id);

    //     // ตรวจสอบว่าเป็นผู้อนุมัติที่ถูกต้อง
    //     if ($hrrequest->approver_manager_id !== auth()->user()->id) {
    //         return redirect()->back()->with('error', 'คุณไม่มีสิทธิ์อนุมัติคำขอนี้');
    //     }

    //     // อัปเดตสถานะการอนุมัติ
    //     $hrrequest->approver_manager_status = $request->input('status');
    //     $hrrequest->approver_manager_comment = $request->input('comment');
    //     $hrrequest->approver_manager_at = now();
    //     $hrrequest->save();

    //     return redirect()->back()->with('success', 'อนุมัติคำขอเรียบร้อยแล้ว');
    // }

    // public function approveHR(Request $request, $id)
    // {
    //     $hrrequest = HrRequests::findOrFail($id);

    //     // ตรวจสอบว่าเป็นผู้อนุมัติที่ถูกต้อง
    //     if ($hrrequest->approver_hr_id !== auth()->user()->id) {
    //         return redirect()->back()->with('error', 'คุณไม่มีสิทธิ์อนุมัติคำขอนี้');
    //     }

    //     // อัปเดตสถานะการอนุมัติ
    //     $hrrequest->approver_hr_status = $request->input('status');
    //     $hrrequest->approver_hr_comment = $request->input('comment');
    //     $hrrequest->approver_hr_at = now();
    //     $hrrequest->save();

    //     return redirect()->back()->with('success', 'อนุมัติคำขอเรียบร้อยแล้ว');
    // }
}
