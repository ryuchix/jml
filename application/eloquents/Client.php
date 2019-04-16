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

    public function leadType()
    {
        return $this->belongsTo(LeadType::class, 'lead_type');
    }

    public function leadBy()
    {
        return $this->belongsTo(User::class, 'lead_by');
    }

    public function clinetLogs()
    {
        return $this->hasMany(ClientLogs::class, 'client_id');
    }
}