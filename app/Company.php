<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'logo',
        'website'
    ];

    //employees
    public function employees()
    {
        return $this->hasMany('App\Employee');
    }

    //users
    public function users()
    {
//        return $this->belongsToMany('App\User', 'user_company', 'company_id', 'user_id');
        return $this->belongsToMany('App\User');
    }
}
