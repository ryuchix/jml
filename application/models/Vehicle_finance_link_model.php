<?php

class Vehicle_finance_link_model extends MY_Model
{
    const DB_TABLE = 'vehicle_finance_links';
    const DB_TABLE_PK = 'id';

    public $id;
    public $vehicle_id;
    public $name;
    public $url;
    public $created_by;
    public $updated_by;

}

?>