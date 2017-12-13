<?php

class Vehicle_rego_model extends MY_Model
{
    const DB_TABLE = 'vehicle_rego';
    const DB_TABLE_PK = 'id';

    public $id;
    public $vehicle_id;
    public $rate;
    public $due_date;
    public $expiry_date;
    public $paid_date;
    public $status;
    public $receipt_no;
    public $file;

}

?>