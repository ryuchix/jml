<?php
use \Illuminate\Database\Eloquent\Model as Eloquent;

class JobCategory extends Eloquent 
{
    protected $guarded = [];

    protected $casts = [
        'job_type' => 'integer'
    ];

    public function jobs()
    {
        return $this->hasMany('Job');
    }

}