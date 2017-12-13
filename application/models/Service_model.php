<?php

/**
 * SERVICE MODAL
 */
class Service_model extends MY_Model
{
    const DB_TABLE = 'service';
    const DB_TABLE_PK = 'id';

    public $id;
    public $name;
    public $rate;
    public $job_type = '';
    public $image = '';
    public $description;
    public $active = 1;
    public $added_by;
//    public $added_time;
    public $updated_by;
//    public $updated_time;
    // public $data_services;

    function get_dropdown_lists($first_empty=1, $active=1)
    {
        $ret = array_map(

                function($o){ 
                    return $o->name; 
                }, 

                $this->getWhere(array('active'=>1))
            );

        return $first_empty? array(''=>'') + $ret : $ret;
    }


}

?>