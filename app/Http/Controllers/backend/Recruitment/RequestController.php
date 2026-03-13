<?php

namespace App\Http\Controllers\Backend\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\Recruitment\RecruitmentRequest;
use App\Models\Recruitment\Department;
use App\Models\Recruitment\JobPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RequestController extends Controller
{
    public function index()
    {
        $requests = RecruitmentRequest::with(['department', 'jobPosition', 'requester'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('backend.recruitment.requests.index', compact('requests'));
    }

    public function create()
    {
        $departments = Department::where('department_status', '0')->get();
        $positions = JobPosition::where('status', 'active')->get();

        // Pull distinct positions from existing employees to help user
        $employeePositions = \App\Models\User::whereNotNull('position')
            ->where('position', '!=', '')
            ->distinct()
            ->pluck('position');

        return view('backend.recruitment.requests.create', compact('departments', 'positions', 'employeePositions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:userkml2025.department,department_id',
            'job_position_id' => 'nullable|exists:recruitment_job_positions,id',
            'position_name' => 'required|string|max:255',
            'headcount' => 'required|integer|min:1',
            'reason' => 'nullable|string',
            'job_description' => 'nullable|string',
            'qualification' => 'nullable|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'required_start_date' => 'nullable|date',
        ]);

        $validated['request_no'] = 'REQ-' . strtoupper(Str::random(8));
        $validated['requested_by'] = Auth::id();
        $validated['status'] = 'pending_manager'; // Default status when submitted

        RecruitmentRequest::create($validated);

        return redirect()->route('backend.recruitment.requests.index')
            ->with('success', 'คำขอเปิดอัตรากำลังถูกสร้างเรียบร้อยแล้ว');
    }

    public function show(RecruitmentRequest $recruitmentRequest)
    {
        $recruitmentRequest->load(['department', 'jobPosition', 'requester', 'managerApprover', 'executiveApprover']);
        return view('backend.recruitment.requests.show', compact('recruitmentRequest'));
    }

    public function approve(Request $request, RecruitmentRequest $recruitmentRequest)
    {
        // Simple approval logic for now
        $user = Auth::user();

        if ($recruitmentRequest->status === 'pending_manager') {
            $recruitmentRequest->update([
                'status' => 'pending_executive',
                'approved_by_manager' => $user->id,
                'approved_at_manager' => now(),
            ]);
        } elseif ($recruitmentRequest->status === 'pending_executive') {
            $recruitmentRequest->update([
                'status' => 'approved',
                'approved_by_executive' => $user->id,
                'approved_at_executive' => now(),
            ]);
        }

        return back()->with('success', 'อนุมัติคำขอเรียบร้อยแล้ว');
    }

    public function reject(Request $request, RecruitmentRequest $recruitmentRequest)
    {
        $recruitmentRequest->update([
            'status' => 'rejected',
            'remarks' => $request->remarks,
        ]);

        return back()->with('success', 'ปฏิเสธคำขอเรียบร้อยแล้ว');
    }
}
