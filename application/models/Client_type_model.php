<?php

/**
 * CLIENT TYPES MODAL
 */
class Client_type_model extends MY_Model
{
    const DB_TABLE = 'client_type';
    const DB_TABLE_PK = 'id';

    public $id;
    public $type;
    public $description;
    public $active = 1;
    public $added_by;
//    public $added_time;
    public $updated_by;
//    public $updated_time;
    
}

?>