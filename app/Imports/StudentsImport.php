<?php

namespace App\Imports;

// path: app/Imports/StudentsImport.php

use App\Models\User;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentsImport implements ToModel
{
    public function model(array $row)
    {
        $user = User::create([
            'name' => $row[0] . ' ' . $row[1],
            'email' => $row[2],
            'password' => bcrypt('password'),
            'role' => 'student',
        ]);

        $user->assignRole('student');

        return new Student([
            'user_id' => $user->id,
            'first_name' => $row[0],
            'last_name' => $row[1],
            'date_of_birth' => $row[3],
        ]);
    }
}
