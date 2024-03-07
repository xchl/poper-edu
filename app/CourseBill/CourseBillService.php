<?php
/**
 * Created by xuchengliang
 * Date: 2024/3/7 15:15
 */

namespace App\CourseBill;

use App\Enums\CourseBillEnum;
use App\Models\CourseBill;
use App\Models\StudentBill;
use Illuminate\Support\Facades\DB;

class CourseBillService
{
    public function sendBillToStudent(int $billId)
    {
        $courseBillModel =  CourseBill::find($billId);
        if($courseBillModel->canSendBill()){
            //考虑到发送账单业务后续可能是一个耗时操作,这里状态先改为发送中，防止重复发送
            $courseBillModel->bill_status = CourseBillEnum::seeding->value;
            $courseBillModel->save();
            $students = $courseBillModel->course->students;
            $data = [];
            foreach ($students as $student){
                $data[] = [
                    'student_user_id' => $student->id,
                    'course_bill_id' => $billId,
                    'course_id' => $courseBillModel->course_id,
                    'course_fee'=> $courseBillModel->course->course_fee,
                    'bill_status' => 1,
                    'omise_charge_id'=> '',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DB::transaction(function ()use($data,$courseBillModel) {
                StudentBill::insert($data);
                $courseBillModel->bill_status = CourseBillEnum::finished->value;
                $courseBillModel->save();
            });
        }
    }
}
