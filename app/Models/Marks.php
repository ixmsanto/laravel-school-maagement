<?php

namespace App\Models;

// path: app/Models/Marks.php

use Illuminate\Database\Eloquent\Model;

class Marks extends Model
{
    protected $fillable = ['student_id', 'teacher_id', 'subject', 'marks', 'period'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
