<?php

namespace App\Models;

// path: app/Models/Teacher.php

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['user_id', 'first_name', 'last_name', 'subject'];

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
