<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Role extends Eloquent 
{
    protected $table = "roles";
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}