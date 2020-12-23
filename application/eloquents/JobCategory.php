<?php
use \Illuminate\Database\Eloquent\Model as Eloquent;

class JobCategory extends Eloquent 
{
    protected $guarded = [];

    protected $casts = [
        'job_type' => 'integer'
    ];

    const CREATED_AT = 'added_time';
    const UPDATED_AT = 'updated_time';

    public function jobs()
    {
        return $this->hasMany('Job');
    }

    public function save($attributes = [])
    {
        $CI =& get_instance();
        if($this->id)
            $this->updated_by = $CI->session->userdata('user_id');
        else
            $this->added_by = $CI->session->userdata('user_id');
        return parent::save($attributes);
    }

}