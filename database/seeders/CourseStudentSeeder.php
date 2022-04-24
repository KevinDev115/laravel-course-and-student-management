<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Seeder;

class CourseStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = Course::all();

        Student::all()->each(function ($student) use ($courses) { 
            $student->courses()->attach(
                $courses->random(rand(1, 50))->pluck('id')->toArray()
            ); 
        });
    }
}
