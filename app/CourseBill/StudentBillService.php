<?php
/**
 * Created by xuchengliang
 * Date: 2024/3/7 19:40
 */

namespace App\CourseBill;

class StudentBillService
{
    public function pay(StudentBill $studentBill)
    {
        $studentBill->bill_status = 2;
        $studentBill->save();
    }

    protected function getCardInfo()
    {



    }
}
