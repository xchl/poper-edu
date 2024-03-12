<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Student extends Authenticatable
{
    use HasApiTokens;
    public $incrementing = false;

    protected $keyType = 'string';

    public function findForPassport(string $username)
    {
        return $this->where('username', $username)->first();
    }

    public function getAuthIdentifier(){
        return $this->id;
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class,'student_courses','course_id','user_id');
    }

    protected $casts = [
        'id' => 'string'
    ];

}
