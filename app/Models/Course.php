<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'schedule',
        'start_date',
        'end_date'
    ];

    protected $appends = [
        'numberOfStudents'
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function getNumberOfStudentsAttribute()
    {
        return $this->students->count();
    }
}
