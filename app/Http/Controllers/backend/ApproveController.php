<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\hrrequest\HrRequests;

class ApproveController extends Controller
{

    public function approvemanalist()
    {
        $hrrequests = HrRequests::with(['user', 'approverManager', 'approverhr', 'category', 'type', 'subtype'])
            ->whereIn('status', [
                HrRequests::STATUS_PENDING,
            ])
            ->where('approver_manager_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('requesthr.approve.approvemanalist', compact('hrrequests'));
    }

    public function managerCheck(Request $request, $id)
    {
        $hrrequest = HrRequests::findOrFail($id);

        if ($hrrequest->approver_manager_id !== auth()->id()) {
            abort(403, 'คุณไม่มีสิทธิ์อนุมัติคำขอนี้');
        }

        $data = $request->validate([
            'status'  => 'required|integer|in:1,2,3',
            'comment' => 'nullable|string|max:1000',
        ]);

        // 0 = รออนุมัติ 1 = อนุมัติ 2 = ไม่อนุมัติ 3 = ส่งกลับแก้ไข
        $status = (int) ($data['status'] ?? $hrrequest->approver_manager_status);

        $hrrequest->approver_manager_status  = $status;
        $hrrequest->approver_manager_comment = $data['comment'] ?? null;
        $hrrequest->approver_manager_at      = now();

        // กำหนดสถานะหลัก + ข้อความตอบกลับ
        $flashType = 'info';
        $flashMsg  = 'อัปเดตสถานะคำขอเรียบร้อยแล้ว';

        if ($status === 1) {
            $hrrequest->status = HrRequests::STATUS_APPROVED_HR;
            $flashType = 'success';
            $flashMsg  = 'คำขอได้รับการอนุมัติแล้ว';
        } elseif ($status === 2) {
            $hrrequest->status = HrRequests::STATUS_REJECTED;
            $flashType = 'error';
            $flashMsg  = 'คำขอถูกปฏิเสธแล้ว';
        } elseif ($status === 3) {
            $hrrequest->status = HrRequests::STATUS_PENDING;
            $flashType = 'warning';
            $flashMsg  = 'คำขอถูกส่งกลับแก้ไขแล้ว';
        }

        if ($hrrequest->save()) {
            return redirect()->route('approve.approvemanalist')->with($flashType, $flashMsg);
        }

        return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการอนุมัติคำขอ');
    }

    public function approvehrlist()
    {
        $hrrequests = HrRequests::with(['user', 'approverManager', 'approverhr', 'category', 'type', 'subtype'])
            ->whereIn('status', [
                HrRequests::STATUS_APPROVED_HR,
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('requesthr.approve.approvehrlist', compact('hrrequests'));
    }

    public function approvehrlistall()
    {
        $hrrequests = HrRequests::with(['user', 'approverManager', 'approverhr', 'category', 'type', 'subtype'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('requesthr.approve.approvehrlistall', compact('hrrequests'));
    }

    public function hrcheck(Request $request, $id)
    {
         $hrrequest = HrRequests::findOrFail($id);

        // if ($hrrequest->approver_hr_id !== auth()->id()) {
        //     abort(403, 'คุณไม่มีสิทธิ์อนุมัติคำขอนี้');
        // }

        $data = $request->validate([
            'status'  => 'required|integer|in:1,2,3',
            'comment' => 'nullable|string|max:1000',
        ]);

        // 0 = รออนุมัติ 1 = อนุมัติ 2 = ไม่อนุมัติ 3 = ส่งกลับแก้ไข
        $status = (int) ($data['status'] ?? $hrrequest->approver_hr_status);

        $hrrequest->approver_hr_id      = auth()->id();
        $hrrequest->approver_hr_status  = $status;
        $hrrequest->approver_hr_comment = $data['comment'] ?? null;
        $hrrequest->approver_hr_at      = now();

        // กำหนดสถานะหลัก + ข้อความตอบกลับ
        $flashType = 'info';
        $flashMsg  = 'อัปเดตสถานะคำขอเรียบร้อยแล้ว';

        if ($status === 1) {
            $hrrequest->status = HrRequests::STATUS_COMPLETED;
            $flashType = 'success';
            $flashMsg  = 'คำขอได้รับการอนุมัติแล้ว';
        } elseif ($status === 2) {
            $hrrequest->status = HrRequests::STATUS_REJECTED;
            $flashType = 'error';
            $flashMsg  = 'คำขอถูกปฏิเสธแล้ว';
        } elseif ($status === 3) {
            $hrrequest->status = HrRequests::STATUS_PENDING;
            $flashType = 'warning';
            $flashMsg  = 'คำขอถูกส่งกลับแก้ไขแล้ว';
        }

        if ($hrrequest->save()) {
            return redirect()->route('approve.approvehrlist')->with($flashType, $flashMsg);
        }

        return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการอนุมัติคำขอ');
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
