<?php
/**
 * Created by xuchengliang
 * Date: 2024/3/9 13:54
 */

namespace App\Enums;

enum StudentBillStatus :int
{
    case created = 1;
    case payed = 2;
    case paying = 3;
}
