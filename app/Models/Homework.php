<?php

namespace App\Models;

// path: app/Models/Homework.php

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    protected $fillable = ['teacher_id', 'student_id', 'title', 'description', 'due_date', 'status'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
