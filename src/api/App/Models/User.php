<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function address()
    {
        return $this->hasOne(UserAddress::class);
    }

}