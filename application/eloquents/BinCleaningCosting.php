<?php
use \Illuminate\Database\Eloquent\Model as Eloquent;

class BinCleaningCosting extends Eloquent 
{
    protected $table = "bin_cleaning_costings";
    protected $fillable = ['cost_title', 'monthly_cost', 'daily_cost', 'notes'];
    protected $casts = [];

    public function creator()
    {
        return $this->belongsTo('User', 'created_by');
    }

}