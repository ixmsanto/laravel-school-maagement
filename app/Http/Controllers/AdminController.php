<?php

namespace App\Http\Controllers;

// path: app/Http/Controllers/AdminController.php

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function listUsers()
    {
        return response()->json(User::all());
    }
    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,teacher,student',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        $user->assignRole($request->role);

        if ($request->role === 'student') {
            Student::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name ?? 'Student',
                'last_name' => $request->last_name ?? 'User',
                'date_of_birth' => $request->date_of_birth ?? now(),
            ]);
        } elseif ($request->role === 'teacher') {
            Teacher::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name ?? 'Teacher',
                'last_name' => $request->last_name ?? 'User',
                'subject' => $request->subject ?? 'General',
            ]);
        }

        return response()->json(['message' => 'User created', 'user' => $user]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'sometimes',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|min:6',
        ]);

        $user->update($request->only('name', 'email', 'password'));
        return response()->json(['message' => 'User updated']);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}
