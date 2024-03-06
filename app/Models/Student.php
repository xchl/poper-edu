<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Student extends Authenticatable
{
    use HasApiTokens;
    public $incrementing = false;

    public function findForPassport(string $username)
    {
        return $this->where('username', $username)->first();
    }

    public function getAuthIdentifier(){
        return $this->id;
    }
}
