<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Teacher extends Authenticatable
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
//    public function validateForPassportPasswordGrant(string $password): bool
//    {
//        return true;
//    }
}
