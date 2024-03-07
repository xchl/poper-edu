<?php
/**
 * Created by xuchengliang
 * Date: 2024/3/7 14:16
 */

namespace App\Enums;

enum CourseBillEnum: int
{
    case created = 1;
    case seeding = 2;
    case finished = 3;

}
