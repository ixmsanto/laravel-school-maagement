<?php

namespace App\Http\Controllers;

// path: app/Http/Controllers/HomeworkController.php

use App\Models\Homework;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeworkController extends Controller
{
    public function assignHomework(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'title' => 'required',
            'description' => 'required',
            'due_date' => 'required|date',
        ]);

        $homework = Homework::create([
            'teacher_id' => Auth::user()->teacher->id,
            'student_id' => $request->student_id,
            'title' => $request->title, // Added missing field
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        return response()->json(['message' => 'Homework assigned', 'homework' => $homework]);
    }

    public function viewHomework()
    {
        $homework = Homework::where('student_id', Auth::user()->student->id)->get();
        return response()->json($homework);
    }

    public function updateHomework(Request $request, $id)
    {
        $homework = Homework::findOrFail($id);
        $request->validate([
            'status' => 'required|in:submitted',
        ]);

        $homework->update(['status' => $request->status]);
        return response()->json(['message' => 'Homework updated']);
    }
}
