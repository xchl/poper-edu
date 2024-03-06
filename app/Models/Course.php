<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['name','year_month','course_fee','user_id'];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class,'student_courses','course_id','user_id');
    }


    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class,'user_id','id');
    }
}
