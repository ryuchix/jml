<?php

/**
 * SERVICE MODAL
 */
class Property_bins_model extends MY_Model
{
    const DB_TABLE = 'property_bins';
    const DB_TABLE_PK = 'id';

    public $id;
    public $property_id;
    public $bin_type;
    public $qty;
    public $notes;
    public $active = 1;
    public $added_by;
//    public $added_time;
    public $updated_by;
//    public $updated_time;
    // public $data_services;

}

?>