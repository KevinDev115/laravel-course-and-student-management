<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Response;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::paginate(5);
        return Inertia::render('Course/Index', [
            'courses' => $courses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Course/Form', [
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
            'schedule'  => 'required',
            'start_date'  => 'required',
            'end_date'  => 'required'
        ]);
        
        Course::create($request->all());
        return Redirect::route('course.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return Inertia::render('Course/Form', [
            'course' => $course,
            'action' => 'update'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $course->update($request->all());
        return Redirect::route('course.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return Redirect::route('course.index');
    }

    /**
     * Display a list of the course's students.
     *
     * @param  \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function viewStudents(Course $course)
    {
        $students = Student::whereNotIn(
            'id',
            $course->students->pluck('id')->toArray()
        )->get();        

        return Inertia::render('Course/Students', [
            'course' => $course,
            'courseStudents' => $course->students,
            'students' => $students
        ]);
    }

    /**
     * Assign a student to a course.
     *
     * @param  \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function assignStudent(Request $request, Course $course)
    {
        $request->validate([
            'student_id' => 'required'
        ]);

        $course->students()->sync([$request->student_id], false);
        return Redirect::route('course.students', $course->id);
    }

    /**
     * Unassign a student to a course.
     *
     * @param  \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function unassignStudent(Request $request, Course $course)
    {
        $request->validate([
            'student_id' => 'required'
        ]);

        $course->students()->detach($request->student_id);
        return Redirect::route('course.students', $course->id);
    }

    /**
     * Returns a list of the top 3 courses 
     * with the most students in the last 6 months.
     *
     * @return \Illuminate\Http\Response
     */
    public function topCourses()
    {
        $topCourses = Course::whereBetween('created_at', [
            Carbon::now()->subMonth(6)->format('Y-m-d'),
            Carbon::now()->addDay()->format('Y-m-d')
        ])
        ->get()
        ->sortByDesc('numberOfStudents')
        ->take(3)
        ->values();

        return response()->json($topCourses, 200);
    }
}
