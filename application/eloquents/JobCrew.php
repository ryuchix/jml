<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class JobCrew extends Eloquent 
{
    protected $table = "job_crew";
    protected $guarded = [];

    public function crews()
    {
        return $this->hasMany(JobCrew::class);
    }
}