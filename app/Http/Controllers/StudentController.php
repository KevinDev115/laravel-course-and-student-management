<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::with('courses')->get();
        return Inertia::render('Student/Index', [
            'students' => $students
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Student/Form', [
            'action' => 'create'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required'
        ]);
        
        Student::create($request->all());
        return Redirect::route('student.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        return Inertia::render('Student/Form', [
            'student' => $student,
            'action' => 'update'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $student->update($request->all());
        return Redirect::route('student.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return Redirect::route('student.index');
    }

    /**
     * Display a list of the student's courses.
     *
     * @param  \App\Models\Student $student
     * @return \Illuminate\Http\Response
     */
    public function viewCourses(Student $student)
    {
        $courses = Course::whereNotIn(
            'id',
            $student->courses->pluck('id')->toArray()
        )->get();        

        return Inertia::render('Student/Courses', [
            'student' => $student,
            'studentCourses' => $student->courses,
            'courses' => $courses
        ]);
    }

    /**
     * Assign a course to a student.
     *
     * @param  \App\Models\Student $student
     * @return \Illuminate\Http\Response
     */
    public function assignCourse(Request $request, Student $student)
    {
        $request->validate([
            'course_id' => 'required'
        ]);

        $student->courses()->sync([$request->course_id], false);
        return Redirect::route('student.courses', $student->id);
    }

    /**
     * Unassign a course to a student.
     *
     * @param  \App\Models\Student $student
     * @return \Illuminate\Http\Response
     */
    public function unassignCourse(Request $request, Student $student)
    {
        $request->validate([
            'course_id' => 'required'
        ]);

        $student->courses()->detach($request->course_id);
        return Redirect::route('student.courses', $student->id);
    }
}
