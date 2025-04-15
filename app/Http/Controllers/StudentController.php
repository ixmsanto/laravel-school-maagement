<?php

namespace App\Http\Controllers;

// path: app/Http/Controllers/StudentController.php

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function viewPerformance(Request $request)
    {
        $student = Student::where('user_id', Auth::user()->id)->with(['marks', 'homework'])->first();
        return response()->json([
            'marks' => $student->marks,
            'homework_completion' => $student->homework->where('status', 'submitted')->count(),
        ]);
    }
}
