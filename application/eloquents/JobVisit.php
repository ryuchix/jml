<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class JobVisit extends Eloquent 
{
    protected $table = "job_visits";
    protected $guarded = [];

    public function job()
    {
        return $this->belongsTo('Job');
    }

    public function crews()
    {
        return $this->belongsToMany('User', 'job_visit_crew', 'visit_id', 'user_id');
    }
}