<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\StudentCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class StudentCourseController extends Controller
{
    public function index()
    {
        $courses = StudentCourse::query()
            ->where(['user_id'=>Auth::user()->id])
            ->with('course')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();
        $courses->setCollection($courses->getCollection()->map(function ($item) {
            return [
                'id' => $item->id,
                'course_name' => $item->course->name,
                'year_month' => $item->course->year_month,
                'course_fee' => $item->course->course_fee,
                'teacher' => $item->course->teacher->name
            ];
        }));

        return Inertia::render('StudentCourse/Index',[
            'courses' => $courses
        ]);
    }
}
