<?php

namespace App\Models;

use App\Enums\StudentBillStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentBill extends Model
{
    use HasFactory;

    public function course():BelongsTo
    {
        return $this->belongsTo(Course::class,'course_id','id');
    }

    public function needPay():bool
    {
        return $this->bill_status === StudentBillStatus::created->value;
    }

    public function student():BelongsTo
    {
        return $this->belongsTo(Student::class,'student_user_id','id');
    }

    protected $casts = [
        'bill_status' => 'integer',
        'student_user_id' => 'string'
    ];
}
