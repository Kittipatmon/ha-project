<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training;

class TrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.training.index', compact('trainings'));
    }

    public function create()
    {
        return view('backend.training.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'hours' => 'required|numeric|min:1',
            'format' => 'required|string|max:255',
            'start_date' => 'required|string|max:255',
            'end_date' => 'required|string|max:255',
            'status' => 'required|in:available,full',
            'details' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf|max:10240', // Max 10MB PDF
            'document_link' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Max 5MB Image
        ]);

        if ($request->hasFile('document')) {
            $validated['document'] = $request->file('document')->store('training_documents', 'public');
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $targetPath = public_path('images/training');

            if (!file_exists($targetPath)) {
                mkdir($targetPath, 0755, true);
            }

            $image->move($targetPath, $imageName);
            $validated['image'] = $imageName;
        }

        Training::create($validated);

        return redirect()->route('backend.training.index')->with('success', 'เพิ่มข้อมูลการฝึกอบรมสำเร็จ');
    }

    public function show($id)
    {
        $training = Training::findOrFail($id);
        return view('backend.training.show', compact('training'));
    }

    public function edit($id)
    {
        $training = Training::findOrFail($id);
        return view('backend.training.edit', compact('training'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'branch' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'hours' => 'required|numeric|min:1',
            'format' => 'required|string|max:255',
            'start_date' => 'required|string|max:255',
            'end_date' => 'required|string|max:255',
            'status' => 'required|in:available,full',
            'details' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf|max:10240', // Max 10MB PDF
            'document_link' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Max 5MB Image
        ]);

        $training = Training::findOrFail($id);

        if ($request->hasFile('document')) {
            // Delete old document if it exists
            if ($training->document) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($training->document);
            }
            $validated['document'] = $request->file('document')->store('training_documents', 'public');
        }

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($training->image) {
                $oldPath = public_path('images/training/' . $training->image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $targetPath = public_path('images/training');

            if (!file_exists($targetPath)) {
                mkdir($targetPath, 0755, true);
            }

            $image->move($targetPath, $imageName);
            $validated['image'] = $imageName;
        }

        $training->update($validated);

        return redirect()->route('backend.training.index')->with('success', 'แก้ไขข้อมูลการฝึกอบรมสำเร็จ');
    }

    public function destroy($id)
    {
        $training = Training::findOrFail($id);
        $training->delete();

        return redirect()->route('backend.training.index')->with('success', 'ลบข้อมูลการฝึกอบรมสำเร็จ');
    }
}
