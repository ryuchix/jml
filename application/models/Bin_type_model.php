<?php

/**
 * SERVICE MODAL
 */
class Bin_type_model extends MY_Model
{
    const DB_TABLE = 'bin_type';
    const DB_TABLE_PK = 'id';

    public $id;
    public $type;
    public $size;
    public $color;
    public $description;
    public $image = '';
    public $active = 1;
    public $added_by;
//    public $added_time;
    public $updated_by;
//    public $updated_time;
    // public $data_services;

}

?>