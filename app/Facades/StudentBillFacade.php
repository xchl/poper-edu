<?php
/**
 * Created by xuchengliang
 * Date: 2024/3/7 15:13
 */

namespace App\Facades;

use App\CourseBill\StudentBillService;
use Illuminate\Support\Facades\Facade;

class StudentBillFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return StudentBillService::class;
    }
}
