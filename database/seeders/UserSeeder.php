<?php

namespace Database\Seeders;

// path: database/seeders/UserSeeder.php

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $admin->assignRole('admin');

        // Teacher
        $teacher = User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@example.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
        ]);
        $teacher->assignRole('teacher');
        Teacher::create([
            'user_id' => $teacher->id,
            'first_name' => 'Teacher',
            'last_name' => 'User',
            'subject' => 'Math',
        ]);

        // Student
        $student = User::create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => bcrypt('password'),
            'role' => 'student',
        ]);
        $student->assignRole('student');
        Student::create([
            'user_id' => $student->id,
            'first_name' => 'Student',
            'last_name' => 'User',
            'date_of_birth' => '2005-01-01',
        ]);
    }
}
