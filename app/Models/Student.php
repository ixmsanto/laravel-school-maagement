<?php

namespace App\Models;

// path: app/Models/Student.php

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['user_id', 'first_name', 'last_name', 'date_of_birth'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function homework()
    {
        return $this->hasMany(Homework::class);
    }

    public function marks()
    {
        return $this->hasMany(Marks::class);
    }
}
