<?php

/**
 * SERVICE MODAL
 */
class Lead_type_model extends MY_Model
{
    const DB_TABLE = 'lead_type';
    const DB_TABLE_PK = 'id';

    public $id;
    public $type;
    public $description;
    public $active = 1;
    public $added_by;
    public $updated_by;

}

?>