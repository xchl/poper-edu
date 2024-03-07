<?php

namespace App\Listeners;

use App\Events\CourseBillCreated;
use App\Facades\CourseBillFacade;
use App\Models\CourseBill;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendCourseBillToStudents
{
//    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * 发送课程账单给学生
     * （后续如果发送订单是耗时业务（发邮件等...），可以优化为队列异步执行
     *
     * Handle the event.
     */
    public function handle(CourseBillCreated $event): void
    {
        try {
            CourseBillFacade::sendBillToStudent($event->courseBillId);
        }catch (\Throwable $throwable){
            Log::error('发送账单错误', [
                '错误' => $throwable->getMessage(),
                '文件' => $throwable->getFile(),
                '行号' => $throwable->getLine()
            ]);
            // 发送通知。。。。
        }
    }
}
