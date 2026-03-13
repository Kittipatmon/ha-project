<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\TrainingApply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TrainingController extends Controller
{
    public function index(Request $request)
    {
        $query = Training::query();

        // Apply filters if any
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('branch', 'like', "%{$search}%");
        }

        if ($request->filled('format')) {
            $format = $request->input('format');
            $query->where('format', $format);
        }

        if ($request->filled('department')) {
            $department = $request->input('department');
            $query->where('department', $department);
        }

        // Pagination setup
        $perPage = 6;
        $courses = $query->paginate($perPage)->appends($request->query());

        $appliedTrainings = [];
        if (auth()->check()) {
            $appliedTrainings = TrainingApply::where('employee_code', auth()->user()->employee_code)
                ->pluck('training_id')
                ->toArray();
        }

        return view('training.index', compact('courses', 'appliedTrainings'));
    }

    public function apply($id)
    {
        $training = Training::findOrFail($id);
        $users = User::orderBy('employee_code')->get();
        return view('training.apply', compact('training', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'training_id' => 'required|exists:trainings,id',
            'employee_code' => 'required|string|max:255',
        ]);

        $training = Training::findOrFail($request->training_id);

        // Map data to the model fields (assuming Training is used here just to show saving something, though normally it's a separate Enrollment model)
        // Note: Re-using Training model to create a record might be incorrect if the table is for defining courses. 
        // We will just keep the existing behavior but update branch/department dynamically.
        // The above lines are no longer needed as we are using a separate table.

        TrainingApply::create($validated);

        return redirect()->route('training.index')->with('success', 'สมัครฝึกอบรมสำเร็จ');
    }

    public function dashboard(Request $request)
    {
        $query = Training::query();

        // 1. Search Filter (Course Name)
        if ($request->filled('search')) {
            $query->where('branch', 'like', '%' . $request->search . '%');
        }

        // 2. Date Filters (Year, Month, Day)
        $query->withCount([
            'applies' => function ($q) use ($request) {
                if ($request->filled('year')) {
                    $q->whereYear('created_at', $request->year);
                }
                if ($request->filled('month')) {
                    $q->whereMonth('created_at', $request->month);
                }
                if ($request->filled('day')) {
                    $q->whereDay('created_at', $request->day);
                }
            }
        ]);

        $trainings = $query->get();

        // Calculate summary metrics based on filtered data
        $totalCourses = $trainings->count();
        $totalApplies = $trainings->sum('applies_count');
        $avgApplies = $totalCourses > 0 ? round($totalApplies / $totalCourses, 1) : 0;

        $popularCourse = $trainings->sortByDesc('applies_count')->first();
        $popularCourseName = $popularCourse ? $popularCourse->branch : '-';

        // Prepare data for the chart
        $labels = [];
        $data = [];

        foreach ($trainings as $training) {
            if ($training->applies_count > 0) {
                $labels[] = $training->branch;
                $data[] = $training->applies_count;
            }
        }

        // Get available years for the filter dropdown
        $years = TrainingApply::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('training.dashboard', [
            'labels' => $labels,
            'data' => $data,
            'years' => $years,
            'totalCourses' => $totalCourses,
            'totalApplies' => $totalApplies,
            'avgApplies' => $avgApplies,
            'popularCourseName' => $popularCourseName,
            'trainings' => $trainings,
        ]);
    }
}
