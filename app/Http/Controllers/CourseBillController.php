<?php

namespace App\Http\Controllers;

use App\Enums\CourseBillEnum;
use App\Events\CourseBillCreated;
use App\Models\Course;
use App\Models\CourseBill;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Request;

class CourseBillController extends Controller
{
    public function index()
    {
        $courses = CourseBill::query()
            ->where(['teacher_user_id'=>Auth::user()->id])
//            ->with('students')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();
        $courses->setCollection($courses->getCollection()->map(function ($courseBill) {
            return [
                'id' => $courseBill->id,
                'name' => $courseBill->name,
//                'year_month' => $courseBill->year_month,
//                'course_fee' => $courseBill->course_fee,
//                'students' => $courseBill->students->map(function ($student) {
//                    return $courseBill->name;
//                }),
            ];
        }));

        return Inertia::render('CourseBill/Index',[
            'courses' => $courses
        ]);
    }

    public function store()
    {
        $attributes = Request::validate([
            'course' => [
                'required',
                'integer',
                'exists:courses,id',
//                'unique:course_bills,course_id',
            ],
        ]);
        $model = CourseBill::create([
            'course_id' => $attributes['course'],
            'teacher_user_id' => Auth::user()->id,
            'name' => Course::find($attributes['course'])->name,
            'bill_status' => CourseBillEnum::created
        ]);
        CourseBillCreated::dispatch($model->id);
        return redirect('/course-bill/index');
    }
    public function create()
    {
        $courses = Course::query()
            ->with('students',function($query){
                $query->select('students.id', 'students.name');
            })
            ->orderBy('id', 'desc')
            ->where(['user_id'=>Auth::user()->id])
            ->take(20)->get(['id','name'])
            ->toArray();
        return Inertia::render('CourseBill/Create',[
            'courses' => $courses
        ]);
    }
}
