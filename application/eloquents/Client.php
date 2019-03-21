<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Client extends Eloquent 
{
    protected $table = "client";
    protected $guarded = [];

    public function jobs()
    {
        return $this->hasMany('Job');
    }
}