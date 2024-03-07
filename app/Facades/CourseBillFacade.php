<?php
/**
 * Created by xuchengliang
 * Date: 2024/3/7 15:13
 */

namespace App\Facades;

use App\CourseBill\CourseBillService;
use Illuminate\Support\Facades\Facade;

class CourseBillFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return CourseBillService::class;
    }
}
