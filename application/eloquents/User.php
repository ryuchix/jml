<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent 
{
    protected $table = "users";
    protected $guarded = [];

    public function getFullNameAttribute($value)
    {
       return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }
}