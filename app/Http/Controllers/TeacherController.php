<?php

namespace App\Http\Controllers;

// path: app/Http/Controllers/TeacherController.php

use App\Models\User;
use App\Models\Student;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function listStudents()
    {
        return response()->json(Student::with('user')->get());
    }
    public function createStudent(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required|date',
            'email' => 'required|email|unique:users',
        ]);

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => bcrypt('password'),
            'role' => 'student',
        ]);

        $user->assignRole('student');

        $student = Student::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return response()->json(['message' => 'Student created', 'student' => $student]);
    }

    public function updateStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $request->validate([
            'first_name' => 'sometimes',
            'last_name' => 'sometimes',
            'date_of_birth' => 'sometimes|date',
        ]);

        $student->update($request->only('first_name', 'last_name', 'date_of_birth'));
        return response()->json(['message' => 'Student updated']);
    }

    public function importStudents(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv']);
        Excel::import(new StudentsImport, $request->file('file'));
        return response()->json(['message' => 'Students imported']);
    }
}
