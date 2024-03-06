<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Request;

class BillController extends Controller
{
    public function index()
    {
        $courses = Course::query()
            ->where(['user_id'=>Auth::user()->id])
            ->when(Request::input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->with('students')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();
        $courses->setCollection($courses->getCollection()->map(function ($course) {
            return [
                'id' => $course->id,
                'name' => $course->name,
                'year_month' => $course->year_month,
                'course_fee' => $course->course_fee,
                'students' => $course->students->map(function ($student) {
                    return $student->name;
                }),
            ];
        }));

        return Inertia::render('Course/Index',[
            'courses' => $courses
        ]);
    }

    public function store()
    {
        $attributes = Request::validate([
            'name' => ['required'],
            'course_fee' => ['required','numeric','min:0','max:1000000'],
            'year_month' => ['required','yearmonth'],
            'students' => 'array',
        ]);
        $attributes['user_id'] = Auth::user()->id;
        DB::transaction(function ()use($attributes) {
            $model = Course::create($attributes);
            if ($attributes['students']) {
                $model->students()->sync($attributes['students']);
            }
        });
        return redirect('/course');
    }
    public function create()
    {
        return Inertia::render('Course/Create',[
            'students' => Student::query()->take(10)->get(['id','name'])->toArray()
        ]);
    }
}
