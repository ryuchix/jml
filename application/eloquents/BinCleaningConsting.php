<?php
use \Illuminate\Database\Eloquent\Model as Eloquent;

class BinCleaningConsting extends Eloquent 
{
    protected $table = "bin_cleaning_constings";
    protected $guarded = [];
    protected $casts = [
    ];

    public function creator()
    {
        return $this->belongsTo('User', 'created_by');
    }

}