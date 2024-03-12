<?php

namespace App\Http\Controllers;

use App\Enums\CourseBillEnum;
use App\Enums\StudentBillStatus;
use App\Events\CourseBillCreated;
use App\Facades\CourseBillFacade;
use App\Models\Course;
use App\Models\CourseBill;
use App\Models\Student;
use App\Models\StudentBill;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Request;

class CourseBillController extends Controller
{
    /**
     * 账单列表
     * @return \Inertia\Response
     */
    public function index()
    {
        $courseBills = CourseBill::query()
            ->where(['teacher_user_id'=>Auth::user()->id])
            ->with('course')
            ->with('details',function ($query){
                $query->with('student');
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();
        $courseBills->setCollection($courseBills->getCollection()->map(function ($courseBill) {
            $paid = [];
            $unpaid = [];
            foreach ($courseBill->details as $detail){
                switch ($detail->bill_status){
                    case StudentBillStatus::created->value:
                    case StudentBillStatus::paying->value:
                        $unpaid[] = $detail->student->name;
                        break;
                    case StudentBillStatus::payed->value:
                        $paid[] = $detail->student->name;
                        break;
                }
            }
            return [
                'id' => $courseBill->id,
                'name' => $courseBill->name,
                'course_id' => $courseBill->course_id,
                'bill_status' => $courseBill->bill_status,
                'paid' => implode(',',$paid),
                'unpaid' => implode(',',$unpaid),
            ];
        }));

        return Inertia::render('CourseBill/Index',[
            'courseBills' => $courseBills
        ]);
    }

    /**
     * 发送账单
     */
    public function sendBill()
    {
        $attributes = Request::validate([
            'billId' => ['required','integer'],
        ]);
        try {
            CourseBillFacade::sendBillToStudent($attributes['billId']);
            Request::session()->flash('success', '发送成功');
        }catch (\Throwable $throwable){
            Request::session()->flash('error', '发送失败'.$throwable->getMessage());
        }
        return redirect('/course-bill');
    }

    public function store()
    {
        $attributes = Request::validate([
            'course' => [
                'required',
                'integer',
                'exists:courses,id',
                'unique:course_bills,course_id',
            ],
        ]);
        $model = CourseBill::create([
            'course_id' => $attributes['course'],
            'teacher_user_id' => Auth::user()->id,
            'name' => Course::find($attributes['course'])->name,
            'bill_status' => CourseBillEnum::created->value
        ]);
        return redirect('/course-bill');
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

    public function billDetails(int $courseBillId)
    {
        $details = StudentBill::query()
            ->where(['course_bill_id'=> $courseBillId])
            ->with('course')
            ->with('student')
            ->paginate(10)
            ->withQueryString();
        $details->setCollection($details->getCollection()->map(function ($item) {
            return [
                'id' => $item->id,
                'course_name' => $item->course->name,
                'course_fee' => $item->course_fee,
                'bill_status' => $item->bill_status,
                'student_name' => $item->student->name
            ];
        }));

        return Inertia::render('CourseBill/Details',[
            'details' => $details
        ]);
    }
}
