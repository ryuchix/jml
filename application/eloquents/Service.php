<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Service extends Eloquent 
{
    protected $table = "service";
    protected $guarded = [];
    public $timestamps = false;
}