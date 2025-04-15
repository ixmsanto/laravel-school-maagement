<?php

namespace App\Http\Controllers;

// path: app/Http/Controllers/MarksController.php

use App\Models\Marks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarksController extends Controller
{
    public function assignMarks(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject' => 'required',
            'marks' => 'required|integer|min:0|max:100',
            'period' => 'required|in:weekly,monthly,yearly',
        ]);

        $marks = Marks::create([
            'student_id' => $request->student_id,
            'teacher_id' => Auth::user()->teacher->id,
            'subject' => $request->subject,
            'marks' => $request->marks,
            'period' => $request->period,
        ]);

        return response()->json(['message' => 'Marks assigned', 'marks' => $marks]);
    }
}
