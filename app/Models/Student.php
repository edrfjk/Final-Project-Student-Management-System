<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'address', 'age', 'year_level', 'photo'
    ];

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'class_student', 'student_id', 'class_id');
    }
}
