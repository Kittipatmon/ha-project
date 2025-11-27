<?php

namespace App\Http\Controllers\backend\users;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Division;

class DepartmentController extends Controller
{
    public function apiDepartments()
    {
        $departments = Department::all();
        return response()->json($departments);
    }
    public function index()
    {
        $departments = Department::all();
        return view('backend.department.index', compact('departments'));
    }

    public function create()
    {
        $divisions = Division::all();
        return view('backend.department.create', compact('divisions'));
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        $divisions = Division::all();
        return view('backend.department.edit', compact('department', 'divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'nullable|string|max:255',
            'department_fullname' => 'nullable|string|max:255',
            'department_status' => 'required|integer|in:0,1',
            'division_id' => 'nullable|integer|exists:divisions,division_id',
        ]);

        Department::create($request->all());

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'department_name' => 'nullable|string|max:255',
            'department_fullname' => 'nullable|string|max:255',
            'department_status' => 'required|integer|in:0,1',
            'division_id' => 'nullable|integer|exists:divisions,division_id',
        ]);

        $department = Department::findOrFail($id);
        $department->update($request->all());

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
