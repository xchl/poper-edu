<?php

namespace App\Models;

use App\Enums\CourseBillEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseBill extends Model
{
    use HasFactory;
    protected $fillable = ['course_id','name','teacher_user_id','bill_status'];

    public function canSendBill():bool
    {
        return $this->bill_status === CourseBillEnum::created->value;
    }

    public function details():HasMany
    {
        return $this->hasMany(StudentBill::class,'course_bill_id','id');
    }

    public function course():BelongsTo
    {
        return $this->belongsTo(Course::class,'course_id','id');
    }
    protected $casts = [
        'bill_status' => 'integer',
    ];
}
