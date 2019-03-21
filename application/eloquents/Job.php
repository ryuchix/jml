<?php
use \Illuminate\Database\Eloquent\Model as Eloquent;

class Job extends Eloquent 
{
    protected $table = "job";
    protected $guarded = [];
    protected $casts = [
        'job_type' => 'integer'
    ];

    public function crews()
    {
        return $this->belongsToMany('User', 'job_crew');
    }

    public function client()
    {
        return $this->belongsTo('Client');
    }

    public function category()
    {
        return $this->belongsTo('JobCategory', 'job_category');
    }

    public function property()
    {
        return $this->belongsTo('Property');
    }

    public function visits()
    {
        return $this->hasMany('JobVisit');
    }

}