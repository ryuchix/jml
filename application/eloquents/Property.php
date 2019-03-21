<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Property extends Eloquent 
{
    protected $table = "property";
    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
        // 'address_location' => 'json'
    ];

    public function jobs()
    {
        return $this->hasMany('Job');
    }

    public function getFullAddressAttribute($value)
    {
        return $this->address . ', ' . $this->address_suburb . ', ' . $this->address_state . ', ' . $this->address_post_code;
    }

    public function getAddressLocationAttribute($value) 
    {
        $s = str_replace(
            array('"',  "'"),
            array('\"', '"'),
            $value
        );
        $s = preg_replace('/(\w+):/i', '"\1":', $s);
        return json_decode($s);
    }
}