<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class JobVisit extends Eloquent 
{
    protected $table = "job_visits";
    protected $guarded = [];
    public $timestamps = false;

    public function job()
    {
        return $this->belongsTo('Job');
    }

    public function crews()
    {
        return $this->belongsToMany('User', 'job_visit_crew', 'visit_id', 'user_id');
    }

    public function items()
    {
        return $this->belongsToMany('Service', 'job_visit_item', 'visit_id', 'service_id')
        ->withPivot('qty', 'unit_cost', 'total', 'description');
    }
}